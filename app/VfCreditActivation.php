<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfCreditActivation extends Model
{
    protected $fillable = ['contract_id', 'AO_bundle_offering_code', 'group_change_group_id', 'objection' , 'additional_contract', 'customer_number', 'password', 'activation_with_hardware'];

    public static function store($request){


    }
}
