<?php

use Illuminate\Support\Facades\Route;

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
   return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Users
Route::get('/listUsers', 'Admin\UserController@index')->name('listUsers');
Route::get('/deleteUser/{idUser}', 'Admin\UserController@delete')->name('deleteUser');
Route::post('/saveUser/{idUser?}', 'Admin\UserController@save')->name('saveUser');
Route::get('/formUser/{idUser?}/{show?}', 'Admin\UserController@form')->name('formmUser');
//Permissions
Route::get('/listPermissions', 'Admin\PermissionController@index')->name('listPermissions');
Route::get('/deletePermission/{idPermission}', 'Admin\PermissionController@delete')->name('deletePermission');
Route::post('/savePermission/{idPermission?}', 'Admin\PermissionController@save')->name('savePermission');
Route::get('/formPermission/{idPermission?}/{show?}', 'Admin\PermissionController@form')->name('formPermission');
//Roles
Route::get('/listRoles', 'Admin\RoleController@index')->name('listRoles');
Route::get('/deleteRole/{idRole}', 'Admin\RoleController@delete')->name('deleteRole');
Route::post('/saveRole/{idRole?}', 'Admin\RoleController@save')->name('saveRole');
Route::get('/formRole/{idRole?}/{show?}', 'Admin\RoleController@form')->name('fromRole');
// Asociar permiso a rol.
Route::get('/listRolePermissions', 'Admin\RolePermissionController@index')->name('listRolPermissions');
Route::get('/deleteRolPermission/{id_role}/{id_permission}', 'Admin\RolePermissionController@delete')->name('deleteRolPermission');
Route::post('/saveRolPermission/{idRolPermission?}', 'Admin\RolePermissionController@save')->name('saveRolPermission');
Route::get('/formRolPermission/{permission_id?}/{role_id?}/{show?}', 'Admin\RolePermissionController@form')->name('formRolPermission');
// Asociar rol a usuario.
Route::get('/listUserRoles', 'Admin\UserRolController@index')->name('listUserRoles');
Route::get('/deleteUserRol/{id_user}/{id_role}', 'Admin\UserRolController@delete')->name('deleteUserRol');
Route::post('/saveUserRol/{idUserRol?}', 'Admin\UserRolController@save')->name('saveUserRol');
Route::get('/formUserRol/{role_id?}/{model_id?}/{show?}', 'Admin\UserRolController@form')->name('formUserRol');

// Hotels
Route::get('/listHotels', 'HotelController@index')->name('listHotels');
Route::get('/formHotel/{id?}/{show?}', 'HotelController@create')->name('formHotel');
Route::post('/saveHotel', 'HotelController@store')->name('saveHotel');
Route::post('/updateHotel/{id}', 'HotelController@update')->name('updateHotel');
Route::get('/deleteHotel/{id}', 'HotelController@destroy')->name('deleteHotel');
Route::get('/roomDetails', 'HotelController@trRoomDetails')->name('roomDetails');
Route::get('/getCities/{idState}', 'HotelController@Cities')->name('Cities');
Route::get('/getAccommodations/{idRoomType}', 'HotelController@Accommodations')->name('Accommodations');