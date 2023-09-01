<?php

use Carbon\Carbon;
use App\Models\Part;
use GuzzleHttp\Client;
use App\Models\Currency;
use App\Models\Location;
use App\Models\Inventory;
use App\Models\SaleOrder;
use App\Models\FamilyGroup;
use App\Models\PartRecount;
use App\Models\LocationGroup;
use App\Models\TransferOrder;
use App\Models\ShippingMarkup;
use App\Models\StorageSetting;
use App\Models\CustomerCompany;
use App\Models\TransferOrderChild;
use Dawson\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PartController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\UsersController;
use App\Models\ProductionReceivingParent;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\part\PartEditController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Costing\CostingController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\part\PartDashboardController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Customer\CustomerEditController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\Customer\CustomerCreationController;
use App\Http\Controllers\TransferOrder\ReceiveOrderController;
use App\Http\Controllers\ShippingMarkup\ShippingMarkupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/


$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);
        if (isset($val['middlewares']) && $val['middlewares'])
            $route->middleware($val['middlewares']);
    }
});
Route::get('/editUi',function () {
    return view('partUiUx');
});
Route::get('/newPartIndex',function () {
    return view('partIndexClient');
});
Route::get('/clientSearchCard',function () {
    return view('searchCard');
});
Route::get('/clientSearchTable',function () {
    return view('searchTableEdit');
});
// Route::get('/', function () {


//     // foreach(Currency::all() as $v){
//     //     Currency::create(
//     //        [
//     //             'code'=>$v->code,
//     //             'name'=>$v->name,
//     //             'symbol'=>$v->symbol,
//     //             'format'=>$v->format,
//     //             'exchange_rate'=>$v->exchange_rate,
//     //         ]
//     //     );
//     // }

//     $arr=[
//         'USD',
//         'EUR',
//         'CNY',
//         'INR',
//         'BRL',
//         'THB',
//     ];
//     $c=Currency::whereIn('code', $arr)->latest()->get();

//     dd($c);
// });

// IMage Rendering Route
Route::get('/images/{quality}/{part}/{position}/{width}/{height}', [ 'uses' => 'App\Http\Controllers\WebImagesController@rendering', 'as' => 'webImages.rendering' ]);

Route::middleware('auth')->group(function () {
    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });

    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });
});

Route::resource('users', UsersController::class);

