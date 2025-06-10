<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'order_column',
        'due_date',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'date:d-m-Y',
        'status' => TaskStatus::class,
    ];

    protected function dueDate(): Attribute
    {
        return Attribute::get(
            fn($value) => $value ? Carbon::create($value)->format('d-m-Y') : null,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
