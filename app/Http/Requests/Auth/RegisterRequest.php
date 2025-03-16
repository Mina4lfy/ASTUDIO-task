<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * {@inheritDoc}
     */
    protected function prepareForValidation(): void
    {
        # Normalize email address.
        $this->merge(['email' => str()->normalizeEmail($this->email)]);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
            ],
            'password' => [
                'nullable',
                'min:8',
                'max:255',
                'confirmed',
            ],
        ];
    }
}
