<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    //protected $guarded = [];
    protected $fillable = ['name', 'tariff_code', 'status', 'group_id', 'provider_id', 'network_id', 'made_by_toker', 'base_price', 'provision', 'valid_from', 'valid_to', 'is_limited'];

    /** Relationship setups according to the ER diagram */

    public function properties(){
        return $this->belongsToMany(Property::class)->withPivot('value');
    }

    public function regions(){
        return $this->belongsToMany(Region::class, 'tariff_region')->withPivot('provider_id')->withTimestamps();
        //** Eloquent will join the two related model names in alphabetical order. However, you are free to override this convention.
        // Normally the name of the pivot table is 'region_tariff'. We have overrided this convention
        // additionally provider_id is extra attribute of the pivot table.*/
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function dealers(){
        //** "ontop" is pivot table for many to many relationship between dealer and tariff
        //** In naming pivot table, Eloquent will join the two related model names  in alphabetical order . However, you are free to override this convention.
        // Normally the name of the pivot table is 'dealer_tariff'. We have overrided this convention by giving 'ontop'
        // additionally 'office_id', 'amount' are extra attributes of the pivot table.*/
        return $this->belongsToMany(Dealer::class, 'ontop')->withPivot('office_id', 'amount')->withTimestamps();
    }

    public function vodafoneTariff(){
        return $this->hasOne(VodafoneTariff::class);
    }

    public function tariffsHighlights(){
        return $this->hasMany(TariffsHighlight::class);
    }

    public function tariffsProvisions(){
        return $this->hasMany(TariffsProvision::class);
    }

    public function tariffsLimit(){
        return $this->hasMany(TariffsLimit::class);
    }

    public function tariffsGroup(){
        return $this->belongsTo(TariffsGroup::class);
    }

    public function network(){
        return $this->belongsTo(Network::class);
    }

    /** User Defined Functions */

    public function setBasicInfo($request){
        $this->name = $request->tariffName;
        $this->tariff_code = $request->tariffCode;
        $this->status = 1;
        $this->group_id = $request->groupID;
        $this->provider_id = $request->providerID;
        $this->network_id = $request->networkID;
        $this->base_price = 0; // base_price and provision will be entered in next step...
        $this->provision = 0;
        $this->valid_from = $request->tariffValidFrom;

        if($request->tariffValidToIndefinite == 'on')
            $this->valid_to = null;
        else
            $this->valid_to = $request->tariffValidTo;

        if ($request->madeByToker == 'on')
            $this->made_by_toker = 1;
        else
            $this->made_by_toker = 0;

        if ($request->isLimited == 'on')
            $this->is_limited = 1;
        else
            $this->is_limited = 0;

        $this->save();

        return $this;

    }

    public function setOnTop($request){

        //** Check if there is an on-top for the tariff to be created */
        if($request->ontop == 'on'){
            //** According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
            // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
            if($request->ontopDealerDependency == 1){ // give the on-top to all dealers and their offices
                $dealers = Dealer::all();
                foreach($dealers as $dealer)
                    foreach($dealer->offices as $office)
                        $this->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
            }
            else if($request->ontopDealerDependency == 2){ // to selected dealers and their offices
                $dealers = Dealer::all();
                foreach($dealers as $dealer)
                    if(array_key_exists($dealer->id, $request->ontopCheckboxOfDealers))
                        foreach($dealer->offices as $office)
                            $this->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
            }
            else if($request->ontopDealerDependency == 3){ // to dealers with certain categories and their offices
                $dealers = Dealer::all();
                foreach($dealers as $dealer)
                    // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                    if(array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories))// if the left condition is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                            foreach($dealer->offices as $office)
                                $this->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                /*
                 * the above is the shorter version
                foreach($dealers as $dealer)
                    for($i = 1; $i <= 5; $i++)// there are 5 categories
                        if(array_key_exists($i, $request->ontopCheckboxOfCategories))// if the current category is checked in GUI
                            if($request->ontopCheckboxOfCategories[$i] == 'on')
                                if($dealer->category_id == $i ) // if category_id of the current dealer in the foreach iteration is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                                    foreach($dealer->offices as $office)
                                        $this->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                */
            }
            else if($request->ontopDealerDependency == 4){ // to dealers in certain regions and their offices
                // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                $dealerRegionVbs = DealerRegionVb::where('provider_id', $request->providerID)->get();
                foreach($dealerRegionVbs as $dealerRegionVb)
                    if(array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions))
                        $this->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
            }
        }
    }
}