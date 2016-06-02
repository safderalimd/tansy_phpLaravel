<?php

namespace App\Http\Modules\CRM\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ClientVisitEditFormRequest extends Request
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
            'organization_entity_id' => 'required|integer',
            'facility_entity_id'     => 'required|integer',

            'campaign_entity_id'     => 'required|integer',
            'contact_entity_id'      => 'required|integer',

            'client_status_id'       => 'required|integer',
            'agent_entity_id'        => 'required|integer',
            'notes'                  => 'string',
            'visit_date'             => 'required|string|max:20|date',
            'next_visit_date'        => 'required|string|max:20|date',
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
