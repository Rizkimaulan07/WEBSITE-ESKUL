<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $nama;
    public $expiry;

    public function __construct($otp, $nama = null, $expiry = 10)
    {
        $this->otp = $otp;
        $this->nama = $nama;
        $this->expiry = $expiry;
    }

    public function build()
    {
        return $this->subject('Kode OTP Reset Password - SIMSKUL')
                    ->markdown('mail.otp');
    }
}
