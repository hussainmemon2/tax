<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'business_name' => $this->business_name ?: null,
            'registration_number' => $this->registration_number ?: null,
            'cnic' => $this->cnic ?: null,
        ]);
    }

    public function rules()
    {
        $clientId = $this->route('client')->id;

        return [

            'client_type' => ['required', Rule::in(['individual', 'business' , 'government' , 'other'])],
            'full_name'   => ['required', 'string', 'max:255'],

            'cnic' => [
                'required',
                'string',
                'max:50',
                Rule::unique('clients', 'cnic')->ignore($clientId),
            ],

            'business_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'registration_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('clients', 'registration_number')->ignore($clientId),
            ],

            'business_address' => ['nullable', 'string'],
            'business_registration_date' => ['nullable', 'date'],

            'sales_tax_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('clients', 'sales_tax_number')->ignore($clientId),
            ],

            'portal_registration_date' => ['nullable', 'date'],

            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'reference' => ['required', 'string', 'max:255'],
        ];
    }
}