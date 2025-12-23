<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfAccountSubcategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'chart_id',
        'name',
        'group_id',
    ];
}
