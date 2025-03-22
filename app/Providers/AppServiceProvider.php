<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Channel;
use App\Models\Theme;
use App\Models\Topic;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Services\CachingService;
use Illuminate\Support\Facades\Log;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      
        View::composer('*', function ($view) {
            try {
                $topics = Topic::select('id', 'name', 'slug','logo')->where('status','active')->take(8)->has('posts')->get();
                foreach ($topics as $topic) {
                    $topic->posts = Post::select('id', 'image','type','video' ,'video_thumb' , 'title', 'slug', 'comment', 'publish_date')
                        ->where('image','!=',null)
                        ->where('image','!=','')
                        ->where('topic_id', $topic->id)
                        ->orderBy('publish_date', 'DESC')
                        ->take(5)
                        ->get()
                        ->map(function ($item) {
                            $item->image = $item->image ?? url('public/front_end/classic/images/default/post-placeholder.jpg');
                            $item->publish_date_news = Carbon::parse($item->publish_date)->format('Y-m-d H:i');
                            $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                            return $item;
                        });
                }
                $channels = Channel::select('id', 'name', 'slug','logo')->where('status', 'active')->take(4)->get();
                foreach ($channels as $channel) {
                    $channel->posts = Post::select('id','image','type','video_thumb','video','title','slug','comment','publish_date')
                    ->where('channel_id', $channel->id)
                    ->orderBy('publish_date', 'DESC')
                    ->take(4)
                    ->get()
                    ->map(function ($item) {
                        $item->image = $item->image ?? url('public/front_end/classic/images/default/post-placeholder.jpg');
                        $item->publish_date_news = Carbon::parse($item->publish_date)->format('Y-m-d H:i');
                        $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                                return $item;
                    });
                }
                $firstChannelPosts = Post::select('id','image','type','video_thumb','video','slug','title','comment','publish_date')
                    ->orderBy('publish_date', 'DESC')
                    ->groupBy('channel_id')
                    ->take(4)
                    ->get()
                    ->map(function ($item) {
                        $item->publish_date_news = Carbon::parse($item->publish_date)->format('Y-m-d H:i');
                        $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                        return $item;
                    });
                
                $data = [
                    [
                    "id" => 0,
                    "name" => "All",
                    "slug" => "",
                    "posts" => $firstChannelPosts
                    ]
                ];
                $channels->prepend((object) $data[0]);
                $model_data = ['subscribe_model_status', 'subscribe_model_title', 'subscribe_model_sub_title', 'subscribe_model_image'];

                
                
                $modelArray = [];
                
                foreach ($model_data as $key) {
                    
                    $model = $this->getSetting($key);

                    $modelArray[$key] = $model->value ?? "";
                }

                $news_hunt_letter_email = request()->cookie('subscriber_email') ?? null;
                                
                $view->with([
                    'favicon' => $this->getFavicon(),
                    'webTitle' => $this->getSetting('company_name'),
                    'modelDatas' => $modelArray,
                    'post_label' => $this->getSetting('news_label_place_holder'),
                    'headerPosts' => $this->getRecentPosts(6),
                    'termsOfCondition' => $this->getSetting('terms_conditions'),
                    'socialMedia' => Setting::select('name', 'value', 'updated_at')->get()->toArray(),
                    'channels' => $channels,
                    'news_hunt_letter' => $news_hunt_letter_email,
                    'topics' => $topics,
                    'dark_logo' => $this->getSetting('dark_logo'),
                    'light_logo' => $this->getSetting('light_logo'),
                    'play_store_link' => $this->getSetting('play_store_link'),
                    'app_store_link' => $this->getSetting('app_store_link'),
                    'app_scheme' => $this->getSetting('android_shceme'),
                    'ios_shceme' => $this->getSetting('ios_shceme'),
                    'header_script' => $this->getSetting('header_script'),
                    'footer_script' => $this->getSetting('footer_script'),
                    'placeholder_image' => $this->getSetting('placeholder_image'),
                    'getTheme' => $this->getTheme()
                   
                ]);

            } catch (Throwable $e) {
                return $e;
            }
        });

    }

    protected function getTheme()
    {
       try{
           $themeData = Theme::select('slug')->where('is_default', '1')->first();
           return optional($themeData)->slug ?? 'classic';
        } catch (Throwable $e) {
        return "";
        }
    }
    

    protected function getFavicon()
    {
        return CachingService::getSystemSettings('favicon_icon');
    }

    protected function getSetting($name)
    {
        try{
        return Setting::select('name', 'value', 'updated_at')->where('name', $name)->first();
    } catch (Throwable $e) {
        return "";
    }
    }

    protected function getRecentPosts($limit)
    {
        try{
        return Post::select('title', 'slug')
            ->orderBy('publish_date', 'DESC')
            ->take($limit)
            ->get();
        } catch (Throwable $e) {
            return "";
        }
    }
}
