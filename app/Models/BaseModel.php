<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;

abstract class BaseModel extends Model
{
    use Searchable;
}
