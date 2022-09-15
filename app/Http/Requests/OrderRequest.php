<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'domain'         => 'required',
            'market'         => 'required',
            'customer_name'  => 'required|min:3',
            'customer_email' => 'required|email',
            'selectedItems'  => 'required|array|min:1',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'customer_name'  => 'name',
            'customer_email' => 'email',
        ];
    }
}
