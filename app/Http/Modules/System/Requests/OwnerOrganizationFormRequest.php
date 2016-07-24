<?php

namespace App\Http\Modules\System\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class OwnerOrganizationFormRequest extends Request
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
            'organization_name'    => 'required',
            // 'address1'             => 'required',
            // 'address2'             => 'required',
            // 'city_area'            => 'required',
            'city_id'              => 'required|integer',
            'work_phone'           => 'regex:/^\d{3,12}$/',
            'mobile_phone'         => 'regex:/^\d{3,12}$/',
            'contact_first_name'   => 'required',
            // 'contact_last_name'    => 'required',
            // 'contact_email'        => 'required',
            'contact_work_phone'   => 'regex:/^\d{3,12}$/',
            'contact_mobile_phone' => 'regex:/^\d{3,12}$/',
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
