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
//Auth::routes() is just a helper class that helps you generate all the routes required for user authentication.
//src/Illuminate/Routing/Router.php, Line Number:1144
//and in Router.php look at RegistersUsers.php. Most of the functionality is there like show "showRegistrationForm"
//vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php

 //LoginController uses AuthenticatesUsers.php --includes login()
 //vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/provider/create', 'ProviderController@create')->name('createProvider')->middleware('auth');
Route::post('/provider/store', 'ProviderController@store')->middleware('auth');
Route::get('/provider/index', 'ProviderController@index')->name('indexProvider')->middleware('auth');
Route::get('/provider/edit/{provider}', 'ProviderController@edit')->middleware('auth');
Route::post('/provider/update/{provider}', 'ProviderController@update')->middleware('auth');
Route::get('/provider/delete/{provider}', 'ProviderController@destroy')->middleware('auth');

Route::get('/dealer/create', 'DealerController@create');
Route::post('/dealer/store', 'DealerController@store');
Route::get('/dealer/list', 'DealerController@list')->name('indexDealer');
Route::get('/dealer/edit/{dealer}', 'DealerController@edit');
Route::post('/dealer/update/{dealer}', 'DealerController@update');
Route::get('/dealer/view/{dealer}', 'DealerController@view');

 //Route::post('/dealer/employee/create', 'Auth\RegisterController@createEmployee')->name('createEmployee');
 //Route::get('register-employee', 'Auth\RegisterController@sendOfficeList')->name('registerEmployeeOfDealer');
 Route::get('/employee/create/{dealerID}', 'Auth\RegisterController@createEmployee')->name('createEmployee')->middleware('auth');
 Route::post('/employee/store', 'Auth\RegisterController@storeEmployee')->name('storeEmployee')->middleware('auth');
 Route::get('/employee/list/{dealerID}', 'Auth\RegisterController@listEmployee')->name('indexEmployee')->middleware('auth');
 Route::get('/employee/edit/{employee}', 'Auth\RegisterController@editEmployee')->name('editEmployee')->middleware('auth');
 Route::post('/employee/update/{employee}', 'Auth\RegisterController@updateEmployee')->name('updateEmployee')->middleware('auth');


 Route::get('/office/create/{dealer}', 'OfficeController@create')->middleware('auth');
 Route::post('/office/store', 'OfficeController@store')->middleware('auth');
 Route::get('/office/list/{dealer}', 'OfficeController@list')->middleware('auth');
 Route::get('/office/edit/{office}', 'OfficeController@edit')->middleware('auth');
 Route::post('/office/update/{office}', 'OfficeController@update')->middleware('auth');

Route::get('/language/{lang}', 'LanguageController@changeLanguage')->middleware('auth');

Route::post('/address/store', 'AddressController@store')->middleware('auth');

//** Authorization */
Route::get('/systemfeatureandauthorization/create', 'SystemFeatureController@create')->middleware('auth');
Route::post('/systemfeatureandauthorization/store', 'SystemFeatureController@store')->middleware('auth');

Route::get('/authorizeUser/index', 'UsersAuthorizationController@index')->name('deneme')->middleware('auth');
Route::post('/authorizeUser/store/{systemFeatureID}', 'UsersAuthorizationController@store')->middleware('auth');

Route::get('/edit-roles-permissions/index', 'RoleController@index')->middleware('auth');
Route::post('/edit-roles-permissions/store/{systemFeatureID}', 'RoleController@store')->middleware('auth');


//**Region Settings
 // Import from Excel file */
Route::get('/representative/import', 'RepresentativeController@import')->middleware('auth');
Route::post('/representative/store', 'RepresentativeController@store')->name('representativeStore')->middleware('auth');
Route::get('/representative/index-asper-provider/{providerID}', 'RepresentativeController@indexAsperProvider')->middleware('auth');
Route::get('/representative/index-asper-region/{regionID}', 'RepresentativeController@indexAsperRegion')->middleware('auth');
Route::get('/representative/edit/{representative}', 'RepresentativeController@edit')->middleware('auth');
Route::post('/representative/update/{representative}', 'RepresentativeController@update')->middleware('auth');

Route::get('/region/postcodeRegionVB/import', 'PostcodeRegionVbController@import')->middleware('auth');
Route::post('/region/postcodeRegionVB/store', 'PostcodeRegionVbController@store')->middleware('auth');

 //DELETE FROM `VF_Tarife` WHERE `VF_Tarife`.`ID` = 213



Route::get('/region/create', 'RegionController@create')->middleware('auth');
Route::post('/region/store', 'RegionController@store')->middleware('auth');
Route::get('/region/index', 'RegionController@index')->middleware('auth');
//Route::get('/region/edit/{region}', 'RegionController@edit')->middleware('auth');
Route::get('/region/edit/{regionID}', 'RegionController@edit')->name('region-edit')->middleware('auth');

Route::post('/region/update/{region}', 'RegionController@update')->middleware('auth');






 Route::get('/re', 'ImportController@getImport')->name('import');
 Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
 Route::post('/import_process', 'ImportController@processImport')->name('import_process');