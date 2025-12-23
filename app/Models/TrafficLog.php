<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address', 'request_size', 'response_size', 'total_traffic', 'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeBandwidthUsageLastMonth($query)
    {
        $totalTrafficBytes = $query->whereBetween('created_at', [now()->subDays(30), now()])->sum('total_traffic');
        $totalTrafficMB = $totalTrafficBytes / 1048576;
        return $totalTrafficMB;
    }
    public function scopeBandwidthUsageToday($query)
    {
        $totalTrafficBytes = $query->whereDate('created_at', today())->sum('total_traffic');
        $totalTrafficMB = $totalTrafficBytes / 1048576;
        return $totalTrafficMB;
    }
}
