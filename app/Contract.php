<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['contract_type', 'provider_id', 'customer_id', 'salesperson_id', 'office_id', 'dealer_id', 'VO_id', 'tariff_id', 'contract_start', 'status'];
}
