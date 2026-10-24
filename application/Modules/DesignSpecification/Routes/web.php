<?php

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

Route::prefix('modules/designspecification')->group(function() {
    Route::any("/search", "Specifications@index");
    Route::get('/', 'Specifications@index');
    Route::get("/{id}/client-project", "Specifications@editClientProject")->where('id', '[0-9]+');
    Route::put("/{id}/client-project", "Specifications@updateClientProject")->where('id', '[0-9]+');
    Route::get("/{id}/email-specification", "Specifications@emailSpecification")->where('id', '[0-9]+');
    Route::put("/{id}/email-specification", "Specifications@emailSpecificationAction")->where('id', '[0-9]+');
    Route::get('/settings/general-notes', 'Specifications@generalNotes');
    Route::post('/settings/general-notes', 'Specifications@updateGeneralNotes');

});
Route::resource('modules/designspecification', 'Specifications');

