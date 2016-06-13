<?php

namespace App\Http\Modules\Organization\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class OrganizationFormRequest extends Request
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
            // header
            'organization_name' => 'required|string|max:128',
            'organization_type_id' => 'required|integer',

            // contact'
            'email' => 'string|max:100|email',
            'work_phone' => 'required|regex:/^\d{3,12}$/',
            'mobile_phone' => 'required|regex:/^\d{3,12}$/',

            // adress'
            'address1' => 'required|string|max:128',
            'address2' => 'string|max:128',
            'city_id' => 'required|integer',
            'city_area' => 'string|max:100',
            'city_area_new' => 'string|max:100',
            'postal_code' => 'string|max:30',
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
