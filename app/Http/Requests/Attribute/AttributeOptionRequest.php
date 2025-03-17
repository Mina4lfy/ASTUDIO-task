<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\Request;

class AttributeOptionRequest extends Request
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'max:255',
            ],
        ];
    }
}
