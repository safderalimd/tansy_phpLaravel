<?php

namespace App\Http\Modules\Product\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ProductFormRequest extends Request
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
            // 'activeRow'    => 'boolean',
            'product'     => 'required|string',
            'productType' => 'required|integer',
            'facilityID'  => 'required|integer',
            'unitRate'    => 'required|string',
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
