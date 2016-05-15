<?php

namespace App\Http\Modules\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class AdmissionFormRequest extends Request
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
            // header'
            'facility_entity_id' => 'required|integer',

            // student'
            'first_name' => 'string|max:30',
            'middle_name' => 'string|max:30',
            'last_name' => 'string|max:30',
            'date_of_birth' => 'string|max:30|date',
            'gender' => 'string|in:male,female',

            // contact'
            'email' => 'string|max:100|email',
            'home_phone' => 'string|max:100',
            'mobile_phone' => 'string|max:100',

            // adress'
            'adress1' => 'string|max:128',
            'adress2' => 'string|max:128',
            'city_id' => 'integer',
            'city_area' => 'string|max:100',
            'postal_code' => 'string|max:30',

            // student info'
            'admission_number' => 'string|max:128',
            'admission_date' => 'string|max:30|date',
            'class_entity_id' => 'integer',
            'class_group_entity_id' => 'integer',
            'roll_number' => 'string|max:45',
            'identification1' => 'string|max:100',
            'identification2' => 'string|max:100',
            'caste_id' => 'integer',
            'religion_id' => 'integer',
            'language_id' => 'integer',

            // parent'
            'relationship_type_id' => 'integer',
            'parent_gender' => 'string|in:male,female',
            'parent_first_name' => 'string|max:100',
            'parent_middle_name' => 'string|max:100',
            'parent_last_name' => 'string|max:100',
            'designation_id' => 'integer',
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
