<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id', 'in_time', 'out_time', 'attendance', 'date', 'created_by'];

    protected $dates = ['created_at', 'updated_at'];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
