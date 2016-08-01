<?php

namespace App\Http\Modules\Communication\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class InboxFormRequest extends Request
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
            'product_name'           => 'required|string|max:120',
            'product_type_entity_id' => 'required|integer',
            'facility_ids'           => 'required|integer',
            'unit_rate'              => 'required|numeric|min:0',
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
