<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = ['employee_id', 'office_id', 'dealer_id', 'product_type', 'product_id'];
}
