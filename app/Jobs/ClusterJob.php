<?php

namespace App\Jobs;

use App\Exports\QueriesClusterExport;
use App\Exports\QueriesExport;
use App\Models\ClusterQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ClusterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


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
        $clusterQuery = ClusterQuery::find($this->clusterTaskId);

        $region = $clusterQuery->region_code;
        $userQueries = json_decode($clusterQuery->queryList);
        $userQueries = explode(PHP_EOL, $userQueries);
        $siteList = json_decode($clusterQuery->siteList, true);
        $allSitesFromUserQueries = [];
        $queriesByUserQueries = [];

        foreach ($userQueries as $one){
            $res = $this->xmlStackQuery($one, $region, 10);
            usleep(70000);
            $allSitesFromUserQueries = array_merge($allSitesFromUserQueries, $res);
            $queriesByUserQueries[$one] = $res;
        }
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
                $countRes = array_intersect($tenSiteList,$queriesByUserQueries[$one]);
                if($countRes >= 3){
                    $res['sum'] = 2;
                }else{
                    $res['sum'] = 0.5;
                }
            }

            array_push($result,$res);
        }

        $result = $this->array_sort($result, 'sum', SORT_DESC);

        $filePath = 'xlFiles/fileCluster'.time().'-'.rand(0,10000).'.xlsx';
        Excel::store(new QueriesClusterExport($result), $filePath);

        $clusterQuery->nameExcelFile = $filePath;
        $clusterQuery->status = 1;
        $clusterQuery->save();
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
        $xml = file_get_contents($xs_key . $query);
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
        foreach ($t as $v) { $res[] = urldecode($v['doc']['url']); }
        $res=array_reverse($res);
        return $res;
    }
}
