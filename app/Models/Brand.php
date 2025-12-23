<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

     protected $fillable = ['brand_name', 'image', 'created_by', 'updated_by'];

     public function products(){
        return $this->belongsTo(Product::class, 'brand_id', 'id');
     }
}
