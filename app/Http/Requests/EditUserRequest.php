<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
class EditUserRequest extends SimpleRequest
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
        $id = Auth::check() ? Auth::user()->id : $request->id;

        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'string|min:6|max:50',
            'avatar' => 'file|mimes:jpg|max:10240'
        ];
    }


}
