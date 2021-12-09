<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PrintPriceController;
use App\Http\Controllers\TransactionsController;  
use App\Http\Controllers\FilesController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MailController;
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
Auth::routes(['verify' => true]);
 
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/welcome', [HomeController::class,'welcome']);
    Route::get('/#collapse_1i', [HomeController::class,'index3']);
    Route::get('/#collapse_2i', [HomeController::class,'index3']);
    Route::get('/#collapse_3i', [HomeController::class,'index3']);
    Route::get('/index', [HomeController::class,'index2']);

    
//only verified account can access with this group
Route::group(['middleware' => ['verified']], function() {
    Route::get('/loginUser', [HomeController::class,'loginUser'])->name('loginUser');
});
 

// start route group
Route::group(['middleware'=>'auth'], function(){

    //users routes
    Route::group([
        'as'=>'user.',
        'middleware'=>'role:admin'
    ], function(){

        //-view users
        Route::get('/users',[UsersController::class,'index']);
        // --get users info
        Route::get('/getUserInfo/{id}',[UsersController::class,'getUserInfo']);
        //  --update user type
        Route::post('/updateUserType',[UsersController::class,'updateUserType'])->name('updateUserType');
        //  --block user 
        Route::post('/blockUser',[UsersController::class,'blockUser'])->name('blockUser');
        // --delete user
        Route::delete('/UserDelete/{id}',[UsersController::class,'destroy']); 

    });

    //order admin routes
    Route::group([
        'as'=>'orderAdmin.',
        'middleware'=>'role:admin'
    ], function(){

        //-view order
        Route::get('/orders',[OrdersController::class,'index']);
        // --get order info
        Route::get('/getOrder/{id}',[OrdersController::class,'adminGetOrderById']);
        //  --accept user order
        Route::post('/acceptOrder',[OrdersController::class,'acceptOrder'])->name('acceptOrder');   
        // cancel order info
        Route::post('/cancelOrder',[OrdersController::class,'cancelOrder'])->name('cancelOrder');
         


    });

     //settings user routes
     Route::group(['as'=>'users.'], function(){

        //-view user
        Route::get('/view',[OrdersController::class,'indexUser']);

        //-view orduserer
        Route::get('/settings',[UsersController::class,'show']);

        //  --edit user settings
        Route::post('/editSettings',[UsersController::class,'edit'])->name('edit');

        
          

    });
    
    //order form user routes
    Route::group(['as'=>'orderUser.'], function(){

        //-view order
        Route::get('/orderForm',[OrdersController::class,'indexUser'])->name('orderForm');
        //  --add print price
        Route::post('/orderAdd',[OrdersController::class,'store'])->name('store');
        // --get product info
        Route::get('/getPrintPrice/{id}',[OrdersController::class,'getPrintPriceById']);
        //  --add print price
        Route::post('/payGcash',[OrdersController::class,'payGcash'])->name('payGcash');
        // --get order track info
        Route::get('/getTrackOrder/{id}',[LogsController::class,'getTrackOrder']);
          // cancel order info
          Route::post('/cancelOrderUser',[OrdersController::class,'cancelOrder'])->name('cancelOrderUser');
     

    });

    


    //print price routes
    Route::group([
        'as'=>'printPrice.',
        'middleware'=>'role:admin'
    ], function(){

        //-view print price
        Route::get('/printprice',[PrintPriceController::class,'index']);
        //  --add print price
        Route::post('/storePrice',[PrintPriceController::class,'store'])->name('store');
         
        // --get print price info
        Route::get('/getPrintPriceInfo/{id}',[PrintPriceController::class,'getPrintPriceInfo']);
        //  --edit print price
        Route::post('/editPrice',[PrintPriceController::class,'edit'])->name('editPrice');
        //  --edit print price
        Route::post('/printPriceAvailability',[PrintPriceController::class,'updateAvailability'])->name('editAvailability');
        // --delete product
        Route::delete('/printPriceDelete/{id}',[PrintPriceController::class,'destroy']);
    });

    
    //announcement routes
    Route::group([
        'as'=>'announcement.',
        'middleware'=>'role:admin'
    ], function(){

        //-view announcement
        Route::get('/announcement',[AnnouncementController::class,'index']);
        //  --add announcement
        Route::post('/addAnnouncement',[AnnouncementController::class,'store'])->name('store');
         
        // --get announcement info
        Route::get('/getAnnouncementInfo/{id}',[AnnouncementController::class,'getAnnouncementInfo']);
        //  --edit announcement
        Route::post('/editAnnouncement',[AnnouncementController::class,'update'])->name('update');

         // --delete announcement
         Route::delete('/printAnnouncement/{id}',[AnnouncementController::class,'destroy']);
       
    });

    //transaction form user routes
    Route::group(['as'=>'transactionUser.'], function(){

        //-view order
        Route::get('/myOrders',[TransactionsController::class,'indexUser']);
        //  --edit order
        Route::post('/editOrder',[TransactionsController::class,'edit'])->name('edit');

        // --get order info
        Route::get('/getMyOrder/{id}',[OrdersController::class,'userGetOrderById']);

        // --view order receipt
        Route::get('/viewReceiptUser/{id}',[TransactionsController::class,'viewReceiptUser']);

         //  --edit order
         Route::post('/feedback',[OrdersController::class,'feedback'])->name('feedback');


    });

    //transaction form user routes
    Route::group([
        'as'=>'transactionAdmin.',
        'middleware'=>'role:admin'
    ], function(){

        //-view order
        Route::get('/transactions',[TransactionsController::class,'indexAdmin']);

        // --get order info updateStatus
        Route::get('/getMyOrderAdmin/{id}',[TransactionsController::class,'adminGetOrderById']);
         
        //  --update status for transaction
        Route::post('/updateStatus',[TransactionsController::class,'update'])->name('updateStatus');

        // --view order receipt
        Route::get('/viewReceiptAdmin/{id}',[TransactionsController::class,'viewReceiptAdmin']);

     // --view order receipt
     Route::post('/notifyUser',[TransactionsController::class,'notifyUser'])->name('notifyUser');
    });

    //transaction form user routes
    Route::group(['as'=>'viewfile.'], function(){
        //-view file
        Route::get('/viewOrder/{id}',[FilesController::class,'viewOrder'])->name('viewOrder');

        //  //-view order
        //  Route::get('/transactions',[TransactionsController::class,'indexAdmin']);
    });

     //dashboard from admin
     Route::group(['as'=>'dashboard.'], function(){
         //-view
         Route::get('/dashboard',[DashboardController::class,'index']);
         //-get revenue
         Route::get('/getRevenue',[DashboardController::class,'getRevenue']);

       
    });

});
// end route group

// Route::get('/send-email', [MailController::class, 'sendEmail']);



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

Route::get('test', function () {
    event(new App\Events\StatusLiked('Someone'));
    return "Event has been sent!";
});