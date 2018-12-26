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

        //ÇALIŞMIYOR...
        return redirect()->home();
    }

    //add address of the Dealer with $dealerID sent from DealerCpntroller@store
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


        //ÇALIŞMIYOR...
        //return redirect()->home();
    }

    public function addOfficeAddressOfDealer ($officeID, $officeType, $dealerID, $request){

        $address = new Address();

        $address->entity_type = 'Dealer';
        $address->entity_id = $dealerID;
        $address->office_id = $officeID;
        $address->address_type = $officeType;
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

    public function updateOfficeAddressOfDealer ($address, $request){


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
