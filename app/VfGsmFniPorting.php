<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfGsmFniPorting extends Model
{
    protected $fillable = ['VF_gsm_id', 'provider_id', 'porting_date', 'analogue_conn_number',
        'digital_conn_number', 'name_1', 'surname_1', 'name_2', 'surname_2', 'name_3', 'surname_3',
        'name_4', 'surname_4', 'same_customer_contact_address',
        'area_code', 'main_phone_number', 'next_number_1', 'next_number_2', 'next_number_3',
        'next_number_4', 'next_number_5', 'next_number_6', 'next_number_7', 'next_number_8',
        'next_number_9', 'porting_all_numbers'];
}
