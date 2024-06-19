<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class PhoneNumberLookup implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    private $client;

    public function __construct()
    {
        $this->client = new Client(config('twilio.account_sid'), config('twilio.auth_token'));
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('The :attribute must not be empty.');
        }
        try {
            $this->client
                ->lookups
                ->v2
                ->phoneNumbers($value)
                ->fetch();
        } 
        catch (TwilioException $e) {
            $fail('The :attribute must be a valid number.');
        }
    }
}
