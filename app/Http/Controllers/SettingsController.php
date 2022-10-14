<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index(){
        return view('settings', ['user'=>Auth::user()]);
    }

    public function getPrices(){
        $user = Auth::user();
        if($user->is_admin == 1){
            $price = Price::where('id','=',1)->first();
            if($price == null){
                $price = Price::firstOrCreate(['id'=>1,'cluster_price'=>0.25,'conc_price'=>20]);
            }
            return [
                'cluster_price' => $price->cluster_price,
                'conc_price' => $price->conc_price,
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
        $price->save();
        return 'ok';
    }

    public function changePass(Request $request){
        $user = Auth::user();
        if (Hash::check($request->get('old_pass'), $user->password)) {
            if($request->get('new_pass') == $request->get('new_pass_accept')){
                $user->forceFill([
                    'password' => Hash::make($request->get('new_pass'))
                ])->setRememberToken(Str::random(60));
            }else{
                return 'Новый и старый пароль не совпадают';
            }
            $user->save();
        }else{
            return 'Неверный старый пароль';
        }


        $user->save();

        return 'ok';
    }

 }
