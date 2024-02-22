<?php

use App\Http\Controllers\admin\AboutusController;
use App\Http\Controllers\admin\AdminIndexController;
use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\admin\AuthimageController;
use App\Http\Controllers\admin\ChartpriceController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\ContactusController;
use App\Http\Controllers\admin\DamController;
use App\Http\Controllers\admin\DamvizheController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\FakecommentController;
use App\Http\Controllers\admin\FaqsettingController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\GetmoneyController;
use App\Http\Controllers\admin\GroupCompanyController;
use App\Http\Controllers\admin\GroupController;
use App\Http\Controllers\admin\HusbandryTextController;
use App\Http\Controllers\admin\IndexpagesettingController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\admin\ParvarbandiController;
use App\Http\Controllers\admin\PaymentConditionController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\QuestionanswerController;
use App\Http\Controllers\admin\QuestionanswersettingController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\SellController;
use App\Http\Controllers\admin\TaxController;
use App\Http\Controllers\admin\TicketgroupeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\UserProfileController;
use App\Http\Controllers\admin\WalletTextController;
use App\Http\Controllers\home\factor\FactorController;
use App\Http\Controllers\home\JoinNewsController;
use App\Http\Controllers\home\user\BankcardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/index', [AdminIndexController::class, 'index'])->name('index');

//----------------------------------------------------------------------------------//

//user-profile
Route::get('/profile/{name}', [UserProfileController::class, 'index'])->name('profile.index');
Route::put('/profile/{user}', [UserProfileController::class, 'update']);
Route::get('/profile/password/{name}', [UserProfileController::class, 'password']);
Route::post('/profile/password', [UserProfileController::class, 'changePassword']);

