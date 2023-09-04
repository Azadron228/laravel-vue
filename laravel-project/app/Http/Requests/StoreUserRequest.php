<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required', 'string', 'max:255',
                // we can set additional password requirements below
                Password::min(8),
            ],
        ];
    }
}
