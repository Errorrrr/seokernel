<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TinkoffController extends Controller
{
    public function createPayment(Request $request){
        $sum = $request->get('sum')*100;
        $orderId = rand(100,999).'0'.count(Transactions::all());
        $postdata = json_encode(
            array(
                'Amount' => $sum,
                'OrderId' => $orderId,
                'TerminalKey' => env('TINKOFF_TERMINAL_ID'),
                'Description'=>'Пополнение баланса на сумму '.($sum/100).' руб. на сайте turbo-yadro.ru',
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);
        Transactions::create([
            'amount'=>$sum,
            'status'=>0,
            'payment_id'=>0,
            'order_id'=>$orderId,
            'user_id'=>Auth::user()->id,
        ]);
        $result = file_get_contents('https://securepay.tinkoff.ru/v2/Init', false, $context);
        $result = json_decode($result, true);
        return redirect($result['PaymentURL']);
    }

    public function hookPayment(){
        $requ= json_decode(file_get_contents('php://input'),true);
        \Illuminate\Support\Facades\Log::debug($requ);
        return 'OK';
    }
}
