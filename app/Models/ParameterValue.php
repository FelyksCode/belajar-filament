<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterValue extends Model
{
    protected $fillable = [
        'value',
        'parameter_id',
        'product_measurement_id',
    ];

    public function parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }

    public function productMeasurement()
    {
        return $this->belongsTo(ProductMeasurement::class, 'product_measurement_id');
    }
}
