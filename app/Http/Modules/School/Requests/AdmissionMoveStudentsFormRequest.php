<?php

namespace App\Http\Modules\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class AdmissionMoveStudentsFormRequest extends Request
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
            'move_to_class_entity_id'       => 'required|integer',
            'move_to_fiscal_year_entity_id' => 'required|integer',
            'admission_ids'                 => 'required|string',
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
