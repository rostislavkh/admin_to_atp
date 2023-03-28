<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = [
        'src_img',
        'first_name',
        'last_name',
        'birthday',
        'salary',
        'email'
    ];

    protected $allowedFilters = [
        'id',
        'first_name',
        'last_name',
        'birthday',
        'salary',
        'email',
        'updated_at',
        'created_at',
    ];

    protected $allowedSorts = [
        'id',
        'first_name',
        'last_name',
        'birthday',
        'salary',
        'email',
        'updated_at',
        'created_at',
    ];

    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    public function getSrc() {
        if ($this->attachment()->first()) {
            return $this->attachment()->first()->url();
        } else {
            return $this->src_img;
        }
    }
}
