<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DaltonMcCleery\LaravelQuickStart\Rules\ReCaptcha;

/**
 * Trait ValidationTrait
 * @package DaltonMcCleery\LaravelQuickStart\Traits
 */
trait ValidationTrait
{
    /**
     * Custom validation rules for the "Contact Us" form
     *
     * @param Request $request
     * @return array
     */
    public function validateContactUs(Request $request): array {
        $validationRules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:7,13',
            'email' => 'required|email:rfc|max:255',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ];

        return $this->validate($request, $validationRules, $this->errorMessages());
    }

    // -------------------------------------------------------------------------------------------------------------- //

    /**
     * Custom Error message display
     *
     * @return array
     */
    private function errorMessages(): array {
        return [
            'required' => 'The <span>:attribute</span> field is required',
            'email' => 'The <span>:attribute</span> field must be in email format',
            'string' => 'The <span>:attribute</span> field must be letters and numbers only',
            'alpha_num' => 'The <span>:attribute</span> field must be letters and numbers only with no spaces',
            'max' => 'The <span>:attribute</span> field must be a maximum of :max characters',
            'min' => 'The <span>:attribute</span> field must be a minimum of :min characters',
            'digits' => 'The <span>:attribute</span> field must have exactly :digits digits',
            'digits_between' => 'The <span>:attribute</span> field must be a minimum of :min and a maximum of :max digits',
            'present' => 'The <span>:attribute</span> field must be present',
            'numeric' => 'The <span>:attribute</span> field must have only numbers',
            'array' => 'The <span>:attribute</span> field must be a list of options selected',
            'date' => 'The <span>:attribute</span> field must be a valid date',
            'boolean' => 'The <span>:attribute</span> field must be either Yes or No',
            'integer' => 'The <span>:attribute</span> field must be numbers only',
            'in' => 'The <span>:attribute</span> field must be one of the following options: :values',
            'file' => 'The <span>:attribute</span> field must be a file',
            'exists' => 'The <span>:attribute</span> field does not exist or is not valid',
            'size' => 'The <span>:attribute</span> field must be exactly :size characters',
            'required_if' => 'The <span>:attribute</span> field is required'
        ];
    }
}
