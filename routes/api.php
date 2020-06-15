<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth'], function ($router) {
    
    Route::get('fetch/request', 'Requester\RequestingController@fetchRequest');

    Route::get('requesting', 'Requester\RequestingController@index');
    Route::delete('requesting/{id}', 'Requester\RequestingController@destroy');
    Route::post('requesting', 'Requester\RequestingController@store');
    Route::get('edit_request/{id}', 'Requester\RequestingController@edit');
    Route::patch('edit/requesting/{id}', 'Requester\RequestingController@update');

    //Admin Side
    Route::get('admin_request', 'Admin\AdminController@index');
    Route::get('ribshack', 'Admin\AdminController@ribshack');
    Route::get('delcom', 'Admin\AdminController@delcom');
    Route::get('ramx', 'Admin\AdminController@ramx');
    Route::get('request/{id}', 'Admin\AdminController@show');
    Route::patch('admin/approve/{id}', 'Admin\AdminController@approve');
    Route::patch('admin/disapprove/{id}', 'Admin\AdminController@disapprove');

    //HR Side
    Route::get('applicants', 'HR\HRController@index');
    Route::get('applicant/show/{id}', 'HR\HRController@showApplicant');
    Route::get('applicants/pending', 'HR\HRController@pending');
    Route::get('pending/applicants', 'HR\HrController@pendingApplicant');
    Route::get('applicants/screening', 'HR\HrController@screening');
    Route::get('applicants/requirements', 'HR\HrController@requirements');
    Route::post('insert/screening', 'HR\HrController@insertScreening');
    Route::post('insert/requirements', 'HR\HrController@insertRequirements');
    Route::patch('update/screening/{id}', 'HR\HrController@saveScreening');
    Route::patch('update/requirements/{id}', 'HR\HrController@saveRequirements');
    Route::patch('remove/applicant/{id}', 'HR\HrController@remove');
});



Route::group([

    'middleware' => 'api',

], function ($router) {

//Applcicant Side
Route::get('applicants/location', 'Applicant\ApplicantController@location');
Route::get('applicants/position/{branch_location}', 'Applicant\ApplicantController@position');
Route::post('applicants', 'Applicant\ApplicantController@store');

});


