<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'email' => [
                'required',
                'email:rfc,dns',
                'exists:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ];
    }
}
