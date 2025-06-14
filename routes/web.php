<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoyaltyController;
use App\Http\Controllers\CustomerPromotionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoyaltyProgramController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReservationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Models\CustomerPromotion;
use App\Models\Inventory;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerController::class, 'index'])->name('index');
Route::get('/login', [CustomerController::class, 'login'])->name('login');
Route::get('/register', [CustomerController::class, 'register'])->name('register');
Route::post('/regist', [CustomerController::class, 'regist'])->name('regist');
Route::post('/auth', [CustomerController::class, 'auth'])->name('auth');

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.update');

    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
    Route::post('/reservation/store', [ReservationController::class, 'makeReservation'])->name('reservation.store');

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::post('/payment/store', [PaymentController::class, 'makePayment'])->name('payment.store');

    Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/store', [CartController::class, 'addToCart'])->name('cart.store');
    Route::delete('/cart/destroy/{cart:id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/cart/update/{cart:id}', [CartController::class, 'update'])->name('cart.update');


    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [CustomerController::class, 'showOrders'])->name('orders.show');
    Route::post('/feedback/store', [FeedbackController::class, 'addFeedback'])->name('feedback.store');

    Route::get('/notification', [NotificationController::class, 'get'])->name('notification.get');

    Route::get('/loyalty', [CustomerController::class, 'loyalty'])->name('loyalty');
    Route::post('/customer_loyalty/store', [CustomerLoyaltyController::class, 'redeemLoyaltyPoint'])->name('customer_loyalty.store');

    Route::post('/customerPromotion/store', [CustomerPromotionController::class, 'store'])->name('customerPromotion.store');
});

Route::get('/logout', [CustomerController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/', [AdminController::class, 'getCustomerProfile'])->name('index');
    Route::get('/profile', [AdminController::class, 'getCustomerProfile'])->name('profile.index');
    Route::get('/profile/{customer:id}', [AdminController::class, 'editCustomerProfile'])->name('profile.edit');
    Route::put('/profile/update/{customer:id}', [AdminController::class, 'updateCustomerProfile'])->name('customer.update');
    Route::delete('/profile/delete/{customer:id}', [AdminController::class, 'deleteCustomerProfile'])->name('customer.delete');

    Route::get('/reservation', [AdminController::class, 'reservation'])->name('reservation');
    Route::patch('/reservation/{reservation:id}', [AdminController::class, 'processReservation'])->name('reservation.update');

    Route::prefix('loyalty')->name('loyalty.')->group(function () {
        Route::get('/', [LoyaltyProgramController::class, 'index'])->name('index');
        Route::get('/{id}', [LoyaltyProgramController::class, 'show'])->name('show');
        Route::post('/store', [LoyaltyProgramController::class, 'store'])->name('store');
        Route::put('/update/{program:id}', [LoyaltyProgramController::class, 'update'])->name('update');
        Route::delete('/delete/{program:id}', [LoyaltyProgramController::class, 'delete'])->name('delete');
    });

    Route::get('/inventory', [InventoryController::class, 'checkStock'])->name('inventory');

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::put('/update/{inventory:id}', [InventoryController::class, 'updateStock'])->name('update');
        Route::post('/store', [InventoryController::class, 'store'])->name('store');
        Route::delete('/destroy/{inventory:id}', [InventoryController::class, 'destroy'])->name('destroy');
    });

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/status/{order:id}', [OrderController::class, 'updateStatus'])->name('order.update.status');

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('/notification/store', [NotificationController::class, 'sendNotification'])->name('notification.store');


    Route::prefix('promotion')->name('promotion.')->group(function () {
        Route::get('', [PromotionController::class, 'index'])->name('index');
        Route::post('/store', [PromotionController::class, 'createPromotion'])->name('store');
        Route::put('/update/{promotion:id}', [PromotionController::class, 'updatePromotion'])->name('update');
        Route::delete('/delete/{promotion:id}', [PromotionController::class, 'deletePromotion'])->name('delete');
    });
});