//user
Route::get('/users/index', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::post('/get-all-users-data', [UserController::class, 'GetAllUsersData']);
Route::post('/add-discount-to-users', [UserController::class, 'AddDiscountToUsers']);
Route::post('/remove-users-discount', [UserController::class, 'RemoveUsersDiscount']);

//dam
Route::get('/dam/index', [DamController::class, 'index']);
Route::get('/dam/create', [DamController::class, 'create']);
Route::delete('/dam/{dam}', [DamController::class, 'destroy']);
Route::get('/dam/{dam}/edit', [DamController::class, 'edit']);
Route::put('/dam/{dam}', [DamController::class, 'update']);
Route::post('/dam', [DamController::class, 'store']);
Route::post('/get-all-dam-data', [DamController::class, 'GetAllDamData']);

//dam vizhe
Route::get('/dam/damvizhe/index', [DamvizheController::class, 'index']);
Route::get('/dam/damvizhe/create', [DamvizheController::class, 'create']);
Route::delete('/damvizhe/{damvizhe}', [DamvizheController::class, 'destroy']);
Route::get('/dam/damvizhe/{damvizhe}/edit', [DamvizheController::class, 'edit']);
Route::put('/damvizhe/{damvizhe}', [DamvizheController::class, 'update']);
Route::post('/damvizhe', [DamvizheController::class, 'store']);
Route::post('/get-all-damvizhe-data', [DamvizheController::class, 'GetAllDamVizheData']);


//message
Route::get('/message/index', [MessageController::class, 'index']);
Route::get('/message/create', [MessageController::class, 'create']);
Route::delete('/message/{message}', [MessageController::class, 'destroy']);
Route::get('/message/{message}/edit', [MessageController::class, 'edit']);
Route::put('/message/{message}', [MessageController::class, 'update']);
Route::post('/message', [MessageController::class, 'store']);
Route::post('/get-all-message-data', [MessageController::class, 'GetAllMessageData']);


//grouo
Route::get('/group/index', [GroupController::class, 'index']);
Route::get('/group/create', [GroupController::class, 'create']);
Route::delete('/group/{group}', [GroupController::class, 'destroy']);
Route::put('/group/{group}', [GroupController::class, 'update']);
Route::post('/group', [GroupController::class, 'store']);
Route::post('/get-all-group-data', [GroupController::class, 'GetAllGroupData']);

//groupcompany
Route::get('/groupcompany/index', [GroupCompanyController::class, 'index']);
Route::get('/groupcompany/create', [GroupCompanyController::class, 'create']);
Route::delete('/groupcompany/{groupcompany}', [GroupCompanyController::class, 'destroy']);
Route::put('/groupcompany/{groupcompany}', [GroupCompanyController::class, 'update']);
Route::post('/groupcompany', [GroupCompanyController::class, 'store']);
Route::get('/groupcompany/{groupcompany}/edit', [GroupCompanyController::class, 'edit']);
Route::post('/get-all-groupcompany-data', [GroupCompanyController::class, 'GetGroupCompanyData']);


//gallery
//Route::resource('/galleries', GalleryController::class);
Route::get('/galleries', [GalleryController::class, 'index']);
Route::post('/galleries', [GalleryController::class, 'store']);
Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy']);
Route::get('/galleries-get-data', [GalleryController::class, 'GetGalleriesData']);

//role
Route::get('/role/index', [RoleController::class, 'index']);
Route::get('/role/create', [RoleController::class, 'create']);
Route::delete('/role/{role}', [RoleController::class, 'destroy']);
Route::put('/role/{role}', [RoleController::class, 'update']);
Route::post('/role', [RoleController::class, 'store']);
Route::get('/role/{role}/edit', [RoleController::class, 'edit']);
Route::post('/get-all-role-data', [RoleController::class, 'GetAllRoleData']);

//permission
Route::get('/permission/index', [PermissionController::class, 'index']);
Route::get('/permission/create', [PermissionController::class, 'create']);
Route::delete('/permission/{permission}', [PermissionController::class, 'destroy']);
Route::put('/permission/{permission}', [PermissionController::class, 'update']);
Route::post('/permission', [PermissionController::class, 'store']);
Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit']);
Route::post('/get-all-permission-data', [PermissionController::class, 'GetAllPermissionData']);

//discountcode
Route::get('/discountcode/index', [DiscountCodeController::class, 'index']);
Route::get('/discountcode/create', [DiscountCodeController::class, 'create']);
Route::delete('/discountcode/{discountcode}', [DiscountCodeController::class, 'destroy']);
Route::put('/discountcode/{discountcode}', [DiscountCodeController::class, 'update']);
Route::post('/discountcode', [DiscountCodeController::class, 'store']);
Route::get('/discountcode/{discountcode}/edit', [DiscountCodeController::class, 'edit']);
Route::post('/get-all-discountcode-data', [DiscountCodeController::class, 'GetAllDiscountCodeData']);

//article
Route::get('/article/index', [ArticleController::class, 'index']);
Route::get('/article/create', [ArticleController::class, 'create']);
Route::delete('/article/{article}', [ArticleController::class, 'destroy']);
Route::put('/article/{article}', [ArticleController::class, 'update']);
Route::post('/article', [ArticleController::class, 'store']);
Route::get('/article/{article}/edit', [ArticleController::class, 'edit']);
Route::post('/get-all-article-data', [ArticleController::class, 'GetAllArticleData']);

//faq setting
Route::get('/faq/index', [FaqsettingController::class, 'index']);
Route::get('/faq/create', [FaqsettingController::class, 'create']);
Route::delete('/faq/{faqsetting}', [FaqsettingController::class, 'destroy']);
Route::put('/faq/{faqsetting}', [FaqsettingController::class, 'update']);
Route::post('/faq', [FaqsettingController::class, 'store']);
Route::get('/faq/{faqsetting}/edit', [FaqsettingController::class, 'edit']);
Route::post('/get-all-faq-data', [FaqsettingController::class, 'GetFaqData']);

//fake comment
Route::get('/fakecomment/index', [FakecommentController::class, 'index']);
Route::get('/fakecomment/create', [FakecommentController::class, 'create']);
Route::delete('/fakecomment/{fakecomment}', [FakecommentController::class, 'destroy']);
Route::put('/fakecomment/{fakecomment}', [FakecommentController::class, 'update']);
Route::post('/fakecomment', [FakecommentController::class, 'store']);
Route::get('/fakecomment/{fakecomment}/edit', [FakecommentController::class, 'edit']);
Route::post('/get-all-fakecomment-data', [FakecommentController::class, 'GetFakeCommentData']);

//sell dam
Route::get('/selldam/index', [SellController::class, 'index']);
Route::delete('/selldam/{sell}', [SellController::class, 'destroy']);
Route::get('/selldam/showData/{sell}', [SellController::class, 'showSellDetailData']);
Route::post('/selldam', [SellController::class, 'store']);
Route::post('/get-all-selldam-data', [SellController::class, 'GetSellDamData']);

//chart price
Route::get('/chartprice/index', [ChartpriceController::class, 'index']);
Route::get('/chartprice/create', [ChartpriceController::class, 'create']);
Route::delete('/chartprice/{chartprice}', [ChartpriceController::class, 'destroy']);
Route::put('/chartprice/{chartprice}', [ChartpriceController::class, 'update']);
Route::post('/chartprice', [ChartpriceController::class, 'store']);
Route::get('/chartprice/{chartprice}/edit', [ChartpriceController::class, 'edit']);
Route::post('/get-all-chartprice-data', [ChartpriceController::class, 'GetChartPriceData']);

//ticket
Route::get('/ticket/index', [TicketgroupeController::class, 'index']);
Route::get('/ticket/create', [TicketgroupeController::class, 'create']);
Route::delete('/ticket/{ticket}', [TicketgroupeController::class, 'destroy']);
Route::post('/ticket', [TicketgroupeController::class, 'store']);
Route::get('/ticketgroupe/show/{ticketgroupe}', [TicketgroupeController::class, 'showTicketGroupe']);
Route::get('/ticketgroupe/showData/{ticketgroupe}', [TicketgroupeController::class, 'showTicketGroupeData']);
Route::post('/get-all-ticket-data', [TicketgroupeController::class, 'GetTicketData']);

//comment
Route::get('/comment/index', [CommentController::class, 'index']);
Route::get('/comment/create', [CommentController::class, 'create']);
Route::delete('/comment/{comment}', [CommentController::class, 'destroy']);
Route::put('/comment/{comment}', [CommentController::class, 'update']);
Route::put('/comment/seen/{comment}', [CommentController::class, 'SeenComment']);
Route::put('/comment/status/{comment}', [CommentController::class, 'StatusComment']);
Route::post('/comment', [CommentController::class, 'store']);
Route::get('/comment/{comment}/edit', [CommentController::class, 'edit']);
Route::post('/get-all-comment-data', [CommentController::class, 'GetAllCommentData']);

//question and answer
Route::get('/questionanswer/index', [QuestionanswerController::class, 'index']);
Route::get('/questionanswer/create', [QuestionanswerController::class, 'create']);
Route::delete('/questionanswer/{questionanswer}', [QuestionanswerController::class, 'destroy']);
Route::put('/questionanswer/{questionanswer}', [QuestionanswerController::class, 'update']);
Route::post('/questionanswer/answer/{questionanswer}', [QuestionanswerController::class, 'StoreQuestionAnswer']);
Route::post('/questionanswer', [QuestionanswerController::class, 'store']);
Route::get('/questionanswer/{questionanswer}/edit', [QuestionanswerController::class, 'edit']);
Route::post('/get-all-questionanswer-data', [QuestionanswerController::class, 'GetAllQuestionAnswerData']);

//question and answer setting
Route::get('/questionanswersetting/index', [QuestionanswersettingController::class, 'index']);
Route::get('/questionanswersetting/create', [QuestionanswersettingController::class, 'create']);
Route::delete('/questionanswersetting/{questionanswersetting}', [QuestionanswersettingController::class, 'destroy']);
Route::put('/questionanswersetting/{questionanswersetting}', [QuestionanswersettingController::class, 'update']);
Route::post('/questionanswersetting', [QuestionanswersettingController::class, 'store']);
Route::get('/questionanswersetting/{questionanswersetting}/edit', [QuestionanswersettingController::class, 'edit']);
Route::post('/get-all-questionanswersetting-data', [QuestionanswersettingController::class, 'GetAllQuestionAnswerSettingData']);


//join news
Route::get('/joinnews/index', [JoinNewsController::class, 'index']);
Route::post('/get-all-joinnews-data', [JoinNewsController::class, 'GetAllJoinNewsData']);

//bank card
Route::get('/bankcard/index', [BankcardController::class, 'index']);
Route::get('/bankcard/create', [BankcardController::class, 'create']);
Route::delete('/bankcard/{bankcard}', [BankcardController::class, 'destroy']);
Route::put('/bankcard/{bankcard}', [BankcardController::class, 'update']);
Route::put('/bankcard/seen/{bankcard}', [BankcardController::class, 'SeenComment']);
Route::put('/bankcard/status/{bankcard}', [BankcardController::class, 'StatusBankCard']);
Route::post('/bankcard', [BankcardController::class, 'store']);
Route::get('/bankcard/{bankcard}/edit', [BankcardController::class, 'edit']);
Route::post('/get-all-bankcard-data', [BankcardController::class, 'GetAllBankCardData']);
Route::post('/bankcard/get_card', [BankcardController::class, 'GetCard']);
Route::post('/bankcard/get-user-information-shaba', [BankcardController::class, 'getUserInformationWithShaba']);

//contact us
Route::get('/contactus/index', [ContactusController::class, 'index']);
Route::post('/contactus', [ContactusController::class, 'store']);

//about us
Route::get('/aboutus/index', [AboutusController::class, 'index']);
Route::post('/aboutus', [AboutusController::class, 'store']);

//payment condition
Route::get('/paymentcondition/index', [PaymentConditionController::class, 'index']);
Route::post('/paymentcondition', [PaymentConditionController::class, 'store']);

//husbandry text
Route::get('/husbandry/index', [HusbandryTextController::class, 'index']);
Route::post('/husbandry', [HusbandryTextController::class, 'store']);

//wallet text
Route::get('/walletext/index', [WalletTextController::class, 'index']);
Route::post('/walletext', [WalletTextController::class, 'store']);

//authimage
Route::get('/authimage/index', [AuthimageController::class, 'index']);
Route::post('/authimage', [AuthimageController::class, 'store']);

//index page setting
Route::get('/indexsetting/index', [IndexpagesettingController::class, 'index']);
Route::post('/indexsetting', [IndexpagesettingController::class, 'store']);

//taxs
Route::get('/taxs/index', [TaxController::class, 'index']);
Route::post('/taxs', [TaxController::class, 'store']);

//payment
Route::get('/payment/{id}', [PaymentController::class, 'payment'])->name('payment');
Route::get('/payment/money/{id}', [PaymentController::class, 'paymentMoney'])->name('paymentMoney');
Route::get('/money/{id}', [PaymentController::class, 'money']);
Route::get('/pay/Moneychecker/{id}', [PaymentController::class, 'Moneychecker']);
Route::get('/pay/checker/{id}', [PaymentController::class, 'checker']);
Route::get('/pay/money/checker/{id}', [PaymentController::class, 'checkerMoney']);

//get money
Route::get('/getmoney/index', [GetmoneyController::class, 'index']);
Route::get('/getmoney/create', [GetmoneyController::class, 'create']);
Route::delete('/getmoney/{getmoney}', [GetmoneyController::class, 'destroy']);
Route::put('/getmoney/{getmoney}', [GetmoneyController::class, 'update']);
Route::post('/getmoney', [GetmoneyController::class, 'store']);
Route::get('/getmoney/{getmoney}/edit', [GetmoneyController::class, 'edit']);
Route::post('/get-all-getmoney-data', [GetmoneyController::class, 'GetAllGetMoneyData']);

//payment-admin
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/{payment}/showdetail', [PaymentController::class, 'ShowDetail'])->name('payment.detail');
Route::post('/get-all-payment-data', [PaymentController::class, 'GetAllPaymentData']);

//factor
Route::get('/factor', [FactorController::class, 'index']);
Route::get('/factor/{factor}/showdetail', [FactorController::class, 'ShowDetail'])->name('factor.detail');
Route::put('/factor/{factordetail}', [FactorController::class, 'update']);
Route::get('/factor/create', [FactorController::class, 'create']);
Route::post('/factor', [FactorController::class, 'store']);
Route::put('/factor/adminshow/{factor}', [FactorController::class, 'adminShow']);
Route::get('/factor/{factor}/edit', [FactorController::class, 'edit']);
Route::delete('/factor/{factor}', [FactorController::class, 'destroy']);
Route::put('/factorpage/{factor}', [FactorController::class, 'updateFactor']);
Route::post('/get-all-factor-data', [FactorController::class, 'GetAllFactorData']);
Route::post('/get-user-dam-data', [FactorController::class, 'GetUserDamData']);

//parvarbandi
Route::get('/parvarbandi/index', [ParvarbandiController::class, 'index']);
Route::get('/parvarbandi/create/index', [ParvarbandiController::class, 'createindex']);
Route::get('/parvarbandi/create', [ParvarbandiController::class, 'create']);
Route::delete('/parvarbandi/{parvarbandi}', [ParvarbandiController::class, 'destroy']);
Route::get('/parvarbandi/{parvarbandi}/edit', [ParvarbandiController::class, 'edit']);
Route::get('/parvarbandi/{group}', [ParvarbandiController::class, 'AddParvarbandi']);
Route::put('/parvarbandi/{parvarbandi}', [ParvarbandiController::class, 'update']);
Route::post('/parvarbandi', [ParvarbandiController::class, 'store']);
//Route::get('/parvarbandi/create/{id}/showdam', [ParvarbandiController::class, 'showDam']);
Route::post('/get-all-parvarbandi-data', [ParvarbandiController::class, 'GetParvarbandiData']);
Route::post('/delete-dam-insert-mohney', [ParvarbandiController::class, 'DeleteDamInsertMohney']);

