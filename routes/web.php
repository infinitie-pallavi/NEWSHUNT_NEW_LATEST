<?php

use Illuminate\Http\Request;
use App\Services\CachingService;
use App\Http\Controllers\WebStory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Apis\ForgetPassword;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\FrontUserController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostDetailController;
use App\Http\Controllers\SearchPostController;
use App\Http\Controllers\TopicFrontController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\ChannelFrontController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\UserRegisterController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AdminControllers\PostController;
use App\Http\Controllers\AdminControllers\RoleController;
use App\Http\Controllers\AdminControllers\StoryController;
use App\Http\Controllers\AdminControllers\TopicController;
use App\Http\Controllers\AdminControllers\UsersController;
use App\Http\Controllers\AdminControllers\ChannelController;
use App\Http\Controllers\AdminControllers\CommentController;
use App\Http\Controllers\AdminControllers\CountryController;
use App\Http\Controllers\AdminControllers\RssFeedController;
use App\Http\Controllers\AdminControllers\SettingController;
use App\Http\Controllers\AdminControllers\LanguageController;
use App\Http\Controllers\AdminControllers\WebThemeController;
use App\Http\Controllers\AdminControllers\AdminUserController;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\InstallerController;
use App\Http\Controllers\AdminControllers\PermissionController;
use App\Http\Controllers\AdminControllers\NotificationController;
use App\Http\Controllers\AdminControllers\SystemUpdateController;
use App\Http\Controllers\AdminControllers\ReportCommentController;
use dacoto\LaravelWizardInstaller\Controllers\InstallKeysController;
use dacoto\LaravelWizardInstaller\Controllers\InstallIndexController;
use dacoto\LaravelWizardInstaller\Controllers\InstallFinishController;
use dacoto\LaravelWizardInstaller\Controllers\InstallFolderController;
use dacoto\LaravelWizardInstaller\Controllers\InstallServerController;
use App\Http\Controllers\AdminControllers\NewsHuntSubscriberController;
use App\Http\Controllers\ReactionController;
use dacoto\LaravelWizardInstaller\Controllers\InstallSetKeysController;
use dacoto\LaravelWizardInstaller\Controllers\InstallDatabaseController;
use dacoto\LaravelWizardInstaller\Controllers\InstallMigrationsController;
use dacoto\LaravelWizardInstaller\Controllers\InstallSetDatabaseController;
use dacoto\LaravelWizardInstaller\Controllers\InstallSetMigrationsController;
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

Auth::routes();

Route::get('/', function () {
    if (!(new InstallServerController())->check() || !(new InstallFolderController())->check()) {
        return redirect()->route('LaravelWizardInstaller::install.folders');
    } else {
        if (Auth::check()) {
            Route::middleware(['auth'])->group(function () {
                Route::get('/user/dashboard', function () {
                    return view('user.dashboard');
                })->name('user.dashboard');
                Route::get('/admin/dashboard', function () {
                    return view('/admin/login');
                })->name('home')->middleware('admin');
            });
        }
    }
    return view('auth.login');
});

Route::group([
    'prefix' => 'install',
    'namespace' => 'dacoto\LaravelWizardInstaller\Controllers',
], static function () {
    Route::get('/', ['as' => 'install.index', 'uses' => InstallIndexController::class]);
    Route::get('/server', ['as' => 'install.server', 'uses' => InstallServerController::class]);
    Route::get('/folders', ['as' => 'install.folders', 'uses' => InstallFolderController::class]);
    Route::get('/database', ['as' => 'install.database', 'uses' => InstallDatabaseController::class]);
    Route::post('/database', ['uses' => InstallSetDatabaseController::class]);
    Route::get('/migrations', ['as' => 'install.migrations', 'uses' => InstallMigrationsController::class]);
    Route::post('/migrations', ['uses' => InstallSetMigrationsController::class]);
    Route::get('/keys', ['as' => 'install.keys', 'uses' => InstallKeysController::class]);
    Route::post('/keys', ['uses' => InstallSetKeysController::class]);
    Route::get('/finish', ['as' => 'install.finish', 'uses' => InstallFinishController::class]);
});
/*****************************************Front End Routes*********************************************/
Route::get('/', function () {
    return redirect()->route('/');
});

