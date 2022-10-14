<?php

namespace App\Handlers;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleBotAPI\UpdatesHandler;

class BotHandler extends UpdatesHandler
{
    public function MessageHandler($message) : bool
    {

        if (property_exists($message, 'text'))
        {
     //       if ($message->text == '/start') {
                $user = User::where('name','=',$message->chat->username)->first();
                if($user == null){
                    $this->Bot->SendMessage([
                        'chat_id' => $message->chat->id,
                        'text' => 'Вы незарегистрированы',
                        'reply_markup' => json_encode(['inline_keyboard' => [
                            [
                                [
                                    'text' => 'Зарегистрироваться',
                                    'url' => 'https://turbo-yadro.ru/register'
                                ]
                            ]
                        ]])
                    ]);
                }else{
                    $pass = Str::random(rand(8,12));
                    $user->forceFill([
                        'password' => Hash::make($pass)
                    ])->setRememberToken(Str::random(60));
                    $user->save();

                    $this->Bot->SendMessage([
                        'chat_id' => $message->chat->id,
                        'text' => 'Ваш пароль: '.$pass,
                        'reply_markup' => json_encode(['inline_keyboard' => [
                            [
                                [
                                    'text' => 'Продолжить на сайте',
                                    'url' => 'https://turbo-yadro.ru/login'
                                ]
                            ]
                        ]])
                    ]);
                }

         //   }
        }
        return true;
    }
}
