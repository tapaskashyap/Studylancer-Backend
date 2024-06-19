<?php

namespace App\Services\Twilio;

use App\Interfaces\VerifyInterface;
use App\Models\User;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Cache;

class Verify implements VerifyInterface
{
	private $client;
	private $verification_sid;

    public function __construct()
    {
        $this->twilio = new Client(config('twilio.account_sid'), config('twilio.auth_token'));
        $this->verification_sid = config('twilio.verification_sid');
    }

    public function send_otp($phone){
    	try{
	    	$verification = $this->twilio->verify->v2->services($this->verification_sid)
	                        ->verifications
	                        ->create($phone, "sms");
            Cache::put('phone:'.$phone, 'lock', 30);
            return $verification;
    	}
    	catch(TwilioException $e)
    	{
            return $e;
    	}
    }

    public function verify_otp($phone,$code){
        try{
            return $verification_check = $this->twilio->verify->v2->services($this->verification_sid)
                                  ->verificationChecks
                                  ->create([
                                    "to" => $phone,
                                    "code" => $code
                                    ]);
        }
        catch(TwilioException $e)
        {
            return $e;
        }
    }
}