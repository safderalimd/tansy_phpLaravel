<?php

namespace App\Http\Modules\loaddata\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class StudentDataFormRequest extends Request
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
            'facility_entity_id' => 'required|integer',
            'attachment' => 'required|excel_file',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'excel_file' => 'The attachment must be a file of type: xls, xlsx, csv, ods.',
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
