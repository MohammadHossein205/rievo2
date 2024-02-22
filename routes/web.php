<?php

use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\QuestionanswerController;
use App\Http\Controllers\admin\SellController;
use App\Http\Controllers\home\about\AboutController;
use App\Http\Controllers\home\blog\BlogController;
use App\Http\Controllers\home\blog_post\BlogPostController;
use App\Http\Controllers\home\cart\CartController;
use App\Http\Controllers\home\cart_method\CartMethodController;
use App\Http\Controllers\home\contact_us\ContactUsController;
use App\Http\Controllers\home\factor\FactorDetailController;
use App\Http\Controllers\home\husbandry\HusbandryController;
use App\Http\Controllers\home\IndexContoller;
use App\Http\Controllers\home\JoinNewsController;
use App\Http\Controllers\home\like\LikeController;
use App\Http\Controllers\home\search\SearchController;
use App\Http\Controllers\home\sellers\SellersController;
use App\Http\Controllers\home\shop\ShopController;
use App\Http\Controllers\home\singleDam\ProductInnerController;
use App\Http\Controllers\home\user\DevicesController;
use App\Http\Controllers\home\user\FailurePaymentController;
use App\Http\Controllers\home\user\NotificationController;
use App\Http\Controllers\home\user\SuccessfulPaymentController;
use App\Http\Controllers\home\user\SupportController;
use App\Http\Controllers\home\user\UserDashboard;
use App\Http\Controllers\home\user\UserHusbandryController;
use App\Http\Controllers\home\user\UserWalletController;
use App\Http\Controllers\home\wallet\WalletController;
use App\Http\Controllers\LoginWithGoogleController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//google login
Route::controller(LoginWithGoogleController::class)->group(function () {
    Route::get('authorized/google', 'redirectToGoogle')->name('auth.google');
    Route::get('authorized/google/callback', 'handleGoogleCallback');
});


//index
Route::get('/', [IndexContoller::class, 'index'])->name('index');
Route::get('/get_groups', [IndexContoller::class, 'GetGroups'])->name('GetGroups');
Route::post('/FillChart', [IndexContoller::class, 'FillChart'])->name('FillChart');
Route::post('/GetLastUpdate', [IndexContoller::class, 'GetLastUpdate'])->name('GetLastUpdate');


Route::get('/husbandry', [HusbandryController::class, 'index'])->name('home.husbandry');
Route::get('/wallet', [WalletController::class, 'index'])->name('home.wallet');


Route::get('/blog', [BlogController::class, 'index'])->name('home.blog');
Route::post('/get-all-blog-data', [BlogController::class, 'GetAllBlogsData']);
Route::get('/blog_post/{article:slug}', [BlogPostController::class, 'index'])->name('home.blog_post');
Route::post('/blog-rate', [BlogController::class, 'store']);


Route::get('/about', [AboutController::class, 'index'])->name('home.about');


Route::get('/contact_us', [ContactUsController::class, 'index'])->name('home.contact_us');

//search
Route::get('/search', [SearchController::class, 'index'])->name('home.search');
Route::post('/search/dam', [SearchController::class, 'FindDam'])->name('home.search.dam');


Route::get('/cart', [CartController::class, 'index'])->name('home.cart');


Route::get('/single/dam/{dam:slug}', [ProductInnerController::class, 'singleDam'])->name('home.single.dam');
Route::get('/single/damvizhe/{damvizhe:slug}', [ProductInnerController::class, 'singleDamVizhe'])->name('home.single.damvizhe');


Route::get('/sellers/{id}', [SellersController::class, 'index'])->name('home.seller');

//get comment
Route::post('/get-comments', [CommentController::class, 'getComments']);

//get comment
Route::post('/get-blog-comments', [CommentController::class, 'getBlogComments']);

//get question answer
Route::post('/get-questionanswer', [QuestionanswerController::class, 'getQuestionAnswer']);

