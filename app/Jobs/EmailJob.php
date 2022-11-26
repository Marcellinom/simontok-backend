<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class EmailJob implements ShouldQueue
{
    use InteractsWithQueue, Dispatchable, SerializesModels;

    private string $email;
    private Mailable $build;

    /**
     * @param string $email
     * @param Mailable $build
     */
    public function __construct(string $email, Mailable $build)
    {
        $this->email = $email;
        $this->build = $build;
    }

    public function handle()
    {
        Mail::to($this->email)->send($this->build);
    }
}
