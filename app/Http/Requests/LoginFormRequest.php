<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\MessageBag;

class LoginFormRequest extends Request
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
            'login'    => 'required',
            'password' => 'required',
        ];
    }

    public function addDBError()
    {
        $this->getValidatorInstance()->add('login', 'test');
    }
}