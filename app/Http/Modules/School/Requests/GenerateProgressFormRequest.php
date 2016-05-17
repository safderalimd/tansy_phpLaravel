<?php

namespace App\Http\Modules\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class GenerateProgressFormRequest extends Request
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
            'exam_entity_id' => 'integer',
            'class_entity_id' => 'integer',
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