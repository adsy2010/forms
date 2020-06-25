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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/user', 'HomeController@index')->name('user.dashboard');

Route::get('/login/{user}/{token}', 'Auth\LoginController@validateToken')->name('authorise.token');

Route::get('/test', function (){
    for($x = 1; $x <=30; $x++) echo \Carbon\Carbon::createFromFormat('Ymd', '202004'.$x)->toDateString() . '<br/>';
    return; } );

Route::get('/files/docs/{filename?}', function ($filename)
{
    $path = 'docs/'.$filename;
    return (!file_exists(Storage::disk('private')->path($path))) ? abort(404) : Storage::disk('private')->get($path);
})->where('filename', '[A-Za-z0-9\/\.\-\_]+')->name('docs.file');
Route::get('/files/images/{filename?}', function ($filename)
{
    $path = storage_path('app/public/images/'.$filename);
    return (!file_exists($path)) ? abort(404) : Image::make($path)->response();
})->where('filename', '[A-Za-z0-9\/\.\-\_]+')->name('image.file');

Route::prefix('user')    ->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('details', function () {})->name('user.details');
    Route::get('messages', 'User\MessageController@messageList')->name('user.messages');
    Route::get('messages/{id}', 'User\MessageController@messageDetails')->name('user.message.view');
    Route::get('personnel/', 'User\PersonnelController@personnelDetails')->name('user.personnel.view');
    Route::get('team/', 'User\PersonnelController@myTeam')->name('user.team.view');
    Route::post('details/update', function () {})->name('user.details.update');

    Route::get('claims/travel', function () { return view('v2.Claims.Travel.item'); });
    Route::get('claims/time', function () { return view('v2.Claims.Time.item'); });
});
Route::prefix('!/admin') ->group(function() {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('group/', 'Admin\GroupController@groupList')->name('admin.groups.view');
    Route::get('group/{id}/details', 'Admin\GroupController@groupDetails')->name('admin.group.view');
    Route::get('helpdesk', 'Admin\HelpdeskController@helpdeskList')->name('admin.helpdesks.view');
    Route::get('helpdesk/{desk}/details', 'Admin\HelpdeskController@helpdeskDetails')->name('admin.helpdesk.view');
    Route::get('user/', 'Admin\UserController@userList')->name('admin.users.view');
    Route::get('user/{id}/details', 'Admin\UserController@userDetails')->name('admin.user.view');
    Route::get('user/sessions', 'Admin\UserController@userSessions')->name('admin.sessions.view');
    Route::get('user/sessions/create', 'Admin\UserController@createSession')->name('admin.sessions.create.ignore');
    Route::post('user/sessions/create', 'Admin\UserController@createSession')->name('admin.sessions.create');
    Route::get('user/sessions/purge', 'Admin\UserController@purgeSessions')->name('admin.sessions.purge');
    Route::get('hr/travelclaims/', 'Admin\ClaimController@showTravelClaimsSettings')->name('admin.travelclaimssettings.view');
    Route::get('hr/personnel/', 'Admin\PersonnelController@listPersonnelDetails')->name('admin.personnel.view');
    Route::get('hr/personnel/details', 'Admin\PersonnelController@listPersonnelDetails')->name('admin.personnel.details');
});

Route::resource('!/admin/TransportType', 'TransportTypeController');
Route::resource('!/admin/MileageType', 'MileageTypeController');
Route::resource('!/admin/ClaimStatus', 'ClaimStatusController');
Route::resource('!/admin/Form', 'FormController');
Route::resource('!/admin/Claim', 'ClaimsController');
Route::get('!/admin/panel', function () { return view('v2.panel'); });

Route::middleware('auth')->get('v2', function(){ return view('v2.template');});
