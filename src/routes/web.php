<?php

use App\Http\Controllers\Dispatcher;
use App\Services\Mvsc\Config;
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
    Route::match(['get'], '/{view?}/{template?}/{id?}', function (Request $request, App $app, $view = null, $template = null, $id = null) {
        $config = new Config($view, $template, $id);
        $controller = App::makeWith(Dispatcher::class, ['config' => $config]);
        $controller->execute($request);

        return $controller->getResponse();
    });

    Route::any('/{view?}/{template?}/{id?}', function (Request $request, App $app, $view, $template = null , $id = null) {

        $config = new Config($view, $template, $id);
        $controller = App::makeWith(Dispatcher::class, ['config' => $config]);
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
