<?php

namespace App\Http\Modules\reports\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class FeeDueReportFormRequest extends Request
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
            'pk' => 'required|integer',
            'rt' => 'required|string',
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
