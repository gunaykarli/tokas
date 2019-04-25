<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    protected $fillable = ['customer_id', 'salutation', 'name', 'surname', 'company_name_1', 'company_name_2', 'street', 'house_number', 'PO_box', 'country', 'postal_code', 'city', 'contact_person', 'country_code', 'area_code', 'phone_number', 'medium_type', 'SMS_notification_NDC', 'SMS_notification_MSISDN'];
}
