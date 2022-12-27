<?php

use App\Http\Controllers\Dispatcher;
use App\Services\Mvsc\Requests\Request;
use Illuminate\Http\JsonResponse;
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
    Route::any( '/{view?}/{template?}/{id?}', function (Request $request, App $app, $view = null, $template = null, $id = null) {
        $request->setView($view)->setViewTemplate($template)->setIds($id);

        $controller = App::makeWith(Dispatcher::class, ['request' => $request]);
        $controller->execute();

        return $controller->getResponse();
    });
});
