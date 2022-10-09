<?php

namespace App\Http\Controllers;

use App\Jobs\ClusterJob;
use App\Models\ClusterQuery;
use App\Models\MainQuery;
use App\Models\SearchRegion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QueryClusterController extends Controller
{

    public function getQueryCluster(){
        $user = Auth::user();
        $result = [];
        foreach(ClusterQuery::where('user_id','=',$user->id)->orderBy('created_at','desc')->paginate(40) as $one){
            $one['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $one['created_at'])->format('Y-m-d');
            array_push($result, $one);
        }
        return $result;
    }

    public function downloadExcel($query){
        $user = Auth::user();
        $mainQuery = ClusterQuery::where('query','=',$query)->where('user_id','=',$user->id)->first();
        return Storage::download($mainQuery->nameExcelFile);
    }

    public function deleteQuery(Request $request){
        $user = Auth::user();

        $mainQuery = ClusterQuery::where('query','=',$request->get('query'))->where('user_id','=',$user->id)->first();
        Storage::delete($mainQuery->nameExcelFile);
        $mainQuery->delete();
        return 'ok';
    }

    public function getRegions(Request $request) {
        return SearchRegion::where('name', 'LIKE', "{$request->get('q')}%")->limit(5)->get();
    }

    public function addTask(Request $request){
        $user = Auth::user();
        $clusterQuery = ClusterQuery::firstOrCreate(['query'=>$request->get('query')],[
            'status'=>0,
            'queryList'=>json_encode($request->get('userQueries'), JSON_UNESCAPED_UNICODE),
            'siteList'=>json_encode($request->get('list'), JSON_UNESCAPED_UNICODE),
            'query'=>$request->get('query'),
            'region_code'=>$request->get('region'),
            'user_id'=>$user->id,
            'nameExcelFile'=>'none',
        ]);
        $user->balance = $user->balance - count(explode(PHP_EOL,$request->get('userQueries')))*env('PRICE_CLUSTER');
        $user->save();
        ClusterJob::dispatch($clusterQuery->id);
        return 'ok';
    }
}
