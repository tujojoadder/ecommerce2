<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['client_id', 'project_name', 'created_by'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
