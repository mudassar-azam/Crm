<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_number',
        'bank_branch_name',
        'IBAN',
        'bank_branch_code',
        'BIC_or_Swift_code',
        'bank_city_name',
        'sort_code',
        'bank_address',
        'country',
        'account_holder_name',
        'transferwise_id',
    ];
}
