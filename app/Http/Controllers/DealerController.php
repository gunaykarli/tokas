<?php

namespace App\Http\Controllers;

use App\Address;
use App\BankAccount;
use App\Dealer;
use App\DealerRegionVb;
use App\DealersMemberCode;
use App\Office;
use App\User;
use Illuminate\Http\Request;

class DealerController extends Controller
{

    /**
     * DealerController constructor.
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {

        if (auth()->check()){
            if (auth()->user()->role_id == 1) {
                $dealers = Dealer::get();
                return view('dealers.list', compact('dealers'));
            }
            else{
                $dealers = Dealer::where('id', auth()->user()->dealer_id)->get();
                return view('dealers.list', compact('dealers'));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dealers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // add the dealer's attributes to the database
        $dealer = new Dealer();
        $dealer->name = $request->name;
        $dealer->type = $request->type;
        $dealer->category_id = $request->categoryID;
        $dealer->owner_name = $request->ownerName;
        $dealer->owner_surname = $request->ownerSurname;
        $dealer->owner_mobile = $request->ownerMobile;
        $dealer->owner_email = $request->ownerEmail;
        if ($request->status == 'on')
            $dealer->status = 'on';
        else
            $dealer->status = 'off';

        $dealer->save();



       //** To add address, member code, bank account, admin and dealerRegionVB info of  the dealer which has been just added to the database in previous step,
       // take ID of the dealer and transfer it to addAddressDealer(), addMemberCodeOfDealer(), addBankAccountOfDealer() and addAdminOfDealer() */
       $name = $request->name;
       $dealer->where('name', $name)->get();
       //$address = new Address();
       //$address->addAddressOfDealer($dealer->id, request());

       $office = new Office();
       $office->addMainOfficeOfDealer($dealer->id, request());

       $dealersMemberCode = new DealersMemberCode();
       $dealersMemberCode->addMemberCodeOfDealer($dealer->id, request());

       $bankAccount = new BankAccount();
       $bankAccount->addBankAccountOfDealer($dealer->id, request());

       $user = new User();
       $user->addAdminOfDealer($dealer->id, request());

       $dealerRegionVB = new DealerRegionVb();
       $dealerRegionVB->addDealerRegionVB($dealer->id);


       return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function view(Dealer $dealer)
    {
        // Dealer's main office address, member codes, bank account and admin info have to be sent to dealers.view

        // The row in addresses table of the database which belongs to the dealer's mail office  is determined.
        $mainOffice = new Office();
        $mainOffice = $dealer->offices()->where('office_type', '=', '1')->first();

        // The row in addresses table of the database which belongs to the dealer's mail office  is determined.
        $mainOfficeAddress = new Address();
        $mainOfficeAddress = $dealer->address()->where('entity_type', '=', 'Dealer')->where('address_type', '=', '1')->first();

        // The row in dealers_member_codes table of the database which belongs to the dealer  is determined.
        $memberCodes = new DealersMemberCode();
        $memberCodes = $dealer->dealersMemberCode()->first();

        // The row in bank_accounts table of the database which belongs to the dealer  is determined.
        $bankAccount = new BankAccount();
        $bankAccount = $dealer->bankAccount()->where('entity_type', '=', 'Dealer')->first();

        // The row in users table of the database which belongs to the dealer's admin  is determined.
        $adminAccount = new User();
        $adminAccount = $dealer->user()->where('role_id', '=', 4)->first();


        return view('dealers.view', compact('dealer', 'mainOffice', 'mainOfficeAddress', 'memberCodes', 'bankAccount', 'adminAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer)
    {
        // Dealer's main office info, main office address, member codes, bank account and admin info have to be sent to dealers.edit

        // The row in addresses table of the database which belongs to the dealer's mail office  is determined.
        $mainOffice = new Office();
        $mainOffice = $dealer->offices()->where('office_type', '=', '1')->first();

        // The row in addresses table of the database which belongs to the dealer's mail office  is determined.
        $mainOfficeAddress = new Address();
        $mainOfficeAddress = $dealer->address()->where('entity_type', '=', 'Dealer')->where('address_type', '=', '1')->first();

        // The row in dealers_member_codes table of the database which belongs to the dealer  is determined.
        $memberCodes = new DealersMemberCode();
        $memberCodes = $dealer->dealersMemberCode()->first();

        // The row in bank_accounts table of the database which belongs to the dealer  is determined.
        $bankAccount = new BankAccount();
        $bankAccount = $dealer->bankAccount()->where('entity_type', '=', 'Dealer')->first();

        // The row in users table of the database which belongs to the dealer's admin  is determined.
        $adminAccount = new User();
        $adminAccount = $dealer->user()->where('role_id', '=', 4)->first();


        return view('dealers.edit', compact('dealer', 'mainOffice', 'mainOfficeAddress', 'memberCodes', 'bankAccount', 'adminAccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dealer $dealer)
    {
        // update the dealer's attribute in the Dealer table of the database
        $dealer->name = $request->name;
        $dealer->type = $request->type;
        $dealer->category_id = $request->categoryID;
        $dealer->owner_name = $request->ownerName;
        $dealer->owner_surname = $request->ownerSurname;
        $dealer->owner_mobile = $request->ownerMobile;
        $dealer->owner_email = $request->ownerEmail;
        if ($request->status == 'on')
            $dealer->status = 'on';
        else
            $dealer->status = 'off';
        $dealer->save();



        // To upgrade main office, main office address, member code, bank account and admin of the dealer, following functions and the parameters are used.

        // In the office table in the database may includes many office. The office with "office_type" is 1 which indicates main office of the dealers must be selected.
        $office = $dealer->offices()->where('office_type', '=', 1)->first();
        $office->updateMainOfficeOfDealer($office, request());

        //the dealer's member code row which belongs to the dealer in the database is determined.
        $dealersMemberCode = $dealer->dealersMemberCode()->first();
        $dealersMemberCode->updateMemberCodeOfDealer($dealersMemberCode, request());

        //the dealer's bank account row which belongs to the dealer in the database is determined.
        $bankAccount = $dealer->bankAccount()->first();
        $bankAccount->updateBankAccountOfDealer($bankAccount, request());

        //the dealer's admin user row which belongs to the dealer in the database is determined. User is dealer's admin user if the "role_id" is 4
        $user = $dealer->user()->where('role_id', '=', 4)->first();
        $user->updateAdminOfDealer($user, request());

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
}
