<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('inicio', 'WelcomeController@index');
Route::get('quienes-somos', 'WelcomeController@about_us');
Route::get('vacantes', 'WelcomeController@vacantes');
Route::get('nuestras-clinicas/traumatologia', 'WelcomeController@sede_traumatologia');
Route::get('nuestras-clinicas/materno_infantil', 'WelcomeController@sede_materno_infantil');
Route::get('nuestras-clinicas/pacientes_cronicos', 'WelcomeController@sede_pacientes_cronicos');
Route::get('contacto', 'WelcomeController@contacto');
Route::post('contacto', 'WelcomeController@sendMsg');
Route::get('galeria', 'WelcomeController@galeria');


Route::get('info', 'InfoController@index');
Route::get('info/form_certificado_pagos_profesionales', 'InfoController@form_certificado_pagos_profesionales');
Route::post('info/certificado_pagos_profesionales', 'InfoController@certificado_pagos_profesionales');
Route::get('info/pdf', 'InfoController@generatePdf');
Route::get('info/form_pago_proveedores', 'InfoController@form_pago_proveedores');
Route::post('info/pago_proveedores', 'InfoController@pago_proveedores');
Route::get('testExcel', 'InfoController@form_certificado_pagos_profesionales_excel');
Route::post('info/testExcel', 'InfoController@testExcel');

Route::get('auth/register', ['middleware' => 'manager', function(){
    return view('auth.register');
}]);
Route::post('register', 'UserController@register');

/*** Usuarios ******/
//Route::get('usuarios', ['middleware' => 'manager', function(){
//    return view('user.index');
//}]);
Route::get('usuarios', 'UserController@index');

Route::post('usuarios/{id}/update', 'UserController@update');
Route::get('usuarios/{id}/edit', 'UserController@edit');
Route::get('usuarios/{id}/delete', 'UserController@delete');

//Route::resource('usuarios', 'UserController');

Route::get('censo/{p}', 'CensoController@censo');

Route::get('contactos', 'ContactController@index');



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

