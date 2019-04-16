<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['customer_type', 'salutation', 'name', 'surname', 'birth_date', 'identity_type', 'identity_card_number', 'company_name_1', 'company_name_2', 'company_registration_number', 'district_court'];

}
