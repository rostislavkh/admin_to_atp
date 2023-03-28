<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CarBrand extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name'
    ];

    protected $allowedFilters = [
        'id',
        'name',
        'updated_at',
        'created_at'
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'updated_at',
        'created_at'
    ];
}
