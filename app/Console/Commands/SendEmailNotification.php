<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailNotifyJob;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class SendEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now()->format('H:i');
        $notifications = Notification::where('notification_time', $now)->get();

        foreach ($notifications as $notification) {
            SendEmailNotifyJob::dispatch($notification);
        }
    }
}
