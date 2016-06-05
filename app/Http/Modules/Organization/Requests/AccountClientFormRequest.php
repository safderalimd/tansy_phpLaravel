<?php

namespace App\Http\Modules\Organization\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Modules\Organization\Repositories\AccountClientRepository;

class AccountClientFormRequest extends Request
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
        $identification = $this->getIdentification();
        $this->validateIdentification($identification);

        $rules = [
            'facility_ids'  => 'required|integer',
            'unique_key_id' => 'required|integer',
            'first_name'    => 'string',
            'middle_name'   => 'string',
            'last_name'     => 'string',
            'gender'        => 'string|in:M,F',
            'date_of_birth' => 'string|date',
            'email'         => 'email',
            'work_phone'    => 'regex:/^\d{3,12}$/',
            'mobile_phone'  => 'regex:/^\d{3,12}$/',
            'address1'      => 'string|max:128',
            'address2'      => 'string|max:128',
            'city_area'     => 'string|max:100',
            'city_area_new' => 'string|max:100',
            'city_id'       => 'integer',
            'postal_code'   => 'string|max:30',
        ];

        switch ($identification) {
            case 'first and last name':
                $rules['first_name'] = 'required|' . $rules['first_name'];
                $rules['last_name'] = 'required|' . $rules['last_name'];
                break;
            case 'name and date of birth ':
                $rules['first_name'] = 'required|' . $rules['first_name'];
                $rules['last_name'] = 'required|' . $rules['last_name'];
                $rules['date_of_birth'] = 'required|' . $rules['date_of_birth'];
                break;
            case 'mobile number':
                $rules['mobile_phone'] = 'required|' . $rules['mobile_phone'];
                break;
            case 'address line1':
                $rules['address1'] = 'required|' . $rules['address1'];
                break;
            case 'email':
                $rules['email'] = 'required|' . $rules['email'];
                break;
            default:
                break;
        }

        return $rules;
    }

    public function getIdentification()
    {
        $repository = new AccountClientRepository;
        $identification = $repository->getIdentification($this->input('unique_key_id'));

        if (isset($identification[0]['unique_key'])) {
            $identification = trim($identification[0]['unique_key']);
            return strtolower($identification);
        }

        return null;
    }

    public function validateIdentification($identification)
    {
        $valid = [
            'first and last name',
            'name and date of birth',
            'mobile number',
            'address line1',
            'email',
        ];

        if (!in_array($identification, $valid)) {
            throw new \Exception("Invalid identification.");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
