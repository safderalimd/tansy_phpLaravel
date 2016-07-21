<?php

namespace App\Http\Modules\Accounting\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class DailyExpenseFormRequest extends Request
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
            'expense_type_id'                 => 'required|integer',
            'supplier_organization_entity_id' => 'required|integer',
            'expense_date'                    => 'required|string',
            'payment_type_id'                 => 'required|integer',
            'amount'                          => 'required|numeric',
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
