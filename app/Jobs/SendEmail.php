<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelloMail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        
        $email = new HelloMail();
        $email_data = $this->data;
        // send email with the template
        Mail::send('mail', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['user_name'])
                ->subject('Welcome to MyProject');
        });
    }
}
