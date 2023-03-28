<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'number',
        'brand_id',
        'driver_id'
    ];

    protected $allowedFilters = [
        'id',
        'number',
        'brand_id',
        'driver_id',
        'updated_at',
        'created_at'
    ];

    protected $allowedSorts = [
        'id',
        'number',
        'brand_id',
        'driver_id',
        'updated_at',
        'created_at'
    ];

    public function setNumberAttribute(string $value): void
    {
        $this->attributes['number'] = strtoupper($value);
    }

    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
