<?php

namespace App\Http\Modules\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ExamScheduleRowsFormRequest extends Request
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
            'hidden_class_subject_ids' => 'required|string',
            'hidden_exam_entity_id' => 'required|integer',
            'exam_date' => 'required|date',
            'exam_start_time' => 'required|string|max:21',
            'exam_end_time' => 'required|string|max:21',
            'max_marks' => 'required|integer',
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
