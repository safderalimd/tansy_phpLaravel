<?php

namespace App\Http\Modules\Organization\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Modules\Organization\Repositories\AccountClientRepository;

class AccountAgentFormRequest extends Request
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
            'facility_ids'           => 'required|integer',
            'organization_entity_id' => 'required|integer',
            'first_name'             => 'required|string',
            'middle_name'            => 'string',
            'last_name'              => 'string',
            'gender'                 => 'string|in:M,F',
            'date_of_birth'          => 'string|date',
            'email'                  => 'email',
            'work_phone'             => 'regex:/^\d{3,12}$/',
            'mobile_phone'           => 'required|regex:/^\d{3,12}$/',
            'address1'               => 'string|max:128',
            'address2'               => 'string|max:128',
            'city_area'              => 'string|max:100',
            'city_area_new'          => 'string|max:100',
            'city_id'                => 'required|integer',
            'postal_code'            => 'string|max:30',
            'login_name'             => 'not_at_symbol|string|max:128',
            'password'               => 'string|max:128',
        ];

        if (isset($this->login_active)) {
            $rules['view_default_facility_id'] = 'required|integer';
        }

        if (isset($this->document_type_id) && $this->document_type_id != 'none') {
            $rules['document_number'] = 'required';
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
