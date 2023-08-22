<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});

// google
Route::get('authorized/google', 'googleController@redirectToGoogle');
Route::get('authorized/google/callback', 'googleController@handleGoogleCallback');
// facebook
Route::get('/redirect', 'FacebookController@redirectFacebook');
Route::get('/callback', 'FacebookController@facebookCallback');
// linkedin
Route::get('auth/linkedin', 'LinkedinController@linkedinRedirect');
Route::get('auth/linkedin/callback', 'LinkedinController@linkedinCallback');

/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'AdminController@notifications')->name('notifications');
        Route::get('notification/read/{id}', 'AdminController@notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'AdminController@readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report', 'AdminController@requestReport')->name('request.report');
        Route::post('request-report', 'AdminController@reportSubmit');

        Route::get('system-info', 'AdminController@systemInfo')->name('system.info');

        //Category Manage
        Route::get('category', 'CategoryController@index')->name('category.list');
        Route::post('category/store', 'CategoryController@store')->name('category.store');
        Route::post('category/update/{id}', 'CategoryController@update')->name('category.update');

        //Admin Company Manage P-A-R
        Route::name('company.')->prefix('companies')->group(function () {
            Route::get('all', 'ManageCompanyController@index')->name('index');
            Route::get('pending', 'ManageCompanyController@index')->name('pending');
            Route::get('approved', 'ManageCompanyController@index')->name('approved');
            Route::get('rejected', 'ManageCompanyController@index')->name('rejected');
            Route::get('details/{id}', 'ManageCompanyController@details')->name('details');
            Route::post('approve', 'ManageCompanyController@approve')->name('approve');
            Route::post('reject', 'ManageCompanyController@reject')->name('reject');
        });

        // Admin Teacher 
        Route::name('teacher.')->prefix('teacher')->group(function () {
            Route::get('all', 'ManageTeacherController@index')->name('index');
            Route::get('pending', 'ManageTeacherController@index')->name('pending');
            Route::get('approved', 'ManageTeacherController@index')->name('approved');
            Route::get('rejected', 'ManageTeacherController@index')->name('rejected');
            Route::get('details/{id}', 'ManageTeacherController@details')->name('details');
            Route::post('approve', 'ManageTeacherController@approve')->name('approve');
            Route::post('reject', 'ManageTeacherController@reject')->name('reject');
        });


        //Admin Review  Manage
        Route::get('reviews', 'ReviewController@index')->name('reviews.list');
        Route::post('review/delete', 'ReviewController@delete')->name('review.delete');
        // teacher review delete
        Route::post('treview/delete', 'ReviewController@trdelete')->name('treview.adelete');
        // claim.list
        Route::get('claim-list', 'ManageTeacherController@claimList')->name('claim.list');
        // claim.approve
        Route::get('claim-list-approve/{id}', 'ManageTeacherController@claimListApprove')->name('claim.approve');
        // claim reject
        Route::get('claim-list-reject/{id}', 'ManageTeacherController@claimListReject')->name('claim.reject');
        // claim.delete
        Route::get('claim-list-delete/{id}', 'ManageTeacherController@claimListDelete')->name('claim.delete');
        // admin teacher reviews
        Route::get('teacher-reviews', 'ReviewController@teacherIndex')->name('treviews.list');
        Route::post('teacher-review/delete', 'ReviewController@teacherDelete')->name('treview.delete');

        // Advertisement Manage//
        Route::get('advertisement', 'AdvertisementController@index')->name('advertisement.index');
        Route::get('advertisement/create', 'AdvertisementController@create')->name('advertisement.create');
        Route::post('advertisement/store', 'AdvertisementController@store')->name('advertisement.store');
        Route::post('advertisement/update/{id}', 'AdvertisementController@update')->name('advertisement.update');
        // End Advertisement   //

        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');
        Route::get('users/with-balance', 'ManageUsersController@usersWithBalance')->name('users.with.balance');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.add.sub.balance');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');
        Route::get('users/email-log/{id}', 'ManageUsersController@emailLog')->name('users.email.log');
        Route::get('users/email-details/{id}', 'ManageUsersController@emailDetails')->name('users.email.details');


        // Report
        Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');
        Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');
        Route::get('report/email/history', 'ReportController@emailHistory')->name('report.email.history');


        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.importLang');

        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');


        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');
        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css', 'GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css', 'GeneralSettingController@customCssSubmit');

        //Cookie
        Route::get('cookie', 'GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie', 'GeneralSettingController@cookieSubmit');

        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');

        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.test.mail');


        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsTemplate')->name('sms.template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsTemplateUpdate')->name('sms.template.global');
        Route::get('sms-template/setting', 'SmsTemplateController@smsSetting')->name('sms.templates.setting');
        Route::post('sms-template/setting', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.setting');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.test.sms');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');

        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {

            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});




