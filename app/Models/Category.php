<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'banner',
        'banner2',
        'created_by',
        'updated_by',
        'is_deleted',
        'is_frontend'
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id' );
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