/************* User Authentication Routes ************/
Route::get('login', [UserLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserLoginController::class, 'login'])->name('user.login');
Route::post('logout', [UserLoginController::class, 'logout'])->name('logout');
Route::post('delete-account', [UserLoginController::class, 'deleteAccount'])->name('delete-user-account');
Route::get('first-login', function (Request $request) {
    $request->session()->forget('first_login');
    return 'success';
});

Route::get('reset-password', [ForgetPassword::class, 'resetPasswordLoad']);
Route::post('password/form', [ForgetPassword::class, 'resetPassword']);
Route::post('profile-update', [UserLoginController::class, 'changeProfileUpdate'])->name('profile-update');


Route::post('/auth/google/callback', [FirebaseAuthController::class, 'googleCallback']);
Route::post('/auth/phone/callback', [FirebaseAuthController::class, 'phoneCallback']);

/***** User Register Routes ******/
Route::get('register', [UserRegisterController::class, 'index'])->name('register');
Route::post('register', [UserRegisterController::class, 'register'])->name('user.register');

Route::get('my-account', [FrontUserController::class, 'index']);
Route::get('my-account/followings', [FrontUserController::class, 'followingsChannels']);
Route::get('my-account/bookmarks', [FrontUserController::class, 'favoritePosts']);

Route::get('/', [HomeController::class, 'index']);
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('channels/{channel?}', [ChannelFrontController::class, 'index']);
Route::get('follow/{channel}', [ChannelFrontController::class, 'channelFollow']);

/* Topic Page */
Route::get('topics', [TopicFrontController::class, 'index']);
Route::get('topics/{topic?}', [CategoryController::class, 'index']);

/* Post Detail page */
Route::get('posts/{slug}', [PostDetailController::class, 'index']);
Route::post('posts/favorite', [PostDetailController::class, 'favorteToggle']);

/* Searching result */
Route::get('posts', [SearchPostController::class, 'search'])->name('posts.search');

/* Reactions routes */
Route::post('/posts/{post}/react', [ReactionController::class, 'react'])->middleware('auth');
Route::get('/posts/{post}/reactions', [ReactionController::class, 'getReactions']);
Route::get('/posts/{post_id}/reactors', [ReactionController::class, 'getreactData']);

Route::get('get-channel-data/{id}', [SearchPostController::class, 'getchannel']);

/* Privacy & Policy */
Route::get('contact-us', [ContactUsController::class, 'index']);
Route::post('contact-us/store', [ContactUsController::class, 'store'])->name('contact_us.store');
Route::get('privacy-policies', [FooterController::class, 'privacyEndPolicy']);
Route::get('terms-and-condition', [FooterController::class, 'termsAndCondition']);
Route::get('about-us', [AboutUsController::class, 'index']);

/* User comments */
Route::get('/posts/{post}/comments', [UserCommentController::class, 'show'])->name('comments.show');
Route::post('/comments/store', [UserCommentController::class, 'store'])->name('comments.store');
Route::post('/comments/update', [UserCommentController::class, 'update'])->name('comments.update');
Route::post('/comments/delete', [UserCommentController::class, 'destroy'])->name('comments.delete');


Route::post('subscribe/store', [NewsHuntSubscriberController::class, 'store'])->name('subscribe.store');

Route::get('sitemap.xml', [SitemapController::class, 'index']);

Route::get('share', function () {
    return view('front_end.classic.pages.share');
});

Route::get('/webstories', [WebStory::class, 'index'])->name('webstories.index');
Route::get('/webstories/{topic:slug}/{story:slug}', [WebStory::class, 'show'])->name('webstories.show');
Route::get('/webstories/{topic:slug}', [WebStory::class, 'storyByTopic'])->name('webstories.by.topic');
/*****************************************Front End Routes Rmds****************************************/

