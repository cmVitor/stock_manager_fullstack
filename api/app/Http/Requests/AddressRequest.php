<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logradouro'  => ['nullable', 'string', 'max:45'],
            'number'      => ['nullable', 'integer'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'city_id'     => ['required', 'integer', 'exists:cities,id'],
            'bairro'      => ['nullable', 'string', 'max:65'],
            'cep'         => ['nullable', 'string', 'size:8'], // CEP sem hífen
        ];
    }
}
