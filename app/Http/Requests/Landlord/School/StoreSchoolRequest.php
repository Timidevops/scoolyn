<?php

namespace App\Http\Requests\Landlord\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSchoolRequest extends FormRequest
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
            'schoolName' => ['required'],
            'schoolType' => ['required', Rule::in(['private', 'public'])],
            'schoolLocation' => ['required'],
            'contactNumber' => ['required'],
            'schoolEmail' => ['nullable'],
            'hasPayment' => ['required', Rule::in(['yes', 'no'])],
            'paymentCurrency' => ['nullable', Rule::in(['ngn'])],
            'domainName' => ['required', 'unique:scoolyn_tenants,domain'],
            'adminEmail' => ['required', 'email', 'unique:school_admins,email'],
            'adminPassword' => ['required','min:8','confirmed'],
        ];
    }
}
