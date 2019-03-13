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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(["namespace"=>"API"],function(){
    Route::get("test",["uses"=>"Test@index"]);
    Route::post('registerAdmin',['as' => 'registerAdmin','uses' => 'Admin@registerAdmin']);
    Route::post('login',['as' => 'login','uses' => 'Verify@Login']);
    Route::post('logout',['middleware' => ['jwt.refresh'],'uses' => 'Verify@Logout']);
    Route::group(['middleware' => ['jwt.auth']],function(){
        // DASHBOARD
            Route::get("getDoanhThuMonth",["uses"=>"Dashboard@getDoanhThuMonth"]);
            Route::get("getDoanhThuToday",["uses"=>"Dashboard@getDoanhThuToday"]);
        // REPORT
            Route::get("report/get_report_sale",["uses"=>"Report@get_report_sale"]);
            Route::get("report/getDoanhThu",["uses"=>"Report@getDoanhThu"]);
            Route::get("report/getBill",["uses"=>"Report@getBill"]);
            Route::get("report/getImport",["uses"=>"Report@getImport"]);
            Route::get("report/getProduct",["uses"=>"Report@getProduct"]);
        // CATEGORY
            Route::get("getListCategory",["uses"=>"Category@getListCategory"]);
            Route::post("addCategory",["uses"=>"Category@addCategory"]);
            Route::delete("deleteCategory",["uses"=>"Category@deleteCategory"]);
            Route::put("updateCategory",["uses"=>"Category@updateCategory"]);
        // CUSTOMER
            Route::get("getListCustomer",["uses"=>"Customer@getListCustomer"]);
            Route::get("getDetailCustomer",["uses"=>"Customer@getDetailCustomer"]);
            Route::get("getListProvince",["uses"=>"Customer@getProvince"]);
            Route::get("getListDistrict",["uses"=>"Customer@getDistrict"]);
            Route::post("addCustomer",["uses"=>"Customer@addCustomer"]);
            Route::delete("deleteCustomer",["uses"=>"Customer@deleteCustomer"]);
            Route::put("updateCustomer",["uses"=>"Customer@updateCustomer"]);
        // PROVIDER
            Route::get("getListProvider",["uses"=>"Provider@getListProvider"]);
            Route::get("getDetailProvider",["uses"=>"Provider@getDetailProvider"]);
            Route::get("getListProvince",["uses"=>"Provider@getProvince"]);
            Route::get("getListDistrict",["uses"=>"Provider@getDistrict"]);
            Route::post("addProvider",["uses"=>"Provider@addProvider"]);
            Route::delete("deleteProvider",["uses"=>"Provider@deleteProvider"]);
            Route::put("updateProvider",["uses"=>"Provider@updateProvider"]);
        // Admin
            Route::get("getListAdmin",["uses"=>"Admin@getListAdmin"]);
            Route::get("getDetailAdmin",["uses"=>"Admin@getDetailAdmin"]);
            Route::get("getListProvince",["uses"=>"Admin@getProvince"]);
            Route::get("getListDistrict",["uses"=>"Admin@getDistrict"]);
            Route::get("getListAdminCloneMessage",["uses"=>"Admin@getListAdminCloneMessage"]);
            Route::post("addAdminCloneMessage",["uses"=>"Admin@addAdminCloneMessage"]);
            Route::post("addAdmin",["uses"=>"Admin@addAdmin"]);
            Route::delete("deleteAdmin",["uses"=>"Admin@deleteAdmin"]);
            Route::delete("deleteAdminCloneMessage",["uses"=>"Admin@deleteAdminCloneMessage"]);
            Route::put("updateAdmin",["uses"=>"Admin@updateAdmin"]);
            Route::get("getPrivilege",["uses"=>"Admin@getPrivilege"]);
        // EVENT
            Route::get("getListEvent",["uses"=>"Event@getListEvent"]);
            Route::get("getDetailEvent",["uses"=>"Event@getDetailEvent"]);
            Route::post("addEvent",["uses"=>"Event@addEvent"]);
            Route::delete("deleteEvent",["uses"=>"Event@deleteEvent"]);
            Route::put("updateEvent",["uses"=>"Event@updateEvent"]);
        // PRODUCT
            Route::get("getListProduct",["uses"=>"Product@getListProduct"]);
            Route::post("addProduct",["uses"=>"Product@addProduct"]);
            Route::delete("deleteProduct",["uses"=>"Product@deleteProduct"]);
            Route::put("updateProduct",["uses"=>"Product@updateProduct"]);
        // PRODUCER
            Route::get("getListProducer",["uses"=>"Producer@getListProducer"]);
            Route::post("addProducer",["uses"=>"Producer@addProducer"]);
            Route::delete("deleteProducer",["uses"=>"Producer@deleteProducer"]);
            Route::put("updateProducer",["uses"=>"Producer@updateProducer"]);
        // BILL
            Route::get("getListBill",["uses"=>"Bill@getListBill"]);
            Route::get("getListAllBill",["uses"=>"Bill@getListAllBill"]);            
            Route::get("getListBillDetail",["uses"=>"Bill@getListBillDetail"]);            
            Route::post("addBill",["uses"=>"Bill@addBill"]);
            Route::delete("deleteBill",["uses"=>"Producer@deleteBill"]);
            Route::put("updateBill",["uses"=>"Bill@updateBill"]);
        // Import
            Route::get("getListImport",["uses"=>"Import@getListImport"]);
            Route::get("getListAllImport",["uses"=>"Import@getListAllImport"]);            
            Route::get("getListImportDetail",["uses"=>"Import@getListImportDetail"]);            
            Route::post("addImport",["uses"=>"Import@addImport"]);
            Route::put("updateImport",["uses"=>"Import@updateImport"]);     
        // ROOM
            Route::get("getDetailRoom",["uses"=>"Room@getDetailRoom"]);
            Route::get("getMessageInRoom",["uses"=>"Room@getMessageInRoom"]);
            Route::post("addMessage",["uses"=>"Room@addMessage"]);       
    
    });
});
