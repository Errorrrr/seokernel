<?php

namespace App\Console\Commands;

use App\Models\ClusterQuery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class xmlThreadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:thread {fileNum}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $queryFile = json_decode(Storage::disk('local')->get('xmlQueries.json'), true);
        $userQueries = $queryFile['userQueries'];
        $queriesByUserQueries = [];
        $res = $this->xmlStackQuery($userQueries[$this->argument('fileNum')], $queryFile['region'], 10);

        $final = [];
        $final['name'] = $userQueries[$this->argument('fileNum')];
        $final['query'] = $res;



        echo json_encode($final, JSON_UNESCAPED_UNICODE);

/*        $offset = $this->getSliceLeftRight(count($userQueries), $this->argument('fileNum'));
        $userQueries = array_slice($userQueries, $offset[0], $offset[1]);
        $queriesByUserQueries = [];
        foreach ($userQueries as $one){
            $res = $this->xmlStackQuery($one, $queryFile['region'], 10);
            $queriesByUserQueries[$one] = $res;
        }
        echo json_encode($queriesByUserQueries, JSON_UNESCAPED_UNICODE);*/
        return 0;
    }

/*    public function getSliceLeftRight($countQueries, $fileNum){

        if($countQueries > 300){
            $countFileNums = 300;
        }else{
            $countFileNums = $countQueries;
        }

        $batchSize = $countQueries/$countFileNums;

        $left = 0;
        $right = 0;
        return [$left,$right];
    }*/

    public function xmlStackQuery($query, $region, $count){

        $checkPrice = $this->curlReq('https://xmlproxy.ru/balance.php?user=omi4sem%40mail.ru&key=MTY0MDI1MTI3Nzg3ODg1ODk3NjU3Mjc1Mzc1', '');
        $jsonInfo = $checkPrice[0];
        $httpcode = $checkPrice[1];
        while($httpcode != 200){
            sleep(3);
            $checkPrice = $this->curlReq('https://xmlproxy.ru/balance.php?user=omi4sem%40mail.ru&key=MTY0MDI1MTI3Nzg3ODg1ODk3NjU3Mjc1Mzc1', '');
            $jsonInfo = $checkPrice[0];
            $httpcode = $checkPrice[1];
        }
        $jsonInfo = json_decode($jsonInfo, true);
        if($jsonInfo['cur_cost'] > 7){
            $xs_key = 'https://xmlstock.com/yandex/xml/?user=9455&key='.env('XMLSTACK_API_KEY');
        }else{
            $xs_key = 'http://xmlproxy.ru/search/xml?page=1&user=omi4sem%40mail.ru&key='.env('XMLPROXY_API_KEY');
        }

        $query = ( '&query='.urlencode($query) ) . ( $region ? '&lr=' . urlencode($region) : '' );
/*        \Illuminate\Support\Facades\Log::debug('Начало запроса к серверу'.$this->argument('fileNum'));*/

        $resp = $this->curlReq($xs_key, $query);
        $xml = $resp[0];
        $httpcode = $resp[1];
        while($httpcode != 200){
            sleep(3);
            $resp = $this->curlReq($xs_key, $query);
            $xml = $resp[0];
            $httpcode = $resp[1];
        }

/*        \Illuminate\Support\Facades\Log::debug('Конец запроса к серверу'.$this->argument('fileNum'));*/

        $res = $this->processXml($xml);

        return $res;
    }

    private function curlReq($xs_key, $query){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL,$xs_key . $query);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
        $xml = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [$xml,$httpcode];
    }

    private function processXml($t){
        $t = new \SimpleXMLElement( $t );
        $t = json_decode( json_encode( $t, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ), 1);
      //  \Illuminate\Support\Facades\Log::debug($t);
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

}
