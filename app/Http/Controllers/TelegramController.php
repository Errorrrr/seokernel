<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public function webhook(){
        $telegram = new Api(env('TELEGRAM_API'));
        $requ= json_decode(file_get_contents('php://input'),true);
        $userid = $requ['message']['from']['id'];
        $text   = $requ['message']['text'];


        if ($text == '/start') {
            $user = User::where('name','=',$requ['message']['from']['username'])->first();
            if($user == null){
                $response = $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => 'Вы незарегистрированы',
                ]);
            }else{
                $pass = Str::random(rand(8,12));
                $user->forceFill([
                    'password' => Hash::make($pass)
                ])->setRememberToken(Str::random(60));
                $user->chat_id = $userid;
                $user->save();

                $response = $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => 'Ваш пароль: '.$pass.' Продолжите на сайте: https://turbo-yadro.ru',
                ]);

            }

        }
    }
}
