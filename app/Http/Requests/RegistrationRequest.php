<?php

namespace App\Http\Requests;


use Config;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
            'gender' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email field is Required',
            'first_name.required' => 'Firstname field is Required',
            'last_name.required' => 'Lastname field is Required',
            'phone.required' => 'Mobile No field is Required',
            'gender.required' => 'Gender is Required'

        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
