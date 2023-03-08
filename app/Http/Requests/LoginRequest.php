<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Log;
class LoginRequest extends SimpleRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(Request $request): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50',
        ];
    }


}
