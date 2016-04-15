<?php

namespace App\Http\Modules\Organizations\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class FiscalYearFormRequest extends Request
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
            'entityID' => 'integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'name' => 'required|string',
            'facilityIDs' => 'array',
            'currentFiscalYear' => 'boolean'
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