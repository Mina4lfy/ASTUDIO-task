<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelHasSearch;

abstract class BaseModel extends Model
{
    use ModelHasSearch;
}
