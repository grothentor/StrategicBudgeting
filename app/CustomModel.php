<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomModel extends Model
{
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }
}