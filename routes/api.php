<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cors')->post('/login/u/{user}/{token}', 'Auth\LoginController@updateToken')->name('update.token');

Route::prefix('v2') ->group(function(){


    //test to show what is received when post method fired

    Route::resource('mileagetype', 'MileageTypeController'); //middleware not required
    Route::resource('transporttype', 'TransportTypeController'); //middleware not required

    Route::prefix('claims')->middleware('auth:api')->group(function(){


        Route::middleware('auth:api')->prefix('travel')->group(function(){
            Route::prefix('sfc')->group(function (){
               Route::get('parking/{claim}',        'ParkingController@showForClaim');
               Route::get('transport/{claim}',      'TransportController@showForClaim');
               Route::get('subsistence/{claim}',    'SubsistenceController@showForClaim');
               Route::get('mileage/{claim}',        'MileageController@showForClaim');
            });
            Route::resource('parking', 'ParkingController');
            Route::resource('transport', 'TransportController');
            Route::resource('subsistence', 'SubsistenceController');
            Route::resource('mileage', 'MileageController');
            Route::middleware('auth:api')->get('/', 'ClaimsController@travel')->name('api.myclaims.travel');
            Route::get('{id}', 'ClaimsController@myTravelClaim')->name('api.myclaim.travel');
            Route::get('a/{id}', 'ClaimsController@getTravelClaim')->name('api.claim.travel');
        });
        Route::middleware('auth:api')->prefix('time')->group(function(){
            Route::resource('t', 'HoursController');
            Route::get('', 'ClaimsController@time')->name('api.myclaims.time');
        });
        Route::get('submissions', 'SubmissionController@my')->name('api.submissions.my');
        Route::get('submissions/authorisation', 'SubmissionController@myAuthorisations')->name('api.submissions.myauth');
        Route::post('submissions', 'SubmissionController@submit')->name('api.submissions.submit');
        Route::delete('submissions', 'SubmissionController@retract')->name('api.submissions.retract');
        Route::resource('outcomes', 'OutcomeController');
        Route::get('{id}', 'ClaimsController@show')->name('api.myclaim');
        Route::get('{id}/retract', 'ClaimsController@retract')->name('api.myclaim.retract');
    });
    Route::prefix('user')->middleware('auth:api')->group(function(){
        Route::get('', 'Auth\AuthDataController@authData');
        Route::get('team', 'User\PersonnelController@myTeam')->name('api.myteam.list');
        Route::get('messages', 'User\MessageController@messageList')->name('api.messages.list');
        Route::get('messages/{id}', 'User\MessageController@messageDetails')->name('api.messages.details');
    });
    Route::middleware('auth:api')->prefix('!/admin')->group(function(){
        Route::get('users', 'Admin\UserController@userList')->name('api.admin.users.view');
        Route::get('users/{id}/', 'Admin\UserController@userDetails')->name('api.admin.user.view');
        Route::get('sessions', 'Admin\UserController@userSessions')->name('api.admin.users.sessions');
        Route::post('sessions/create', 'Admin\UserController@createSession')->name('api.admin.users.sessions.create');
        Route::delete('sessions', 'Admin\UserController@purgeSessions')->name('api.admin.users.sessions.purge');
        Route::get('groups', 'Admin\GroupController@groupList')->name('api.admin.groups.view');
        Route::get('groups/{id}/', 'Admin\GroupController@groupDetails')->name('api.admin.group.view');
        Route::get('stafflist', 'Admin\UserController@staffList');
        Route::resource('mileagetypes/ppm', 'PPMController');

        //authorisation admin routes
        Route::resource('agf-members', 'AuthGroupMemberController');
        Route::get('agf/my', 'AuthGroupMemberController@myGroups');
        Route::resource('aga', 'AuthGroupAuthorisationController');
        Route::resource('submissions', 'SubmissionController');
    });


    Route::resource('r', "ReflectorController");
    Route::get('test', 'Admin\UserController@staffList');

    //test apis while in development
    Route::resource('form', 'FormController');
    Route::middleware('auth:api')->resource('claim', 'ClaimsController');
    Route::resource('claimstatus', 'ClaimStatusController');
});

