<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'name',
    ];

    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }
}
