<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'role' => $this->input('cargo'),
            'password' => $this->input('senha'),
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
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'cpf'         => ['required', 'string', 'max:255', 'unique:users,cpf'],
            'role'        => [
                                'required',
                                'string',
                                Rule ::in(['admin', 'funcionario'])
                             ],
            'password'    => ['required', 'string', 'max:255'],
            'city_id'     => ['required'],
            'logradouro'  => ['required'],
            'number'      => ['required'],
            'complemento' => ['required'],
            'bairro'      => ['required'],
            'cep'         => ['required']
        ];
    }
}
