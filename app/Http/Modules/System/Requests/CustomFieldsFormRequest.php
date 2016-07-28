<?php

namespace App\Http\Modules\System\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class CustomFieldsFormRequest extends Request
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
            'ui_label'          => 'required',
            'data_type_id'      => 'required|integer',
            'input_type_id'     => 'required|integer',
            'input_length'      => 'integer|max:50,min:1',
            'custom_field_list' => 'custom_field',
        ];

        if (isset($this->existing)) {
            $rules['primary_key_id'] = 'required|integer';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'custom_field' => 'Characters "|" and "$<>$" are not allowed.',
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
