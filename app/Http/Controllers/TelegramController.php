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
        \Illuminate\Support\Facades\Log::debug($requ);
        $userid = $requ['message']['from']['id'];
        if(isset($requ['message']['contact']) && isset($requ['message']['contact']['phone_number'])){
            $user = User::where('name','=',$requ['message']['from']['username'])->first();
            $userWithSameNubmer = User::where('phone','=',$requ['message']['contact']['phone_number'])->first();
            if($userWithSameNubmer == null){
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

           }else{
                $response = $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => 'Пользователь с таким номером телефона уже существует',
                ]);
           }


        }else{
            $text   = $requ['message']['text'];

            if ($text == '/start') {
                $keyboard = [
                    'keyboard' => [
                        [
                            ['text' => 'Зарегистрироваться', 'request_contact' => true,]
                        ]
                    ],
                    'resize_keyboard' => true,
                ];
                $encodedKeyboard = json_encode($keyboard);

                $response = $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => 'Чтобы зарегистрироваться нажмите на кнопку ниже',
                    'reply_markup' => $encodedKeyboard,
                ]);
            }
        }



    }
}
