<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $business_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($userDetail)
    {
        
        if($userDetail->user->supplier){
            $this->business_name = $userDetail->user->supplier->business_name;
        }
        if($userDetail->user->reseller){
            $this->business_name = $userDetail->user->reseller->business_name;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ceo@sharesell.com')->subject('Welcome to Sharesell')->view('mail.auth.welcome')->with([
            "business_name" => $this->business_name
        ]);
    }
}
