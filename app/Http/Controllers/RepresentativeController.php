<?php

namespace App\Http\Controllers;

use App\Imports\RepresentativeImport;
use App\Provider;
use App\Region;
use App\Representative;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RepresentativeController extends Controller
{
    /**
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Display a page for importing "representatives" of a specific provider, from excel file */
    public function import(){

        $providers = Provider::all();
        return view('regions.representatives.import', compact('providers'));

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAsperProvider($providerID)
    {
        $representatives = Representative::where('provider_id', $providerID)->get();
        return view('regions.representatives.index', compact('representatives'));
    }

    public function indexAsperRegion($regionID)
    {
        $representatives = Representative::where('region_id', $regionID)->get();
        return view('regions.representatives.index', compact('representatives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store representatives who are not in the DB.
     * Upgrade, if they are already in the DB..
     * And, delete the representatives from the DB if they are not in the excel file.
     */
    public function store (Request $request){

        //** Take all representative of selected provider from excel to array */
        if($request->hasFile('representatives')){
            $representativesInExcel = Excel::load($request->file('representatives')->getRealPath());
            $representativesInArray = $representativesInExcel->toArray();

            //** Start saving representatives who are not in the DB. Or, upgrade, if they are already in the DB.  */
            $data['provider_id'] = $request->providerID;

            foreach ($representativesInArray as $key => $row) {
                    $data['name'] = ucfirst($row['name']);
                    $data['surname'] = ucfirst($row['surname']);
                    $data['region_id'] = (Region::where('abbreviation', strtoupper($row['abbreviation']))->first())->id;
                    $data['phone'] = $row['phone'];
                    $data['email'] = $row['email'];


                if(!empty($data)) {
                        //** Check if a representative to be saved to the DB is already in the DB
                        $representativeInDB = Representative::where('name', $data['name'])->where('surname', $data['surname'])->first();
                        if(empty($representativeInDB)){
                            DB::table('representatives')->insert($data);
                        }
                        else{
                            //** check if "region, phone number and mail" of the representative who is already in the DB, have been updated in Excel file.
                            // If so save it to the DB.
                            if($representativeInDB->region_id != $data['region_id']){
                                $representativeInDB->region_id = $data['region_id'];
                                $representativeInDB->save();
                            }
                            if($representativeInDB->phone != $data['phone']){
                                $representativeInDB->phone = $data['phone'];
                                $representativeInDB->save();
                            }
                            if($representativeInDB->email != $data['email']){
                                $representativeInDB->email = $data['email'];
                                $representativeInDB->save();
                            }
                        }
                }
            }

            //** Delete the representatives from the DB if they are not in the excel file.
            //  Take all representative for current provider from the DB*/
            $representativesInDB = Representative::where('provider_id', $request->providerID)->get();
            foreach($representativesInDB as $representativeInDB){
                $existInExcel = 0;
                foreach($representativesInArray as $key => $row){
                    if(($representativeInDB->name == $row['name']) && ($representativeInDB->surname == $row['surname'])){
                        $existInExcel = 1;
                        break;
                    }
                }
                //** If the representative in DB is not exist in the excel, then delete it. */
                if($existInExcel == 0){
                    $representativeInDB->delete();
                }
            }
        }

        return back()->with('success', 'Insert Record successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Representative  $represantative
     * @return \Illuminate\Http\Response
     */
    public function show(Representative $represantative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Representative  $represantative
     * @return \Illuminate\Http\Response
     */
    public function edit(Representative $representative)
    {
        $providers = Provider::all();
        return view('regions.representatives.edit', compact('representative', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Representative  $represantative
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Representative $representative)
    {
        //$representative->name = $request->name;
        //$representative->surname = $request->surname;
        $representative->phone = $request->phone;
        $representative->email = $request->email;

        $representative->save();

        $representatives = Representative::all();
        return view('regions.representatives.index', compact('representatives'))->with('success', 'Update Record successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Representative  $represantative
     * @return \Illuminate\Http\Response
     */
    public function destroy(Representative $represantative)
    {
        //
    }
}
