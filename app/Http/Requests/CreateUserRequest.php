<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|email|unique:users,email',
		];
	}
	/**
	 * Get custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'firstname.required' => 'El nombre(s) es obligatorio',
			'lastname.required' => 'Los apellidos son obligatorio',
			'email.required' => 'El correo es obligatorio',
			'email.unique' => 'El correo ya existe'
		];
	}
}
