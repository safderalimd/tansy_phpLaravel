<?php

namespace App\Http\Modules\Admin\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordFormRequest extends Request
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
            'old_password'              => 'required',
            'new_password'              => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
