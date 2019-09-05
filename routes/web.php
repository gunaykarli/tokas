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

\Illuminate\Support\Facades\Auth::routes();
//Auth::routes() is just a helper class that helps you generate all the routes required for user authentication.
//src/Illuminate/Routing/Router.php, Line Number:1144
//and in Router.php look at RegistersUsers.php. Most of the functionality is there like show "showRegistrationForm"
//vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php

 //LoginController uses AuthenticatesUsers.php --includes login()
 //vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php

Route::get('/home', 'HomeController@index')->name('home');

// sending email
Route::get('/send/employee-registration', 'HomeController@employeeRegistration');


Route::get('/provider/create', 'ProviderController@create')->name('createProvider');
Route::post('/provider/store', 'ProviderController@store')->middleware('auth');
Route::get('/provider/index', 'ProviderController@index')->name('indexProvider');
Route::get('/provider/edit/{provider}', 'ProviderController@edit');
Route::post('/provider/update/{provider}', 'ProviderController@update');
Route::get('/provider/delete/{provider}', 'ProviderController@destroy');

Route::get('/dealer/create', 'DealerController@create');
Route::post('/dealer/store', 'DealerController@store');
Route::get('/dealer/list', 'DealerController@list')->name('indexDealer');
Route::get('/dealer/edit/{dealer}', 'DealerController@edit');
Route::post('/dealer/update/{dealer}', 'DealerController@update');
Route::get('/dealer/view/{dealer}', 'DealerController@view');

 //Route::post('/dealer/employee/create', 'Auth\RegisterController@createEmployee')->name('createEmployee');
 //Route::get('register-employee', 'Auth\RegisterController@sendOfficeList')->name('registerEmployeeOfDealer');
 Route::get('/employee/create/{dealerID}', 'Auth\RegisterController@createEmployee')->name('createEmployee');
 Route::post('/employee/store', 'Auth\RegisterController@storeEmployee')->name('storeEmployee');
 Route::get('/employee/list/{dealerID}', 'Auth\RegisterController@listEmployee')->name('indexEmployee');
 Route::get('/employee/edit/{employee}', 'Auth\RegisterController@editEmployee')->name('editEmployee');
 Route::post('/employee/update/{employee}', 'Auth\RegisterController@updateEmployee')->name('updateEmployee');


 Route::get('/office/create/{dealer}', 'OfficeController@create');
 Route::post('/office/store', 'OfficeController@store');
 Route::get('/office/list/{dealer}', 'OfficeController@list');
 Route::get('/office/edit/{office}', 'OfficeController@edit');
 Route::post('/office/update/{office}', 'OfficeController@update');

Route::get('/language/{lang}', 'LanguageController@changeLanguage');

Route::post('/address/store', 'AddressController@store');

//** Authorization */
Route::get('/systemfeatureandauthorization/create', 'SystemFeatureController@create');
Route::post('/systemfeatureandauthorization/store', 'SystemFeatureController@store');

Route::get('/authorizeUser/index', 'UsersAuthorizationController@index')->name('deneme');
Route::post('/authorizeUser/store/{systemFeatureID}', 'UsersAuthorizationController@store');

Route::get('/edit-roles-permissions/index', 'RoleController@index');
Route::post('/edit-roles-permissions/store/{systemFeatureID}', 'RoleController@store');


//**Region Settings
 // Import from Excel file */
Route::get('/representative/import', 'RepresentativeController@import');
Route::post('/representative/store', 'RepresentativeController@store')->name('representativeStore');
Route::get('/representative/index-asper-provider/{providerID}', 'RepresentativeController@indexAsperProvider');
Route::get('/representative/index-asper-region/{regionID}', 'RepresentativeController@indexAsperRegion');
Route::get('/representative/edit/{representative}', 'RepresentativeController@edit');
Route::post('/representative/update/{representative}', 'RepresentativeController@update');

Route::get('/region/postcodeRegionVB/import', 'PostcodeRegionVbController@import');
Route::post('/region/postcodeRegionVB/store', 'PostcodeRegionVbController@store');



Route::get('/region/create', 'RegionController@create');
Route::post('/region/store', 'RegionController@store');
Route::get('/region/index', 'RegionController@index');
//Route::get('/region/edit/{region}', 'RegionController@edit');
Route::get('/region/edit/{regionID}', 'RegionController@edit')->name('region-edit');
Route::post('/region/update/{region}', 'RegionController@update');

//** Law Texts */
Route::get('/law-text/index', 'LawTextController@index');
Route::get('/law-text/create', 'LawTextController@create');
Route::post('/law-text/store', 'LawTextController@store');
Route::get('/law-text/edit/{lawText}', 'LawTextController@edit');
Route::post('/law-text/update/{lawText}', 'LawTextController@update');

