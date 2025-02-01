<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMeasurment extends Model
{
    protected $fillable = [
        'description',
        'id_barcode',
        'id_employee',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barcode');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'id_employee');
    }

    public function parameterValues()
    {
        return $this->hasMany(ParameterValue::class, 'product_measurement_id');
    }
}