/*** Dashboard Module : START ***/
Route::group(['prefix' => 'admin'], static function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('admin.login')
        ->middleware('auth.redirect');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::post('logout', [LoginController::class, 'logout']);

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Redirect route for /admin
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('admin.login');
    });

    Route::group(['middleware' => ['authcheck', 'language']], static function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('change-password', [DashboardController::class, 'changePasswordUpdate'])->name('change-password.update');
        Route::get('change-password', [DashboardController::class, 'changePassword'])->name('change-password');
        Route::post('change-profile', [DashboardController::class, 'changeProfileUpdate'])->name('change-profile.update');
        Route::get('profile', [DashboardController::class, 'changeProfile'])->name('change-profile');

        /***** Get Chart data *****/
        Route::get('/chart/data/{year}/{month}', [DashboardController::class, 'getMonthYearData'])->name('admin.dashboard.data');

        /*** Customer Module : START ***/
        Route::resource('users', UsersController::class);
        Route::post('/users/{id}/recover', [UsersController::class, 'recover'])->name('users.recover');


        /*** User Module : START ***/
        Route::group(['prefix' => 'admin-user'], static function () {
            Route::put('/{id}/change-password', [AdminUserController::class, 'changePassword'])->name('admin-user.change-password');
        });
        Route::resource('admin-users', AdminUserController::class);
        Route::get('updateFCMID', [AdminUserController::class, 'updateFCMID']);


        /*** Channel Routes : START ***/
        Route::resource('channels', ChannelController::class);
        Route::post('channel/update/status', [ChannelController::class, 'updateStatus'])->name('channel.update.status');

        /*** Topics Routes : START ***/
        Route::resource('topics', TopicController::class);
        Route::post('topic/update/status', [TopicController::class, 'updateStatus'])->name('topic.update.status');

        /*** Rss Feed Routes : START ***/
        Route::resource('rss-feeds', RssFeedController::class);
        Route::post('rssfeed/update/status', [RssFeedController::class, 'updateStatus'])->name('rsfeed.update.status');
        Route::post('rssfeed/single-fetch', [RssFeedController::class, 'singelFeedFetch'])->name('rsfeed.single-fetch');

        /*** Posts Routes : START ***/
        Route::resource('posts', PostController::class);

        /*** Posts Comments Routes : START ***/
        Route::resource('user-comments', CommentController::class);
        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');

        /* Reported commens rotue */
        Route::resource('report-comments', ReportCommentController::class);

        /*** Permission */
        Route::resource('permission', PermissionController::class);

        /******* Start Contries Routes *******/
        Route::group(['prefix' => 'countries'], static function () {
            Route::get("/", [CountryController::class, 'countryIndex'])->name('countries.index');
            Route::get("/show", [CountryController::class, 'countryShow'])->name('countries.show');
            Route::post("/import", [CountryController::class, 'importCountry'])->name('countries.import');
            Route::delete("/{id}/delete", [CountryController::class, 'destroyCountry'])->name('countries.destroy');
        });

        /*** Roles Module : END ***/
        Route::get("/roles-show", [RoleController::class, 'list'])->name('roles.list');
        Route::resource('roles', RoleController::class);

        /*** Setting Module : START ***/
        Route::group(['prefix' => 'settings'], static function () {
            Route::get('/', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/store', [SettingController::class, 'store'])->name('settings.store');

            Route::get('system', [SettingController::class, 'page'])->name('settings.system');
            Route::get('about-us', [SettingController::class, 'page'])->name('settings.about-us.index');
            Route::get('privacy-policy', [SettingController::class, 'page'])->name('settings.privacy-policy.index');
            Route::get('terms-conditions', [SettingController::class, 'page'])->name('settings.terms-conditions.index');

            Route::get('firebase', [SettingController::class, 'page'])->name('settings.firebase.index');
            Route::post('firebase/update', [SettingController::class, 'updateFirebaseSettings'])->name('settings.firebase.update');

            Route::get('error-logs', [LogViewerController::class, 'index'])->name('settings.error-logs.index');

            Route::get('system-update/index', [SystemUpdateController::class, 'index'])->name('system-update.index');
            Route::post('system-update/update', [SystemUpdateController::class, 'update'])->name('system-update.update');

            Route::resource('web_theme', WebThemeController::class);
            Route::post('web_theme/update/status', [WebThemeController::class, 'updateStatus'])->name('web_theme.update.status');

            /* Cronjob info */
            Route::get('cronjob/info', function () {
                return view('admin.settings.cronjob-info');
            })->name('settings.cronjob.info');
        });


        /* View Privacy & Policy */
        Route::get('page/privacy-policy', static function () {
            $privacy_policy = CachingService::getSystemSettings('privacy_policy');
            echo htmlspecialchars_decode($privacy_policy);
        })->name('public.privacy-policy');

        /* View Terms & Codition */
        Route::get('page/terms-conditions', static function () {
            $terms_conditions = CachingService::getSystemSettings('terms_conditions');
            echo htmlspecialchars_decode($terms_conditions);
        })->name('public.terms-conditions');
        /*** Setting Module : END ***/

        Route::group(['middleware' => ['auth', 'language']], static function () {

            /*** Language Module : START ***/
            Route::group(['prefix' => 'language'], static function () {
                Route::get('set-language/{lang}', [LanguageController::class, 'setLanguage'])->name('language.set-current');
                Route::get('download/panel', [LanguageController::class, 'downloadPanelFile'])->name('language.download.panel.json');
                Route::get('download/app', [LanguageController::class, 'downloadAppFile'])->name('language.download.app.json');
                Route::get('download/web', [LanguageController::class, 'downloadWebFile'])->name('language.download.web.json');
            });
            Route::resource('language', LanguageController::class);
            /*** Language Module : END ***/


            /*** Notification Module : START ***/
            Route::group(['prefix' => 'notification'], static function () {
                Route::delete('/batch-delete', [NotificationController::class, 'batchDelete'])->name('notification.batch.delete');
            });
            Route::get('/userList', [NotificationController::class, 'userListNofification'])->name('userList');
            Route::resource('notification', NotificationController::class);
            /*** Notification Module : END ***/

            /* Contact us */
            Route::get('contact-us', [ContactUsController::class, 'view'])->name('contact-us.index');
            Route::get('contact-us/show', [ContactUsController::class, 'show'])->name('contact-us.show');

            /* Subscriber */
            Route::get('subscriber', [NewsHuntSubscriberController::class, 'index'])->name('subscriber.index');
            Route::get('subscriber/show', [NewsHuntSubscriberController::class, 'show'])->name('subscriber.show');

            // stories admin
            Route::resource('stories', StoryController::class);
            Route::get('/stories', [StoryController::class, 'publicIndex'])->name('stories.publicIndex');
            Route::get('create', [StoryController::class, 'create_story'])->name('create.story');
            Route::get('stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
            Route::put('stories/{story}', [StoryController::class, 'update'])->name('stories.update');
            Route::post('/stories/{story}/reorder', [StoryController::class, 'updateOrder'])->name('stories.updateOrder');

        });
    });

    /************ Starts Commands  **************/
    Route::get('clear', static function () {
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        Artisan::call('debugbar:clear');
        return redirect()->back();
    });

    /* To start the queue porcess */
    Route::get('/run-queue', static function () {
        Artisan::call('rss:fetch');
        return response()->json(['error' => false, 'message' => "All Feeds fetched successfully"]);
    })->name('admin.run-queue');

    /* Migration Database */
    Route::get('/migrate', static function () {
        Artisan::call('migrate');
        echo "Done";
    });

    /* Rollback Migration */
    Route::get('/migrate-rollback', static function () {
        Artisan::call('migrate:rollback');
        return redirect()->back();
    });

    /* Reset the migration */
    Route::get('/reset-migrate', function () {
        Artisan::call('migrate:fresh');
        return 'Database tables have been deleted and re-migrated.';
    });

    /* Run the seeder */
    Route::get('/seeder', static function () {
        Artisan::call('db:seed --class=ReactionsTableSeeder');
        return redirect()->back();
    });

    /************ Ends Commands  **************/
    return redirect('/');
});




/************************************************************************************************************************************************/
/**********************************************************Unused Routes*************************************************************************/
/************************************************************************************************************************************************/

/* Non-Authenticated Common Functions */
Route::group(['prefix' => 'common'], static function () {
    Route::get('/js/lang.js', [Controller::class, 'readLanguageFile'])->name('common.language.read');
});

Route::group(['prefix' => 'install'], static function () {
    Route::get('purchase-code', [InstallerController::class, 'purchaseCodeIndex'])->name('install.purchase-code');
    Route::post('purchase-code', [InstallerController::class, 'checkPurchaseCode'])->name('install.purchase-code.post');
});
    