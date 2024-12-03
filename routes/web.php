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

/* The following are the new pages made by broccoli, please merage the back-end deta into it, thanks */
// about us page
Route::get('about-us', 'AboutUsController@index');
Route::get('yizixue-faq', 'YizixueFaqController@index');
/* End of new pages */

Route::get('/', 'FrontPageController@index');
Route::get('introduction/{id}', 'IntroductionController@getDetial')->name('get-introduction');
Route::get('article-list/{user}', 'ArticleController@getAllArticle')->name('article-list');
Route::get('article/{article}', 'ArticleController@getArticle')->name('article');
Route::get('study-abroad', 'ArticleController@studyAbroad')->name('study-abroad');
Route::get('senior', 'SeniorController@index')->name('senior');
Route::any('line-pay/confirm', 'LinePayController@confirm')->name('line-pay-confirm');
Route::any('line-pay/cancel', 'LinePayController@cancel')->name('line-pay-cancel');
Route::get('membership-agreement', 'ContractController@membershipAgreement')->name('membership-agreement');
Route::get('service-agreement', 'ContractController@serviceAgreement')->name('service-agreement');
Route::get('disclaimer', 'ContractController@disclaimer')->name('disclaimer');
Route::get('subscription-agreement', 'ContractController@subscriptionAgreement')->name('subscription-agreement');
Route::get('privacy', 'ContractController@privacy')->name('privacy');

//line login
Route::get('/line', 'LoginController@pageLine');
Route::get('/callback/login', 'LoginController@lineLoginCallBack');

Route::get('qna', 'GuestQaController@index')->name('qna');
Route::get('qna/{id}', 'GuestQaController@show')->name('qna.show');


//LIKE
Route::get('like-user/{id}', 'LikeController@likeUser')->name('like-user');
Route::get('like-post/{id}', 'LikeController@likePost')->name('like-post');
//Collect
Route::get('collect-user/{id}', 'CollectController@collectUser')->name('collect-user');
Route::get('collect-post/{id}', 'CollectController@collectPost')->name('collect-post');
Route::get('collect-qa/{id}', 'CollectController@collectQa')->name('collect-qa');

//reference
Route::delete('reference-delete/{id}', 'UserController@referenceDelete')->name('reference-delete');
Route::get('reference-download/{id}', 'UserController@referenceDownload')->name('reference-download');


//meta login
Route::get('facebook-login', 'Auth\FacebookController@login')->name('facebook-login');
Route::any('facebook-callback', 'Auth\FacebookController@callback')->name('facebook-callback');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//PostController
Route::group(['middleware' => ['auth', 'isEmailVerified']],function() {

    Route::get('/list-posts', 'PostController@list')->name('list-all-posts');
    Route::get('/collect-posts', 'PostController@collect')->name('collect-posts');
    Route::get('create-post', 'PostController@create')->name('create-post');
    Route::get('/edit-post/{uuid}', 'PostController@edit')->name('edit-post');
    Route::post('/save-post', 'PostController@save')->name('save-post');
    Route::post('/update-post', 'PostController@update')->name('update-post');
    Route::get('/delete-post/{uuid}', 'PostController@delete')->name('delete-post');
    Route::get('view-post/{uuid}', 'PostController@show')->name('view-post');

    //QnAController
    Route::get('/list-qa', 'QnAController@list')->name('list-all-qa');
    Route::get('/collect-qa', 'QnAController@collect')->name('collect-qa');
    Route::get('/create-qa', 'QnAController@create')->name('create-qa');
    Route::get('/view-qa/{uuid}', 'QnAController@show')->name('view-qa');
    Route::get('/view-collect-qa/{uuid}', 'QnAController@showCollectQa')->name('view-collect-qa');
    Route::get('/edit-qa/{uuid}', 'QnAController@edit')->name('edit-qa');
    Route::post('/save-qa', 'QnAController@save')->name('save-qa');
    Route::post('/update-qa', 'QnAController@update')->name('update-qa');
    Route::get('/delete-qa/{uuid}', 'QnAController@delete')->name('delete-qa');
    Route::get('/delete-collect-qa/{uuid}', 'QnAController@deleteCollectQa')->name('delete-collect-qa');
    Route::get('/delete-attachment/{id}', 'QnAController@deleteAttachment')->name('delete-attachment');
    Route::get('/download-attachment/{id}', 'QnAController@attachmentDownload')->name('download-attachment');

    Route::get('/user/get', 'UserController@getAll');
    Route::get('/user/collect-user', 'UserController@collect')->name('collect-user');
    Route::get('/user/skill', 'UserController@getUserBySkill');
    Route::get('/user/profile', 'UserController@profile')->name('profile');
    Route::post('/user/profile/update', 'UserController@update')->name('update-profile');
    Route::post('/user/profile/update', 'UserController@update')->name('update-profile');
    Route::get('/user/invite-list', 'UserController@showInviteList');
    Route::post('/user/accept-invite/{id}', 'UserController@getInviteList')->name('accept-invite');
    Route::delete('/user/delete-collect/{id}', 'UserController@deleteCollect')->name('delete-collect');

    Route::get('/bulletinboard', 'BulletinBoardController@index')->name('bulletinboard');
    Route::get('pay-product', 'PayProductController@index')->name('pay-product-list');
    Route::post('pay-product/{id}', 'PayProductController@store')->name('pay-product');
    Route::get('pay-order', 'PayOrderController@index')->name('pay-order-list');
    Route::get('university-list', 'UniversityController@index')->name('university-list');

    //newebpay
    Route::post('pay-product-newebpay/{id}', 'NewebPayController@createPaymentForm')->name('pay-product-newebpay');
});

//carousel
Route::get('carousel-list', 'CarouselController@list')->name('carousel-list');

// newebpay return
Route::any('newebpay-return-url', 'NewebPayController@returnUrl')->name('newebpay-return-url');
Route::any('newebpay-notify-url', 'NewebPayayController@handleNewebPaymentCallback')->name('newebpay-notify-url');

//Verify
Route::get('register/verify', 'Auth\RegisterController@verify')->name('verifyEmailLink');
Route::get('register/verify/resend', 'Auth\RegisterController@showResendVerificationEmailForm')->name('showResendVerificationEmailForm');
Route::post('register/verify/resend', 'Auth\RegisterController@resendVerificationEmail')->name('resendVerificationEmail');

Route::get('sms_confirm', 'SmsContractController@index')->name('sms.index');
Route::post('sms_confirm', 'SmsContractController@store')->name('sms.confirm');