/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::group(['namespace' => 'App\Http\Controllers'], function () {
        // Module Route Start
        Route::get('/module/index', ['uses' => 'ModuleController@index', 'as' => 'module.index', 'middleware' => 'permission:show module']);
        Route::get('/module/create', ['uses' =>  'ModuleController@create', 'as' => 'module.create', 'middleware' => 'permission:create module']);
        Route::post('/module/store', ['uses' => 'ModuleController@store', 'as' => 'module.store', 'middleware' => 'permission:create module']);
        Route::get('/module/{id}/edit', ['uses' => 'ModuleController@edit', 'as' => 'module.edit', 'middleware' => 'permission:edit module']);
        Route::post('/module/{id}/update', ['uses' => 'ModuleController@update', 'as' => 'module.update', 'middleware' => 'permission:edit module']);
        Route::get('/module/{id}/view', ['uses' => 'ModuleController@show', 'as' => 'module.view', 'middleware' => 'permission:view module']);
        Route::post('/module/destroy', ['uses' => 'ModuleController@destroy', 'as' => 'module.destroy', 'middleware' => 'permission:delete module']);

        // Permission Route Start
        Route::get('/permission/index', ['uses' => 'PermissionController@index', 'as' => 'permission.index', 'middleware' => 'permission:show permission']);
        Route::get('/permission/create', ['uses' => 'PermissionController@create', 'as' => 'permission.create', 'middleware' => 'permission:create permission']);
        Route::post('/permission/store', ['uses' => 'PermissionController@store', 'as' => 'permission.store', 'middleware' => 'permission:create permission']);
        Route::get('/permission/{id}/edit', ['uses' => 'PermissionController@edit', 'as' => 'permission.edit', 'middleware' => 'permission:edit permission']);
        Route::post('/permission/{id}/update', ['uses' => 'PermissionController@update', 'as' => 'permission.update', 'middleware' => 'permission:edit permission']);
        Route::get('/permission/{id}/view', ['uses' => 'PermissionController@show', 'as' => 'permission.view', 'middleware' => 'permission:view permission']);
        Route::post('/permission/destroy', ['uses' => 'PermissionController@destroy', 'as' => 'permission.destroy', 'middleware' => 'permission:delete permission']);

        // Role Route Start
        Route::get('/role/index', ['uses' => 'RoleController@index', 'as' => 'role.index', 'middleware' => 'permission:show role']);
        Route::get('/role/create', ['uses' => 'RoleController@create', 'as' => 'role.create', 'middleware' => 'permission:create role']);
        Route::post('/role/store', ['uses' => 'RoleController@store', 'as' => 'role.store', 'middleware' => 'permission:create role']);
        Route::get('/role/{id}/edit', ['uses' => 'RoleController@edit', 'as' => 'role.edit', 'middleware' => 'permission:edit role']);
        Route::post('/role/{id}/update', ['uses' => 'RoleController@update', 'as' => 'role.update', 'middleware' => 'permission:edit role']);
        Route::get('/role/{id}/view', ['uses' => 'RoleController@show', 'as' => 'role.view', 'middleware' => 'permission:view role']);
        Route::post('/role/destroy', ['uses' => 'RoleController@destroy', 'as' => 'role.destroy', 'middleware' => 'permission:delete role']);

        // User Route Start
        Route::get('/user/index', ['uses' => 'UsersController@index', 'as' => 'user.index', 'middleware' => 'permission:show user']);
        Route::get('/user/create', ['uses' => 'UsersController@create', 'as' => 'user.create', 'middleware' => 'permission:create user']);
        Route::post('/user/store', ['uses' => 'UsersController@store', 'as' => 'user.store', 'middleware' => 'permission:create user']);
        Route::get('/user/{id}/edit', ['uses' => 'UsersController@edit', 'as' => 'user.edit', 'middleware' => 'permission:edit user']);
        Route::post('/user/{id}/update', ['uses' => 'UsersController@update', 'as' => 'user.update', 'middleware' => 'permission:edit user']);
        Route::get('/user/{id}/view', ['uses' => 'UsersController@show', 'as' => 'user.view', 'middleware' => 'permission:view user']);
        Route::post('/user/destroy', ['uses' => 'UsersController@destroy', 'as' => 'user.destroy', 'middleware' => 'permission:delete user']);
        Route::post('/user/selected-destroy', ['uses' => 'UsersController@selectedDestroy', 'as' => 'user.selectedDestroy', 'middleware' => 'permission:delete user']);
        Route::post('/user/group/activate', ['uses' => 'UsersController@groupActivate', 'as' => 'user.groupActivate', 'middleware' => 'permission:delete user']);
        Route::get('/user/log/get', [ 'uses' => 'UsersController@logGet', 'as' => 'user.logGet' ]);

        // User Information Update Route
        Route::post('/user-information/{id}/update', [ 'uses' => 'UsersController@userInformationUpdate', 'as' => 'userInformation.update' ]);
        // User Location Update Route
        Route::post('/user-location/{id}/update', [ 'uses' => 'UsersController@userLocationUpdate', 'as' => 'userLocation.update' ]);
        // User Roles Attach
        Route::post('/user-role/{id}/attach', [ 'uses' => 'UsersController@userRoleAttach', 'as' => 'userRole.attach' ]);
        // Remove Role From User
        Route::post('/user-role/detach', [ 'uses' => 'UsersController@userRoleDetach', 'as' => 'userRole.detach' ]);

        // Part Dashboard
        // Route::get('/part/dashboard', ['uses' => 'PartController@dashboard', 'as' => 'part.dashboard']);
        Route::get('/part/search', ['uses' => 'PartController@searchPartNo', 'as' => 'part.search']);

        // Vendor Route Start
        Route::get('/vendor/index', ['uses' => 'VendorController@index', 'as' => 'vendor.index', 'middleware' => 'permission:show vendor']);
        Route::get('/vendor/create', ['uses' => 'VendorController@create', 'as' => 'vendor.create', 'middleware' => 'permission:create vendor']);
        Route::any('/vendor/store', ['uses' => 'VendorController@store', 'as' => 'vendor.store', 'middleware' => 'permission:create vendor']);
        Route::get('/vendor/{id}/edit', ['uses' => 'VendorController@edit', 'as' => 'vendor.edit', 'middleware' => 'permission:edit vendor']);
        Route::post('/vendor/{id}/update', ['uses' => 'VendorController@update', 'as' => 'vendor.update', 'middleware' => 'permission:edit vendor']);
        Route::get('/vendor/{id}/view', ['uses' => 'VendorController@show', 'as' => 'vendor.view', 'middleware' => 'permission:view vendor']);
        Route::post('/vendor/destroy', ['uses' => 'VendorController@destroy', 'as' => 'vendor.destroy', 'middleware' => 'permission:delete vendor']);
        Route::post('/vendor/activate', ['uses' => 'VendorController@activate', 'as' => 'vendor.activate', 'middleware' => 'permission:delete vendor']);
        Route::post('/vendor/inactivate', ['uses' => 'VendorController@inactivate', 'as' => 'vendor.inactivate', 'middleware' => 'permission:delete vendor']);

        // Setup fields Route Start
        Route::get('/field/index', ['uses' => 'FieldController@index', 'as' => 'field.index', 'middleware' => 'permission:show field']);
        Route::get('/field/create', ['uses' => 'FieldController@create', 'as' => 'field.create', 'middleware' => 'permission:create field']);
        Route::post('/field/store', ['uses' => 'FieldController@store', 'as' => 'field.store', 'middleware' => 'permission:create field']);
        Route::get('/field/{id}/edit', ['uses' => 'FieldController@edit', 'as' => 'field.edit', 'middleware' => 'permission:edit field']);
        Route::post('/field/{id}/update', ['uses' => 'FieldController@update', 'as' => 'field.update', 'middleware' => 'permission:edit field']);
        Route::get('/field/{id}/view', ['uses' => 'FieldController@show', 'as' => 'field.view', 'middleware' => 'permission:view field']);
        Route::post('/field/destroy', ['uses' => 'FieldController@destroy', 'as' => 'field.destroy', 'middleware' => 'permission:delete field']);

        // Sub Fields Route
        // Route::post('/sub/option/store', ['uses' => 'OptionController@store', 'as' => 'suboption.store']);
        // Route::post('/sub/option/update', ['uses' => 'OptionController@update', 'as' => 'suboption.update']);
        // Route::post('/sub/option/destroy', ['uses' => 'OptionController@destroy', 'as' => 'suboption.destroy']);

        // Upc Route Start
        Route::get('/upc/index', ['uses' => 'UpcController@index', 'as' => 'upc.index', 'middleware' => 'permission:show upc']);
        Route::get('/upc/create', ['uses' => 'UpcController@create', 'as' => 'upc.create', 'middleware' => 'permission:create upc']);
        Route::post('/upc/store', ['uses' => 'UpcController@store', 'as' => 'upc.store', 'middleware' => 'permission:create upc']);
        Route::get('/upc/{id}/edit', ['uses' => 'UpcController@edit', 'as' => 'upc.edit', 'middleware' => 'permission:edit upc']);
        Route::post('/upc/{id}/update', ['uses' => 'UpcController@update', 'as' => 'upc.update', 'middleware' => 'permission:edit upc']);
        Route::post('/upc/destroy', ['uses' => 'UpcController@destroy', 'as' => 'upc.destroy', 'middleware' => 'permission:delete upc']);
        Route::post('/upc/import', ['uses' => 'UpcController@import', 'as' => 'upc.import', 'middleware' => 'permission:import upc']);
        Route::get('/upc/sample/download', ['uses' => 'UpcController@sampleDownload', 'as' => 'upc.sample']);

        Route::post('/option/store', ['uses' => 'OptionController@store', 'as' => 'option.store']);
        Route::post('/option/update', ['uses' => 'OptionController@update', 'as' => 'option.update']);
        Route::post('/option/destroy', ['uses' => 'OptionController@destroy', 'as' => 'option.destroy']);

        // Inventory Route Start
        Route::get('find/inventory/part', ['uses' => 'InventoryController@inventoryPart', 'as' => 'inventory.findPart', 'middleware' => 'permission:show inventory']);
        Route::get('find/inventory/part/module', ['uses' => 'InventoryController@inventoryTab', 'as' => 'inventory.tab', 'middleware' => 'permission:show inventory']);
        Route::get('find/part/dashboard/{id?}', ['uses' => 'InventoryController@findPartWNo', 'as' => 'part.locate_module', 'middleware' => 'permission:show inventory']);
        Route::get('find/inventory/part/quantity/{qty?}', ['uses' => 'InventoryController@inventoryPartQuanity', 'as' => 'inventory.findPartQuantity', 'middleware' => 'permission:show inventory']);

        // Bin Route Start
        Route::get('/bin/index', ['uses' => 'BinController@index', 'as' => 'bin.index', 'middleware' => 'permission:show bin']);
        Route::get('/bin/create', ['uses' => 'BinController@create', 'as' => 'bin.create', 'middleware' => 'permission:create bin']);
        Route::post('/bin/store', ['uses' => 'BinController@store', 'as' => 'bin.store', 'middleware' => 'permission:create bin']);
        Route::get('/bin/{id}/edit', ['uses' => 'BinController@edit', 'as' => 'bin.edit', 'middleware' => 'permission:edit bin']);
        Route::post('/bin/{id}/update', ['uses' => 'BinController@update', 'as' => 'bin.update', 'middleware' => 'permission:edit bin']);
        Route::post('/bin/delete', ['uses' => 'BinController@destroy', 'as' => 'bin.destroy', 'middleware' => 'permission:delete bin']);

        // Shopify Account Route Start
        Route::get('/shopify/account/index', ['uses' => 'ShopifyAccountController@index', 'as' => 'shopify_account.index', 'middleware' => 'permission:show shopify account']);
        Route::get('/shopify/account/create', ['uses' => 'ShopifyAccountController@create', 'as' => 'shopify_account.create', 'middleware' => 'permission:create shopify account']);
        Route::post('/shopify/account/store', ['uses' => 'ShopifyAccountController@store', 'as' => 'shopify_account.store', 'middleware' => 'permission:create shopify account']);
        Route::get('/shopify/account/{id}/edit', ['uses' => 'ShopifyAccountController@edit', 'as' => 'shopify_account.edit', 'middleware' => 'permission:edit shopify account']);
        Route::post('/shopify/account/{id}/update', ['uses' => 'ShopifyAccountController@update', 'as' => 'shopify_account.update', 'middleware' => 'permission:edit shopify account']);
        Route::post('/shopify/account/destroy', ['uses' => 'ShopifyAccountController@destroy', 'as' => 'shopify_account.destroy', 'middleware' => 'permission:delete shopify account']);

        // new Part Creation
        Route::get('/part/create' , ['uses' => 'PartController@create', 'as' => 'part.create']);
        Route::get('/part/create/base-load', ['uses' => 'PartController@baseLoad', 'as' => 'part.baseLoad']);
        Route::get('/part/create/get-dropdowns', ['uses' => 'PartController@getDropDowns', 'as' => 'part.getDropdown']);
        Route::get('/part/create/get-gender', ['uses' => 'PartController@getGender', 'as' => 'part.getGender']);
        Route::get('/part/create/get-style', ['uses' => 'PartController@getStyle', 'as' => 'part.getStyle' ]);
        Route::get('/part/create/get-stone-detail', ['uses' => 'PartController@getStone', 'as' => 'part.getStone']);
        Route::post('/part/store/steps', ['uses' => 'PartController@stepStore', 'as' => 'part_store.steps' ]);
        Route::get('/part/create/detail', ['uses' => 'PartController@detail', 'as' => 'part_store.detail']);
        Route::post('/part/create/vendor/store', ['uses' => 'PartController@vendorStore', 'as' => 'part.vendor_store']);
        Route::get('/part/{id}/continue', ['uses' => 'PartController@continue', 'as' => 'part.continue']);

        // Location Group Route Start
        Route::get('/location/group/index', ['uses' => 'LocationGroupController@index', 'as' => 'location_group.index', 'middleware' => 'permission:show location group']);
        Route::get('/location/group/create', ['uses' => 'LocationGroupController@create', 'as' => 'location_group.create', 'middleware' => 'permission:create location group']);
        Route::post('/location/group/store', ['uses' => 'LocationGroupController@store', 'as' => 'location_group.store', 'middleware' => 'permission:create location group']);
        Route::get('/location/group/{id}/edit', ['uses' => 'LocationGroupController@edit', 'as' => 'location_group.edit', 'middleware' => 'permission:edit location group']);
        Route::post('/location/group/{id}/update', ['uses' => 'LocationGroupController@update', 'as' => 'location_group.update', 'middleware' => 'permission:edit location group']);
        Route::get('/location/group/{id}/view', ['uses' => 'LocationGroupController@show', 'as' => 'location_group.view', 'middleware' => 'permission:view location group']);
        Route::post('/location/group/delete', ['uses' => 'LocationGroupController@destroy', 'as' => 'location_group.delete', 'middleware' => 'permission:delete location group']);

        // Location Route Start
        Route::get('/location/index', ['uses' => 'LocationController@index', 'as' => 'location.index', 'middleware' => 'permission:show location']);
        Route::get('/location/create', ['uses' => 'LocationController@create', 'as' => 'location.create', 'middleware' => 'permission:create location']);
        Route::post('/location/store', ['uses' => 'LocationController@store', 'as' => 'location.store', 'middleware' => 'permission:create location']);
        Route::get('/location/{id}/edit', ['uses' => 'LocationController@edit', 'as' => 'location.edit', 'middleware' => 'permission:edit location']);
        Route::post('/location/{id}/update', ['uses' => 'LocationController@update', 'as' => 'location.update', 'middleware' => 'permission:edit location']);
        Route::post('/location/delete', ['uses' => 'LocationController@destroy', 'as' => 'location.delete', 'middleware' => 'permission:delete location']);
        Route::get('/check-location-accuracy/{location_input_text}', ['uses' => 'LocationController@checkAccuracy', 'as' => 'location.checkAccuracy', 'middleware' => 'permission:edit location']);

        // Currency Route Start
        Route::get('/currency/index', ['uses' => 'CurrencyController@index', 'as' => 'currency.index', 'middleware' => 'permission:show currency']);
        Route::get('/currency/create', ['uses' => 'CurrencyController@create', 'as' => 'currency.create', 'middleware' => 'permission:create currency']);
        Route::post('/currency/store', ['uses' => 'CurrencyController@store', 'as' => 'currency.store', 'middleware' => 'permission:create currency']);
        Route::get('/currency/{id}/edit', ['uses' => 'CurrencyController@edit', 'as' => 'currency.edit', 'middleware' => 'permission:edit currency']);
        Route::post('/currency/{id}/update', ['uses' => 'CurrencyController@update', 'as' => 'currency.update', 'middleware' => 'permission:edit currency']);
        Route::post('/currency/delete', ['uses' => 'CurrencyController@destroy', 'as' => 'currency.delete', 'middleware' => 'permission:delete currency']);

        // Get old Bins
        Route::get('/manage/bins', ['uses' => 'InventoryController@manageBins', 'as' => 'manage.bins']);
        Route::post('/manage/bins/add', ['uses' => 'InventoryController@binAdd', 'as' => 'bin.add']);
        Route::post('/manage/bins/remove', ['uses'=>  'InventoryController@remove', 'as' => 'bins.remove']);

        // Detach User to Location Group Route
        Route::post('/location/group/attach', ['uses' => 'LocationGroupController@attach', 'as' => 'location_group.attach']);
        Route::post('/location/group/detach', ['uses' => 'LocationGroupController@detach', 'as' => 'location_group.detach']);

        // Location Append in User Form
        Route::get('/user/create/get-location', ['uses' => 'UsersController@getLocation', 'as' => 'user.getLocation']);

        // Part Module Duplicate Route
        Route::get('/part/{id}/duplicate', ['uses' => 'PartController@duplicate', 'as' => 'part.duplicate']);

        // Part Edit Bin History Get
        Route::get('/part/bin/history', [ 'uses' => 'PartController@binHistory', 'as' => 'part.binHistory' ]);

        // Part Bins Get
        Route::get('/part/bin/list', [ 'uses' => 'PartController@partBins', 'as' => 'part.binList' ]);
        // Get Metal Stamp Against Base Material in Part
        Route::get('/metal/stamp/get', [ 'uses' => 'PartController@getMetalStamp', 'as' => 'getMetalStamp' ]);

        //PrintLabel labels
        Route::post('print-part-label',['uses'=>'PrintController@printPartLabel','as'=>'print.part.label']);
        Route::post('print-bin-label',['uses'=>'PrintController@printBinLabel','as'=>'print.bin.label']);

        // Part Delete Option
        Route::post('/part/delete', [ 'uses' => 'PartController@destroy', 'as' => 'part.destroy', 'middleware' => 'permission:delete part' ]);
        //Advance Search
        Route::get('/advance-search/get-dropdowns', ['uses' => 'PartController@getAdvanceSearchDropdown', 'as' => 'advance_search.getDropdown']);

        // Setting Route
        Route::get('/setting/storage', [ 'uses' => 'StorageSettingController@index', 'as' => 'storage.index', 'middleware' => 'permission:show storage setting' ]);
        Route::post('/setting/storage/update', ['uses' => 'StorageSettingController@update', 'as' => 'storage.update', 'middleware' => 'permission:update storage setting']);
        Route::post('/setting/storage/shipping-markup', ['uses' => 'StorageSettingController@shippingMarkup', 'as' => 'storage.shippingMarkup', 'middleware' => 'permission:update storage setting']);
        Route::post('variation-edit/availability', [PartEditController::class, 'variationAvailability'])->name('variation.edit.availability')->middleware('permission:create part');

        // Log Detail Get Route
        Route::get('/log/detail/get' ,[ 'uses' => 'PartController@logDetailGet', 'as' => 'log.detailGet' ]);

        // Upload Image Route
        Route::post('/part/image/upload', [ 'uses' => 'PartController@imageUpload', 'as' => 'part.imageUpload' ]);
        Route::post('/part/image/delete', [ 'uses' => 'PartController@imageDelete', 'as' => 'part.imageDelete' ]);

        // Logs Get in Part Edit
        Route::get('/part/logs/list', [ 'uses' => 'PartController@logGet', 'as' => 'part.logGet' ]);
        // family get in part edit
        Route::get('/part/family/list', [ 'uses' => 'PartController@familyGet', 'as' => 'part.familyGet' ]);
        Route::post('/part/images/Download', [ 'uses' => 'PartController@downloadAllImage', 'as' => 'part.downloadAllImages' ]);


        // Web Images Route
        Route::get('/web/images', [ 'uses' => 'WebImagesController@index', 'as' => 'web.images', 'middleware' => 'permission:show web images' ]);
        Route::get('/web/images/part/search', [ 'uses' => 'WebImagesController@search', 'as' => 'webImage.search' ]);
        Route::get('/web/images/part{id}/detail', [ 'uses' => 'WebImagesController@detail', 'as' => 'webImage.detail' ]);
        Route::post('/web/images/part/upload',['uses'=>'WebImagesController@uploadImagesToPart','as'=>'webImage.uploadToPart']);
        Route::get('/web/images/error-logs',['uses'=>'WebImagesController@errorLogs','as'=>'webImage.errorLogs']);
        Route::get('/web/images/get',['uses'=>'WebImagesController@getWebImages','as'=>'webImages.get']);

        //get Images Log
        Route::get('web/images/logs',['uses'=>'WebImagesController@webImagesLog','as'=>'webImages.logs']);
        //get images activity logs
        Route::get('web/images/activity/get-logs',['uses'=>'WebImagesController@getActivtyLogData','as'=>'webImages.activtyLog']);

        // Remove Web Images
        Route::post('/web/images/remove', [ 'uses' => 'WebImagesController@remove', 'as' => 'webImages.remove' ]);
        Route::post('/web/images/default' ,[ 'uses' => 'WebImagesController@ImageDefault', 'as' => 'webImages.default' ]);
        Route::post('/web/image/remove/dropzone', [ 'uses' => 'WebImagesController@dropzoneDeleteImage', 'as' => 'webImage.imageDeleteDropZone' ]);
        Route::get('/delete/error/webimages/{rowId}/{folderName}/{imageName}',[ 'uses' => 'WebImagesController@deleteErrorWebImageImage', 'as' => 'delete.webImabge' ]);
        Route::get('/update/eroor/webimages/{rowId}/{folderName}/{imageName}',['uses' => 'WebImagesController@updateErrorWebImages', 'as' => 'updateError.webImage']);
        Route::get('/fetch/batch/{batch}',['uses'=>'WebImagesController@fetchBatch','as'=>'fetch.batch']);
        // Web Video Route
        Route::get('/delete/video/{videoId}',['uses'=>'WebImagesController@deleteVideo','as'=>'delete.video']);
        Route::get('/set/default/video/{videoId}',['uses'=>'WebImagesController@setDefaultVideo','as'=>'setDefault.video']);
        // Result Pool
        Route::get('/result/pool/index', [ 'uses' => 'ResultPoolController@index', 'as' => 'resultPool.index', 'middleware' => 'permission:show result pool' ]);
        Route::post('/result/pool/store', [ 'uses' => 'ResultPoolController@store', 'as' => 'resultPool.store', 'middleware' => 'permission:create result pool' ]);
        Route::post('/result/pool/update', [ 'uses' => 'ResultPoolController@update', 'as' => 'resultPool.update', 'middleware' => 'permission:edit result pool' ]);
        Route::post('/result/pool/delete', [ 'uses' => 'ResultPoolController@destroy', 'as' => 'resultPool.delete', 'middleware' => 'permission:delete result pool' ]);
        Route::get('/result/pool/{id}//view', [ 'uses' => 'ResultPoolController@show', 'as' => 'resultPool.view', 'middleware' => 'permission:view result pool' ]);
        Route::post('/result/pool/part/remove', [ 'uses' => 'ResultPoolController@remove', 'as' => 'resultPool.remove' ]);

        // part Dashboard Send to pool New Pool Part
        Route::post('/part/send/pool/new', [ 'uses' => 'ResultPoolController@newPool', 'as' => 'resultPool.newPart' ]);
        Route::post('/part/send/pool/existing', [ 'uses' => 'ResultPoolController@existingPool', 'as' => 'resultPool.existing' ]);
        Route::get('/existing-pool', [ 'uses' => 'ResultPoolController@getExistingPool', 'as' => 'get.existingPool' ]);

        // Virtual Part Routes
        Route::get('/virtual/part/create', [ 'uses' => 'VirtualPartController@create', 'as' => 'virtualPart.create', 'middleware' => 'permission:create virtual part' ]);

        Route::get('/virtual/part/base-load', [ 'uses' => 'VirtualPartController@baseload', 'as' => 'virtualPart.baseLoad' ]);

        // Result Pool Category
        Route::get('/pool/category/index', [ 'uses' => 'PoolCategoryController@index', 'as' => 'poolCategory.index', 'middleware' => 'permission:show pool category' ]);
        Route::get('/pool/category/create', [ 'uses' => 'PoolCategoryController@create', 'as' => 'poolCategory.create', 'middleware' => 'permission:create pool category' ]);
        Route::post('/pool/category/store', [ 'uses' => 'PoolCategoryController@store', 'as' => 'poolCategory.store', 'middleware' => 'permission:create pool category' ]);
        Route::get('/pool/category/{id}/edit', [ 'uses' => 'PoolCategoryController@edit', 'as' => 'poolCategory.edit', 'middleware' => 'permission:edit pool category' ]);
        Route::post('/pool/category/{id}/update', [ 'uses' => 'PoolCategoryController@update', 'as' => 'poolCategory.update', 'middleware' => 'permission:edit pool category' ]);
        Route::post('/pool/category/delete', [ 'uses' => 'PoolCategoryController@destroy', 'as' => 'poolCategory.delete', 'middleware' => 'permission:delete pool category' ]);

        // Get Parts in Virtual Part Creation
        Route::get('/virtual/part/get-part', [ 'uses' => 'PartController@getParts', 'as' => 'virtualPart.getPart' ]);

        // load Virtual Part Review Page Data
        Route::get('/virtual/part/review', [ 'uses' => 'PartController@reviewData', 'as' => 'virtual.reviewData' ]);

        // load Part Tab Data
        Route::get('/edit/part/get-part-tab', [ 'uses' => 'PartController@partTab', 'as' => 'editPart.partTab' ]);

        // Delete Virtual Parts
        Route::get('/edit/part/delete-virtual-part',  [ 'uses' => 'PartController@deleteVirtualPart', 'as' => 'editPart.deleteVirtual' ]);

        // Store Virtual Part in part Edit
        Route::post('/edit/part/store-virtual-part', [ 'uses' => 'PartController@storeVirtualPart', 'as' => 'editPart.storeVirtual' ]);

        // Store Result Pool in Part Edit
        Route::post('/edit/part/store-result-pool', [ 'uses' => 'PartController@storeResultPool', 'as' => 'editPart.storeResultPool' ]);

        // Display Route Start
        Route::get('/production/display/create', [ 'uses' => 'DisplayController@create', 'as' => 'production.newDisplay' ]);
        Route::get('/production/display/{id}/remove', [ 'uses' => 'DisplayController@destroy', 'as' => 'production.removeDisplay' ]);

        // Match Part and Save against Display
        Route::get('/production/display/part/store', [ 'uses' => 'DisplayController@store', 'as' => 'production.storeDisplay' ]);

        // Delete Display Part
        Route::get('/production/display/part/delete', [ 'uses' => 'DisplayController@delete', 'as' => 'productionDisplay.deletePart' ]);
        Route::get('/production/display/{id}', [ 'uses' => 'DisplayController@displayContinue', 'as' => 'productionDisplay.continue' ]);
        Route::post('/production/display/finish', [ 'uses' => 'DisplayController@finish', 'as' => 'productionDisplay.finish' ]);

        // Job Request in Production Display
        Route::get('/production/display/{id}/job-request', [ 'uses' => 'DisplayController@jobRequest', 'as' => 'productionDisplay.jobRequest' ]);

        // Assign Display Job
        Route::get('/production/display/job/assign', [ 'uses' => 'DisplayController@jobAssign', 'as' => 'display.jobAssign' ]);

        // Print Display
        Route::get('/production/display/print', [ 'uses' => 'DisplayController@prints', 'as' => 'display.prints' ]);
        Route::get('/production/display-print', [ 'uses' => 'DisplayController@displayPrint', 'as' => 'displayPrint' ]);

        // Update Display Part Qty
        Route::post('/production/display/update-qty', [ 'uses' => 'DisplayController@updateQty', 'as' => 'display.updateQtys' ]);

        // Display Archive Route
        Route::get('/display/archive', [ 'uses' => 'DisplayController@archive', 'as' => 'display.archive' ]);

        // Bin Route Start
        Route::get('/production/bin/start', [ 'uses' => 'BinCheckedController@index', 'as' => 'productionBin.start' ]);
        Route::post('/production/bin/create', [ 'uses' => 'BinCheckedController@store', 'as' => 'productionBin.create' ]);
        Route::get('/production/bin/{id}/new', [ 'uses' => 'BinCheckedController@new', 'as' => 'productionBin.new' ]);
        Route::post('/production/bin/part/add', [ 'uses' => 'BinCheckedController@storePart', 'as' => 'productionBin.partStore' ]);

        // Production Bin Recount
        Route::get('/production/bin/part/recount', [ 'uses' => 'BinCheckedController@recount', 'as' => 'productionBin.partRecount' ]);
        Route::get('/production/bin/continue/{id}', [ 'uses' => 'BinCheckedController@continue', 'as' => 'productionBin.continue' ]);

        // Remove Part in Production Bin
        Route::post('/production/bin/part/remove', [ 'uses' => 'BinCheckedController@removePart', 'as' => 'productionBin.removePart' ]);

        // Finish bin Production
        Route::post('/production/bin/part/finish', ['uses' => 'BinCheckedController@finish', 'as' => 'productionBin.finish']);

        // Production Bin Archive List
        Route::get('/production/bin/archive', ['uses' => 'BinCheckedController@archive', 'as' => 'productionBin.archive']);

        // Bin Print Route
        Route::get('/production/bin/print', ['uses' => 'BinCheckedController@print', 'as' => 'binPrint']);

        // Refill Route Start
        Route::get('/production/refill/', ['uses' => 'RefillController@create', 'as' => 'productionRefill.create']);
        Route::post('/production/refill/store', ['uses' => 'RefillController@store', 'as' => 'productionRefill.store']);
        Route::get('/production/refill/{id}', ['uses' => 'RefillController@continue', 'as' => 'productionRefill.continue']);

        Route::get('/production/send-refill', ['uses' => 'RefillController@sendRefill', 'as' => 'refill.send']);

        // Start Refilling Route
        Route::post('/production/refilling/finish', ['uses' => 'RefillController@refillingFinish', 'as' => 'refilling.finish']);

        //
        Route::post('/production/refilling/assign-job', ['uses' => 'RefillController@assignJob', 'as' => 'refilling.assignJob']);

        // Refilled Status
        Route::get('/production/refilled', ['uses' => 'RefillController@refilled', 'as' => 'refill.refilled']);
        // Refilled update Time

        Route::post('/production/refill/update-time', ['uses' => 'RefillController@updateTime', 'as' => 'refill.updateTime']);

        // Archive for Refill
        Route::get('/production/refill/archive/list', ['uses' => 'RefillController@archive', 'as' => 'refill.archive']);

        // Delete Refill
        Route::get('/production/refill/{id}/delete', ['uses' => 'RefillController@destroy', 'as' => 'refill.destroy']);

        // Recount Part
        Route::get('/production/refill/recount/part', ['uses' => 'RefillController@recount', 'as' => 'refill.recount']);

        //production refill map
        Route::get('/production/refill/recount/map', ['uses' => 'RefillController@map', 'as' => 'refill.map']);

        // Print Refill
        Route::get('/production/refilling/print', [ 'uses' => 'RefillController@print', 'as' => 'refillPrint' ]);

        // recheck Bin Detail Table against Bin
        Route::get('/production/bin/recheck/detail', [ 'uses' => 'BinCheckedController@recheckedDetail', 'as' => 'bin.recheckedDetail' ]);

        // ReChecked Location on Bin Checked Detail
        Route::get('/production/bin/recheck/location/detail', [ 'uses' => 'BinCheckedController@recheckedLocationDetail', 'as' => 'binRecheck.LocationDetail' ]);

        // Refill Rechecked Location and Qty
        Route::get('/production/refill/qty/rechecked', [ 'uses' => 'RefillController@qtyRechecked', 'as' => 'refill.qtyRechecked' ]);

        // Get State Against Country
        Route::get('/country/state/get', ['uses' => 'Customer\CustomerCreationController@getState', 'as' => 'country.getState' ]);
        Route::post('/customer/address/store', ['uses' => 'Customer\CustomerCreationController@addressStore', 'as' => 'customer.addressStore' ]);
        Route::get('/customer/address/{id}/setDefault', [ 'uses' => 'Customer\CustomerCreationController@setDefaultAddress', 'as' => 'customer.addressDefault' ]);
        Route::post('/customer/address/delete', [ 'uses' => 'Customer\CustomerCreationController@deleteAddress', 'as' => 'customer.addressDelete' ]);

        // Search Customers Detail on Index Page of Customer
        Route::get('/get-customer', [ 'uses' => 'Customer\CustomerController@searchCustomer' ])->name('searchCustomer');

        // Delete Customer Route
        Route::post('/customer/delete', [ 'uses' => 'Customer\CustomerController@delete', 'as' => 'customer.delete' ]);

        // Sale Order Search
        Route::get('/sale-order/search', [ 'uses' => 'SaleOrderController@searchSaleOrder' ])->name('searchSaleOrder');

        // Delete Sale Order
        Route::post('/sale-order/delete', [ 'uses' => 'SaleOrderController@delete', 'as' => 'saleOrder.delete' ]);

        // Sale Order Dashboard Route
        Route::get('/sale-order/dashboard', [ 'uses' => 'SaleOrderController@dashboard', 'as' => 'saleOrder.dashboard' ]);

        // Picking Sale Order
        Route::get('sale-order/{id}/picking', [ 'uses' => 'SaleOrderPickingController@index', 'as' => 'saleOrderPicking.index' ]);

        // Picking Action NotFound and Skip Route
        Route::get('/sale-order/picking/update-behaviour', [ 'uses' => 'SaleOrderPickingController@updateBehaviour', 'as' => 'saleOrderPicking.updateBehaviour' ]);

        // Load Picking Page Data
        Route::get('/sale-order/picking/load-content', [ 'uses' => 'SaleOrderPickingController@loadContent', 'as' => 'saleOrderPicking.loadContent' ]);

        // Account Receivable
        Route::get('/account/receivable', [ 'uses' => 'AccountReceivableController@index', 'as' => 'accountReceivable.index' ]);

        // Search Account Receiveable
        Route::get('/get-account-receiveable', [ 'uses' => 'AccountReceivableController@searchReceiveable' ])->name('searchReceiveable');

        // Picking orders search index page sidebar
        Route::get('sale-order/picking/search/index', [ 'uses' => 'SaleOrderPickingController@pickingSearchIndex', 'as' => 'saleOrderPicking.pickingSearchIndex' ]);
        // search picking
        Route::post('sale-order/picking/search', [ 'uses' => 'SaleOrderPickingController@searchPicking', 'as' => 'saleOrderPicking.searchPicking' ]);
        // fulfiil picking item
        Route::post('sale-order/picking/part/fulfill', [ 'uses' => 'SaleOrderPickingController@fulfillAction', 'as' => 'saleOrderPicking.fulfillAction']);
        // check picking item
        Route::post('sale-order/picking/check/quantity', [ 'uses' => 'SaleOrderPickingController@checkQuantity', 'as' => 'saleOrderPicking.checkQuantity']);
        // refill picking action
        Route::post('sale-order/picking/refill', [ 'uses' => 'SaleOrderPickingController@refill', 'as' => 'saleOrderPicking.refill']);
        //replace action modal
        Route::post('sale-order/picking/replace', [ 'uses' => 'SaleOrderPickingController@replace', 'as' => 'saleOrderPicking.replace']);
        //print label
        Route::post('sale-order/picking/print/label', [ 'uses' => 'SaleOrderPickingController@printLabel', 'as' => 'saleOrderPicking.ptintLabel']);
        //replace part
        Route::post('sale-order/picking/replace/part', [ 'uses' => 'SaleOrderPickingController@replacePart', 'as' => 'saleOrderPicking.replacePart']);
        //replace part
        Route::post('sale-order/picking/get/virtual/subparts/short', [ 'uses' => 'SaleOrderPickingController@getShortParts', 'as' => 'saleOrderPicking.getShortParts']);
        //complete non inventory part
        Route::post('sale-order/picking/get/complete/non-inventory/part', [ 'uses' => 'SaleOrderPickingController@completeNonInventoryPart', 'as' => 'saleOrderPicking.completeNonInventoryPart']);
        //void non inventory part
        Route::post('sale-order/picking/get/void/non-inventory/part', [ 'uses' => 'SaleOrderPickingController@viodNonInventoryPart', 'as' => 'saleOrderPicking.viodNonInventoryPart']);
        //void inventory and virtual parts
        Route::post('sale-order/picking/get/void/inventory/and/virtual/part', [ 'uses' => 'SaleOrderPickingController@voidInventoryAndSpecialParts', 'as' => 'saleOrderPicking.voidInventoryAndSpecialParts']);
        //fetch bag details
        Route::post('sale-order/picking/get/part/bags/detail', [ 'uses' => 'SaleOrderPickingController@fetchBagDetails', 'as' => 'saleOrderPicking.fetchBagDetails']);
        //replace bag details
        Route::post('sale-order/picking/update/bag/details', [ 'uses' => 'SaleOrderPickingController@updateBagDetails', 'as' => 'saleOrderPicking.updateBagDetails']);
    });

    // Material Routes
    Route::get('/material/index', [MaterialController::class, 'index'])->name('material.index')->middleware('permission:show material');
    Route::get('/material/create', [MaterialController::class, 'create'])->name('material.create')->middleware('permission:create material');
    Route::post('/material/store', [MaterialController::class, 'store'])->name('material.store')->middleware('permission:create material');
    Route::get('/material/{id}/edit', [MaterialController::class, 'edit'])->name('material.edit')->middleware('permission:edit material');
    Route::post('/material/{id}/update', [MaterialController::class, 'update'])->name('material.update')->middleware('permission:edit material');
    Route::get('/material/{id}/view', [MaterialController::class, 'show'])->name('material.view')->middleware('permission:view material');
    Route::post('/material/destroy', [MaterialController::class, 'destroy'])->name('material.destroy')->middleware('permission:delete material');
    Route::get('/fetch/partAdd/info', [PartEditController::class, 'fetchPartAddInfo'])->name('fetch.infoForAddModal')->middleware('permission:create part');

    // Part Routes
    Route::get('/part/index', [PartController::class, 'index'])->name('part.index')->middleware('permission:show part');
    Route::get('/part/dashboard',[PartDashboardController::class,'partDashboard'])->name('new.part.dashboard')->middleware('permission:show part');
    // old one part/dashboard
    // Route::get('/part/search/dashboard',[PartDashboardController::class,'partSearch'])->name('part.search.dashboard');

    // edit part Routes
    Route::post('/update/general', [PartEditController::class, 'updateGeneral'])->name('general.update')->middleware('permission:create part');
    Route::post('/update/classification', [PartEditController::class, 'updateClassification'])->name('classification.update')->middleware('permission:create part');
    Route::get('/update/style', [PartEditController::class, 'updateStyles'])->name('style.update')->middleware('permission:create part');
    Route::get('/update/gender', [PartEditController::class, 'updateGenders'])->name('gender.update')->middleware('permission:create part');
    Route::get('/update/stone', [PartEditController::class, 'updateStone'])->name('stone.update')->middleware('permission:create part');
    Route::post('/update/additional/info', [PartEditController::class, 'updateAdditionalInfo'])->name('additionalinfo.update')->middleware('permission:create part');
    Route::post('/update/factory', [PartEditController::class, 'updateFactory'])->name('factory.update')->middleware('permission:create part');
    Route::get('/fetch/part/info', [PartEditController::class, 'fetchPartInfo'])->name('fetch.partInfo')->middleware('permission:create part');
    Route::post('/setdefault/part/style', [PartEditController::class, 'setDefaultPartStyle'])->name('setDefault.style')->middleware('permission:create part');
    Route::post('/setdefault/part/stone', [PartEditController::class, 'setDefaultPartStone'])->name('setDefault.stone')->middleware('permission:create part');
    Route::post('/setdefault/part/gender', [PartEditController::class, 'setDefaultPartGender'])->name('setDefault.gender')->middleware('permission:create part');
    Route::post('/delete/part/style', [PartEditController::class, 'deletePartStyle'])->name('delete.style')->middleware('permission:create part');
    Route::post('/delete/part/gender', [PartEditController::class, 'deletePartGender'])->name('delete.gender')->middleware('permission:create part');
    Route::post('/delete/part/stone', [PartEditController::class, 'deletePartStone'])->name('delete.stone')->middleware('permission:create part');
    Route::post('/update/part/status', [PartEditController::class, 'updatePartStatus'])->name('part.statusUpdate')->middleware('permission:create part');
    Route::get('/get/baseMaterilal/metal', [PartEditController::class, 'getBaseMaterialMetals'])->name('base.metal')->middleware('permission:create part');
    Route::get('/fetch/partEdit/info', [PartEditController::class, 'fetchPartEditInfo'])->name('fetch.editInfo')->middleware('permission:create part');
    // part Routes
    Route::get('/part/create', [PartController::class, 'create'])->name('part.create')->middleware('permission:create part');
    // Route::post('/part/store', [ PartController::class, 'store' ])->name('part.store')->middleware('permission:create part');
    Route::get('/part/{id}/edit', [PartController::class, 'edit'])->name('part.edit');
    // Route::get('/part/{id}/editPart', [PartController::class, 'editPart'])->name('editPart');
    // new edit
    Route::get('/edit/{id}/part', [PartController::class, 'editPart'])->name('edit.part');
    Route::post('/part/{id}/update', [PartController::class, 'update'])->name('part.update');
    Route::get('/part/{id}/view', [PartController::class, 'show'])->name('part.view')->middleware('permission:view part');
