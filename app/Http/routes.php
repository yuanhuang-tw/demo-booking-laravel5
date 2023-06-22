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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{year?}/{month?}', 'InterviewController@showCalendar')->where(['year' => '[1-2][0-9]{3}', 'month' => '0[1-9]|1[0-2]']);

Route::get('/create/{ymd?}', 'InterviewController@create')->where('ymd', '[0-9]{8}');
Route::post('/create', 'InterviewController@store');

Route::get('/user', 'InterviewController@listInterview');

Route::get('/interview/{interview}', 'InterviewController@detail')->where('interview', '[0-9]+');
Route::get('/interview/{interview}/edit', 'InterviewController@edit')->where('interview', '[0-9]+');
Route::patch('/interview/{interview}', 'InterviewController@update')->where('interview', '[0-9]+');
Route::get('/interview/{interview}/delete', 'InterviewController@destroy')->where('interview', '[0-9]+');

Route::post('/interview/{interview}/upload', 'InterviewController@upload')->where('interview', '[0-9]+');

Route::get('/remove', 'RemoveController@remove')->middleware(['auth', 'admin_middleware']);

Route::get('/search', 'SearchController@search');
Route::post('/search', 'SearchController@searchOutput');

Route::get('/msg', 'MessageController@msg')->middleware(['auth', 'mktg_middleware']);
Route::post('/msg', 'MessageController@msgStore')->middleware(['auth', 'mktg_middleware']);
Route::get('/msg/list', 'MessageController@msgList')->middleware(['auth', 'mktg_middleware']);
Route::get('/msg/{msg}/edit', 'MessageController@msgEdit')->where('msg', '[0-9]+')->middleware(['auth', 'mktg_middleware']);
Route::patch('/msg/{msg}', 'MessageController@msgUpdate')->where('msg', '[0-9]+')->middleware(['auth', 'mktg_middleware']);
Route::get('/msg/{msg}/delete', 'MessageController@msgDestroy')->where('msg', '[0-9]+')->middleware(['auth', 'mktg_middleware']);

Route::get('/dj', 'DjController@dj')->middleware(['auth', 'admin_middleware']);
Route::post('/dj', 'DjController@djStore')->middleware(['auth', 'admin_middleware']);
Route::get('/dj/list', 'DjController@djList')->middleware(['auth', 'admin_middleware']);
Route::get('/dj/{dj}/delete', 'DjController@djDestroy')->where('dj', '[0-9]+')->middleware(['auth', 'admin_middleware']);

Route::get('/reminder', 'ReminderController@reminder');

Route::get('/send-to-department-head/{interview}', 'DepartmentHeadController@sendToDepartmentHead')->where('interview', '[0-9]+');
Route::get('/department-head-approve/{interview}', 'DepartmentHeadController@departmentHeadApprove')->where('interview', '[0-9]+');
Route::get('/department-head-reject/{interview}', 'DepartmentHeadController@departmentHeadReject')->where('interview', '[0-9]+');

Route::get('/requests-list', 'RequestsListController@requestsList');

Route::auth();

// Route::get('/home', 'HomeController@index');
