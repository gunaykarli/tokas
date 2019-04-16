<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPaymentTool extends Model
{
    protected $fillable = ['customer_id', 'card_number', 'valid_to_month', 'valid_to_year', 'credit_institution', 'IBAN', 'BIC', 'account_number', 'bank_code', 'credit_Institution', 'account_owner', 'usage'];
}
