<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'subcategory_id',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

    public function cat(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcat(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }
}
