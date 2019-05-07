<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    protected $fillable = ['customer_id', 'street', 'house_number', 'city', 'country', 'postal_code', 'country_code', 'area_code', 'phone_number', 'contact_person', 'email'];

    /**
     * Define the relations
     */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    /**
     * User defined functions
     */
    public static function store($customerID, $request){ // Execution forwarded from ContractController@forward

        $customerContact = new CustomerContact();

        $customerContact->customer_id = $customerID ;
        $customerContact->street = $request->mainCustomerStreet ;
        $customerContact->house_number = $request->mainCustomerHouseNumber ;
        $customerContact->city = $request->mainCustomerCity ;
        $customerContact->country = 'Germany' ;
        $customerContact->postal_code = $request->mainCustomerPostalCode ;
        $customerContact->country_code = 49 ;
        $customerContact->area_code = 0 ;
        $customerContact->phone_number = $request->mainCustomerTelephone ;
        $customerContact->contact_person = $request->mainCustomerContactPerson ;
        $customerContact->email = $request->mainCustomerEmail ;

        $customerContact->save();

    }
}


