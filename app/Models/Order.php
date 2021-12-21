<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'number',
        'date',
        'temperature',
        'sample_type',
        'order_number',
        'country_id',
        'package_id',
        'weight',
        'production_date',
        'expire_date',
        'release_date',
        'customer',
        'status',
        'created_by',
        'updated_by',
        'experiments',
        'result'
    ];

    protected $casts = [
        'experiments'    => 'array'
    ];

    protected static $logAttributes = [
        'number',
        'date',
        'temperature',
        'sample_type',
        'order_number',
        'country_id',
        'package_id',
        'weight',
        'production_date',
        'expire_date',
        'release_date',
        'customer',
        'status',
        'created_by',
        'updated_by',
        'experiments'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
