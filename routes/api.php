<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\ForgetPassword;
use App\Http\Controllers\Apis\StoryController;
use App\Http\Controllers\SearchPostController;
use App\Http\Controllers\Apis\ChannelController;
use App\Http\Controllers\Apis\BookmarkController;
use App\Http\Controllers\Apis\FavoriteController;
use App\Http\Controllers\Apis\FirebaseController;
use App\Http\Controllers\Apis\ReactionsController;
use App\Http\Controllers\Apis\UserLoginController;
use App\Http\Controllers\Apis\GetSettingController;
use App\Http\Controllers\Apis\UserCommentController;
use App\Http\Controllers\Apis\FetchRssFeedController;
use App\Http\Controllers\Apis\NotificationController;
use App\Http\Controllers\Apis\SuggestionPostController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*======================================V1=APIs================================================ */
Route::group(['prefix' => 'v1'], static function () {
    /***** User Authentication Routes *****/
    Route::post('register', [UserLoginController::class, 'register']);
    Route::post('login', [UserLoginController::class, 'login']);
        Route::post('firebaseauth', [FirebaseController::class, 'firebaseTokenverify']);

    /* Get Setting APi */
    Route::get('get-system-settings', [GetSettingController::class, 'getSystemSettings']);

    /***** Home page api Starts******/
    Route::group(['prefix' => 'fetch-feeds'], static function () {
        Route::get('banner', [FetchRssFeedController::class, 'fetchBannerPosts']);
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => 'fetch-feeds'], function () {

            Route::get('recommended', [FetchRssFeedController::class, 'fetchPosts']);
            Route::get('followerd-channels-post', [FetchRssFeedController::class, 'followedChannelsPosts']);

            // Route::get('populer-home', [FetchRssFeedController::class, 'fetchPopularHome']);
            Route::get('populer/{page?}', [FetchRssFeedController::class, 'fetchPopularPosts']);

            /***** Fetch By Topic *****/
            Route::get('topic/{topic}', [FetchRssFeedController::class, 'fetchPostsByTopic']);
        });

        /******* Post Description api********/
        Route::get('fetch-post/descriptions/{slug}/{device_id?}/{fcm_id?}', [FetchRssFeedController::class, 'postDescription']);

        /*****Channel API & Subscribe Channel API*****/
        Route::get('fetch-feeds/channels', [ChannelController::class, 'index']);
        // Route::post('subscribe-channel/{slug}', [ChannelController::class, 'subscribeChannel']);

        Route::get('fetch-feeds/channels/{slug}', [ChannelController::class, 'getProfileData']);
        Route::get('fetch-feeds/channel/posts/{slug}', [ChannelController::class, 'getProfilePosts']);

        /***** Manage user Favorite post *****/
        // Route::post('favorites', [FavoriteController::class, 'toggleFavorite']);
        Route::get('favorites/posts', [FavoriteController::class, 'getPosts']);

        /* Bookmark API */
        Route::post('favorites/add', [FavoriteController::class, 'addToggleFavorite']);
        Route::post('favorites/remove', [FavoriteController::class, 'removeToggleFavorite']);

        /******** Search & Get Suggestions *********/
        Route::get('search/suggestion', [SuggestionPostController::class, 'getsuggestion']);
        Route::get('search/result', [SuggestionPostController::class, 'search']);

        /* User Profile */
        Route::get('get-profile', [UserLoginController::class, 'getProfile']);
        Route::post('profile-update', [UserLoginController::class, 'updateProfile']);
        Route::get('user-channel-list', [UserLoginController::class, 'getChannelList']);

        /* Comments api */
        Route::post('commets', [UserCommentController::class, 'store']);
        Route::post('commets/update', [UserCommentController::class, 'update']);
        Route::delete('delete-comment/{id}', [UserCommentController::class, 'destroy']);
        
        /* Report Comments */
        Route::post('commets/report', [UserCommentController::class, 'reportComment']);

        /************ Discover API ****************/
        Route::get('discover/posts/{page?}', [BookmarkController::class, 'discoverPosts']);
        Route::get('posts/autocomplete', [SearchPostController::class, 'autocomplete'])->name('posts.autocomplete');

        /* Notificaitons api */
        Route::get('notifications', [NotificationController::class, 'getNotificationList']);
    });
    Route::get('fetch-feeds/topics', [ChannelController::class, 'fetchTopics']);

    Route::get('commets/{id}', [UserCommentController::class, 'show']);
    Route::get('commets/replies/{postId}/{parentId}', [UserCommentController::class, 'replayShow']);

    /******Forget Password*********/
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        /* Channel Subscribe */
        Route::post('channel/subscribe/{slug}', [ChannelController::class, 'subscribeChannelNew']);
        Route::post('channel/unsubscribe/{slug}', [ChannelController::class, 'unSubscribeChannel']);

        Route::post('user-profile-update', [UserLoginController::class, 'updateProfileNew']);

        /* Delete user account */
        Route::delete('remove-account', [UserLoginController::class, 'deleteUser']);
        
        /* User react */
        Route::get('react/{type}/{slug}', [ReactionsController::class, 'react']);
    });
    Route::get('get-reactions',[ReactionsController::class, 'getReaction']);
    Route::get('get-reactors/{type}/{slug}',[ReactionsController::class, 'getReactors']);

    Route::post('store-fcm', [NotificationController::class,'storeOnlyFcm']);

    /****** Story API*********/
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('stories/{type}/{topic?}', [StoryController::class, 'index']);
        
   });
});