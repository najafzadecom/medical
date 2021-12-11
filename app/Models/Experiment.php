<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Experiment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'type'
    ];

    protected static $logAttributes = ['name', 'type'];

    public function getTypeNameAttribute()
    {
        return config('app.experiment_type')[$this->type] ?? 'Seçilməyib';
    }

}
