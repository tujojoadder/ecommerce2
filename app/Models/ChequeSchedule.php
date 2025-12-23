<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'supplier_id',
        'bank_name',
        'cheque_no',
        'amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
