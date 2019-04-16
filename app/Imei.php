<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imei extends Model
{
    protected $fillable = ['contract_id', 'provider_id', 'IMEI', 'device', 'package', 'VO', 'status', 'user', 'salesperson_id', 'date', 'award_date'];
}
