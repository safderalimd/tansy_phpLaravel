<?php

namespace App\Http\Modules\CRM\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ClientVisitCreateFormRequest extends Request
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
            'campaign_entity_id'              => 'required|integer',

            'organization_entity_id'          => 'integer',
            'organization_name'               => 'string|max:100',
            'organization_address1'           => 'string|max:100',
            'organization_address2'           => 'string|max:100',
            'organization_city_id'            => 'integer',
            'organization_city_area'          => 'string|max:100',
            'organization_city_area_new'      => 'string|max:100',
            'organization_work_phone'         => 'regex:/^\d{3,12}$/',
            'organization_mobile_phone'       => 'regex:/^\d{3,12}$/',

            'facility_entity_id'              => 'integer',
            'facility_type_id'                => 'integer',
            'facility_name'                   => 'string|max:100',
            'facility_address1'               => 'string|max:100',
            'facility_address2'               => 'string|max:100',
            'facility_city'                   => 'string|max:100',
            'facility_city_id'                => 'integer',
            'facility_city_area'              => 'string|max:100',
            'facility_city_area_new'          => 'string|max:100',
            'facility_work_phone'             => 'regex:/^\d{3,12}$/',
            'facility_mobile_phone'           => 'regex:/^\d{3,12}$/',

            'contact_entity_id'               => 'integer',
            'organization_contact_frist_name' => 'string|max:100',
            'organization_contact_last_name'  => 'string|max:100',
            'contact_email'                   => 'string|max:100|email',
            'contact_phone_number'            => 'regex:/^\d{3,12}$/',
            'contact_mobile_number'           => 'regex:/^\d{3,12}$/',

            'agent_entity_id'                 => 'required|integer',
            'client_status_id'                => 'required|integer',
            'visit_date'                      => 'required|string|max:20|date',
            'next_visit_date'                 => 'string|max:20|date',
            'notes'                           => 'string',
        ];

        if ($this->has('facility_new')) {
            $rules['facility_type_id'] = 'required|' . $rules['facility_type_id'];
            $rules['facility_name'] = 'required|' . $rules['facility_name'];
        }

        if ($this->has('contact_new')) {
            $rules['organization_contact_frist_name'] = 'required|' . $rules['organization_contact_frist_name'];
            $rules['organization_contact_last_name'] = 'required|' . $rules['organization_contact_last_name'];
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
