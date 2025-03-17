<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\Request;
use App\Models\EAV\Attribute;
use App\Enum\AttributeType;

class AttributeRequest extends Request
{
    /**
     * Attribute from bound params.
     *
     * @var null|Attribute
     */
    protected null|Attribute $attribute;

    /**
     * {@inheritDoc}
     */
    public function prepareForValidation(): void
    {
        $this->attribute = $this->route('attribute');
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        $requiredOnCreate = $this->attribute ? 'nullable' : 'required';

        return [
            'name' => [
                $requiredOnCreate,
                'string',
                'max:255',
            ],
            'type' => [
                $requiredOnCreate,
                'string',
                'max:255',
                AttributeType::validationRule(),
            ],
            'entities' => [
                'nullable',
                'array',
                'min:1',
                'max:1', // @note: remove it when the multiple entities issue is fixed.
            ],
            'entities.*' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function messages(): array
    {
        return [
            'type.in' => AttributeType::validationMessages(),
        ];
    }
}
