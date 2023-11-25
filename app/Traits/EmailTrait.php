<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait EmailTrait
{
    /**
     * @return void
     */
    public function sendEmail($to, $email)
    {
        Mail::to($to)->send($email);
    }
}
