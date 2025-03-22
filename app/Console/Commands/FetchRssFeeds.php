<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RssFeed;
use App\Jobs\FetchRssFeedJob;
use App\Models\Admin\Notifications;
use App\Models\Post;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FetchRssFeeds extends Command
{
    protected $signature = 'rss:fetch';
    protected $description = 'Fetch RSS feeds and store posts';

    public function handle()
    {
        /* Despatch Feeds */
        $feeds = RssFeed::where('status', 'active')->get();
        FetchRssFeedJob::dispatch($feeds);
        try {
            // Delete Old Posts
            $days = Setting::where('name', 'keep_old_posts')->first();
            $dayCount = (int)($days->value ?? 15);
            
            $cutoffDate = Carbon::now()->subDays($dayCount);
            Post::where('publish_date', '<', $cutoffDate)->delete();
            
            // Delete Old Notifications
            $notificationDays = Setting::where('name', 'keep_old_notification')->first();
            $notificationDayCount = (int)($notificationDays->value ?? 8);
            
            $cutoffDate = Carbon::now()->subDays($notificationDayCount);
            Notifications::where('created_at', '<', $cutoffDate)->delete();
            
        } catch (\Exception $e) {
            Log::error('Error during deletion process: ' . $e->getMessage(), [
                'exception' => $e
            ]);
        }
        
        
    }
}
