<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountBillingAddressRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country_id'   => 'required|exists:countries,id',
            'company_name' => 'present',
            'street'       => 'required',
            'postal_code'  => 'required',
            'city'         => 'required',
            'vat_number'   => 'present',
        ];
    }


    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return ['country_id' => 'country'];
    }
}
