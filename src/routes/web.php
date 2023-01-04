<?php

use App\Http\Controllers\Dispatcher;
use App\Services\Mvsc\Requests\MvscRequest;
use App\Services\Mvsc\SystemNotifications\MessageQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::group(['middleware' => ['XssSanitizer']], function () {
    Route::any( '/{view?}/{template?}/{id?}',
        function (Request $request, MessageQueue $msgQue, $view = null, $template = null, $id = null)
        {
            $mvscRequest = new MvscRequest($request, $msgQue, $view, $template, $id);
            $controller = App::makeWith(Dispatcher::class, ['request' => $mvscRequest]);
            $controller->execute();

            return $controller->getResponse();
        }
    );
});