//     Route::post('/part/destroy', [PartController::class, 'destroy'])->name('part.destroy')->middleware('permission:delete part');

    // Route::get('/part/dashboard', [PartController::class, 'dashboard'])->name('part.dashboard');
    Route::get('/part/location/id', [PartController::class, 'fetchLocationId'])->name('location.fetchId');


    Route::get('/rate/index', [RateController::class, 'index'])->name('rate.index')->middleware('permission:show rate');
    Route::get('/refresh/rate/currency', [RateController::class, 'refresh'])->name('currency.refresh')->middleware('permission:show rate');



});
// Inventory
Route::group(['prefix'=>'inventory','namespace' => '\App\Http\Controllers\Inventory'], function () {
    Route::get('/fetch/locations', ['uses'=>'InventoryController@fetchPartInfo'])->name('part.information')->middleware('permission:show rate');
    Route::get('/filter/add/locations', ['uses'=>'InventoryController@filterAddLocations'])->name('filter.AddLocations')->middleware('permission:show rate');
    Route::post('/add/inventory', ['uses'=>'InventoryController@addInventory'])->name('inventory.add')->middleware('permission:show rate');
    Route::get('/show/inventory', ['uses'=>'InventoryController@index'])->name('inventory.all')->middleware('permission:show rate');
    Route::get('/fetch/move/locations', ['uses'=>'InventoryController@moveLcations'])->name('locations.move')->middleware('permission:show rate');
    Route::get('/fetch/user/groups', ['uses'=>'InventoryController@fetchUserGroups'])->name('user.groups')->middleware('permission:show rate');
    Route::get('/fetch/inventory/history', ['uses'=>'InventoryController@inventoryHistory'])->name('inventory.history.records')->middleware('permission:show rate');
    Route::post('/move/inventory', ['uses'=>'InventoryController@moveInventory'])->name('inventory.move')->middleware('permission:show rate');
    Route::get('/fetch/location/cycle', ['uses'=>'InventoryController@moveDetails'])->name('fetch.moveData')->middleware('permission:show rate');
    Route::post('/add/recount', ['uses'=>'InventoryController@addRecount'])->name('recount.add')->middleware('permission:show rate');
    Route::post('/add/scrap', ['uses'=>'InventoryController@addScrap'])->name('scrap.add')->middleware('permission:show rate');
    Route::post('/add/inventory/recount', ['uses'=>'InventoryController@addZeroInventoryRecount'])->name('recount.insert')->middleware('permission:show rate');
    Route::post('/fetch/inventory/detail', ['uses'=>'InventoryController@inventoryDetail'])->name('get.detailedInventory');
    Route::get('/fetch/specific/part/{part_id}', ['uses'=>'InventoryController@fetchSpecificPartInformation'])->name('get.specific.part');
    // check inventory controller
    Route::get('/check/inventory', ['uses'=>'CheckInventory@create'])->name('check.create')->middleware('permission:show rate');
});

