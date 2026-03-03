<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

     protected function prepareForValidation()
    {
        // Normalize empty strings to null
        $this->merge([
            'business_name' => $this->business_name ?: null,
            'registration_number' => $this->registration_number ?: null,
            'cnic' => $this->cnic ?: null,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules()
    {
        return [

            // Always required
            'client_type' => ['required', Rule::in(['individual', 'business' , 'government' , 'other'])],
            'full_name'   => ['required', 'string', 'max:255'],

            // Individual Logic
            'cnic' => [
                'required',
                'string',
                'max:50',
                'unique:clients,cnic',
            ],

            // Business Logic
            'business_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'registration_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:clients,registration_number',
            ],

            'business_address' => ['nullable', 'string'],
            'business_registration_date' => ['nullable', 'date'],

            'sales_tax_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:clients,sales_tax_number',
            ],

            'portal_registration_date' => ['nullable', 'date'],

            // Contact
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'reference' => ['required', 'string', 'max:255'],
        ];
    }
}
