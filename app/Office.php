<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;

class Office extends Model
{
    protected $fillable = ['name', 'dealer_id', 'office_type', 'contact_person_id',  'phone', 'status'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function address(){
        return $this->hasOne(Address::class, 'office_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'office_id');
    }

    public function dealerRegionsVBs(){
        return $this->hasMany(DealerRegionVb::class, 'office_id');
    }

    public function addMainOfficeOfDealer($dealerID, $request){

        $office = new Office();
        $office->dealer_id = $dealerID;
        $office->name = $request->officeName;
        $office->office_type = 1; // 1 indicates the dealer's "Main Office"


        /**Since admin user will be contact person of the office, $office->contact_person_id must be stored in addAdminOfDealer() function after creating and storing the admin.*/
        //$office->contact_person_id = $request->contactPersonName;

        $office->phone = $request->phone;
        if ($request->status == 'on')
            $office->status = 'on';
        else
            $office->status = 'off';

        $office->save();

        $address = new Address();
        $address->addOfficeAddressOfDealer($office, $request);
    }

    public function updateMainOfficeOfDealer($office, $request){

        $office->name = $request->officeName;
        $office->phone = $request->phone;

        //$office->office_type = 1; // office type is not  edited here...
        //$office->contact_person_name = $request->contactPersonName;
        //$office->contact_person_surname = $request->contactPersonSurname;
        //$office->email = $request->contactPersonEmail;
        //$office->mobile = $request->mobile;
        $office->save();


        // update address of newly updated dealer's office
        $address = $office->address()->where('entity_type', '=', 'Dealer' )->first();
        $address->updateOfficeAddressOfDealer($address, request());
    }
}
