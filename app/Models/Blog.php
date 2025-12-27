<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'slug',
        'description',
        'category_id',
        'tags',
        'post_author',
        'posted_by',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tags' => 'array',
    ];

    public function category(){
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_published', 0);
    }
}