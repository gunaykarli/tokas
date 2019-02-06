<?php

namespace App\Http\Controllers;

use App\DealerRegionVb;
use App\PostcodeRegionVb;
use App\Provider;
use App\Region;
use App\Representative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PostcodeRegionVbController extends Controller
{
    /**
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Display a page for importing "PostcodeRegionVb" of a specific provider, from excel file */
    public function import(){

        $providers = Provider::all();
        return view('regions.postcodeRegionVBs.import', compact('providers'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request){

        //** Take all representative of selected provider from excel to array */
        if($request->hasFile('postcodeRegionVB')){
            $postcodeRegionVBInExcel = Excel::load($request->file('postcodeRegionVB')->getRealPath());
            $postcodeRegionVBsInArray = $postcodeRegionVBInExcel->toArray();

            //** Start saving postcode-Region-VBs who are not in the DB. Or, upgrade, if they are already in the DB.
            //  Establish an array called $postcodeRegionVB[] for each row in the Excel file */
            $postcodeRegionVB['provider_id'] = $request->providerID;
            foreach ($postcodeRegionVBsInArray as $key => $row) {
                //** Establish $postcodeRegionVB[] array in the loop for each row in the excel file...

                //** Set  $postcodeRegionVB['region_id']*/
                $postcodeRegionVB['region_id'] = (Region::where('abbreviation', strtoupper($row['region']))
                    ->first())
                    ->id;

                //** Set  $postcodeRegionVB['primary_VB_id'] and $postcodeRegionVB['secondary_VB_id'] */

                // For $postcodeRegionVB['primary_VB_id'] and $postcodeRegionVB['secondary_VB_id'],
                // It must be check if a representative in the Excel file is already in the DB. If a provider has new representative he/she first must be added to the DB
                // Note: vb_primary_name is defined in Excel file as vb-primary-name using - not _ */
                if(!((Representative::where('name', ucfirst($row['vb_primary_name']))->where('surname', ucfirst($row['vb_primary_surname'])))->first())){
                    $representative = new Representative();
                    $representative->name = ucfirst($row['vb_primary_name']);
                    $representative->surname = ucfirst($row['vb_primary_surname']);
                    $representative->provider_id = $request->providerID;
                    $representative->region_id = $postcodeRegionVB['region_id'];
                    //** phone and mail does not exist it the Excel file so an warnning message should be giving to the user to upgrade the current representative */

                    $representative->save();
                }
                //** take "id" of primary VB who has just saved to the DB */
                $postcodeRegionVB['primary_VB_id'] = (Representative::where('name', ucfirst($row['vb_primary_name']))
                    ->where('surname', ucfirst($row['vb_primary_surname'])))
                    ->first()
                    ->id;

                if(!((Representative::where('name', ucfirst($row['vb_secondary_name']))->where('surname', ucfirst($row['vb_secondary_surname'])))->first())){
                    $representative = new Representative();
                    $representative->name = ucfirst($row['vb_secondary_name']);
                    $representative->surname = ucfirst($row['vb_secondary_surname']);
                    $representative->provider_id = $request->providerID;
                    $representative->region_id = $postcodeRegionVB['region_id'];
                    //** phone and mail does not exist it the Excel file so an warnning message should be giving to the user to upgrade the current representative */

                    $representative->save();
                }

                //** take "id" of secondary VB who has just saved to the DB */
                $postcodeRegionVB['secondary_VB_id'] = (Representative::where('name', ucfirst($row['vb_secondary_name']))
                    ->where('surname', ucfirst($row['vb_secondary_surname'])))
                    ->first()
                    ->id;


                //** Set  $postcodeRegionVB['postcode']*/
                $postcodeRegionVB['postcode'] = $row['postcode'];

                //** Control, if postcode in the excel file is already in the DB. If it is not in the DB it means that the provider assign new representative to the new postcode area.
                //So save the current row in excel file to the DB */
                if(!(PostcodeRegionVb::where('postcode', $row['postcode'])->first())){
                    $postcodeRegionVBInDB = new PostcodeRegionVb();
                    $postcodeRegionVBInDB->postcode = $postcodeRegionVB['postcode'];
                    $postcodeRegionVBInDB->provider_id = $postcodeRegionVB['provider_id'];
                    $postcodeRegionVBInDB->region_id = $postcodeRegionVB['region_id'];
                    $postcodeRegionVBInDB->primary_VB_id = $postcodeRegionVB['primary_VB_id'];
                    $postcodeRegionVBInDB->secondary_VB_id = $postcodeRegionVB['secondary_VB_id'];

                    $postcodeRegionVBInDB->save();
                    continue;
                }

                //** Check if a postcodeRegionVB to be saved is already in the DB
                $postcodeRegionVBInDB = new PostcodeRegionVb();
                $postcodeRegionVBInDB
                    ->where('postcode', $postcodeRegionVB['postcode'])
                    ->where('provider_id', $postcodeRegionVB['provider_id'])
                    ->where('region_id', $postcodeRegionVB['region_id'])
                    ->where('primary_VB_id', $postcodeRegionVB['primary_VB_id'])
                    ->where('secondary_VB_id', $postcodeRegionVB['secondary_VB_id'])
                    ->first();

                //** if a postcodeRegionVB to be saved to the DB is NOT in the DB, the reason of the absence might be change of primary VB or secondary VB in the current postcode area.
                // So the row which includes the current postcode must be updated
                // !empty($postcodeRegionVBInDB) means it is not in the DB */
                if(!empty($postcodeRegionVBInDB)){

                    //** find the row which includes the current postcode */
                    $postcodeRegionVBInDB = $postcodeRegionVBInDB
                        ->where('postcode', $postcodeRegionVB['postcode'])
                        ->first();
                    //dd($postcodeRegionVBInDB->postcode);
                    //$postcodeRegionVBInDB->postcode = $postcodeRegionVB['postcode'];
                    $postcodeRegionVBInDB->provider_id = $postcodeRegionVB['provider_id'];
                    $postcodeRegionVBInDB->region_id = $postcodeRegionVB['region_id'];
                    $postcodeRegionVBInDB->primary_VB_id = $postcodeRegionVB['primary_VB_id'];
                    $postcodeRegionVBInDB->secondary_VB_id = $postcodeRegionVB['secondary_VB_id'];

                    $postcodeRegionVBInDB->save();
                }
            }
        }

        //** Update the dealer_region_VBs table according to the postcode_region_VBs table that has been just updated using above codes */
        $dealerRegionVB = new DealerRegionVb();
        $dealerRegionVB->updateDealerRegionVB();

        return back()->with('success', 'Insert Record successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostcodeRegionVb  $postcodeRegionVb
     * @return \Illuminate\Http\Response
     */
    public function show(PostcodeRegionVb $postcodeRegionVb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostcodeRegionVb  $postcodeRegionVb
     * @return \Illuminate\Http\Response
     */
    public function edit(PostcodeRegionVb $postcodeRegionVb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostcodeRegionVb  $postcodeRegionVb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostcodeRegionVb $postcodeRegionVb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostcodeRegionVb  $postcodeRegionVb
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostcodeRegionVb $postcodeRegionVb)
    {
        //
    }
}
