<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        /* Clear output buffer to prevent unwanted output */
        ob_clean();
    
        $sitemap = Sitemap::create();
        $baseurl = url('/');
        
        $sitemap->add(Url::create(url($baseurl))
            ->setPriority(1.0)
        );
        
        $channels = Channel::select('slug')->where('status','active')->get();
        
        $sitemap->add(Url::create(url('channels'))
        ->setPriority(0.9)
        );

        foreach ($channels as $channel) {
            $sitemap->add(Url::create(url('channels/'.$channel->slug))
                ->setPriority(0.8)
            );
        }

        $topics = Topic::select('slug')->where('status','active')->get();

        foreach ($topics as $topic) {
            $sitemap->add(Url::create(url('topics/'.$topic->slug))
                ->setPriority(0.8)
            );
        }

        $posts = Post::select('slug', 'pubdate')->where('status','active')->orderBy('created_at', 'DESC')->take('200')->get();
    
        foreach ($posts as $post) {
            $sitemap->add(Url::create(url('posts/'.$post->slug))
                ->setPriority(0.8)
                ->setChangeFrequency('weekly')
            );
        }

        $response = response($sitemap->render(), 200)->header('Content-Type', 'application/xml');
        $sitemapXml = $response->getContent();
        
        $sitemapXml = preg_replace('/<changefreq>.*?<\/changefreq>/s', '', $sitemapXml);
            
        return response($sitemapXml, 200)->header('Content-Type', 'application/xml');

    }   
}