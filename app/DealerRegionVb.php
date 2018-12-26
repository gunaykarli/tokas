<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerRegionVb extends Model
{
    protected $fillable = ['dealer_id', 'dealer_postcode', 'provider_id', 'region_id', 'primary_VB_id', 'secondary_VB_id'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function postcodeRegionVB(){
        return $this->belongsTo(PostcodeRegionVb::class);
    }

    //**This function is called from DealerController.php-store() once a new dealer added to the system
    public function addDealerRegionVB($dealerID){
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

    //**This function is called from PostcodeRegionVbController.php-store() when a chance occur in excel file concerning any provider's postcode-primary/secondary VB
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

}
