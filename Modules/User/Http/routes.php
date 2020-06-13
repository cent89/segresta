<?php
use Modules\User\Entities\User;
Route::group(['middleware' => ['web', 'verified'], 'prefix' => 'admin', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
  Route::resource('user', 'UserController', ['only' => ['store', 'index']]);
  Route::get('user/users_list', ['as' =>'user.users_list', 'uses' => 'UserController@users_list']);
  Route::get('user/getData', ['as' =>'user.data', 'uses' => 'UserController@data']);
  Route::post('user/action', ['as' =>'user.action', 'uses' => 'UserController@action']);
});

Route::group(['middleware' => ['web',  'verified'], 'namespace' => 'Modules\User\Http\Controllers'], function() {

  Route::patch('user/updateprofile',['as' => 'user.updateprofile', 'uses' => 'UserController@updateprofile']);
  Route::get('profile/show', ['as' => 'profile.show', 'uses' => 'UserController@profile']);
  Route::get('user/dropdown', function(){
    $id_oratorio = Session::get('session_oratorio');
    return User::select('users.id', 'users.name', 'users.cognome')->leftJoin('user_oratorio', 'user_oratorio.id_user', '=', 'users.id')->where('user_oratorio.id_oratorio', $id_oratorio)->orderBy("users.cognome", "ASC")->get();
  });
});
