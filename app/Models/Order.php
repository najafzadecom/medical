<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'temperature',
        'sample_type',
        'order_number',
        'country_id',
        'package',
        'weight',
        'production_date',
        'expire_date',
        'release_date',
        'customer'
    ];

    public function country_name()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
