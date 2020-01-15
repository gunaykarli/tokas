<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['entity_type', 'entity_id', 'office_id', 'address_type', 'street_address', 'PO_box', 'postal_code', 'city', 'state', 'country'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    //add address of the Provider with $providerID sent from ProviderCpntroller@store
    public function addAddressOfProvider ($providerID, $request){

        $address = new Address();

        $address->entity_type = 'Provider';
        $address->entity_id = $providerID;
        $address->office_id = 0; // Since we store only main office, office_id is 0
        $address->address_type = 1; //1 for main office, 2 for suboffice.
        $address->street_address = $request->streetAddress;
        $address->PO_box = $request->POBox;
        $address->postal_code = $request->postalCode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();


        return redirect()->home();
    }

    //add address of the Dealer with $dealerID sent from DealerController@store
    public function addAddressOfDealer ($dealerID, $request){

        $address = new Address();

        $address->entity_type = 'Dealer';
        $address->entity_id = $dealerID;
        $address->street_address = $request->streetAddress;
        $address->PO_box = $request->POBox;
        $address->postal_code = $request->postalCode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();


        //return redirect()->home();
    }

    //** This function is called from OfficeController@store() OR office.php-addMainOfficeOfDealer() */
    public function addOfficeAddressOfDealer ($newOffice, $request){

        $address = new Address();
        $address->entity_type = 'Dealer';
        $address->entity_id = $newOffice->dealer_id;
        $address->office_id = $newOffice->id;
        $address->address_type = $newOffice->office_type;
        $address->street_address = $request->streetAddress;
        $address->PO_box = $request->POBox;
        $address->postal_code = $request->postalCode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();

        //** In DealerRegionVB table, Region and VBs must be setup for the office which has been just added to the DB,    */
        $dealerRegionVb = new DealerRegionVb();
        $dealerRegionVb->addDealerRegionVB($newOffice);

        //ÇALIŞMIYOR...
        //return redirect()->home();
    }

    public function updateOfficeAddressOfDealer ($address, $request){


        //** Before updating the address we should check if post code of the office is changed. If so, region setting must be done in "DealerRegionVBs" table
        if($address->postal_code != $request->postalCode){
            $newPostcode = $request->postalCode;
            $dealerID = $address->entity_id; // "entity_id" in addresses table stands for dealer or provider ids. In this case it shows dealer id.

            $dealerRegionVB = new DealerRegionVb();
            $dealerRegionVB->updateSpecificDealerRegionVB($newPostcode, $dealerID);
        }

        //$dealerID = $address->entity_id;
        //$newPostcode = $request->postalCode;

        $address->address_type = $address->office->office_type;
        $address->street_address = $request->streetAddress;
        $address->PO_box = $request->POBox;
        $address->postal_code = $request->postalCode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();


        //ÇALIŞMIYOR...
        //return redirect()->home();
    }

    public function updateAddressOfProvider ($address , $request){

        //$address = new Address();
        //$name=$request->name;
        //$provider = Provider::where('name', $name)->get();
        //$provider->where('name', $name)->get();
        //$address->where('entityID', $providerID)->get();

        //çalışmıyor*** $address = Address::where('name', $name)->get();
        //$address = new Address();
        //$address->where('provider_id', $providerID)->get();
        //$address = Address::find($addressID);

        //Since the address to be updated is sent by ProivderControler-update(), fields of the address are taken from the $request and updated...
        $address->street_address = $request->streetAddress;
        $address->PO_box = $request->POBox;
        $address->postal_code = $request->postalCode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();

        //ÇALIŞMIYOR...
        return redirect()->home();
    }

    public function updateAddressOfDealer ($address , $request){

        //Since the address to be updated is sent by DealerControler@update(), fields of the address are taken from the $request.
        $address->street_address = $request->streetAddress;
        $address->PO_box = $request->POBox;
        $address->postal_code = $request->postalCode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();

        //ÇALIŞMIYOR...
        return redirect()->home();
    }
}
