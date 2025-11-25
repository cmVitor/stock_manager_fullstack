<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mapear campos enviados pelo front
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->input('nome'),
            'phone' => $this->input('contato'),
            'email' => $this->input('email'),
            'city_id' => $this->input('cidade'),
            'number' => $this->input('numero'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:80', 'unique:suppliers,name'],
            'phone'       => ['required', 'string', 'max:25'],
            'email'       => ['required', 'string', 'email', 'max:80'],
            'city_id'     => ['required'],
            'logradouro'  => ['required'],
            'number'      => ['required'],
            'complemento' => ['required'],
            'bairro'      => ['required'],
            'cep'         => ['required']
        ];
    }
}