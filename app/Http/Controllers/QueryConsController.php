<?php

namespace App\Http\Controllers;

use App\Models\MainQuery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QueryConsController extends Controller
{
    public function getQueryCons(){
        $user = Auth::user();
        $result = [];
        foreach(MainQuery::where('user_id','=',$user->id)->orderBy('created_at','desc')->paginate(40) as $one){
            $one['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $one['created_at'])->format('Y-m-d');
            array_push($result, $one);
        }
        return $result;
    }

    public function downloadExcel($query){
        $user = Auth::user();
        $mainQuery = MainQuery::where('query','=',$query)->where('user_id','=',$user->id)->first();
        return Storage::download($mainQuery->nameExcelFile);
    }

    public function deleteQuery(Request $request){
        $user = Auth::user();

        $mainQuery = MainQuery::where('query','=',$request->get('query'))->where('user_id','=',$user->id)->first();
        Storage::delete($mainQuery->nameExcelFile);
        $mainQuery->delete();
        return 'ok';
    }
}
