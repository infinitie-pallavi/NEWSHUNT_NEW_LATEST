<?php

namespace App\Jobs;

use App\Events\SendNotification;
use App\Models\Admin\Notifications;
use App\Models\Post;
use App\Models\UserFcm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\RequestException;
use Carbon\Carbon;

class FetchRssFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rssFeeds;

    public function __construct(Collection $rssFeeds)
    {
        $this->rssFeeds = $rssFeeds;
    }
    public function handle()
    {
        foreach ($this->rssFeeds as $rssFeed) {
            try {
                $response = Http::get($rssFeed->feed_url);

                if ($response->successful()) {
                    $feedData = simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);
                    $namespaces = $feedData->getNamespaces(true);
                    foreach ($feedData->channel->item as $item) {
                        $title = strip_tags(trim((string) $item->title));
                        $slug = Str::slug($title);

                        if (!Post::where('title', $title)->orWhere('slug', $slug)->exists()) {
                            $description = strip_tags(trim((string) $item->description));
                            $link = (string) $item->link;
                            $pubDate = trim(strip_tags((string) $item->pubDate));
                            $imageUrl = $this->extractImageUrl($item, $namespaces);
                            $publishDate = Carbon::parse($item->pubDate);

                            DB::enableQueryLog();

                            DB::transaction(function () use ($rssFeed, $title, $slug, $link, $description, $pubDate, $publishDate, $imageUrl) {
                                Post::create([
                                    'channel_id' => $rssFeed->channel_id,
                                    'topic_id' => $rssFeed->topic_id,
                                    'title' => $title,
                                    'resource' => $link,
                                    'slug' => $slug,
                                    'image' => $imageUrl,
                                    'description' => $description,
                                    'status' => 'active',
                                    'pubdate' => $pubDate,
                                    'publish_date' => $publishDate,
                                ]);
                            });
                        }
                    }
                } else {
                    Log::error("Failed to fetch RSS feed: " . $rssFeed->feed_url);
                }
            } catch (RequestException $e) {
                Log::error("Error fetching RSS feed: " . $rssFeed->feed_url . " - " . $e->getMessage());
            } catch (\Throwable $e) {
                Log::error("Error processing RSS feed: " . $rssFeed->feed_url . " - " . $e->getMessage());
            }
        }
        $existPostSlugs = Notifications::select('slug')->pluck('slug')->toArray();
        $post = Post::select('id', 'title','description', 'image', 'slug')->whereNotIn('slug', $existPostSlugs)->orderBy('publish_date', 'desc')->first();

        $fcmIds = UserFcm::select('fcm_id')->get()->toArray();
        /* Call an event for send notification */
        event(new SendNotification($post->title,$post->description, $post->image, $post->slug, $fcmIds));
    }

    private function extractImageUrl($item, $namespaces)
    {
        // Check for thumbnail in namespaces
        foreach ($namespaces as $prefix => $namespace) {
            if (isset($item->children($namespace)->thumbnail)) {
                $data = (string) $item->children($namespace)->thumbnail->attributes()->url;
            }
        }

        // Check for enclosure URL
        if (isset($item->enclosure['url'])) {
            $data = (string) $item->enclosure['url'];
        }

        // Check for media:content URL
        if (isset($item->children('media', true)->content)) {
            foreach ($item->children('media', true)->content as $mediaContent) {
                if ((string) $mediaContent->attributes()->type === 'image/jpeg') {
                    $data = (string) $mediaContent->attributes()->url;
                }
            }
        }

        // Check for img tag in description
        if (isset($item->description)) {
            $matches = [];
            preg_match('/<img[^>]+src="([^">]+)"/', (string) $item->description, $matches);
            if (!empty($matches[1])) {
                return $matches[1];
            }
        }

        return $data ?? null;
    }
}
