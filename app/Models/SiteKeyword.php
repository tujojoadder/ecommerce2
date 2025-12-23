<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class SiteKeyword extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'keyword',
        'arabic',
        'bangla',
        'english',
        'hindi',
    ];

    /**
     * Get all the settings.
     */
    public static function getAllKeywords()
    {
        return Cache::rememberForever('site_keywords', function () {
            return self::all();
        });
    }
}
