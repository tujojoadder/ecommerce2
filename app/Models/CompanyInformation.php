<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'company_type',
        'logo',
        'banner',
        'invoice_greetings',
        'invoice_header',
        'invoice_footer',
        'proprietor',
        'country',
        'address',
        'address_optional',
        'email',
        'phone',
        'city',
        'state',
        'post_code',
        'stock_warning',
        'currency_symbol',
        'sms_api_code',
        'sms_sender_id',
        'sms_provider',
        'sms_setting',
        'favicon',
    ];
}
