<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerRegionVb extends Model
{
    protected $fillable = ['dealer_id', 'office_id', 'office_postcode', 'provider_id', 'region_id', 'primary_VB_id', 'secondary_VB_id'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function postcodeRegionVB(){
        return $this->belongsTo(PostcodeRegionVb::class);
    }

    //**This function is called from DealerController.php-store() once a new dealer added to the system
    public function addDealerRegionVB1($dealerID){
        //** Determine postcode of the dealer */
        $postcodeOfTheDealer = (Address
            ::where('entity_type', 'Dealer')
            ->where('entity_id', $dealerID)
            ->where('address_type', 1)
            ->first())
            ->postal_code;

        //** Take all 'PostcodeRegionVBs' table's rows whose 'postcode' is equal to postcode of the dealer that has been just added to the DB.
        //  Since PostcodeRegionVBs table includes data for all providers, more than one rows would be retrieved. */
        $postcodeRegionVBs = PostcodeRegionVb::where('postcode', $postcodeOfTheDealer)->get();

        //** Save the retrieved row(s) to the 'dealer_region_Vbs table' */
        foreach($postcodeRegionVBs as $postcodeRegionVB){
            $dealerRegionVB = new DealerRegionVb();

            $dealerRegionVB->dealer_id = $dealerID;
            $dealerRegionVB->dealer_postcode = $postcodeOfTheDealer;
            $dealerRegionVB->provider_id = $postcodeRegionVB->provider_id;
            $dealerRegionVB->region_id = $postcodeRegionVB->region_id;
            $dealerRegionVB->primary_VB_id = $postcodeRegionVB->primary_VB_id;
            $dealerRegionVB->secondary_VB_id = $postcodeRegionVB->secondary_VB_id;

            $dealerRegionVB->save();
        }
    }

    public function addDealerRegionVB($office){
        //** Determine postcode of office of the dealer */
        $postcodeOfTheOffice = (Address
            ::where('entity_type', 'Dealer')
            ->where('office_id', $office->id)
            ->first())
            ->postal_code;

        //** Take all 'PostcodeRegionVBs' table's rows whose 'postcode' is equal to postcode of the dealer that has been just added to the DB.
        //  Since PostcodeRegionVBs table includes data for all providers, more than one rows would be retrieved. */
        $postcodeRegionVBs = PostcodeRegionVb::where('postcode', $postcodeOfTheOffice)->get();

        //** Save the retrieved row(s) to the 'dealer_region_Vbs table' */
        foreach($postcodeRegionVBs as $postcodeRegionVB){
            $dealerRegionVB = new DealerRegionVb();

            $dealerRegionVB->dealer_id = $office->dealer_id;
            $dealerRegionVB->office_id = $office->id;
            $dealerRegionVB->office_postcode = $postcodeOfTheOffice;
            $dealerRegionVB->provider_id = $postcodeRegionVB->provider_id;
            $dealerRegionVB->region_id = $postcodeRegionVB->region_id;
            $dealerRegionVB->primary_VB_id = $postcodeRegionVB->primary_VB_id;
            $dealerRegionVB->secondary_VB_id = $postcodeRegionVB->secondary_VB_id;

            $dealerRegionVB->save();
        }
    }


    //**  This function is called from PostcodeRegionVbController.php-store() when a chance occur in excel file concerning any provider's postcode-primary/secondary VB
    public function updateDealerRegionVB(){

        //** Take all records from the dealer_region_VBs table and update the records according to the postcode_region_VBs which has been just updated. */
        $dealerRegionVBs = DealerRegionVb::all();
        foreach($dealerRegionVBs as $dealerRegionVB){
            //** Take all 'PostcodeRegionVBs' table's rows whose 'postcode' is equal to postcode of the dealer.
            //  Since PostcodeRegionVBs table includes data for all providers, more than one rows would be retrieved. */
            $postcodeRegionVBs = PostcodeRegionVb::where('postcode', $dealerRegionVB->dealer_postcode)->get();

            //** Save the retrieved row(s) to the 'dealer_region_Vbs table' */
            foreach($postcodeRegionVBs as $postcodeRegionVB){

                $dealerRegionVB->primary_VB_id = $postcodeRegionVB->primary_VB_id;
                $dealerRegionVB->secondary_VB_id = $postcodeRegionVB->secondary_VB_id;

                $dealerRegionVB->save();
            }
        }
    }

    //** This function is invoked "Address.php->updateOfficeAddressOfDealer()" when address of any dealer's main office is chanced... */
    public function updateSpecificDealerRegionVB($newPostcode, $dealerID){

        //** retrieve specific rows from the DealerRegionVB table according to $dealerID. More than one rows will come due to the providerS*/
        $dealerRegionVBs = DealerRegionVb::where('dealer_id', $dealerID)->get();
        foreach($dealerRegionVBs as $dealerRegionVB){
            //** Take all 'PostcodeRegionVBs' table's rows whose 'postcode' is equal to "new postcode ($newPostcode)" of the dealer.
            //  Since PostcodeRegionVBs table includes data for all providers, more than one rows would be retrieved. */
            $postcodeRegionVBs = PostcodeRegionVb::where('postcode', $newPostcode)->get();

            //** Save the retrieved row(s) to the 'dealer_region_Vbs table' */
            foreach($postcodeRegionVBs as $postcodeRegionVB){

                $dealerRegionVB->dealer_postcode = $newPostcode;
                $dealerRegionVB->region_id = $postcodeRegionVB->region_id;
                $dealerRegionVB->primary_VB_id = $postcodeRegionVB->primary_VB_id;
                $dealerRegionVB->secondary_VB_id = $postcodeRegionVB->secondary_VB_id;

                $dealerRegionVB->save();
            }
        }
    }
}
