<?php

namespace App\Jobs;

use App\Mail\SendMailUpdateQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailUpdateQuestionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $exam;
    protected $child;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $exam, $child)
    {
        $this->user = $user;
        $this->exam = $exam;
        $this->child = $child;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SendMailUpdateQuestion($this->user, $this->exam, $this->child));
    }
}
