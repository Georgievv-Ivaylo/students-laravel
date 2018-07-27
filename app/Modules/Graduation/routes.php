<?php

Route::group(['middleware' => ['web']], function () {
	Route::get(
		'graduation', 'App\Modules\Graduation\Controllers\ViewController@index'
	)->name('graduation');
	Route::get(
		'ajax/graduation/form', 'App\Modules\Graduation\Controllers\ViewController@validationForm'
	)->name('validationForm');
	Route::get(
		'graduation/new', 'App\Modules\Graduation\Controllers\ViewController@new'
	)->name('graduationNew');
	Route::post(
		'graduation/new', 'App\Modules\Graduation\Controllers\ViewController@newPost'
	)->name('graduationNew');
	Route::get(
		'graduation/edit/{id}', 'App\Modules\Graduation\Controllers\ViewController@edit'
	)->name('graduationEdit');
	Route::patch(
		'graduation/edit/{id}', 'App\Modules\Graduation\Controllers\ViewController@editPatch'
	)->name('graduationEdit');
	Route::put(
		'graduation/delete/{id}', 'App\Modules\Graduation\Controllers\ViewController@editDelete'
	)->name('graduationDelete');
});
