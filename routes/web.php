<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PartnerPageController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Partner\PartnerTransactionController;
use App\Http\Controllers\Partner\PartnerReviewController;
use App\Http\Controllers\PartnerRegistrationController;
use App\Http\Controllers\Admin\PartnerRegistrationController as AdminPartnerRegistrationController;


/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\PengurusController;


use App\Http\Controllers\Partner\PartnerAuthController;
use App\Http\Controllers\Partner\PartnerDashboardController;
use App\Http\Controllers\Partner\PartnerEventController;
use App\Http\Controllers\Partner\PartnerAccountController;


/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE
|--------------------------------------------------------------------------
*/


// Home
Route::get('/', [HomeController::class, 'index'])
    ->name('home');


// Detail Event
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');


// Detail Partner (PUBLIC)
// URL : /partners/1
Route::get('/partners/{partner}', [PartnerPageController::class, 'show'])
    ->name('partners.show');

Route::get('/partner-registration', [PartnerRegistrationController::class, 'create'])
    ->name('partner-registration.create');

Route::post('/partner-registration', [PartnerRegistrationController::class, 'store'])
    ->name('partner-registration.store');

Route::get('/partner-registration/success', [PartnerRegistrationController::class, 'success'])
    ->name('partner-registration.success');

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/


Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');


Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');


Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])
    ->name('checkout.payment');


Route::get('/success/{order_id}', [CheckoutController::class, 'success'])
    ->name('checkout.success');



/*
|--------------------------------------------------------------------------
| REVIEW EVENT
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {


    Route::get('/events/{event}/review',
        [ReviewController::class, 'create']
    )
    ->name('reviews.create');


    Route::post('/events/{event}/review',
        [ReviewController::class, 'store']
    )
    ->name('reviews.store');


});



/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN
|--------------------------------------------------------------------------
*/


Route::get('/auth/google',
    [SocialiteController::class, 'redirect']
)
->name('google.redirect');


Route::get('/auth/google/callback',
    [SocialiteController::class, 'callback']
)
->name('google.callback');



Route::post('/logout',
    [SocialiteController::class, 'logout']
)
->middleware('auth')
->name('user.logout');



/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK
|--------------------------------------------------------------------------
*/


Route::post('/midtrans/callback',
    [MidtransWebhookController::class, 'handle']
)
->name('midtrans.callback');



/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION
|--------------------------------------------------------------------------
*/


// Halaman Login Admin
Route::get('/admin/login',
    [AuthController::class, 'showLogin']
)
->name('admin.login');


// Proses Login Admin
Route::post('/admin/login',
    [AuthController::class, 'login']
)
->name('admin.login.post');


// Logout Admin
Route::post('/admin/logout',
    [AuthController::class, 'logout']
)
->middleware('auth')
->name('admin.logout');


// Alias 'login' — dibutuhkan oleh middleware 'auth' bawaan Laravel.
// Ketika user belum login mengakses route yang dilindungi middleware
// 'auth' (mis. /admin/dashboard), Laravel akan redirect ke route('login').
// Tanpa route bernama 'login' ini, Laravel melempar RouteNotFoundException.
Route::get('/login', function () {
    return redirect()->route('admin.login');
})
->name('login');



/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','admin'])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard',
            [DashboardController::class, 'index']
        )
        ->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | Event Management
        |--------------------------------------------------------------------------
        */

        Route::resource('events',
            EventAdminController::class);



        /*
        |--------------------------------------------------------------------------
        | Transaction Management
        |--------------------------------------------------------------------------
        */

        Route::get('/transactions',
            [TransactionController::class, 'index']
        )
        ->name('transactions.index');



        /*
        |--------------------------------------------------------------------------
        | Category Management
        |--------------------------------------------------------------------------
        */

        Route::resource('categories',
            CategoryController::class);



        /*
        |--------------------------------------------------------------------------
        | Partner Management
        |--------------------------------------------------------------------------
        */

        Route::resource('partners',
            PartnerController::class);



        /*
        |--------------------------------------------------------------------------
        | Jabatan Management
        |--------------------------------------------------------------------------
        */

        Route::resource('jabatans',
            JabatanController::class);



        /*
        |--------------------------------------------------------------------------
        | Pengurus Management
        |--------------------------------------------------------------------------
        */

        Route::resource('pengurus',
            PengurusController::class);


    });

    Route::get('/partner-registrations',
    [AdminPartnerRegistrationController::class, 'index'])
    ->name('admin.partner-registrations.index');

Route::get('/partner-registrations/{registration}',
    [AdminPartnerRegistrationController::class, 'show'])
    ->name('admin.partner-registrations.show');

Route::post('/partner-registrations/{registration}/approve',
    [AdminPartnerRegistrationController::class, 'approve'])
    ->name('admin.partner-registrations.approve');

Route::post('/partner-registrations/{registration}/reject',
    [AdminPartnerRegistrationController::class, 'reject'])
    ->name('admin.partner-registrations.reject');

    /*
|--------------------------------------------------------------------------
| Partner
|--------------------------------------------------------------------------
*/

Route::prefix('partner')->group(function () {

    Route::get('/login', [PartnerAuthController::class,'login'])
        ->name('partner.login');

    Route::post('/login', [PartnerAuthController::class,'authenticate'])
        ->name('partner.authenticate');

    Route::middleware('partner')->group(function () {

        Route::get('/dashboard', [PartnerDashboardController::class,'index'])
            ->name('partner.dashboard');

        Route::resource('events', PartnerEventController::class)
            ->except('show')
            ->names('partner.events');

        Route::get('/transactions', [PartnerTransactionController::class, 'index'])
            ->name('partner.transactions.index');

        Route::get('/reviews', [PartnerReviewController::class, 'index'])
            ->name('partner.reviews.index');

        Route::post('/reviews/{review}/reply', [PartnerReviewController::class, 'reply'])
            ->name('partner.reviews.reply');

        Route::get('/account', [PartnerAccountController::class, 'edit'])
            ->name('partner.account.edit');

        Route::put('/account', [PartnerAccountController::class, 'update'])
            ->name('partner.account.update');

        Route::post('/logout', [PartnerAuthController::class,'logout'])
            ->name('partner.logout');

    });

});