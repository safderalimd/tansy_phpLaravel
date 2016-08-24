<?php

namespace App\Http\Modules\School\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class EventsFormRequest extends Request
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
            'event_name'    => 'required|string|max:100',
            'event_type_id' => 'required|integer',
            'start_date'    => 'required',
            'end_date'      => 'required',
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
