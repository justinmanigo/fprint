<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PrintPriceController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Log; 
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

// start route group
Route::group(['middleware'=>'auth'], function(){

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home2');

    //users routes
    Route::group(['as'=>'user.'], function(){

    //-view users
    Route::get('/users',[UsersController::class,'index']);
     // --get order info
     Route::get('/getUserInfo/{id}',[UsersController::class,'getUserInfo']);
     //  --update user type
     Route::post('/updateUserType',[UsersController::class,'updateUserType'])->name('updateUserType');

    });

    //order admin routes
    Route::group(['as'=>'orderAdmin.'], function(){

        //-view order
        Route::get('/orders',[OrdersController::class,'index']);
        // --get order info
        Route::get('/getOrder/{id}',[OrdersController::class,'adminGetOrderById']);
        //  --accept user order
        Route::post('/acceptOrder',[OrdersController::class,'acceptOrder'])->name('acceptOrder');   
        // cancel order info
        Route::post('/cancelOrder',[OrdersController::class,'cancelOrder'])->name('cancelOrder');
         


    });

    
    //order form user routes
    Route::group(['as'=>'orderUser.'], function(){

        //-view order
        Route::get('/orderForm',[OrdersController::class,'indexUser']);
        //  --add print price
        Route::post('/orderAdd',[OrdersController::class,'store'])->name('store');
        // --get product info
        Route::get('/getPrintPrice/{id}',[OrdersController::class,'getPrintPriceById']);
        //  --add print price
        Route::post('/payGcash',[OrdersController::class,'payGcash'])->name('payGcash');
         

    });


    //print price routes
    Route::group(['as'=>'printPrice.'], function(){

        //-view print price
        Route::get('/printprice',[PrintPriceController::class,'index']);
        //  --add print price
        Route::post('/storePrice',[PrintPriceController::class,'store'])->name('store');
         
        // --get print price info
        Route::get('/getPrintPriceInfo/{id}',[PrintPriceController::class,'getPrintPriceInfo']);
        //  --edit print price
        Route::post('/editPrice',[PrintPriceController::class,'edit'])->name('editPrice');
        // --delete product
        Route::delete('/printPriceDelete/{id}',[PrintPriceController::class,'destroy']);
    });

       //transaction form user routes
       Route::group(['as'=>'transactionUser.'], function(){

        //-view order
        Route::get('/myOrders',[TransactionsController::class,'indexUser']);

         // --get order info
         Route::get('/getMyOrder/{id}',[OrdersController::class,'userGetOrderById']);
       

    });

    //transaction form user routes
    Route::group(['as'=>'transactionAdmin.'], function(){

        //-view order
        Route::get('/transactions',[TransactionsController::class,'indexAdmin']);

        // --get order info
        Route::get('/getMyOrderAdmin/{id}',[TransactionsController::class,'adminGetOrderById']);

    });
 

});
// end route group






// // start route group
// Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {

//         Log::info("sod route");
//     Route::get('/', [HomeController::class,'index'])->name('home');

//     //-view users
//     Route::get('/users',[UsersController::class,'index']);

//     //users routes
    

// });
// // end route group

// // user protected routes
// Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
//     Route::get('/home5',  [HomeController::class,'index2'])->name('home2');
// });

 