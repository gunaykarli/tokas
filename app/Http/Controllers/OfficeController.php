<?php

namespace App\Http\Controllers;

use App\Address;
use App\Dealer;
use App\Office;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;


class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Dealer $dealer)
    {
        $offices = Office:: where ('dealer_id', $dealer->id)->get();
        //$address = Address::where ('dealer_id', $dealer->id)->get();
        return view('dealers.offices.list', compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dealer $dealer)
    {
        return view('dealers.offices.create', compact('dealer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $office = new Office();
        $office->dealer_id = $request->dealerID;
        $office->name = $request->officeName;
        $office->office_type = 2; // 1 indicates the dealer's "Main Office". 2 for "suboffice".
        $office->contact_person_id = $request->contactPersonID;
        $office->status = 'on';
        $office->phone = $request->phone;
        $office->save();


        $name = $request->officeName;
        $office->where('name', $name)->first();
        // add address of newly created dealer's office address
        $address = new Address();
        $address->addOfficeAddressOfDealer($office->id, $office->office_type, $request->dealerID, request());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        return view('dealers.offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {


        // Main and sub office set up...
        // If a suboffice is attempted to change to main office;
        // office_type in offices table and address_type in addresses table must be altered from 2 to 1
        // 1 indicates the dealer's "Main Office". 2 for "suboffice".
        if (($office->office_type == 2) && ($request->officeType == 1)){
            // find related current main office and change it to suboffice
            $mainOffice = Office::where('dealer_id', $office->dealer_id)->where('office_type', 1)->first();
            $mainOffice->office_type = 2;
            $mainOffice->save();

            // find related current main office's address in the address table and and change its 'address_type' value from 1 to 2
            $address = Address::where('entity_id', $office->dealer_id)->where('address_type', 1)->first();
            $address->address_type = 2;
            $address->save();
            // and address_type of the office to be updated from 2 to 1
            // It is achieved in  ($address->address_type = $request->officeType;) updateOfficeAddressOfDealer() in address.php

            // setup new main office
            $office->office_type = 1;
        }
        else if (($office->office_type == 1) && ($request->officeTpye == 2)){
            \UxWeb\SweetAlert\SweetAlert::swap('Main Office can not be altered to suboffice!');
            //return redirect()->back()->with('alert', 'Main Office can not be change!');
        }

        // Main Office can not be inactivated
        if ($request->officeType == 1){
            \UxWeb\SweetAlert\SweetAlert::success('Main Office can not be inactivated!');
        }
        else{
            if ($request->status == 'on')
                $office->status = $request->status;
            else
                $office->status = 'off';
        }


        $office->name = $request->officeName;
        $office->contact_person_id = $request->contactPersonID;
        $office->phone = $request->phone;
        $office->save();
        //SweetAlert::swap('this is success alert');

        //$address = Address::where('office_id', $office->id)->where('entity_id', $office->deeler_id);

        $address = $office->address()->where('entity_type', '=', 'Dealer' )->first();
        $address->updateOfficeAddressOfDealer($address, request());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }
}
