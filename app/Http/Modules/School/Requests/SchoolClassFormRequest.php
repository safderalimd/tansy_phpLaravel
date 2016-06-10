<?php

namespace App\Http\Modules\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class SchoolClassFormRequest extends Request
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
            'class_name'               => 'required|string|max:100',
            'class_group_entity_id'    => 'required|integer',
            'class_category_entity_id' => 'required|integer',
            'class_teacher_entity_id'  => 'required|integer',
            'reporting_order'          => 'required|integer',
            'facility_ids'             => 'required|integer',
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
