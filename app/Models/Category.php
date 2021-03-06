<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'name',
        'slug',
        'product',
        'web_priority',
        'app_priority',
        'parent',
        'ui',
    ];

    protected $casts = [
        'ui' => 'array'
    ];

    public function scopeParents($query)
    {
        return $query->where('parent', 0);
    }

    public function scopeChild($query)
    {
        return $query->where('parent', '<>', 0);
    }

    public function scopeChildren($query, $column = 'app_priority', $sort = 'asc')
    {
        return $query->with(['children' => function ($q) use ($column, $sort) {
            return $q->orderBy($column, $sort)->get();
        }]);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent', 'id')->with('children');
    }
}
