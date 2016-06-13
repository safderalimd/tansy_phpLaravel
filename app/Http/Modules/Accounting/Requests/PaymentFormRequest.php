<?php

namespace App\Http\Modules\Accounting\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class PaymentFormRequest extends Request
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
            'schEntID_dateID_schAmnt_PaidAmnt_list' => 'required',
            'credited_to_entity_id' => 'required',
            'total_paid_amount' => 'required',
            'new_balance' => 'required',
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