//get dams
Route::post('/user/GetDamWithCondition/dam', [CartController::class, 'GetDamWithCondition'])->name('home.user.GetDamWithCondition.dam');
//shop
Route::get('/shop', [ShopController::class, 'index'])->name('home.shop');
Route::post('/shop/get_dam', [ShopController::class, 'GetPagDam'])->name('home.GetPagDam');
Route::get('/shop/{group:name}', [ShopController::class, 'ShopByGroup'])->name('home.shop.shop_by_group');


Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserDashboard::class, 'index'])->name('home.user.dashboard');
    Route::post('/user/dashboard/update', [UserDashboard::class, 'update'])->name('home.user.dashboard.update');
    Route::get('/user/failure_payment', [FailurePaymentController::class, 'index'])->name('home.user.failure_payment');
    Route::get('/user/husbandry', [UserHusbandryController::class, 'index'])->name('home.user.husbandry');
    Route::get('/user/successful_payment', [SuccessfulPaymentController::class, 'index'])->name('home.user.successful_payment');

    //user sell dam
    Route::post('/user/sell', [SellController::class, 'create'])->middleware('CheckPassword');
    Route::post('/user/check/sell', [SellController::class, 'CheckSell']);
    Route::post('/user/check/sell/vizhe', [SellController::class, 'CheckSellVizhe']);
    Route::post('/user/check/sell/confirmed', [SellController::class, 'CheckSellConfirmed']);
    Route::post('/user/check/sell/confirmed/vizhe', [SellController::class, 'CheckSellConfirmedVizhe']);
    Route::delete('/user/cancel/sell/{id}', [SellController::class, 'CancelSell']);
    // user notification
    Route::get('/user/notification', [NotificationController::class, 'index'])->name('home.user.notification');
    Route::post('/user/notification/SetMessageStatus', [NotificationController::class, 'SetMessageStatus'])->name('home.user.notification.SetMessageStatus');

    //user dam
    Route::post('/user/payment_detail', [UserHusbandryController::class, 'GetUserPaymentDetailForDam']);
    Route::post('/user/payment_detail/array', [UserHusbandryController::class, 'GetUserPaymentDetailForDamArray']);
    Route::post('/user/payment_detail/resource', [UserHusbandryController::class, 'GetUserPaymentDetailForDamResource']);
    Route::post('/user/payment_detail/resource/array', [UserHusbandryController::class, 'GetUserPaymentDetailForDamResourceArray']);
    Route::post('/user/payment_detail/id', [UserHusbandryController::class, 'GetUserPaymentDetailForDamId']);
    Route::post('/user/factor_detail', [UserHusbandryController::class, 'GetUserFactorDetailForDam']);
    Route::post('/user/GetUserFactorDetailForEachDam', [UserHusbandryController::class, 'GetUserFactorDetailForEachDam']);
    Route::post('/user/dam', [UserHusbandryController::class, 'GetUserDam']);
    Route::post('/user/dam/vizhe', [UserHusbandryController::class, 'GetUserDamVizhe']);
    Route::post('/user/dam/group_id', [UserHusbandryController::class, 'GetUserDamGroupId']);
    Route::post('/user/dam/FillChart', [UserHusbandryController::class, 'FillChart']);
    Route::post('/user/dam/FillChart/Array', [UserHusbandryController::class, 'FillChartArray']);
    Route::get('/user/dam/FillChart/Array/All', [UserHusbandryController::class, 'FillChartArrayAll']);

    //connected device
    Route::get('/user/devices', [DevicesController::class, 'index'])->name('home.user.devices');
    Route::delete('/user/devices/remove/{connecteddevice}', [DevicesController::class, 'destroy'])->name('home.user.devices.remove');

    //ticket
    Route::get('/user/support', [SupportController::class, 'index'])->name('home.user.support');
    Route::post('/user/ticket', [SupportController::class, 'SendUserTicket']);
    Route::get('/user/ticket/answer/{ticketgroupe}', [SupportController::class, 'ShowTicketAnswer'])->name('user.ticket.answer');

    //full price
    Route::get('/user/full_price', [UserHusbandryController::class, 'CheckFullPrice']);
    Route::post('/user/set/full_price', [UserHusbandryController::class, 'SetFullPrice']);
    Route::post('/user/update/full_price', [UserHusbandryController::class, 'UpdateFullPrice']);

//get dams cart
    Route::get('/get/cart', [CartController::class, 'GetCart']);
    Route::post('/set/cart', [CartController::class, 'SetCart']);
    Route::post('/edit/cart', [CartController::class, 'EditCart']);
    Route::delete('/delete/cart/{id}/{type}', [CartController::class, 'DeleteCart']);
    Route::post('/delete/all/cart', [CartController::class, 'DeleteAllCart']);
    Route::post('/user/get/dam', [CartController::class, 'GetDam'])->name('home.user.get.dam');
    Route::post('/user/get/dam/vizhe', [CartController::class, 'GetDamVizhe'])->name('home.user.get.dam.vizhe');

//    user wallet

    Route::get('/user/wallet', [UserWalletController::class, 'index'])->name('home.user.wallet');
    Route::post('/user/get/money', [UserWalletController::class, 'GetUserMoney'])->name('home.user.wallet.get.money');
    Route::post('/user/add/money', [UserWalletController::class, 'AddMoney'])->name('home.user.wallet.add.money');
    Route::post('/user/give/money', [UserWalletController::class, 'GiveMoney'])->name('home.user.wallet.give.money');
    Route::post('/user/CheckDiscount', [UserWalletController::class, 'CheckDiscount'])->name('home.user.wallet.CheckDiscount');
    Route::put('/user/add/discount', [UserWalletController::class, 'AddDiscount'])->name('home.user.add.discount');
    Route::post('/user/payment/money', [UserWalletController::class, 'UserPayment'])->name('home.user.wallet.payment');
    Route::post('/user/payment/payment_detail', [UserWalletController::class, 'UserPaymentDetail'])->name('home.user.wallet.payment.payment_detail');
    Route::post('/user/factor/status', [UserWalletController::class, 'FactorStatus'])->name('home.user.wallet.factor.status');
    Route::post('/admin/set/give/money', [UserWalletController::class, 'SetGiveMoney']);

//    factor
    Route::post('/user/create/factor', [FactorDetailController::class, 'CreateFactor'])->name('home.user.create.factor');
    Route::post('/user/create/factor_detail', [FactorDetailController::class, 'CreateDetailFactor'])->name('home.user.create.factor_detail');
    Route::post('/user/get/factor_detail', [FactorDetailController::class, 'GetDetailFactor']);
    Route::post('/user/sum/factor_detail', [FactorDetailController::class, 'SumMoney']);
    Route::post('/user/sum/monthly/factor_detail', [FactorDetailController::class, 'MonthlySumMoney']);
//    user cart
    Route::get('/user/pay/dam', [CartMethodController::class, 'index'])->name('home.user.pay.dam')->middleware('CheckPassword');

    //like
    Route::post('/like', LikeController::class);

    //comment
    Route::post('/comments', [CommentController::class, 'store']);

    //join news
    Route::post('/join_news', [JoinNewsController::class, 'InsertEmail'])->name('join_news');

    //card
    Route::get('/get/card/activity', [WalletController::class, 'CardActivity']);
});
require __DIR__ . '/auth.php';
