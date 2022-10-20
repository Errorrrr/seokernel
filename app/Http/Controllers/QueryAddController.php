<?php

namespace App\Http\Controllers;

use App\Exports\QueriesExport;
use App\Models\Price;
use App\Models\Query;
use Carbon\Carbon;
use Fomvasss\Punycode\Facades\Punycode;
use Illuminate\Http\Request;
use App\Models\MainQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QueryAddController extends Controller
{

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


    public function getPagesList(Request $request){
        $region = $request->get('region') == null ? "1" : $request->get('region');

        $settings = Price::find(1);
        $stopKeyso = explode(PHP_EOL,json_decode($settings->stopKeyso, true)[0]);


        if($this->multineedle_stripos($request->get('request'), $stopKeyso)){
            return 'err';
        }


        $checkPrice = file_get_contents('https://xmlproxy.ru/balance.php?user=omi4sem%40mail.ru&key='.env('XMLPROXY_API_KEY'));
        $jsonInfo = json_decode($checkPrice, true);
        if($jsonInfo['cur_cost'] > 7){
            $xs_key = 'https://xmlstock.com/yandex/xml/?user=9455&key='.env('XMLSTACK_API_KEY');
        }else{
            $xs_key = 'http://xmlproxy.ru/search/xml?groupby=attr%3Dd.mode%3Ddeep.groups-on-page%3D10.docs-in-group%3D3&user=omi4sem%40mail.ru&key='.env('XMLPROXY_API_KEY');
        }

     //   $region = $this->getYaRegionCode( $region );
        $query = ( '&query='.urlencode($request->get('request')) ) . ( $region ? '&lr=' . urlencode($region) : '' );
        $xml = file_get_contents($xs_key . $query);
        $res = $this->processXml($xml);

        if($request->get('limit') == 'ТОП-20'){ // Если юзер выбрал ТОП20, то смотрим ещё вторую страницу
            $xml = file_get_contents($xs_key . $query . '&page=2');
            $res2 = $this->processXml($xml);
            $res = array_merge($res,$res2);
        }


        return $res;
    }

    public function addTask(Request $request){
       // Excel::download(new UsersExport, 'users.xlsx');
        $user = Auth::user();
        $price = Price::find(1);

        if($user->balance - $price->conc_price >= 0){
            $user->balance = $user->balance - $price->conc_price;
            $user->save();
        }else{
            return 'err';
        }


        $rid = $this->getKeysoGroup($request->get('list'),'msk');
        $keywords = json_decode($this->getKeysoKeywordsByRid($rid, ['base'=>'msk']), true);

        $resArray = [];
       // dd($keywords['data'][0]);
        foreach($keywords['data'] as $key=>$one){
            unset($keywords['data'][$key]['weight']);
            unset($keywords['data'][$key]['docs']);
            unset($keywords['data'][$key]['avbid']);
            unset($keywords['data'][$key]['adscnt']);
            unset($keywords['data'][$key]['isgeo']);
            unset($keywords['data'][$key]['isquest']);
            unset($keywords['data'][$key]['serpf']);
/*            Query::updateOrCreate([
                'query'=>$one['word'],
                'ws'=>$one['ws'],
                'wsk'=>$one['wsk'],
                'numwords'=>$one['numwords'],
                'main_queries_id'=>$mainQuery->id,
            ]);*/
        }
        $filePath = 'xlFiles/file'.time().'-'.rand(0,10000).'.xlsx';
        Excel::store(new QueriesExport($keywords['data']), $filePath); //Чтобы файлы не затёрлись добавляем соль в название
        if(MainQuery::where('user_id','=',$user->id)->where('query','=',$request->get('query'))->first() != null){
            //Случай если юзер снова тот же запрос обрабатывает, чтоб не засорять серв удаляем эксель
            $mainQuery = MainQuery::where('user_id','=',$user->id)->where('query','=',$request->get('query'))->first();
            Storage::delete($mainQuery->nameExcelFile);
            $mainQuery->delete();
            $mainQuery = MainQuery::firstOrCreate([
                'user_id'=>$user->id,
                'query'=>$request->get('query'),
                'nameExcelFile'=>$filePath,
            ]);
        }else{
            $mainQuery = MainQuery::firstOrCreate([
                'user_id'=>$user->id,
                'query'=>$request->get('query'),
                'nameExcelFile'=>$filePath,
            ]);
        }


        return 'ok';
    }



    private function processXml($t){
        $t = new \SimpleXMLElement( $t );
        $t = json_decode( json_encode( $t, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ), 1);

        $t =  $t['response']['results']['grouping']['group'];

        $res=[];
        foreach ($t as $v) {
            if(!isset($v['doc'][0])){
                $prefix = $v['doc'];
            }else{
                $prefix = $v['doc'][0];
            }
            $tmp = idn_to_utf8(urldecode($prefix['url']));
            if($tmp == false){
                $host = idn_to_utf8(parse_url(urldecode($prefix['url']))['host']);
                $tmp = str_replace(parse_url(urldecode($prefix['url']))['host'], $host, $prefix['url']);
            }
            $res[] = $tmp;
        }
        $res=array_reverse($res);
        return $res;
    }

    public function getKeysoKeywordsByRid( $rid, $opts=[] ){
        $path = 'tools/keywords_by_pages/weight/' . $rid;

        $pars = 'base=' . $opts['base'] . '&sort=wsk%7Cdesc&page=1&per_page=500000';
        $res = $this->getKeysoBase( $path, [ $pars ], false);

        return $res;
    }

    public function getKeysoBase( $path, $requests, $usePost=true )
    {
        $base = 'https://api.keys.so/';
        $token = '62fe145ec43a41.44769549622a118f33cc51b840c0e6be5d338ac6';

        $reqs = http_build_query($requests, '', '&');

        $url = $base . $path;
        $curl = curl_init();
        $headers = array('X-Keyso-TOKEN: ' . $token,
            'Content-Type: application/json'
        );
        if ( $usePost ) {
            //curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST , 'POST');
            // curl_setopt($curl, CURLOPT_POSTFIELDS, $reqsa);
            curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode( $requests ) );
        } else {
            $url .= '?' . $requests[0];
        }

        //file_put_contents( $_SERVER['DOCUMENT_ROOT'] . '/files/test3.json', json_encode( [$url, $path, $requests, $usePost] ) );


        $this->temp['reqs_in_getKeysoBase'] = json_encode( $requests );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER =>  $headers,
        ));

        $response = curl_exec($curl);

//        $this->temp['res']=$response;   //t
//        $this->temp['url']=$url;        //t
//        $this->temp['reqs']= $reqs;     //t

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headerCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseBody = $response; //substr($response, $header_size);
        curl_close($curl);
        $this->temp['code'] = $headerCode; //t

        return $responseBody;
    }

    public function getKeysoGroup( $sitelist, $region_code )
    {
        $opts = [
            'base'=>$region_code,
            'list'=>$sitelist
        ];

        $rid = json_decode( $this->getKeysoBase('tools/keywords_by_pages', $opts), 1 ); //json_decode( $this->getKeysoBase('report/group', $opts) );
        $this->temp['rid_']=var_export( $rid['uid'], 1);//t

        return $rid['uid'];
    }


}
