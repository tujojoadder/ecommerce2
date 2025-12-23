<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareStatus extends Model
{
    use HasFactory;
    protected $flllable = ['api_key', 'invoice_id', 'package_id', 'admin_id'];
}
