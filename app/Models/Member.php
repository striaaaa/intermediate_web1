<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
        'registration_date' => 'date',
        'verified_at' => 'datetime',
        'simpanan_pokok_paid' => 'boolean',
        'simpanan_pokok_paid_amount' => 'decimal:2',
    ];
}
