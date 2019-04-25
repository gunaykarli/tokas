<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPaymentTool extends Model
{
    protected $fillable = ['customer_id', 'card_number', 'valid_to_month', 'valid_to_year', 'card_credit_institution', 'IBAN', 'BIC', 'account_number', 'bank_code', 'bank_credit_institution', 'account_owner', 'usage'];
}
