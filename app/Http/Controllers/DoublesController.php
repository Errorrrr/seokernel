<?php

namespace App\Http\Controllers;

use App\Exports\DoublesExport;
use App\Exports\QueriesExport;
use App\Models\Doubles;
use App\Models\MainQuery;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DoublesController extends Controller
{
    public function getDoubles(){
        $user = Auth::user();
        $result = [];
        foreach(Doubles::where('user_id','=',$user->id)->orderBy('created_at','desc')->paginate(40) as $one){
            $one['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $one['created_at'])->format('Y-m-d');
            array_push($result, $one);
        }
        return $result;
    }

    public function downloadExcel($query){
        $user = Auth::user();
        $mainQuery = Doubles::where('name','=',$query)->where('user_id','=',$user->id)->first();
        return Storage::download($mainQuery->nameExcelFile);
    }

    public function deleteDoubles(Request $request){
        $user = Auth::user();

        $mainQuery = Doubles::where('name','=',$request->get('name'))->where('user_id','=',$user->id)->first();
        Storage::delete($mainQuery->nameExcelFile);
        $mainQuery->delete();
        return 'ok';
    }

    public function addDoubles(Request $request){
        $user = Auth::user();
        $price = Price::find(1);

        if($user->balance - $price->doubles_price >= 0){
            $user->balance = $user->balance - $price->doubles_price;
            $user->save();
        }else{
            return 'err';
        }
        $queries = explode(PHP_EOL, $request->get('userQueries'));
        $withoutDoubles = $this->deleteKeysoDoubles($queries);
        $res = [];
        foreach ($withoutDoubles as $one){
            $res[] = [$one];
        }
        $filePath = 'xlFiles/file'.time().'-'.rand(0,10000).'.xlsx';
        Excel::store(new DoublesExport($res), $filePath);
        $doubles = Doubles::create([
            'user_id'=>$user->id,
            'name'=>'Смысловые дубли',
            'queryList'=>json_encode($queries,JSON_UNESCAPED_UNICODE),
            'nameExcelFile'=>$filePath,
        ]);
        $doubles->name = 'Смысловые дубли №'.$doubles->id;
        $doubles->save();
        return 'ok';
    }


    public function deleteKeysoDoubles( $phrases )
    {
        $opts = [
            'list'=>$phrases
        ];
        $rid = json_decode( $this->getKeysoBase('tools/delete_double', $opts), 1 ); //json_decode( $this->getKeysoBase('report/group', $opts) );
        return $rid['keys'];
    }
    public function getKeysoBase( $path, $requests, $usePost=true )
    {
        $price = Price::find(1);
        $base = 'https://api.keys.so/';
        $token = $price->api_keyso;

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

}
