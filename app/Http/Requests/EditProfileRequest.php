<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class EditProfileRequest extends SimpleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'password' => 'string|min:6|max:50',
            'avatar' => 'file|mimes:jpg|max:10240'
        ];
    }


}
