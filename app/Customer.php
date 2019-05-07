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

    /**
     * Define the relations
     */
    public function customerContact(){
        return $this->hasOne(CustomerContact::class);
    }

    public function customerPaymentTool(){
        return $this->hasOne(CustomerPaymentTool::class);
    }

    public function customerInvoice(){
        return$this->hasOne(CustomerInvoice::class);
    }

    public function contracts(){
        $this->hasMany(Contract::class);
    }


    /**
     * User defined functions
     */

    public static function store($request){ // Execution forwarded from ContractController@forward

        // Depending on the customerType, store the Private/SOHo or Business customer's data in the Customers table
        $customer = new Customer();

        if($request->customerType == 1 or $request->customerType == 3){ // Private/SOHo
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
        else if($request->customerType == 2){ // Business
            $customer->customer_type = $request->customerType;
            $customer->company_name = $request->companyName;
            $customer->contact_person = $request->companyContactPerson;
            $customer->company_registration_number = $request->companyRegistrationNumber;
            $customer->district_court = $request->companyDistrictCourt;
        }

        $customer->save();
    }
}