//** Tariffs */
Route::get('/tariff/providers-list', 'TariffController@providers');
Route::get('/tariff/index/{provider}', 'TariffController@index');
Route::get('/tariff/index', 'TariffController@index');
Route::post('/tariff/index/tariffs-with-filter', 'TariffController@fetchTariffsWithFilter')->name('fetchTariffsWithFilter');
Route::post('/tariff/index/change-status-of-tariff', 'TariffController@changeStatusOfTariff');

 /** On-Top */
 //Cloning
Route::get('/tariff/on-top-cloning/create', 'TariffController@createCloning');
Route::post('/tariff/on-top-cloning/store', 'TariffController@storeOnTopCloning');
 //Vodafone
Route::get('/tariff/vodafone/on-top/create', 'VodafoneTariffController@createOnTop');
Route::post('/tariff/vodafone/on-top/store', 'VodafoneTariffController@storeOnTop');
Route::get('/tariff/vodafone/on-top/edit/{tariff}', 'VodafoneTariffController@editOnTop');



Route::get('/tariff/vodafone/create', 'VodafoneTariffController@create');
Route::post('/tariff/vodafone/store', 'VodafoneTariffController@store');
Route::get('/tariff/vodafone/edit/{tariff}', 'VodafoneTariffController@edit');
Route::post('/tariff/vodafone/update/{tariff}', 'VodafoneTariffController@update');

Route::get('/tariff/index/{provider}/{isAdditionalTariff}', 'VodafoneTariffController@index');
Route::post('/tariff/vodafone/tariffs-with-filter', 'VodafoneTariffController@fetchTariffsWithFilter');

Route::get('/tariff/vodafone/provision-setup', 'TariffsProvisionController@showProvisionSetupPage');
Route::post('/tariff/vodafone/provision-setup/store-for-a-tariff', 'TariffsProvisionController@storeForTariff');
Route::post('/tariff/vodafone/fetch-provision-of-tariffs-by-group', 'TariffsProvisionController@fetchProvisionOfTariffs');

Route::get('/tariff/vodafone/base-price-setup', 'VodafoneTariffController@showBasePriceSetupPage');
Route::post('/tariff/vodafone/fetch-base-price-of-tariffs-by-group', 'VodafoneTariffController@fetchBasePriceOfTariffs');
Route::post('/tariff/vodafone/base-price-setup/store-for-tariffs', 'VodafoneTariffController@storeBasePriceForTariffs');



Route::get('/service/create', 'ServiceController@create');
Route::post('/service/store', 'ServiceController@store');



//** IMEIs */
Route::get('/IMEIs/IMEI-pool-status', 'ImeiPoolController@IMEIPoolStatus');
Route::post('/IMEIs/IMEI-pool-status-change', 'ImeiPoolController@forwardToChangeIMEIPoolStatus');

//** Contracts */
 Route::get('/contract/shopping-cart', 'ShoppingCartController@index');
 Route::get('/contract/shopping-cart/add-tariff/{tariff}/{isAdditionalTariff}', 'ShoppingCartController@addTariff');
 Route::get('/contract/shopping-cart/delete-tariff/{tariff}', 'ShoppingCartController@deleteTariff');
 Route::get('/contracts/vodafone/shopping-cart/enter-SIM-IMEI-services/{tariff}/{isAdditionalTariff}', 'ShoppingCartController@callToSimImeiServicesGUI');
 Route::post('/contract/vodafone/shopping-cart/SIM-IMEI-services/{tariff}/{isAdditionalTariff}', 'ShoppingCartController@saveSimImeiServicesToSession');
 Route::get('/contracts/vodafone/shopping-cart/change-main-tariff/{tariff}', 'ShoppingCartController@changeTariff'); //resources/views/contracts/shoppingCartORJ.blade.php - to change the main tariff in shopping cart

 Route::get('/contracts/vodafone/XML/takeXML', 'ContractController@viewTakeXML');
 Route::post('/contracts/vodafone/XML/readXML', 'ContractController@forwardToReadXML');



 Route::get('/contract/generate-XML', 'ContractController@callToGenerateXMLGUI');
 Route::post('/contract/forward-to-generateXML', 'ContractController@forwardToGenerateXML');

 Route::post('/contract/forward-to-finalize', 'ContractController@forwardToFinalize');
 Route::post('/contract/forward-to-store', 'ContractController@forwardToStore');

 //** Contracts Vodafone*/
 Route::get('/contracts/vodafone/create', 'ContractController@create');

 //Route::post('/contracts/vodafone/store', 'ContractController@store');



 Route::get('/gui/index-raleway', 'HomeController@dene');
 Route::get('/gui/welcome1', 'HomeController@welcome1');


 Route::get('/re', 'ImportController@getImport')->name('import');
 Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
 Route::post('/import_process', 'ImportController@processImport')->name('import_process');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
