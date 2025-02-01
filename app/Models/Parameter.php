<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'product_id',
        'tool_id',
        'name',
        'type',
        "min_value",
        "max_value",
        "unit",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
