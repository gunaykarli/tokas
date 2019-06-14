<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceAddress extends Model
{
    protected $fillable = ['customer_id', 'salutation', 'name', 'surname', 'company_name_1', 'street', 'house_number', 'PO_box', 'country', 'postal_code', 'city', 'contact_person', 'country_code', 'area_code', 'phone_number', 'medium_type', 'SMS_notification_NDC', 'SMS_notification_MSISDN'];

    /** Define the relations */

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    /** User Defined Functions */

    public static function store($differenInvoiceAddress, $customerID, $request){
        $customerInvoiceAddress = new CustomerInvoiceAddress();
        $customerInvoiceAddress->customer_id = $customerID;

        $customerContact = CustomerContact
            ::where('customer_id', $customerID)
            ->first();

        $customer = Customer
            ::where('id', $customerID)
            ->first();

        if($differenInvoiceAddress == 1){
            if($request->differentInvoiceAddressSalutation == 1 or $request->differentInvoiceAddressSalutation == 2){ // sir or madam

                $customerInvoiceAddress->salutation = $request->differentInvoiceAddressSalutation;
                $customerInvoiceAddress->name = $request->differentInvoiceAddressName;
                $customerInvoiceAddress->surname = $request->differentInvoiceAddressSurname;
                $customerInvoiceAddress->contact_person = $request->differentInvoiceAddressContactPerson;
                $customerInvoiceAddress->street = $request->differentInvoiceAddressStreet;
                $customerInvoiceAddress->house_number = $request->differentInvoiceAddressHouseNumber;
                $customerInvoiceAddress->postal_code = $request->differentInvoiceAddressPostalCode;
                $customerInvoiceAddress->city = $request->differentInvoiceAddressCity;
            }
            else if($request->differentInvoiceAddressSalutation == 3){ // Firma
                $customerInvoiceAddress->salutation = $request->differentInvoiceAddressSalutation;
                $customerInvoiceAddress->company_name_1 = $request->differentInvoiceAddressCompanyName;
                $customerInvoiceAddress->contact_person = $request->differentInvoiceAddressContactPerson;
                $customerInvoiceAddress->street = $request->differentInvoiceAddressStreet;
                $customerInvoiceAddress->house_number = $request->differentInvoiceAddressHouseNumber;
                $customerInvoiceAddress->postal_code = $request->differentInvoiceAddressPostalCode;
                $customerInvoiceAddress->city = $request->differentInvoiceAddressCity;
            }
        }
        else if($differenInvoiceAddress == 0){ // copy from "CustomerContact" table

            if($customer->customer_type == 1 or $customer->customer_type == 2){ // private or SoHo
                $customerInvoiceAddress->salutation = $customer->salutation;
                $customerInvoiceAddress->name =  $customer->name;
                $customerInvoiceAddress->surname =  $customer->surname;
                $customerInvoiceAddress->contact_person =  $customer->contact_person;
                $customerInvoiceAddress->street = $customer->customerContact->street;
                $customerInvoiceAddress->house_number = $customer->customerContact->house_number;
                $customerInvoiceAddress->postal_code = $customer->customerContact->postal_code;
                $customerInvoiceAddress->city = $customer->customerContact->city;
            }
            else if($customer->customer_type == 3){ // business
                $customerInvoiceAddress->salutation = 3; // Firma
                $customerInvoiceAddress->company_name_1 = $customer->company_name;
                $customerInvoiceAddress->contact_person =  $customer->contact_person;
                $customerInvoiceAddress->street = $customer->customerContact->street;
                $customerInvoiceAddress->house_number = $customer->customerContact->house_number;
                $customerInvoiceAddress->postal_code = $customer->customerContact->postal_code;
                $customerInvoiceAddress->city = $customer->customerContact->city;
            }

        }

        // set medium_type. paper invoice-1, online invoice-2
        $customerInvoiceAddress->medium_type = $request->invoiceType;
        if($request->invoiceType = 2){
            $customerContact->email = $request->onlineInvoiceEmail;
            $customerContact->save();
        }
        $customerInvoiceAddress->save();
    }
}
