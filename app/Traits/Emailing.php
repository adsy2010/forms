<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 02/05/2019
 * Time: 22:31
 */

namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Mail;

trait Emailing
{
    public function send(User $user, $message, $cc = null, $bcc = null)
    {
        Mail::to($user->email)
            ->cc($cc)
            ->bcc($bcc)
            ->send($message);
    }

}