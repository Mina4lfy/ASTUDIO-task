<?php

namespace App\Traits;

trait RequestAppendsUserId
{
    public function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge(['user_id' => $this->user()?->id]);
    }
}
