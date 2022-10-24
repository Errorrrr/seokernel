<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Telegram\Bot\Api;

class SettingsController extends Controller
{
    public function index(){
/*        echo        implode('<br>',json_decode(Storage::disk('local')->get('test.json'), true)['userQueries']);
        dd(1);*/
        return view('settings', ['user'=>Auth::user()]);
    }

    public function getPrices(){
        $user = Auth::user();
        if($user->is_admin == 1){
            $price = Price::where('id','=',1)->first();
            if($price == null){
                $price = Price::firstOrCreate(['id'=>1,'cluster_price'=>0.25,'conc_price'=>20,'start_balance'=>500]);
            }
            return [
                'cluster_price' => $price->cluster_price,
                'conc_price' => $price->conc_price,
                'start_balance' => $price->start_balance,
                'api_keyso' => $price->api_keyso,
                'api_proxy' => $price->api_proxy,
                'api_stack' => $price->api_stack,
            ];
        }else{
            return 'err';
        }
    }

    public function getStops(){
        $user = Auth::user();
        if($user->is_admin == 1){
            $price = Price::where('id','=',1)->first();
            $price->stopClusterPart = implode('\n',json_decode($price->stopClusterPart == "null" ? "[]" : $price->stopClusterPart, true));
            $price->stopClusterFull = implode('\n',json_decode($price->stopClusterFull == "null" ? "[]" : $price->stopClusterFull, true));
            $price->stopKeyso = implode('\n',json_decode($price->stopKeyso == "null" ? "[]" : $price->stopKeyso, true));
            return [
                'partCluster' => $price->stopClusterPart,
                'fullCluster' => $price->stopClusterFull,
                'stopKeys' => $price->stopKeyso,
            ];
        }else{
            return 'err';
        }
    }

    public function changeStops(Request $request){
        $user = Auth::user();
        if($user->is_admin == 0){
            return 'err';
        }
        $price = Price::find(1);
        $price->stopClusterPart = json_encode(explode('\n',$request->get('partCluster')));
        $price->stopClusterFull = json_encode(explode('\n',$request->get('fullCluster')));
        $price->stopKeyso = json_encode(explode('\n',$request->get('stopKeys')));
        $price->save();
        return 'ok';
    }

    public function changePrice(Request $request){
        $user = Auth::user();
        if($user->is_admin == 0){
            return 'err';
        }
        $price = Price::find(1);
        $price->cluster_price = $request->get('cluster_price');
        $price->conc_price = $request->get('conc_price');
        $price->start_balance = $request->get('start_balance');
        $price->api_keyso = $request->get('api_keyso');
        $price->api_proxy = $request->get('api_proxy');
        $price->api_stack = $request->get('api_stack');
        $price->save();
        return 'ok';
    }

    public function changePass(){
        $telegram = new Api(env('TELEGRAM_API'));

        $user = Auth::user();

        $pass = Str::random(15);

        $user->forceFill([
            'password' => Hash::make($pass)
        ])->setRememberToken(Str::random(60));
        $user->save();
        $telegram->sendMessage([
            'chat_id' => $user->chat_id,
            'text' => 'Ваш новый пароль: '.$pass,
        ]);

        $user->save();

        return 'ok';
    }

 }