// Costing layer
Route::group(['prefix'=>'costing','namespace' => '\App\Http\Controllers\Costing'], function () {
    Route::post('/get/costing/layer',[CostingController::class,'getCostingLayer'])->name('get.costingLayer');
});

//Varaition
Route::group(['namespace' => '\App\Http\Controllers\part','middleware' => 'auth'], function () {
    Route::get('/variation/variation-dropdowns', ['uses'=>'VariationController@getVariationDropdown'])->name('variation.getDropdown');
    Route::post('variation/part-search',['uses'=>'VariationController@variationPartSearch'])->name('variation.search')->middleware('permission:create part');
    Route::post('variation/save-value',['uses'=>'VariationController@variationSaveValue'])->name('variation.saveValue')->middleware('permission:create part');
    Route::post('variation/save-family',['uses'=>'VariationController@saveFamily'])->name('variation.saveFamily')->middleware('permission:create part');
    Route::get('/part/{id}/variation/{variation}', ['uses' => 'VariationController@variation'])->name( 'part.variation');
    Route::post('variation/availability',['uses'=>'VariationController@variationAvailability',])->name('variation.availability');
    Route::post('variation/set-default',['uses'=>'VariationController@setDefault',])->name('variation.setDefault');
    Route::post('delete-variation',['uses'=>'VariationController@variationDeAttach'])->name('variation.delete')->middleware('permission:create part');


});

