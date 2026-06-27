<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRawEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;
    protected $toEmail;
    protected $toName;
    protected $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($content, $toEmail, $toName, $subject)
    {
        $this->content = $content;
        $this->toEmail = $toEmail;
        $this->toName = $toName;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->toEmail;
        $toName = $this->toName;
        $subject = $this->subject;

        Mail::raw($this->content, function ($message) use ($toEmail, $toName, $subject) {
            if ($toName) {
                $message->to($toEmail, $toName);
            } else {
                $message->to($toEmail);
            }
            $message->subject($subject);
        });
    }
}
