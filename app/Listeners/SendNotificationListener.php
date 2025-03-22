<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Services\SendNotification as FirebaseService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotificationListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Handle the event.
     */
    public function handle(SendNotification $event): void
    {
        if (!is_string($event->fcmIds)) {
            foreach ($event->fcmIds as $fcmId) {
                $this->firebaseService->sendPostNotification(
                    [$fcmId],
                    $event->title,
                    $event->description,
                    $event->slug,
                    $event->image ?? ""
                );
            }
        }
    }
}