// Route::get('/module/index', ['uses' => 'ModuleController@index', 'as' => 'module.index', 'middleware' => 'permission:show module']);
// part images
Route::group(['namespace' => 'App\Http\Controllers\DropBox' ,'middleware' => 'auth'],function(){
    Route::get('/part/images/import', [ 'uses' => 'DropBoxController@importImagesFromDropBox', 'as' => 'importPart.images' ]);
    Route::get('/check/dropbox/in/queue', [ 'uses' => 'DropBoxController@checkDropboxImportInQueue', 'as' => 'isDropBoxImport.finish' ]);
    Route::post('/import/images/batch', [ 'uses' => 'DropBoxController@importImagesBatchLocally', 'as' => 'import.images.batch' ]);
    Route::get('/check/job/exist/{displayNameJob}', [ 'uses' => 'DropBoxController@checkJobInJobsTable', 'as' => 'check.job.existence' ]);
    Route::get('/import/videos/dropbox',['uses' => "DropBoxController@importVideosDropbox", 'as' => 'import.videos.dropbox']);
    Route::get('/youtube',['uses' => "DropBoxController@youtube", 'as' => 'youtube']);
});
Route::get('/youtube/callback',['uses' => "App\Http\Controllers\DropBox\DropBoxController@youtubeCallback", 'as' => 'youtubeCallback']);

