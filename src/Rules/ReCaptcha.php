<?php

namespace DaltonMcCleery\LaravelQuickStart\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class ReCaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') {
            // Bypass recaptcha
            return true;
        }

        $client   = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params' =>
                 [
                     'secret'   => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                     'response' => $value
                 ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        return $body->success;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ReCAPTCHA field is invalid.';
    }
}
