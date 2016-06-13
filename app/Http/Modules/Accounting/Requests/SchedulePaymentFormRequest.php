<?php

namespace App\Http\Modules\Accounting\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class SchedulePaymentFormRequest extends Request
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
            'subject_entity_id' => 'required|integer',
            'product_entity_id' => 'required|integer',
            'frequency_id' => 'required|integer',
            'schedule_name' => 'required|string',
            'amount' => 'required|numeric',
            'start_date' => 'required|string|date',
            'end_date' => 'required|string|date',
            'due_date_days_value' => 'required|integer',
            'facility_ids' => 'required|integer',
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
