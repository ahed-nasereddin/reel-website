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

    public function getEquipmentsAttribute($value)
    {
        $decoded = is_string($value) ? json_decode($value, true) : $value;

        if (function_exists('request') && request()?->is('admin/*')) {
            return is_array($decoded)
                ? json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                : $decoded;
        }

        return $decoded;
    }
}
