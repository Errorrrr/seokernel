<?php

namespace App\Jobs;

use App\Exports\QueriesClusterExport;
use App\Exports\QueriesExport;
use App\Models\ClusterQuery;
use App\Models\Price;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ClusterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 90000;

    private $clusterTaskId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clusterTaskId)
    {
        $this->clusterTaskId = $clusterTaskId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', 172800);
        $toLog = [];
        $toLog['user_input'] = [];

        $clusterQuery = ClusterQuery::find($this->clusterTaskId);

        $region = $clusterQuery->region_code;
        $userQueries = json_decode($clusterQuery->queryList);
        $userQueries = explode(PHP_EOL, $userQueries);
        $siteList = json_decode($clusterQuery->siteList, true);
        $allSitesFromUserQueries = [];
        $queriesByUserQueries = [];
        $toLog['AllTwenty'] = $siteList;

        $splitQueries = $this->clearQueries($userQueries);
        $userQueries = $splitQueries[0];
        $minusQueries = $splitQueries[1];

        $clusterQuery->countQueries = count($userQueries);
        $clusterQuery->countMinusQueries = count($minusQueries);
        $clusterQuery->save();
/*        \Illuminate\Support\Facades\Log::debug('Старт работы с файлами');*/

        Storage::disk('local')->put('xmlQueries.json', json_encode([
            'userQueries'=>$userQueries,
            'region'=>$region,
            'cluster_id'=>$clusterQuery->id,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        Storage::disk('local')->delete('result.json');
        shell_exec('python3 '.base_path().'/multiCluster.py '.env('PHP_FOR_ARTISAN').' '.(count($userQueries)-1));

        while (!Storage::disk('local')->exists('result.json')) {
            sleep(1);
        }
        $pythonRes = json_decode(Storage::disk('local')->get('result.json'), true);
        \Illuminate\Support\Facades\Log::debug('Конец работы с файлами');

        foreach ($pythonRes as $one){
            $allSitesFromUserQueries = array_merge($allSitesFromUserQueries, $one['query']);
            $queriesByUserQueries[$one['name']] = $one['query'];
        }
        $toLog['user_input'] = $queriesByUserQueries;
        $mostPopular = array_count_values($allSitesFromUserQueries);
        $mostPopularManyDem = [];
        foreach ($mostPopular as $key=>$one){
            array_push($mostPopularManyDem,[
                'site'=>$key,
                'rank'=>$one,
            ]);
        }
        $mostPopularManyDem = $this->array_sort($mostPopularManyDem, 'rank', SORT_DESC);
        $need = 4;
        //d([$mostPopular,$siteList]);
        $bestFourSites = [];
        foreach($mostPopularManyDem as $one){
            if(in_array($one['site'], $siteList)){
                array_push($bestFourSites, $one['site']);
                $need--;
            }
            if($need == 0){
                break;
            }
        }
        $toLog['bestFour'] = $bestFourSites;
        $result = [];
        foreach ($userQueries as $one){
            $res = [];
            $res['query'] = $one;
            $res['hasFirstBest'] = '-';
            $res['hasSecondBest'] = '-';
            $res['hasThirdBest'] = '-';
            $res['hasFourthBest'] = '-';
            $res['sum'] = 0;

            foreach($queriesByUserQueries[$one] as $site){
                if($site == $bestFourSites[0] && $res['hasFirstBest'] == '-'){
                    $res['hasFirstBest'] = $site;
                    $res['sum']++;
                }
                if($site == $bestFourSites[1] && $res['hasSecondBest'] == '-'){
                    $res['hasSecondBest'] = $site;
                    $res['sum']++;
                }
                if($site == $bestFourSites[2] && $res['hasThirdBest'] == '-'){
                    $res['hasThirdBest'] = $site;
                    $res['sum']++;
                }
                if($site == $bestFourSites[3] && $res['hasFourthBest'] == '-'){
                    $res['hasFourthBest'] = $site;
                    $res['sum']++;
                }
            }

            if($res['sum'] == 1 || $res['sum'] == 2){
                $tenSiteList = array_slice($siteList, 0, 10);
                $countRes = count(array_intersect($tenSiteList,$queriesByUserQueries[$one]));
                if($countRes >= 3){
                    $res['sum'] = 2;
                }else{
                    $res['sum'] = 0.5;
                }
            }
            if($res['sum'] >= 2){
                array_push($result,$res);
            }else{
                array_push($minusQueries, $res['query']);
            }
        }

        $result = $this->array_sort($result, 'sum', SORT_DESC);

        $newResult = [];
        foreach ($result as $one){
            $newResult[] = [$one['query']];
        }
        $result = $newResult;

        $newResult = [];
        foreach ($minusQueries as $one){
            $newResult[] = [$one];
        }
        $minusQueries = $newResult;

        Storage::disk('local')->put('logse.json', json_encode($toLog, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $filePath = 'xlFiles/fileCluster'.time().'-'.rand(0,10000).'.xlsx';
        Excel::store(new QueriesClusterExport($result,$minusQueries), $filePath);

        $clusterQuery->nameExcelFile = $filePath;
        $clusterQuery->status = 1;
        $clusterQuery->save();

/*        \Illuminate\Support\Facades\Log::debug('Конец работы с задачей');*/

    }

    public function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function xmlStackQuery($query, $region, $count){
        $xs_key = 'https://xmlstock.com/yandex/xml/?user=9455&key='.env('XMLSTACK_API_KEY');
        $query = ( '&query='.urlencode($query) ) . ( $region ? '&lr=' . urlencode($region) : '' );
        try {
            $xml = file_get_contents($xs_key . $query);
        } catch (Exception $e) {
            sleep(1);
            $xml = file_get_contents($xs_key . $query);
        }

        $res = $this->processXml($xml);

        if($count == 20){ // Если юзер выбрал ТОП20, то смотрим ещё вторую страницу
            $xml = file_get_contents($xs_key . $query . '&page=2');
            $res2 = $this->processXml($xml);
            $res = array_merge($res,$res2);
        }

        return $res;
    }

    private function processXml($t){
        $t = new \SimpleXMLElement( $t );
        $t = json_decode( json_encode( $t, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ), 1);

        $t =  $t['response']['results']['grouping']['group'];

        $res=[];
        foreach ($t as $v) {
            $tmp = idn_to_utf8(urldecode($v['doc']['url']));
            if($tmp == false){
                $host = idn_to_utf8(parse_url(urldecode($v['doc']['url']))['host']);
                $tmp = str_replace(parse_url(urldecode($v['doc']['url']))['host'], $host, $v['doc']['url']);
            }
            $res[] = $tmp;
        }
        $res=array_reverse($res);
        return $res;
    }

    private function multineedle_stripos($haystack, $needles, $offset=0) {
        $phrase = explode(' ', $haystack);
        foreach($phrase as $one){
            foreach($needles as $needle) {
                if(str_starts_with($one, $needle) !== false){
                    return true;
                }
            }
        }

        return false;
    }

    private function multineedle_striposFul($haystack, $needles, $offset=0) {
        $phrase = explode(' ', $haystack);
        foreach($phrase as $one){
            foreach($needles as $needle) {
                if($one == $needle){
                    return true;
                }
            }
        }

        return false;
    }


    private function isFirstOrLastPredlog($str, $predlogs){
        $arr = explode(' ',$str);
        if(in_array($arr[0],$predlogs) || in_array($arr[count($arr)-1],$predlogs)){
            return true;
        }
        return false;
    }

    private function clearQueries($userQueries){

        $settings = Price::find(1);
        $stopFull = json_decode($settings->stopClusterFull, true);
        $stopPart = json_decode($settings->stopClusterPart, true);
        $minuses = [];
        $good = [];
        $predlogs = [
            'без', 'в', 'вне', 'во', 'для', 'до', 'за', 'из', 'изо', 'к'
            , 'ко', 'на', 'над', 'о', 'об', 'обо', 'от', 'ото', 'перед', 'по', 'под', 'после', 'пред', 'при', 'про', 'с'
        ];

        foreach($userQueries as $one){
            if(
                count(explode(' ', $one)) == 1 ||
                //preg_match("/^[а-я]{1,3} /", $one) ||
                //preg_match("/\ [а-я]{1,3}$/", $one) ||
                $this->isFirstOrLastPredlog($one, $predlogs) ||
                $this->multineedle_stripos($one, $stopPart) ||
                $this->multineedle_striposFul($one, $stopFull)
            ){
                $minuses[] = $one;
            }else{
                $good[] = $one;
            }
        }

        return [$good, $minuses];

    }
}
