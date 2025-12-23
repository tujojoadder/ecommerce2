<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortcutMenu extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'address',
        'position',
        'icon',
        'bg_color',
        'text_color',
    ];
}
