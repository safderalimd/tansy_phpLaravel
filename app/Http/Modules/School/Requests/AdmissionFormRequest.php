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

            // student
            'student_first_name' => 'required|string|max:30',
            'student_middle_name' => 'string|max:30',
            'student_last_name' => 'required|string|max:30',
            'student_date_of_birth' => 'required|string|max:30|date',
            'student_gender' => 'required|string|in:M,F',

            // contact'
            'email' => 'string|max:100|email',
            'home_phone' => 'string|max:100',
            'mobile_phone' => 'string|max:100',

            // adress'
            'address1' => 'required|string|max:128',
            'address2' => 'string|max:128',
            'city_name' => 'required|string|max:128',
            'city_area' => 'string|max:100',
            'postal_code' => 'string|max:30',

            // student info'
            'admission_number' => 'required|string|max:128',
            'admission_date' => 'required|string|max:30|date',
            'admitted_to_class_group_entity_id' => 'required|integer',
            'admitted_to_class_entity_id' => 'integer',
            'student_roll_number' => 'string|max:45',
            'identification1' => 'required|string|max:100',
            'identification2' => 'string|max:100',
            'caste_name' => 'string|max:128',
            'religion_name' => 'string|max:100',
            'mother_language_name' => 'string|max:100',

            // parent'
            'parent_relationship_type_id' => 'required|integer',
            'parent_gender' => 'required|string|in:M,F',
            'parent_first_name' => 'required|string|max:100',
            'parent_middle_name' => 'string|max:100',
            'parent_last_name' => 'required|string|max:100',
            'parent_designation_name' => 'string|max:100',
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
