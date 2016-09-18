<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ForgotPasswordFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login_field'          => 'required',
            'mobile_phone'         => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'The captcha field is required.',
            'g-recaptcha-response.captcha'  => 'Invalid captcha.',
        ];
    }
}
