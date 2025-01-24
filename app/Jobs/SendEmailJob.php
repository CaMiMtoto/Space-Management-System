<?php

namespace App\Jobs;

use App\Mail\GenericEmail;
use App\Models\EmailLink;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected string $subject;
    protected string $content;
    protected ?EmailLink $link;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $subject, string $content, ?EmailLink $link = null)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
        $this->link = $link;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new GenericEmail($this->subject, $this->content, $this->link);
        Mail::to($this->email)->send($email);
    }
}
