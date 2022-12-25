<?php

use App\Http\Controllers\Config;
use App\Http\Controllers\Dispatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
    Route::match(['get'], '/{view?}/{id?}', function (Request $request, App $app, $view = null, $id = null) {
        $config = new Config($view, $id);
        $controller = App::makeWith(Dispatch::class, ['config' => $config]);
        $controller->execute($request);

        return $controller->getResponse();
    });

    Route::any('/{view?}/{id?}', function (Request $request, App $app, $view = 'index', $id = null) {

        $config = new Config($view, $id);
        $controller = App::makeWith(Dispatch::class, ['config' => $config]);
        $controller->execute($request);

        return $controller->getResponse();
    });
});

Route::get('/', function () {
    return view('index', ['index' => 0]);
});

Route::post('/preview', function (Request $request) {

   $body = View::make(
       'document.preview',
       $request->input('document', [])
   )->render();
    return new JsonResponse(['body' => $body]);
});

Route::get('/paragraph/{index?}', function ($index = 0) {
    $body = View::make('document.paragraph', ['index' => $index])->render();
    return new JsonResponse(['body' => $body]);
});

Route::get('/sentence/{index?}', function ($index = 0) {
    $body = View::make('document.sentence', ['index' => $index, 'canDelete' => true])->render();
    return new JsonResponse(['body' => $body]);
});
