<?php

namespace App\Interfaces;

Interface VerifyInterface
{
    public function send_otp($phone);

    public function verify_otp($phone,$code);
}
