<?php

namespace App\Http\Modules\System\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class CustomFieldsUpdateFormRequest extends Request
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
        $rules = [
            'ui_label'      => 'required',
            'input_length'  => 'integer|max:50,min:1',
        ];

        if (isset($this->existing)) {
            $rules['primary_key_id'] = 'required|integer';
        }

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
