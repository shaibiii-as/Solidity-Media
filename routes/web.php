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
Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return redirect('/');
});

Route::view('/', 'app');
Route::view('/write', 'app');
Route::view('/help', 'app');
Route::view('/about', 'app');

Route::get('admin/login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');
Route::post('admin/login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function ()
{
  Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
  Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');

  Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');

  Route::get('profile', 'Admin\AdminController@profile')->name('admin.profile');
  Route::post('profile', 'Admin\AdminController@updateProfile')->name('admin.updateProfile');

  Route::resource('wallets', 'Admin\WalletController')->except(['show']);

  Route::get('messages/push-to-blockchain/{id?}', 'Admin\MessageController@pushToBlockchain')->name('admin.push_to_blockchain');
  Route::get('messages/pushed-to-blockchain/{id?}', 'Admin\MessageController@pushedToBlockchain');
  Route::get('messages/transactions-verification', 'Admin\MessageController@transactions_verification');
  Route::get('messages/move-to-unverify/{id}', 'Admin\MessageController@moveToUnverify');
  Route::resource('messages', 'Admin\MessageController');

  Route::get('settings', 'Admin\SettingController@index')->name('admin.settings');
  Route::post('settings', 'Admin\SettingController@updateSettings')->name('admin.updateSettings');

});