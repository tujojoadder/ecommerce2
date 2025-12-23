<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteLog extends Model
{
    use HasFactory;

    protected $fillable = ['table', 'row_id', 'deleted_by'];
}
