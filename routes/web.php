<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

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

//EMAIL VERIFICATION
Route::prefix('email')->group(function () {
    Route::view('verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');
    Route::post('verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

//Payments
Route::get('ipay/checkout', 'PaymentController@payment');
Route::get('ipay/callback', 'PaymentController@callback');
Route::get('ipay/failed', 'PaymentController@paymentFailed');
Route::get('mtn/checkout', 'MtnController@payment');
Route::put('mtn/callback', 'MtnController@callback');
Route::put('mtn/failed', 'MtnController@paymentFailed');
Route::get('paypal/checkout', 'PaypalController@paymentProcess');
Route::get('paypal/success', 'PaypalController@paymentSuccess');
Route::get('paypal/cancel', 'PaypalController@paymentCancel');
Route::post('paypal/ipn', 'PaypalController@postNotify');

//User Links
Route::prefix('user')->middleware(['auth', 'useremail'])->group(function () {
    Route::get('profile', 'UserController@show')->name('profile.show');
    Route::patch('{user}/update-profile', 'UserController@update')->name('profile.update');
    Route::get('change-password', 'UserController@passwordChange')->name('change.password');
    Route::post('change-password', 'UserController@updatePassword')->name('update.password');
    Route::get('read/{slug}', 'MagazineController@show')->middleware(['viewissue']);
    Route::get('free/read/{slug}', 'MagazineController@giftShow');
    Route::get('download/{slug}', 'MagazineController@freeDownload')->name('downloadissue');
    Route::get('payments', 'UserController@mypayments')->name('user.payments');
    Route::get('invites', 'UserController@invite')->name('user.invite');
    Route::post('invites', 'UserController@memberStore')->name('member.store');
    Route::get('remove-member/{team}', 'UserController@memberdestroy')->name('member.destroy');
    Route::get('subscribed/magazines', 'UserController@subscriptionMagazines')->name('user.subscribed.magazines')->middleware('LogVisits');
    Route::get('team/magazines', 'UserController@teamMagazines')->name('user.team.magazines');
    Route::get('myOrders', 'UserController@Orders')->name('user.orders');
    Route::get('view-invoice-{payment}', 'UserController@ipayInvoice')->name('Myipay.invoice');
    Route::get('mtn-invoice-{payment}', 'UserController@mtnInvoice')->name('Mymtn.invoice');
    Route::get('paypal-invoice-{payment}', 'UserController@paypalInvoice')->name('Mypaypal.invoice');
});

//Admin Links
Route::prefix('admin')->middleware(['auth', 'useremail', 'AdminAccess'])->group(function () {
    Route::get('file-manager', 'FileManagerController@index')->name('manage.magazines');
    Route::get('give-promotional-magazine', 'MagazineController@givePromotion')->name('promote.magazine');
    Route::patch('give-promotional-magazine', 'MagazineController@updatePromotion')->name('update.promotion');
    Route::get('destroy-promotional-magazine/{id}', 'MagazineController@destroyPromotion')->name('destroy.promotion');
    Route::view('subscription-plans', 'admin.subscription-plans')->name('manage.plans')->middleware('SuperAccess');
    Route::view('upload-magazine', 'admin.magazine-upload')->name('upload.magazine');
    Route::post('post-magazine', 'MagazineController@store')->name('magazine.upload');
    Route::get('upload-article', 'ArticleController@create')->name('upload.article');
    Route::post('post-article', 'ArticleController@store')->name('article.upload');
    Route::get('Paypal-payments', 'ViewTransactionController@paypalTransaction')->name('paypal.admin')->middleware('SuperAccess');
    Route::get('Ipay-payments', 'ViewTransactionController@ipayTransaction')->name('ipay.admin')->middleware('SuperAccess');
    Route::get('MTN-payments', 'ViewTransactionController@mtnTransaction')->name('mtn.admin')->middleware('SuperAccess');
    Route::get('Customers', 'CustomerController@index')->name('customers.view');
    Route::get('ExchangeRates', 'ViewTransactionController@rates')->name('exchange.rates')->middleware('SuperAccess');
    Route::get('Customer-{customer}', 'CustomerController@customerInfo')->name('customer.info');
    Route::get('gifts', 'GiftController@gifts')->name('admin.gift');
    Route::post('gifts', 'GiftController@postGift')->name('gift.store');
    Route::get('remove-gift/{gift}', 'GiftController@destroyGift')->name('gift.destroy');
    Route::get('Cart-Orders', 'OrderController@CartOrder')->name('cart.orders');
    Route::get('Subscription-Orders', 'OrderController@SubOrder')->name('subscription.orders');
    Route::get('ipay-Invoice-{payment}', 'ViewTransactionController@ipayInvoice')->name('ipay.invoice');
    Route::get('paypal-Invoice-{payment}', 'ViewTransactionController@paypalInvoice')->name('paypal.invoice');
    Route::get('upload/users', 'UploadUsersController@create')->name('upload.users');
    Route::post('upload/users', 'UploadUsersController@storeUsers')->name('store.users');
    Route::get('visits', 'MagazineController@showVisits')->name('visits');
    Route::get('urls', 'ArticleController@urls')->name('urls');
});

Route::view('/dashboard', 'dashboard')->middleware(['auth', 'useremail'])->name('dashboard');

//Unauth Pages
//Route::view('/', 'welcome')->name('landing.page');
Route::get('mtn', 'MtnController@testMtn');
Route::get('/', 'HomePageController@welcome')->name('landing.page');
Route::get('/Previous-Issues', 'HomePageController@previous')->name('previous.issues');
Route::post('/Add-to-Cart', 'HomePageController@cart')->name('cart.store');
Route::post('/Remove-from-Cart', 'HomePageController@remove')->name('cart.remove');
Route::view('/choose/plan', 'choose-plan')->name('choose.plan');
Route::post('/subscribe/plan', 'SubscriptionController@store')->name('chosen.plan');
Route::get('/checkout/Cart', 'SubscriptionController@checkout')->name('checkout.cart');
Route::post('/checkout/Cart', 'ShippingController@checkout')->name('checkout.pay');
Route::get('/subscribe/plan', 'SubscriptionController@index')->name('subscribe.plan');
Route::post('/make/payment', 'ShippingController@store')->name('make.payment');

Route::get('/user/subscriptions', [UserController::class, 'subscriptions'])->name('user.subscriptions');

//Socialite Login
Route::prefix('auth')->group(function () {
    Route::get('/{key}/redirect', 'SocialiteController@redirect')->name('socialite');
    Route::get('/{key}/callback', 'SocialiteController@callback');
});

Route::get('bug-test',function(){
    Bugsnag::notifyException(new RuntimeException("Test error"));
});


Route::view('/rapo-tables', 'test');

Route::get('/custom/{shortURLKey}', '\AshAllenDesign\ShortURL\Controllers\ShortURLController');


require __DIR__ . '/auth.php';