// transfer orders
Route::group(['prefix'=>'transfer/order','namespace'=>'App\Http\Controllers\TransferOrder','middleware' => 'auth'],function(){
    Route::get('/index', ['uses' => 'TransferOrderController@index'])->name('transferOrder.index');
    Route::get('/get-transfer-order', ['uses' => 'TransferOrderController@getTransferOrder'])->name('transferOrder.get');
    Route::get('/create', ['uses' => 'TransferOrderController@create'])->name('transferOrder.create');
    Route::get('/search/part/{from_group_id}/{part_no?}', ['uses' => 'TransferOrderController@searchPart'])->name('transferOrder.searchPart');
    Route::post('/store/indiviual/part', ['uses' => 'TransferOrderController@storeIndiviualPart', 'as' => 'transferOrder.create.indiviualPart']);
    Route::post('/remove-part', ['uses' => 'TransferOrderController@removePart', 'as' => 'transferOrder.removePart']);
    Route::post('/update-qty', ['uses' => 'TransferOrderController@updateQty', 'as' => 'transferOrder.updateQty']);
    Route::post('/print-label', ['uses' => 'TransferOrderController@printLabel', 'as' => 'transferOrder.print-label']);
    Route::post('/issue-single-part', ['uses' => 'TransferOrderController@issueSinglePart', 'as' => 'transferOrder.issueSinglePart']);
    Route::post('/fix-error-part', ['uses' => 'TransferOrderController@fixErrorPart', 'as' => 'transferOrder.fixErrorPart']);
    Route::post('/issue-all-part', ['uses' => 'TransferOrderController@issueAllPart', 'as' => 'transferOrder.issueAllPart']);
    Route::post('/un-issue-all-part', ['uses' => 'TransferOrderController@unIssueAllPart', 'as' => 'transferOrder.unIssueAllPart']);
    Route::get('/{transfer_order_id}/edit', ['uses' => 'TransferOrderController@editTransferOrder', 'as' => 'transferOrder.edit']);
    Route::post('/delete', ['uses' => 'TransferOrderController@deleteTransferOrder', 'as' => 'transferOrder.delete']);
    Route::get('/unissue/to/child', ['uses' => 'TransferOrderController@UnIssueChild', 'as' => 'transferOrder.child.unissue']);
    Route::post('/save/to/group', ['uses' => 'TransferOrderController@saveToGroup', 'as' => 'transferOrder.save.toGroup']);
    Route::get('/print/issued/{to_id}', ['uses' => 'TransferOrderController@printIssuedTo'])->name('transferOrder.printIssuedTo');
});
//Production
Route::group(['prefix' => 'production', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function () {
    Route::get('/show', ['uses' => 'ProductionController@index'])->name('production.index');
    Route::post('/update-table', ['uses' => 'ProductionController@updateTables'])->name('production.updateTable');
});

//Receive Transfer Order
Route::group(['prefix' => 'transfer-order/receive', 'namespace' => 'App\Http\Controllers\TransferOrder', 'middleware' => 'auth', 'as' => 'receiveOrder.'], function () {
    Route::get('/{id}/detail', ['uses' => 'ReceiveOrderController@transferOrderDetail'])->name('detail');
    Route::post('/receive-all', ['uses' => 'ReceiveOrderController@receiveAll'])->name('receiveAll');
    Route::post('/fulfil-all', ['uses' => 'ReceiveOrderController@fulfilAll'])->name('fulfilAll');
    Route::post('/fulfil-single', ['uses' => 'ReceiveOrderController@fullfillSingle'])->name('fulfillSingle');
    Route::post('/check-status', ['uses' => 'ReceiveOrderController@checkStatus'])->name('checkStatus');
    Route::post('/fulfil-single-scanner', ['uses' => 'ReceiveOrderController@fullfillSingleByScanner'])->name('fullfillSingleByScanner');
    Route::post('/get-location', ['uses' => 'ReceiveOrderController@getlocations'])->name('getlocations');
    Route::get('/archive', ['uses' => 'ReceiveOrderController@archive'])->name('archive');
    Route::post('/print', ['uses' => 'ReceiveOrderController@printTransferOrder'])->name('print');
    Route::post('/fetch-categories', ['uses' => 'ReceiveOrderController@fetchCategories'])->name('fetchCategories');
});
// production receiving
Route::group(['prefix' => 'production/receiving', 'namespace' => 'App\Http\Controllers\TransferOrder', 'middleware' => 'auth', 'as' => 'production.receiving.'], function () {
    Route::get('/create',[ReceiveOrderController::class,'productionReceivingCreate'])->name('create');
    Route::get('{id}/edit',[ReceiveOrderController::class,'productionReceivingEdit'])->name('edit');
    Route::get('search/part',[ReceiveOrderController::class,'productionReceivingSearchPart'])->name('search.part');
    Route::get('search/location',[ReceiveOrderController::class,'productionReceivingSearchLocation'])->name('search.location');
    Route::get('change/location',[ReceiveOrderController::class,'productionReceivingChangeLocation'])->name('change.location');
    Route::post('remove/child/{childId}',[ReceiveOrderController::class,'productionReceivingRemoveChild'])->name('remove.child');
    Route::post('change/user',[ReceiveOrderController::class,'productionReceivingChangeUser'])->name('change.user');

    Route::post('receive',[ReceiveOrderController::class,'productionReceivingReceive'])->name('receive');
    Route::post('add/part',[ReceiveOrderController::class,'productionReceivingAddPartToDb'])->name('add.part');
    Route::get('delete/{id}',[ReceiveOrderController::class,'productionReceivingDelete'])->name('delete');
    Route::post('from/display/create',[ReceiveOrderController::class,'productionReceivingFromDisplayCreate'])->name('from.display');
    Route::post('/lock/child/for/bin',[ReceiveOrderController::class,'lockChildForBin'])->name('child.bin.lock');
    Route::post('/update/child/qty',[ReceiveOrderController::class,'updateChildQty'])->name('child.update');
    Route::post('/row/replace/child',[ReceiveOrderController::class,'rowReplaceChild'])->name('row.replace');
    Route::post('/print/receiving',[ReceiveOrderController::class,'printReceiving'])->name('fullfilled.print');
    Route::get('fetch/finished',[ReceiveOrderController::class,'fetchAllFinishedReceivings'])->name('finished');
    Route::get('fetch/except/finished',[ReceiveOrderController::class,'fetchAllExceptFinishedReceivings'])->name('exceptFinish');
    Route::get('fetch/archived',[ReceiveOrderController::class,'fetchArchivedReceiving'])->name('archived');
    Route::get('check/inProgress/receiving',[ReceiveOrderController::class,'checkReceivingInProgress'])->name('checkInProgress');
    Route::get('/print-label', [PrintController::class, 'receivingLabels'])->name('printLabel');

});
// production move
Route::group(['prefix' => 'production/move', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth', 'as' => 'production.move.'], function () {
    Route::get('/create', ['uses' => 'MoveController@create'])->name('create');
    Route::get('/index/{id}', ['uses' => 'MoveController@index'])->name('index');
    Route::get('/get-location', ['uses' => 'MoveController@getLocation'])->name('getLocation');
    Route::post('/search-part', ['uses' => 'MoveController@search'])->name('search');
    Route::post('/remove-part', ['uses' => 'MoveController@removePart'])->name('removePart');
    Route::post('/update-qty', ['uses' => 'MoveController@updateQty'])->name('updateQty');
    Route::post('/assign-job', ['uses' => 'MoveController@assignJob'])->name('assignJob');
    Route::post('/moved-move', ['uses' => 'MoveController@moveMove'])->name('moveMove');
    Route::get('/delete-move/{id}', ['uses' => 'MoveController@deleteMove'])->name('deleteMove');
    Route::get('/archive', ['uses' => 'MoveController@archive'])->name('archive');
    Route::get('/print-label', ['uses' => 'PrintController@moveLabelPrint'])->name('printLabel');

});
// production Reprint
Route::group(['prefix' => 'production/reprint', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth', 'as' => 'production.reprint.'], function () {
    Route::get('/show/{id}', ['uses' => 'ReprintController@show'])->name('show');
    Route::get('/print-label', ['uses' => 'PrintController@reprintLabels'])->name('printLabel');
    Route::get('/achieve', ['uses' => 'ReprintController@achieve'])->name('achieve');


});
// production recount
Route::group(['prefix' => 'production/recount', 'namespace' => 'App\Http\Controllers\PartRecount', 'middleware' => 'auth', 'as' => 'production.recount.'], function () {
    Route::post('/part',['uses' => "PartRecountController@recount" ,"as" => "part"]);
    Route::get('/showAll/{created_at_date?}',['uses' => "PartRecountController@showAll" ,"as" => "showAll"]);
    Route::get('/show/{part_id}/batch',['uses' => "PartRecountController@showBatch" ,"as" => "showBatch"]);
    Route::get('/complete/{row_id}/check',['uses' => "PartRecountController@completeCheck" ,"as" => "complete.check"]);
    Route::get('/history/{part_id}',['uses' => "PartRecountController@showRecountHistoryPart" ,"as" => "history.part"]);
    Route::get('/print',['uses' => "PartRecountController@print" ,"as" => "print"]);
    Route::get('/show/all/parts/recount',['uses' => "PartRecountController@showAllPartsRecount" ,"as" => "showAll.recount"]);
    Route::get('/get/recounts',['uses' => "PartRecountController@getRecounts" ,"as" => "get"]);
    Route::get('/get/archived',['uses' => "PartRecountController@archived" ,"as" => "archived"]);
});


// production move
Route::group(['prefix' => 'production/return', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth', 'as' => 'production.return.'], function () {
    Route::get('/create', ['uses' => 'ReturnController@create'])->name('create');
    Route::get('/index/{id}', ['uses' => 'ReturnController@index'])->name('index');
    Route::post('/search-part', ['uses' => 'ReturnController@search'])->name('search');
    Route::post('/remove-part', ['uses' => 'ReturnController@removePart'])->name('removePart');
    Route::post('/assign-job', ['uses' => 'ReturnController@assignJob'])->name('assignJob');
    Route::post('/finish-insert', ['uses' => 'ReturnController@finishInsert'])->name('finishInsert');
    Route::get('/delete-move/{id}', ['uses' => 'ReturnController@deleteReturn'])->name('deleteReturn');
    Route::get('/archive', ['uses' => 'ReturnController@archive'])->name('archive');
    Route::post('/recount', ['uses' => 'ReturnController@recount'])->name('recount');
    Route::post('/return', ['uses' => 'ReturnController@returned'])->name('returned');
    Route::post('/not-found', ['uses' => 'ReturnController@notFound'])->name('notFound');
    Route::post('/refreshPart', ['uses' => 'ReturnController@refreshPart'])->name('refreshPart');
    Route::post('/finish', ['uses' => 'ReturnController@finish'])->name('finish');
    Route::post('/print', ['uses' => 'ReturnController@prints'])->name('print');
});
// production customer
Route::group(['prefix' => 'customer', 'namespace' => 'App\Http\Controllers\Customer', 'middleware' => 'auth', 'as' => 'customer.'], function () {
    Route::get('/index', ['uses' => 'CustomerController@index'])->name('index');
    Route::post('/add/api/new-details', ['uses' => 'CustomerController@addApiNewDetails'])->name("addNewApiDetails");
    Route::get('/google/auth', ['uses' => 'CustomerController@getAuthUrl'])->name("google.auth");
    Route::any('/api/save-access-token', ['uses' => 'CustomerController@saveAccessToken'])->name("saveAccessToken");
    Route::get('/add-contacts', ['uses' => 'CustomerController@addContact'])->name("addContact");
    Route::get('/get-contacts', ['uses' => 'CustomerController@updateContact'])->name("getContact");
    Route::get('/set/customer/default', ['uses' => 'CustomerController@setCustomerAsDefault'])->name('set.default');
});
// customer
// creation
Route::group(['prefix' => 'customer/creation', 'namespace' => 'App\Http\Controllers\Customer', 'middleware' => 'auth', 'as' => 'customer.creation.'], function () {
    Route::get('/create', ['uses' => 'CustomerCreationController@create'])->name('create');
    Route::get('/creation-form/{id}', ['uses' => 'CustomerCreationController@creationForm'])->name('creationForm');
    Route::post('/update-personal-name', ['uses' => 'CustomerCreationController@updatePersonalName'])->name('updatePersonalName');
    Route::post('/update-company-name', ['uses' => 'CustomerCreationController@updateCompanyName'])->name('updateCompanyName');
    Route::post('/update-account-name', ['uses' => 'CustomerCreationController@updateAccountName'])->name('updateAccountName');
    Route::post('/add-phone-number', ['uses' => 'CustomerCreationController@addPhoneNumber'])->name('addPhoneNumber');
    Route::post('/remove-phone-number', ['uses' => 'CustomerCreationController@removePhoneNumber'])->name('removePhoneNumber');
    Route::post('/change-default-phone-number', ['uses' => 'CustomerCreationController@changeNumberDefault'])->name('changeNumberDefault');
    Route::post('/add-email', ['uses' => 'CustomerCreationController@addEmail'])->name('addEmail');
    Route::post('/remove-email', ['uses' => 'CustomerCreationController@removeEmail'])->name('removeEmail');
    Route::post('/change-default-email', ['uses' => 'CustomerCreationController@changeDefaultEmail'])->name('changeDefaultEmail');
    Route::post('/add-date', ['uses' => 'CustomerCreationController@addDate'])->name('addDate');
    Route::post('/update-status', ['uses' => 'CustomerCreationController@updateStatus'])->name('updateStatus');
    Route::post('/remove-group', ['uses' => 'CustomerCreationController@removeGroup'])->name('removeGroup');
    Route::post('/add-group', ['uses' => 'CustomerCreationController@addGroup'])->name('addGroup');
    Route::post('/update-language', ['uses' => 'CustomerCreationController@addLanguage'])->name('updateLanguage');
    Route::post('/change-default-language', ['uses' => 'CustomerCreationController@changeDefaultLanguage'])->name('changeDefaultLanguage');
    Route::post('/remove-language', ['uses' => 'CustomerCreationController@removeLanguage'])->name('removeLanguage');
    Route::post('/add-customer-incoming-from', ['uses' => 'CustomerCreationController@addCustomerIncoming'])->name('addCustomerIncoming');
    Route::post('/remove-customer-incoming-from', ['uses' => 'CustomerCreationController@removeCustomerIncoming'])->name('removeCustomerIncoming');
    Route::post('/update-sale-person', ['uses' => 'CustomerCreationController@updateSalePerson'])->name('updateSalePerson');
    Route::post('/contact-or-not', ['uses' => 'CustomerCreationController@DNC'])->name('DNC');
    Route::post('/credit/limit', ['uses' => 'CustomerCreationController@updateCreditLimit'])->name('update.credit.limit');
    Route::post('/fetch/ar/balance', ['uses' => 'CustomerCreationController@fetchCustomerArBalance'])->name('fetch.ar.balance');
    Route::post('/add/payment', ['uses' => 'CustomerCreationController@addCustomerPayment'])->name('add.payment');
    Route::post('/update/credit/status', ['uses' => 'CustomerCreationController@updateCreditStatus'])->name('updateCreditStatus');
    Route::post('/update/tax/number', ['uses' => 'CustomerCreationController@updateTaxNumber'])->name('updateTaxNumber');
    Route::post('/get/sale/orders/company', ['uses' => 'CustomerCreationController@getSaleOrdersWithTotal'])->name('getSaleOrdersWithTotal');
    Route::post('/get/sale/order/remaining', ['uses' => 'CustomerCreationController@getSaleOrderRemaining'])->name('getSaleOrderRemaining');
    Route::post('/get/sale/order/paid', ['uses' => 'CustomerCreationController@getSaleOrderPaid'])->name('getSaleOrderPaid');

    // revert customer
    Route::post('/revert-customer-on-cancel', ['uses' => 'CustomerCreationController@revertCustomerOnCancel'])->name('revertCustomerOnCancel');

    // modal creation route
    Route::get('/company/create', ['uses' => 'CustomerCreationController@createComapny'])->name('company');
    Route::get('/against/company', ['uses' => 'CustomerCreationController@createCustomerAgainstComapny'])->name('against.company');
    Route::get('/fetch/company/data', ['uses' => 'CustomerCreationController@fetchCompanyData'])->name('fetch.company.data');
    Route::get('/fetch/company/accounts', ['uses' => 'CustomerCreationController@fetchCompanyAccounts'])->name('fetch.company.accounts');
    Route::get('/fetch/company/last/zero/entry', ['uses' => 'CustomerCreationController@fetchCompanyLastZeroAccount'])->name('fetch.company.last.zero.account');
    Route::get('/fetch/countries', ['uses' => 'CustomerCreationController@fetchCountries'])->name('fetch.countries');
    Route::get('/fetch/customer', ['uses' => 'CustomerCreationController@fetchCustomer'])->name('fetch.customer');
    Route::get('/fetch/details/card/dropdown',['uses' => 'CustomerCreationController@fetchDetailCardInfo'])->name('details.card.dropdown');
    Route::get('/delete/contact',['uses' => 'CustomerCreationController@deleteContact'])->name('delete.contact');
    Route::post('/save/company/contact/on/google/on/close',['uses' => 'CustomerCreationController@saveCompanyContactsOnGooleApi'])->name('saveCompanyContactsOnGooleApi');
    Route::post('/save/contact/on/close/from/edit',['uses' => 'CustomerCreationController@saveContactOnClose'])->name('saveContactOnClose');
});
// Edit
Route::group(['prefix' => 'edit/customer', 'namespace' => 'App\Http\Controllers\Customer', 'middleware' => 'auth', 'as' => 'edit.customer.'], function () {
    Route::get('/{id}', [CustomerEditController::class, 'edit']);
    Route::post('/add/phone', [CustomerEditController::class, 'addPhoneNumber'])->name("phone.add");
    Route::post('/set/phone/default', [CustomerEditController::class, 'setPhoneNumberDefault'])->name("phone.set.default");
    Route::post('/delete/phone', [CustomerEditController::class, 'deletePhoneNumber'])->name("phone.delete");
    Route::post('/update/information', [CustomerEditController::class, 'updateInfo'])->name("update.information");
    Route::post('/get/country/state', [CustomerEditController::class, 'getCountryState'])->name("get.state");
    Route::post('/add/state', [CustomerEditController::class, 'addAddress'])->name("add.address");
    Route::post('/set/address/default', [CustomerEditController::class, 'setAddressDefault'])->name("address.set.default");
    Route::post('/delete/address', [CustomerEditController::class, 'deleteAddress'])->name("address.delete");
    Route::post('/add/email', [CustomerEditController::class, 'addEmail'])->name("add.email");
    Route::post('/set/email/default', [CustomerEditController::class, 'setEmailDefault'])->name("email.set.default");
    Route::post('/delete/email', [CustomerEditController::class, 'deleteEmail'])->name("email.delete");
    Route::post('/change/status', [CustomerEditController::class, 'changeStatus'])->name("change.status");


});

Route::group(['prefix' => 'sale-order', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth', 'as' => 'saleOrder.'], function () {
    Route::get('/index', ['uses' => 'SaleOrderController@index'])->name('index');
    Route::get('/create', ['uses' => 'SaleOrderController@create'])->name('create');
    Route::get('/edit/{id}', ['uses' => 'SaleOrderController@edit'])->name('edit');
    Route::post('/update-customer', ['uses' => 'SaleOrderController@updateCustomer'])->name('updateCustomer');
    Route::post('/all-address', ['uses' => 'SaleOrderController@allAddress'])->name('allAddress');
    Route::post('/change-address', ['uses' => 'SaleOrderController@changeAddress'])->name('changeAddress');
    Route::post('/add-new-address', ['uses' => 'SaleOrderController@addNewAddress'])->name('addNewAddress');
    Route::post('/fetch-current-address', ['uses' => 'SaleOrderController@fetchCurrentAddress'])->name('fetchCurrentAddress');
    Route::post('/save-edited-address', ['uses' => 'SaleOrderController@saveEditedAddress'])->name('saveEditedAddress');
    Route::post('/change-location-group', ['uses' => 'SaleOrderController@changeLocationGroup'])->name('changeLocationGroup');
    Route::post('/change-replacement', ['uses' => 'SaleOrderController@saveReplacement'])->name('saveReplacement');
    Route::get('/get-parts', ['uses' => 'SaleOrderController@getParts'])->name('getParts');
    Route::post('/save-parts', ['uses' => 'SaleOrderController@savePart'])->name('savePart');
    Route::post('/quantity-availability', ['uses' => 'SaleOrderController@quantityAvailability'])->name('quantityAvailability');
    Route::post('/add-discount', ['uses' => 'SaleOrderController@addDiscount'])->name('addDiscount');
    Route::post('/add-subTotal', ['uses' => 'SaleOrderController@addSubTotal'])->name('addSubTotal');
    Route::get('/part-number-autocomplete', ['uses' => 'SaleOrderController@partNoAutoComplete'])->name('partNoAutoComplete');
    Route::get('/customer-autocomplete', ['uses' => 'SaleOrderController@customerAutoComplete'])->name('customerAutoComplete');
    Route::get('/part-desc-autocomplete', ['uses' => 'SaleOrderController@partDescAutoComplete'])->name('partDescAutoComplete');
    Route::post('/update-quantity', ['uses' => 'SaleOrderController@updateQty'])->name('updateQty');
    Route::post('/update-unit-price', ['uses' => 'SaleOrderController@updateUnitPrice'])->name('updateUnitPrice');
    Route::post('/remove-sale-order-part', ['uses' => 'SaleOrderController@removeSaleOrderPart'])->name('removeSaleOrderPart');
    Route::post('/get-quotes', ['uses' => 'SaleOrderController@getQuotes'])->name('getQuotes');
    Route::post('/update-carrier', ['uses' => 'SaleOrderController@updateCurrierServices'])->name('updateCurrierServices');
    Route::get('/retrieve-state', ['uses' => 'SaleOrderController@retrieveState'])->name('retrieveState');
    Route::post('/update-state', ['uses' => 'SaleOrderController@updateState'])->name('updateState');
    //get customer datatable
    Route::get('/get-customer-datable', ['uses' => 'SaleOrderController@getCustomerDatable'])->name('getCustomerDatable');

    // Mail Sale Order Part Image
    Route::get('/sale-order/mail', ['uses' => 'SaleOrderController@mailImage', 'as' => 'imageMail']);
    //change tax
    Route::post('/change-tax', ['uses' => 'SaleOrderController@changeTax', 'as' => 'changeTax']);
    //change shipping Cost
    Route::post('/change-shipping-cost', ['uses' => 'SaleOrderController@changeShippingCost', 'as' => 'changeShippingCost']);
    //save factor
    Route::post('/save-factor', ['uses' => 'SaleOrderController@saveFactor', 'as' => 'saveFactor']);
    //select customer after creation
    Route::post('/get-customer-id', ['uses' => 'SaleOrderController@getCustomerId', 'as' => 'getCustomerId']);
    //get detail tab data
    Route::post('/get-detail-tab-data', ['uses' => 'SaleOrderController@getDetailTabData', 'as' => 'getDetailTabData']);
    //add Notes
    Route::post('/add-notes', ['uses' => 'SaleOrderController@addNotes', 'as' => 'addNotes']);
    //fetch note by id
    Route::get('/fetch-note-by-id', ['uses' => 'SaleOrderController@fetchNoteById', 'as' => 'fetchNoteById']);
    //save Edited note
    Route::post('/save-edited-notes', ['uses' => 'SaleOrderController@saveEditedNote', 'as' => 'saveEditedNote']);
    //confirm modal
    Route::post('/delete-modal', ['uses' => 'SaleOrderController@deleteNote', 'as' => 'deleteNote']);
    //remove selectedr
    Route::post('/remove-selected', ['uses' => 'SaleOrderController@removeSelected', 'as' => 'removeSelected']);
    //update Sequnce
    Route::post('/update-sequence', ['uses' => 'SaleOrderController@updateSequence', 'as' => 'updateSequence']);

    //print sale Order
    Route::get('print-sale-order', ['uses' => 'SaleOrderController@printSaleOrder', 'as' => 'printSaleOrder']);
    // disclaimer page
    Route::get('/disclaimer/index', ['uses' => 'SaleOrderController@displaimerIndex', 'as' => 'disclaimerIndex']);
    //update company info
    Route::post('/update/company-info', ['uses' => 'SaleOrderController@updateCompanyInfo', 'as' => 'updateCompanyInfo']);
    //update
    Route::post('/update-disclaimer', ['uses' => 'SaleOrderController@updateDisclaimer', 'as' => 'updateDisclaimer']);
    //amount pay
    Route::post('/amount-pay', ['uses' => 'SaleOrderController@amountPay', 'as' => 'amountPay']);

    //parts in virual part
    Route::get('/parts-in-virtual-parts', ['uses' => 'SaleOrderController@partsInVirtualPart', 'as' => 'partsInVirtualPart']);
    //replace virtual Part
    Route::post('/replace-virtual-part', ['uses' => 'SaleOrderController@replaceVirtualPart', 'as' => 'replaceVirtualPart']);
    //issue Sale order
    Route::post('/issue-sale-order', ['uses' => 'SaleOrderController@issueSaleOrder', 'as' => 'issueSaleOrder']);
    //unissue sale order
    Route::post('/un-issue-sale-order', ['uses' => 'SaleOrderController@unIssueSaleOrder', 'as' => 'unIssueSaleOrder']);
    //issue sale order parts
    Route::post('/issue-sale-order-parts',['uses'=>'SaleOrderController@issueSaleOrderParts','as'=>'issueSaleOrderParts']);
    //in issue sale order parts
    Route::post('/unissue-sale-order-parts',['uses'=>'SaleOrderController@unIssueSaleOrderParts','as'=>'unIssueSaleOrderParts']);

    //
    Route::get('/get-customer-ar-balance',['uses'=>'SaleOrderController@getCompanyAr','as'=>'getCompanyAr']);
    //update picking person
    Route::post('/update-picking-person',['uses'=>'SaleOrderController@updatePickingPerson','as'=>'updatePickingPerson']);


});
// Route::get('/youtube/callback',['uses' => "App\Http\Controllers\DropBox\DropBoxController@youtubeCallback", 'as' => 'youtubeCallback']);

Route::group(['prefix' => 'shipping/markup','namespace' => 'App\Http\Controllers\ShippingMarkup','middleware' => 'auth','as' => 'shippingMarkup.'],function(){
    Route::get('/index',[ShippingMarkupController::class,'index']);
    Route::post('/update/service',[ShippingMarkupController::class,'update'])->name("update");
    Route::get('/acive',[ShippingMarkupController::class,'getActiveMarkups'])->name("get.active");
    Route::post('/update/service/value',[ShippingMarkupController::class,'updateServiceValue'])->name("value.update");
    Route::post('/update/service/percentage',[ShippingMarkupController::class,'updateServicePercentageMarkup'])->name("percentage.update");

});
Route::get("/test", function () {
    // return view('sale-order.estimate.new-edit.index');
    $locations = SaleOrder::saleOrderExcludedLocation(1);
            $locationNames = Inventory::InventoryWithLocationName(2,$locations);
            $locationNames = implode(",", $locationNames);
            
});
 Route::get("/sl",[CustomerCreationController::class,"getAllSalesOrdersId"]);


 Route::get("/testing",[CustomerCreationController::class,"testing"]);

