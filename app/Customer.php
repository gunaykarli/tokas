<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['customer_type',
        'password', 'salutation', 'name', 'surname', 'birth_date', 'identity_type', 'identity_card_number',
        'contact_person',
        'company_name', 'company_registration_number', 'district_court'
    ];

    public static function store($request){

        $customer = new Customer();

        // Depending on the customerType, store the Private/SOHo or Business customer's data in the Customers table
        if($request->customerType == 1 or $request->customerType == 2){ // Private/SOHo
            $customer->customer_type = $request->customerType;
            $customer->password = $request->mainCustomerPassword;
            $customer->salutation = $request->mainCustomerSalutation;
            $customer->surname = $request->mainCustomerSurname;
            $customer->name = $request->mainCustomerName;
            $customer->contact_person = $request->mainCustomerContactPerson;
            $customer->birth_date = $request->mainCustomerBirthDate;
            $customer->identity_type = $request->mainCustomerIDCardType;
            $customer->identity_card_number = $request->mainCustomerIDNumber;
        }
        else if($request->customerType == 3){ // Business
            $customer->customer_type = $request->customerType;
            $customer->company_name = $request->companyName;
            $customer->contact_person = $request->companyContactPerson;
            $customer->company_registration_number = $request->companyRegistrationNumber;
            $customer->district_court = $request->companyDistrictCourt;
        }

        $customer->save();


}
}
