<?php

use GuzzleHttp\Middleware;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'usuarioAdmin'], function (){
    Route::get('clientes', function () {
        return view('cliente');
    })->name('cliente');

    Route::get('concesionarios', function () {
        return view('concesionario');
    })->name('concesionario'); 

    Route::get('reporte/clientes', 'ReporteController@viewReportes')->name('viewreporte');
    Route::get('reporte/clientespdf/{idc}/{idl}', 'ReporteController@clientes')->name('reporteClientepdf');
    Route::get('reporte/concesionariopdf', 'ReporteController@concesionario')->name('reporteConcesionariopdf');

    Route::get('reporte/datosconcesionarios', 'ReporteController@datosconcesionarios')->name('datosconcesionarios');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


