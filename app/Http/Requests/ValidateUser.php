<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ValidateUser extends FormRequest
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
        $userId = Auth::id();
        return [
            'email' => [
                'required',
                'unique:users',
                Rule::unique('users')->ignore($userId),
                'email'
            ],
            'firstname' => 'string|min:3|nullable',
            'company' => 'string|min:3|nullable',
            'nip' => [
                'min:10', 'max:10',
                Rule::unique('users')->ignore($userId),
                'regex:/^[0-9]+$/', 'nullable'
            ],
            'lastname' => 'string|min:3|nullable',
            'password' => 'string|min:8|nullable',
            'phonenumber' => [
                'min:9',
                Rule::unique('users')->ignore($userId),
                'regex:/^[0-9]+$/'
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => "Pole e-mail jest wymagane."  ,
            'email.unique' => "Podany email jest już zajęty.",
            'email.email' => "Błędny format adresu e-mail.",
            'firstname.required' => 'Pole imię jest wymagane.',
            'firstname.min' => 'Imię musi zawierać minimum 3 znaki.',
            'lastname.required' => 'Pole nazwisko jest wymagane.',
            'lastname.min' => 'Nazwisko musi zawierać minimum 3 znaki.',
            'password.string' => "Hasło musi być ciągiem znaków.",
            'password.min' => "Hasło musi zawierać minimum 8 znaków.",
            'password.confirmed' => "Hasła muszą być jednakowe.",
            'phonenumber.min' => "Numer telefonu musi posiadać minimum 9 znaków.",
            'phonenumber.unique' => "Podany numer telefonu jest już zajęty.",
            'phonenumber.regex' => "Numer telefonu musi składać się z cyfr.",
            'nip.regex' => "NIP musi składać się z cyfr.",
            'nip.min' => "NIP mieć dokładnie 10 cyfr.",
            'nip.max' => "NIP mieć dokładnie 10 cyfr.",
            'company.name' => "Nazwa firmy musi mieć minimum 3 znaki",
        ];
    }
}
