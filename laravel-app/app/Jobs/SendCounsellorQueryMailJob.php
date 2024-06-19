<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CounsellorQueryMail;
use Mail;

class SendCounsellorQueryMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $emailTo;
    protected $text;
    protected $phone;
    /**
     * Create a new job instance.
     */
    public function __construct($params)
    {
        $this->name = $params['name'];
        $this->emailTo = $params['email'];
        $this->text = $params['text'];
        $this->phone = $params['phone'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new CounsellorQueryMail($this->name,$this->emailTo,$this->phone,$this->text);
        Mail::to($this->emailTo)
            ->cc('animesh.kuzur@outlook.com')
            ->send($email);
    }
}
