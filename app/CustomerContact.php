<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    protected $fillable = ['customer_id', 'street', 'house_number', 'city', 'country', 'postal_code', 'country_code', 'area_code', 'phone_number', 'contact_person', 'email'];
}
