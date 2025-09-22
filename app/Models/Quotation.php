<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Quotation extends Model
{
    protected $table="quotations";
    protected $fillable = [
        'name',
        'company_name',
        'email',
        'mobile',
        'no_days',
        'pickup_date',
        'location',
        'equipments',
        'notes',
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'equipments'  => 'array',
    ];
}
