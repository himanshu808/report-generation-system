<?php

// use App\Http\Controllers\SubjectsController;
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
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::resource('leaves','LeavesController');

	Route::resource('classes','ClassesController');

	Route::post('/subjects/list', 'SubjectsController@list')->name('subjects.list');
	Route::resource('subjects','SubjectsController');
	Route::delete('/subjects/{subject}/{class}','SubjectsController@destroy');
	Route::post('/subjects/create/{class}','SubjectsController@create');
	Route::post('/subjects/{class}/{teacher}','SubjectsController@store');
	Route::put('/subjects/{subject}/{teacher}','SubjectsController@update');
	Route::post('ajax-batch', ['as' => 'ajax-batch','uses' => 'SubjectsController@ajaxBatch']);
	// Route::get('/subjects/list','SubjectsController@list')->name('subjects.list');


	Route::post('/topics/list', 'TopicsController@list');
	Route::resource('topics','TopicsController');
	Route::post('ajax-call', ['as' => 'ajax-call','uses' => 'TopicsController@ajaxCall']);
	Route::post('/topics/create/{subject}','TopicsController@create');
	Route::post('/topics/{subject}','TopicsController@store');
	Route::delete('/topics/{topic}/{subject}','TopicsController@destroy');

	Route::get('/reports', 'ReportsController@index')->name('reports.index');
	Route::post('/reports', 'ReportsController@generate')->name('reports.generate');
	Route::put('/reports', 'ReportsController@excel')->name('reports.excel');
	Route::get('/reports/{course_code}/{month}', 'ReportsController@adjustedDetails')->name('reports.adjusted');

	// Route::post('ajax-month', ['as' => 'ajax-month','uses' => 'ReportsController@ajaxMonth']);
	Route::get('/lectures', 'LecturesController@index')->name('lectures.index');
	Route::post('ajax-subject', ['as' => 'ajax-subject','uses' => 'LecturesController@ajaxSubject']);
	Route::post('/lectures','LecturesController@list');
	Route::post('/lectures/{data}','LecturesController@store')->name('lectures.store');

	Route::get('/midterm', 'MidtermController@index')->name('midterm.index');
	Route::post('/midterm', 'MidtermController@generate')->name('midterm.generate');
	Route::put('/midterm', 'MidtermController@excel')->name('midterm.excel');
	Route::get('/midterm/{course_code}/{from}/{to}', 'MidtermController@adjustedDetails')->name('midterm.adjusted');
});

Route::get('/home', 'HomeController@index')->name('home');