/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/


Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
    Route::post('check-mail', 'Auth\RegisterController@checkUser')->name('checkUser');
    Route::get('otp', 'Auth\RegisterController@OTP')->name('otp');
    Route::post('verify/otp', 'Auth\RegisterController@OTPVerification')->name('verify.otp');
    // registersuccess
    Route::get('verification/success', 'Auth\RegisterController@registerSuccess')->name('registersuccess');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');

            Route::get('profile-setting', 'UserController@profile')->name('profile.setting');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('change.password');
            Route::post('change-password', 'UserController@submitPassword');

            // password reset
            Route::get('password/reset', 'UserController@showLinkRequestForm')->name('password.requestnew');
            Route::post('password/email', 'UserController@sendResetCodeEmail')->name('password.emailnew');
            Route::get('password/code-verify', 'UserController@codeVerify')->name('password.code.verifynew');
            Route::post('password/verify-code', 'UserController@verifyCode')->name('password.verify.codenew');
            Route::get('password/reset/{token}', 'UserController@showResetForm')->name('password.resetnew');
            //Company Manage
            Route::get('companies', 'CompanyController@index')->name('company');
            Route::get('company/create', 'CompanyController@create')->name('company.create');
            Route::post('company/store', 'CompanyController@store')->name('company.store');
            Route::get('company/edit/{id}', 'CompanyController@edit')->name('company.edit');
            Route::post('company/update/{id}', 'CompanyController@update')->name('company.update');

             //Company Manage
             Route::get('teacher', 'TeacherController@index')->name('teacher');
             Route::get('teacher/create', 'TeacherController@create')->name('teacher.create');
             Route::post('teacher/store', 'TeacherController@store')->name('teacher.store');
             Route::get('teacher/edit/{id}', 'TeacherController@edit')->name('teacher.edit');
             Route::post('teacher/update/{id}', 'TeacherController@update')->name('teacher.update');
            // saveTeacherClaimFrom
            Route::post('save-teacher/claim-form/{id}', 'TeacherController@saveTeacherClaimFrom')->name('saveTeacherClaimFrom');
            // saveInstituteClaimFrom
            Route::post('save-institute/claim-form/{id}', 'CompanyController@saveInstituteClaimFrom')->name('saveInstituteClaimFrom');
            // claimTeacherProfile 
            Route::get('claim-teacher/profile/{id}', 'TeacherController@claimTeacherProfile')->name('claimTeacherProfile');
            // claimInstituteProfile
            Route::get('claim-institute/profile/{id}', 'CompanyController@claimInstituteProfile')->name('claimInstituteProfile');
            // Review-update
            Route::post('update/review', 'UserController@updateReview')->name('update.review');
            Route::post('update/teacher/review', 'UserController@updateTeacherReview')->name('update.teacher.review');
            Route::post('delete/review', 'UserController@deleteReview')->name('delete.review');
            Route::post('delete/teacher/review', 'UserController@deleteTeacherReview')->name('delete.teacher.review');
        });
    });
});
 
Route::get('companies/all', 'SiteController@companies')->name('company.all');
Route::get('company', 'SiteController@searchFromBanner')->name('search.company');
Route::get('companies/category/{id}', 'SiteController@companies')->name('category.company');
Route::get('companies/filter', 'SiteController@filterCompanies')->name('company.filter');
Route::get('company/{id}/{slug}', 'SiteController@companyDetails')->name('company.details');
Route::get('teacher/all', 'SiteController@companies1')->name('teacher.all');
Route::get('teacher', 'SiteController@searchFromBanner1')->name('search.teacher');
Route::get('teacher/category/{id}', 'SiteController@companies1')->name('category.teacher');
Route::get('teacher/filter', 'SiteController@filterCompanies1')->name('teacher.filter');
Route::get('teacher/{id}/{slug}', 'SiteController@companyDetails1')->name('teacher.details');
Route::post('review/{id}', 'SiteController@review')->name('user.review');

// user.teacher.review
Route::post('teacher/review/{id}', 'SiteController@teacherReview')->name('user.teacher.review');
Route::get('get/review/{id}', 'SiteController@getReview')->name('get.user.review');
 
Route::get('contact', 'SiteController@contact')->name('contact');
Route::post('contact', 'SiteController@contactSubmit');
Route::get('change/{lang?}', 'SiteController@changeLanguage')->name('lang');



Route::get('/add/click/{id}', 'SiteController@addClick')->name('add.click');
Route::get('cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');

Route::get('blog', 'SiteController@blogs')->name('blog');
Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');
Route::get('policy/{slug}/{id}', 'SiteController@policyPage')->name('policy.page');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');
// test rating view
Route::get('testRating', 'SiteController@testRating');

Route::get('/{slug}', 'SiteController@pages')->name('pages');
Route::get('/', 'SiteController@index')->name('home');
