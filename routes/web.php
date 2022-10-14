<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect()->route('queries');;
})->middleware(['auth']);

Route::get('/queries', function () {
    return view('queries', ['user'=>\Illuminate\Support\Facades\Auth::user()]);
})->middleware(['auth'])->name('queries');

Route::get('/clusters', function () {
    return view('queries_cluster', ['user'=>\Illuminate\Support\Facades\Auth::user()]);
})->middleware(['auth']);

Route::get('/clusters/add_tusk', function () {
    return view('queries_cluster_add', ['user'=>\Illuminate\Support\Facades\Auth::user()]);
})->middleware(['auth']);

Route::get('/queries/add_tusk', function () {
    return view('queries_add', ['user'=>\Illuminate\Support\Facades\Auth::user()]);
})->middleware(['auth']);

Route::get('/prices', function () {
    return view('prices', ['price'=>\App\Models\Price::find(1), 'user'=>\Illuminate\Support\Facades\Auth::user()]);
})->middleware(['auth']);

Route::post('/api/pages_list', 'QueryAddController@getPagesList')->middleware(['auth']);
Route::post('/api/add_task', 'QueryAddController@addTask')->middleware(['auth']);
Route::post('/api/cluster_add_task', 'QueryClusterController@addTask')->middleware(['auth']);
Route::get('/api/get_query_cons', 'QueryConsController@getQueryCons')->middleware(['auth']);
Route::get('/api/get_query_cluster', 'QueryClusterController@getQueryCluster')->middleware(['auth']);
Route::get('/api/get_regions', 'QueryClusterController@getRegions')->middleware(['auth']);
Route::get('api/download_excel/{query}', 'QueryConsController@downloadExcel')->middleware(['auth']);
Route::get('api/download_excel_cluster/{query}', 'QueryClusterController@downloadExcel')->middleware(['auth']);
Route::post('api/delete_query', 'QueryConsController@deleteQuery')->middleware(['auth']);
Route::post('api/delete_query_cluster', 'QueryClusterController@deleteQuery')->middleware(['auth']);
Route::get('api/get_price', 'SettingsController@getPrices')->middleware(['auth']);
Route::get('api/get_stops', 'SettingsController@getStops')->middleware(['auth']);
Route::post('api/change_price', 'SettingsController@changePrice')->middleware(['auth']);
Route::post('api/change_stops', 'SettingsController@changeStops')->middleware(['auth']);
Route::post('api/change_password', 'SettingsController@changePass')->middleware(['auth']);
Route::post('/bot_webhook', function () {
    \Illuminate\Support\Facades\Log::debug('An informational message.');

    $Bot = new \SimpleBotAPI\TelegramBot(env('TELEGRAM_API'), new \App\Handlers\BotHandler());
    $Bot->OnWebhookUpdate();
})->middleware('api');

Route::get('/settings', 'SettingsController@index')->middleware(['auth']);

require __DIR__.'/auth.php';
