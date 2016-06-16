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
        $rules = [
            'subject_entity_id' => 'required|integer',
            'product_entity_id' => 'required|integer',
            'frequency_id' => 'required|integer',
            'schedule_name' => 'required|string',
            'amount' => 'required|numeric',
            'start_date' => 'required|string|date',
            'end_date' => 'string|date',
            'due_date_days_value' => 'required|integer',
            'facility_ids' => 'required|integer',
        ];

        if (!$this->isOneTimeFrequency()) {
            $rules['end_date'] = 'required|' . $rules['end_date'];
        } else {
            $this['end_date'] = $this->input('start_date');
        }

        return $rules;
    }

    public function isOneTimeFrequency()
    {
        $frequency = $this->input('hidden_frequency_text');
        $frequency = trim($frequency);
        $frequency = strtolower($frequency);
        if ($frequency == 'onetime') {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
