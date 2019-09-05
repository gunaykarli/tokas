<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tariff extends Model
{
    //protected $guarded = [];
    protected $fillable = ['name', 'tariff_code', 'status', 'group_id', 'provider_id', 'network_id', 'made_by_toker', 'action_tariff', 'base_price', 'provision', 'valid_from', 'valid_to', 'is_limited'];

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
        return $this->belongsToMany(Dealer::class, 'ontop')->withPivot('office_id', 'ontop')->withTimestamps();
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
        return $this->hasOne(TariffsLimit::class);
    }

    public function tariffsGroup(){
        return $this->belongsTo(TariffsGroup::class);
    }

    public function network(){
        return $this->belongsTo(Network::class);
    }

    /** User Defined Functions */


    /**
     * forwarted from VodafoneTariffController@store */
    public function setBasicInfo($request){
        $this->name = $request->tariffName;
        $this->tariff_code = $request->tariffCode;

        // if the given tariffValidFrom is today then activate the status of the tariff immediately, otherwise CronJob will activate it on the given date
        $difference = Carbon::parse($request->tariffValidFrom)->diffInDays(Carbon::now());
        if($difference == 0){
            $this->status = 1;
        }
        else{
            /** set up using CronJob*/
            $this->status = 1;
        }

        $this->group_id = $request->groupID;
        $this->provider_id = $request->providerID;
        $this->network_id = $request->networkID;
        $this->base_price = 0; /** base_price and provision will be entered in next step...VEYA burada mı verilmeli SOR!*/
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

        if ($request->actionTariff == 'on')
            $this->action_tariff = 1;
        else
            $this->action_tariff = 0;

        // set limited amount of the tariff.
        // limit and remaining amount fields will be set up in setLimit@TariffLimit called form store@VodafoneTariffController
        if ($request->isLimitedAmount == 'on'){
            $this->is_limited = 1;
        }
        else{
            $this->is_limited = 0;
        }

        $this->save();

        return $this;
    }

    /** called from VodafoneTariffController@update */
    public function updateBasicInfo($tariff, $request){
        //echo $tariff->status;
        //dd ($request->tariffStatus);
        $tariff->name = $request->tariffName;
        $tariff->tariff_code = $request->tariffCode;

        /** begin: change status of the tariff */
        if($tariff->status == 1) // current status of the tariff is 1/on
            if($request->tariffStatus == 'on'){ // no change on current status. But valid_to may be changed. No need to change valid_from
                $tariff->status = 1;
                // update valid_to
                if($request->tariffValidToIndefinite == 'on')
                    $tariff->valid_to = null;
                else
                    $tariff->valid_to = $request->tariffValidTo;
            }
            else{ // disable the tariff
                $tariff->status = 0;
                $tariff->valid_to = Carbon::yesterday();
            }
        else if($tariff->status == 0){ // current status of the tariff is 0/off
            //dd ($request->tariffStatus);

            if($request->tariffStatus == null) // no change
                $tariff->status = 0;
            else if($request->tariffStatus == 'on'){ // activate the tariff
                // update valid_from and valid_to
                $tariff->valid_from = $request->tariffValidFrom;
                if($request->tariffValidToIndefinite == 'on')
                    $tariff->valid_to = null;
                else
                    $tariff->valid_to = $request->tariffValidTo;

                // update status of the tariff according to the "$request->tariffValidFrom"
                // if the given tariffValidFrom is today then activate the status of the tariff immediately otherwise CronJob will activate on the given date
                $difference = Carbon::parse($request->tariffValidFrom)->diffInDays(Carbon::now());
                if($difference == 0){
                    //dd("request->tariffValidFrom");
                    $tariff->status = 1;
                }
                else{
                    /** set up using CronJob*/
                    $tariff->status = 1;
                }
            }
        }

        /** change status of the tariff according to the "valid_to". */
        // User can change status of the tariff according to the "tariffValidTo".
        // If valid_to has the date before today, then change the status of the tariff from 1 to 0
        $todaysDate = new Carbon;
        if($request->tariffValidToIndefinite == null){ // limited tariff, tariffValidTo is entered. Otherwise tariffValidTo is not entered
            if($todaysDate > $request->tariffValidTo){
                //dd("tariff->status = 0");
                $tariff->status = 0;
            }
        }
        /** end: change status of the tariff */

        $tariff->group_id = $request->groupID;
        $tariff->provider_id = $request->providerID;
        $tariff->network_id = $request->networkID;

        // base_price and provision can be edited in separate GUI...
        //$this->base_price = 0;
        //$this->provision = 0;

        // edit for "special" tariff
        if ($request->madeByToker == 'on')
            $tariff->made_by_toker = 1;
        else
            $tariff->made_by_toker = 0;

        // edit for "aktion" tariff
        if ($request->actionTariff == 'on')
            $tariff->action_tariff = 1;
        else
            $tariff->action_tariff = 0;

        // edit for tariff with limited amount. Eğer limitsiz bir tarife limit ekleniyorsa bu bölüm aktifleştirilmeli. Aksi taktirte sil...
        if ($request->isLimited == 'on')
            $tariff->is_limited = 1;
        else
            $tariff->is_limited = 0;

        $tariff->update();
    }

    /**
     * called from VodafoneTariffController@storeOnTop */
    public function setOnTop($provider, $request){

        /** Check tariff dependency. */
        if($request->ontopTariffDependency == 1){ // for all tariffs
            // According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
            $tariffs = Tariff
                ::where('provider_id', $provider->id)
                ->get();
            foreach($tariffs as $tariff){
                // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
                if ($request->ontopDealerDependency == 1) { // give the on-top to all dealers and their offices
                    $dealers = Dealer::all();
                    foreach ($dealers as $dealer)
                        foreach ($dealer->offices as $office){
                            // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                            // then update the "ontop" value.
                            // Otherwise create new one.
                            $isOnTopExistForTheOffice = DB::table('ontop')
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', $dealer->id)
                                ->where('office_id', $office->id)
                                ->first();
                            if($isOnTopExistForTheOffice){
                                $tariff->dealers()->newPivotStatement()
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->delete();
                                $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                            else
                                $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                        }

                }
                else if ($request->ontopDealerDependency == 2) { // to selected dealers and their offices
                    $dealers = Dealer::all();
                    foreach ($dealers as $dealer)
                        if (array_key_exists($dealer->id, $request->ontopCheckboxOfDealers))
                            foreach ($dealer->offices as $office){
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                }
                else if ($request->ontopDealerDependency == 3) { // to dealers with certain categories and their offices
                    $dealers = Dealer::all();
                    foreach ($dealers as $dealer)
                        // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                        if (array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories))// if the left condition is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                            foreach ($dealer->offices as $office){
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }

                }
                else if ($request->ontopDealerDependency == 4) { // to dealers in certain regions and their offices
                    // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                    // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                    $dealerRegionVbs = DealerRegionVb::where('provider_id', $provider->id)->get();
                    foreach ($dealerRegionVbs as $dealerRegionVb) {
                        if (array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions)) {
                            $isOnTopExistForTheOffice = DB::table('ontop')
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', $dealerRegionVb->dealer_id)
                                ->where('office_id', $dealerRegionVb->office_id)
                                ->first();
                            if ($isOnTopExistForTheOffice){
                                $tariff->dealers()->newPivotStatement()
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealerRegionVb->dealer_id)
                                    ->where('office_id', $dealerRegionVb->office_id)
                                    ->delete();
                                $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                            }
                            else
                                $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                        }
                    }
                }
            }
        }
        else if($request->ontopTariffDependency == 2){ // for tariffs in particular group
            $tariffs = Tariff
                ::where('provider_id', $provider->id)
                ->get();
            foreach($tariffs as $tariff){
                // control is the tariff at the current  iteration is in the group that checked in tariff dependency in GUI
                if(array_key_exists($tariff->group_id, $request->ontopCheckboxOfGroups)){
                    //** According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
                    // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
                    if ($request->ontopDealerDependency == 1) { // give the on-top to all dealers and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer)
                            foreach ($dealer->offices as $office){
                                // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                                // then update the "ontop" value.
                                // Otherwise create new one.
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                    }
                    else if ($request->ontopDealerDependency == 2) { // to selected dealers and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer)
                            if (array_key_exists($dealer->id, $request->ontopCheckboxOfDealers))
                                foreach ($dealer->offices as $office){
                                    $isOnTopExistForTheOffice = DB::table('ontop')
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->first();
                                    if($isOnTopExistForTheOffice){
                                        $tariff->dealers()->newPivotStatement()
                                            ->where('tariff_id', $tariff->id)
                                            ->where('dealer_id', $dealer->id)
                                            ->where('office_id', $office->id)
                                            ->delete();
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                    else
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                    }
                    else if ($request->ontopDealerDependency == 3) { // to dealers with certain categories and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer)
                            // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                            if (array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories))// if the left condition is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                                foreach ($dealer->offices as $office){
                                    $isOnTopExistForTheOffice = DB::table('ontop')
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->first();
                                    if($isOnTopExistForTheOffice){
                                        $tariff->dealers()->newPivotStatement()
                                            ->where('tariff_id', $tariff->id)
                                            ->where('dealer_id', $dealer->id)
                                            ->where('office_id', $office->id)
                                            ->delete();
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                    else
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }

                    }
                    else if ($request->ontopDealerDependency == 4) { // to dealers in certain regions and their offices
                        // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                        // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                        $dealerRegionVbs = DealerRegionVb::where('provider_id', $provider->id)->get();
                        foreach ($dealerRegionVbs as $dealerRegionVb){
                            if (array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions)){
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealerRegionVb->dealer_id)
                                    ->where('office_id', $dealerRegionVb->office_id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealerRegionVb->dealer_id)
                                        ->where('office_id', $dealerRegionVb->office_id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                }
            }
        }
        else if($request->ontopTariffDependency == 3){ // for certain tariffs
            $tariffs = Tariff
                ::where('provider_id', $provider->id)
                ->get();
            foreach($tariffs as $tariff){
                // control is the tariff at the current  iteration is in the group that checked in tariff dependency in GUI
                if(array_key_exists($tariff->id, $request->OnTopCheckboxTariffs)){
                    //** According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
                    // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
                    if ($request->ontopDealerDependency == 1) { // give the on-top to all dealers and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer)
                            foreach ($dealer->offices as $office){
                                // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                                // then update the "ontop" value.
                                // Otherwise create new one.
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                    }
                    else if ($request->ontopDealerDependency == 2) { // to selected dealers and their offices
                            foreach($request->ontopCheckboxOfDealers as $dealerID) {
                                $dealer = Dealer::find($dealerID);
                                foreach ($dealer->offices as $office) {
                                    $isOnTopExistForTheOffice = DB::table('ontop')
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->first();
                                    if ($isOnTopExistForTheOffice){
                                        $tariff->dealers()->newPivotStatement()
                                            ->where('tariff_id', $tariff->id)
                                            ->where('dealer_id', $dealer->id)
                                            ->where('office_id', $office->id)
                                            ->delete();
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                    else{
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                }
                            }
                    }
                    else if ($request->ontopDealerDependency == 3) { // to dealers with certain categories and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer)
                            // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                            if (array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories))// if the left condition is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                                foreach ($dealer->offices as $office){
                                    $isOnTopExistForTheOffice = DB::table('ontop')
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->first();
                                    if($isOnTopExistForTheOffice){
                                        $tariff->dealers()->newPivotStatement()
                                            ->where('tariff_id', $tariff->id)
                                            ->where('dealer_id', $dealer->id)
                                            ->where('office_id', $office->id)
                                            ->delete();
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                    else
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }

                    }
                    else if ($request->ontopDealerDependency == 4) { // to dealers in certain regions and their offices
                        // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                        // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                        $dealerRegionVbs = DealerRegionVb::where('provider_id', $provider->id)->get();
                        foreach ($dealerRegionVbs as $dealerRegionVb){
                            if (array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions)){
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealerRegionVb->dealer_id)
                                    ->where('office_id', $dealerRegionVb->office_id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealerRegionVb->dealer_id)
                                        ->where('office_id', $dealerRegionVb->office_id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                }
            }
        }
dd("Stop");
    }
    public function setOnTopWithOffices($provider, $request){

        /** Check tariff dependency. */
        if($request->ontopTariffDependency == 1){ // for all tariffs
            // According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
            $tariffs = Tariff
                ::where('provider_id', $provider->id)
                ->get();
            foreach($tariffs as $tariff){
                // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
                if ($request->ontopDealerDependency == 1) { // give the on-top to all offices of the all dealers.
                    $dealers = Dealer::all();
                    foreach ($dealers as $dealer) {
                        foreach ($dealer->offices as $office) {
                            // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                            // then update the "ontop" value.
                            // Otherwise create new one.
                            $isOnTopExistForTheOffice = DB::table('ontop')
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', $dealer->id)
                                ->where('office_id', $office->id)
                                ->first();
                            if ($isOnTopExistForTheOffice){
                                //$tariff->dealers()->updateExistingPivot(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                                //$tariff->dealers()->detach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                                $tariff->dealers()->newPivotStatement()
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->delete();
                                $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                            else
                                $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                        }
                    }
                }
                else if ($request->ontopDealerDependency == 2) { // to selected offices of the dealers
                    foreach($request->ontopCheckboxOfOfficesOfDealers as $officeID){
                        $isOnTopExistForTheOffice = DB::table('ontop')
                            ->where('tariff_id', $tariff->id)
                            ->where('dealer_id', Office::find($officeID)->dealer_id)
                            ->where('office_id', $officeID)
                            ->first();
                        if($isOnTopExistForTheOffice){
                            //$tariff->dealers()->updateExistingPivot(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                            //$tariff->dealers()->detach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                            $tariff->dealers()->newPivotStatement()
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', Office::find($officeID)->dealer_id)
                                ->where('office_id', $officeID)
                                ->delete();
                            $tariff->dealers()->attach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                        }
                        else
                            $tariff->dealers()->attach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                    }
                }
                else if ($request->ontopDealerDependency == 3) { // to dealers with certain categories and their offices
                    $dealers = Dealer::all();
                    foreach ($dealers as $dealer) {
                        // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                        if (array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories)){ // if the condition on the left is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                            foreach ($dealer->offices as $office) {
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                }
                else if ($request->ontopDealerDependency == 4) { // to dealers in certain regions and their offices
                    // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                    // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                    // $dealerRegionVBs instance consists of info related to dealers and their offices
                    $dealerRegionVbs = DealerRegionVb::where('provider_id', $provider->id)->get();
                    foreach ($dealerRegionVbs as $dealerRegionVb) {
                        if (array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions)) {
                            $isOnTopExistForTheOffice = DB::table('ontop')
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', $dealerRegionVb->dealer_id)
                                ->where('office_id', $dealerRegionVb->office_id)
                                ->first();
                            if ($isOnTopExistForTheOffice){
                                $tariff->dealers()->newPivotStatement()
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealerRegionVb->dealer_id)
                                    ->where('office_id', $dealerRegionVb->office_id)
                                    ->delete();
                                $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                            }
                            else
                                $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                        }
                    }
                }
            }
        }
        else if($request->ontopTariffDependency == 2){ // for tariffs in particular group
            $tariffs = Tariff
                ::where('provider_id', $provider->id)
                ->get();
            foreach($tariffs as $tariff){
                // control is the tariff at the current  iteration is in the group that checked in tariff dependency in GUI
                if(array_key_exists($tariff->group_id, $request->ontopCheckboxOfGroups)){
                    //** According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
                    // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
                    if ($request->ontopDealerDependency == 1) { // give the on-top to all dealers and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer) {
                            foreach ($dealer->offices as $office) {
                                // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                                // then update the "ontop" value.
                                // Otherwise create new one.
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    //$tariff->dealers()->updateExistingPivot(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                                    //$tariff->dealers()->detach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                    else if ($request->ontopDealerDependency == 2) { // to selected offices of the dealers
                        foreach($request->ontopCheckboxOfOfficesOfDealers as $officeID){
                            $isOnTopExistForTheOffice = DB::table('ontop')
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', Office::find($officeID)->dealer_id)
                                ->where('office_id', $officeID)
                                ->first();
                            if($isOnTopExistForTheOffice){
                                //$tariff->dealers()->updateExistingPivot(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                                //$tariff->dealers()->detach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                                //$movie->find(1)->people()->newPivotStatement()->where('people_id',1)->where('role', 'Producer')->delete();
                                $tariff->dealers()->newPivotStatement()
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', Office::find($officeID)->dealer_id)
                                    ->where('office_id', $officeID)
                                    ->delete();
                                $tariff->dealers()->attach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                            }
                            else
                                $tariff->dealers()->attach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                        }
                    }
                    else if ($request->ontopDealerDependency == 3) { // to dealers with certain categories and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer) {
                            // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                            if (array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories)) {// if the left condition is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                                foreach ($dealer->offices as $office) {
                                    $isOnTopExistForTheOffice = DB::table('ontop')
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->first();
                                    if ($isOnTopExistForTheOffice){
                                        $tariff->dealers()->newPivotStatement()
                                            ->where('tariff_id', $tariff->id)
                                            ->where('dealer_id', $dealer->id)
                                            ->where('office_id', $office->id)
                                            ->delete();
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                    else
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                            }
                        }
                    }
                    else if ($request->ontopDealerDependency == 4) { // to dealers in certain regions and their offices
                        // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                        // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                        $dealerRegionVbs = DealerRegionVb::where('provider_id', $provider->id)->get();
                        foreach ($dealerRegionVbs as $dealerRegionVb){
                            if (array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions)){
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealerRegionVb->dealer_id)
                                    ->where('office_id', $dealerRegionVb->office_id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealerRegionVb->dealer_id)
                                        ->where('office_id', $dealerRegionVb->office_id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                }
            }
        }
        else if($request->ontopTariffDependency == 3){ // for certain tariffs
            $tariffs = Tariff
                ::where('provider_id', $provider->id)
                ->get();
            foreach($tariffs as $tariff){
                // control is the tariff at the current  iteration is in the group that checked in tariff dependency in GUI
                if(array_key_exists($tariff->id, $request->OnTopCheckboxTariffs)){
                    //** According to the selected dealer dependencies in the GUI, the on-top is assigned to specific dealers.
                    // Since some dealers have more than one office, on-top must be assigned to the office(s) of the dealers*/
                    if ($request->ontopDealerDependency == 1) { // give the on-top to all dealers and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer) {
                            foreach ($dealer->offices as $office) {
                                // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                                // then update the "ontop" value.
                                // Otherwise create new one.
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealer->id)
                                    ->where('office_id', $office->id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                    else if ($request->ontopDealerDependency == 2) { // to selected offices of the dealers
                        foreach($request->ontopCheckboxOfOfficesOfDealers as $officeID){
                            $isOnTopExistForTheOffice = DB::table('ontop')
                                ->where('tariff_id', $tariff->id)
                                ->where('dealer_id', Office::find($officeID)->dealer_id)
                                ->where('office_id', $officeID)
                                ->first();
                            if($isOnTopExistForTheOffice){
                                $tariff->dealers()->newPivotStatement()
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', Office::find($officeID)->dealer_id)
                                    ->where('office_id', $officeID)
                                    ->delete();
                                $tariff->dealers()->attach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                            }
                            else
                                $tariff->dealers()->attach(Office::find($officeID)->dealer_id, ['office_id' => $officeID, 'ontop' => $request->ontopAmount]);
                        }
                    }
                    else if ($request->ontopDealerDependency == 3) { // to dealers with certain categories and their offices
                        $dealers = Dealer::all();
                        foreach ($dealers as $dealer) {
                            // if category_id of the current dealer is equal to the category checked in the GUI, give the on-top to the dealer and its offices
                            if (array_key_exists($dealer->category_id, $request->ontopCheckboxOfCategories)) {// if the left condition is true the next one is also true. "if($request->checkboxOfCategories[$dealer->category_id] == 'on')"
                                foreach ($dealer->offices as $office) {
                                    $isOnTopExistForTheOffice = DB::table('ontop')
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealer->id)
                                        ->where('office_id', $office->id)
                                        ->first();
                                    if ($isOnTopExistForTheOffice)
                                    {
                                        $tariff->dealers()->newPivotStatement()
                                            ->where('tariff_id', $tariff->id)
                                            ->where('dealer_id', $dealer->id)
                                            ->where('office_id', $office->id)
                                            ->delete();
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                    }
                                    else
                                        $tariff->dealers()->attach($dealer->id, ['office_id' => $office->id, 'ontop' => $request->ontopAmount]);
                                }
                            }
                        }
                    }
                    else if ($request->ontopDealerDependency == 4) { // to dealers in certain regions and their offices
                        // Since DealerRegionVB model consist of dealers, their offices and region_id info, we use this model.
                        // Get the dealerRegionVB instance whose provider_id is equal to the current/selected provider.
                        $dealerRegionVbs = DealerRegionVb::where('provider_id', $provider->id)->get();
                        foreach ($dealerRegionVbs as $dealerRegionVb){
                            if (array_key_exists($dealerRegionVb->region_id, $request->ontopCheckboxOfRegions)){
                                $isOnTopExistForTheOffice = DB::table('ontop')
                                    ->where('tariff_id', $tariff->id)
                                    ->where('dealer_id', $dealerRegionVb->dealer_id)
                                    ->where('office_id', $dealerRegionVb->office_id)
                                    ->first();
                                if ($isOnTopExistForTheOffice){
                                    $tariff->dealers()->newPivotStatement()
                                        ->where('tariff_id', $tariff->id)
                                        ->where('dealer_id', $dealerRegionVb->dealer_id)
                                        ->where('office_id', $dealerRegionVb->office_id)
                                        ->delete();
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                                }
                                else
                                    $tariff->dealers()->attach($dealerRegionVb->dealer_id, ['office_id' => $dealerRegionVb->office_id, 'ontop' => $request->ontopAmount]);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * called from TariffController@storeOnTopCloning */
    public function setOnTopCloning($request){
        // determine tariffs which belongs to the dealer sent from the GUI.
        //$fromOffice = Office::find($request->officeID);
        $referenceDealer = Dealer::find($request->dealerID);
        //dd($fromOffice->id . " * ". $dealer->id);

        $tariffsOfOfficeOfDealer = $referenceDealer->tariffs()->wherePivot('office_id', $request->officeID)->get();

        foreach($referenceDealer->tariffs as $tariff){
            // find the on-top of the current tariff which belongs to the office of the dealer in pivot table
            $onTopOfTariffForReferenceDealer = DB::table('ontop')
                ->where('tariff_id', $tariff->id)
                ->where('dealer_id', $referenceDealer->id)
                ->first()
                ->ontop;

            foreach($request->ontopCheckboxOfDealers as $targetDealerID){
                $targetDealer = Dealer::find($targetDealerID);
                foreach ($targetDealer->offices as $targetOffice){
                    // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
                    // then update the "ontop" value.
                    // Otherwise create new one.
                    $isOnTopExistForTheOffice = DB::table('ontop')
                        ->where('tariff_id', $tariff->id)
                        ->where('dealer_id', $targetDealer->id)
                        ->where('office_id', $targetOffice->id)
                        ->first();

                    if($isOnTopExistForTheOffice){
                        $tariff->dealers()->newPivotStatement()
                            ->where('tariff_id', $tariff->id)
                            ->where('dealer_id', $targetDealer->id)
                            ->where('office_id', $targetOffice->id)
                            ->delete();
                        $tariff->dealers()->attach($targetDealer->id, ['office_id' => $targetOffice->id, 'ontop' => $onTopOfTariffForReferenceDealer]);
                    }
                    else
                        $tariff->dealers()->attach($targetDealer->id, ['office_id' => $targetOffice->id, 'ontop' => $onTopOfTariffForReferenceDealer]);
                }
            }
        }
    }
    public function setOnTopCloningWithOffice($request){
       // determine tariffs which belongs to the office of the dealer sent from the GUI.
       $fromOffice = Office::find($request->officeID);
       $fromDealer = Dealer::find($fromOffice->dealer_id);
       //dd($fromOffice->id . " * ". $dealer->id);

       $tariffsOfOfficeOfDealer = $fromDealer->tariffs()->wherePivot('office_id', $request->officeID)->get();

       foreach($tariffsOfOfficeOfDealer as $tariff){
           // find the on-top of the current tariff which belongs to the office of the dealer in pivot table
           $onTopOfTariffOfFromOffice = DB::table('ontop')
               ->where('tariff_id', $tariff->id)
               ->where('dealer_id', $fromOffice->dealer_id)
               ->where('office_id', $request->officeID)
               ->first()
               ->ontop;

           foreach ($request->ontopCheckboxOfOffices as $toOfficeID){
               // if the on-top of the tariff (instance of "$tariffsOfOfficeOfDealer")for the office which takes the on-top ($toOffice) exists in the "ontop" table,
               // then update the "ontop" value.
               // Otherwise create new one.
               $isOnTopExistForTheOffice = DB::table('ontop')
                   ->where('tariff_id', $tariff->id)
                   ->where('dealer_id', Office::where('id',$toOfficeID )->first()->dealer_id)
                   ->where('office_id', $toOfficeID)
                   ->first();
               if($isOnTopExistForTheOffice)
                   $tariff->dealers()->updateExistingPivot(Office::where('id',$toOfficeID )->first()->dealer_id, ['office_id' => $toOfficeID, 'ontop' => $onTopOfTariffOfFromOffice]);
               else
                   $tariff->dealers()->attach(Office::where('id',$toOfficeID )->first()->dealer_id, ['office_id' => $toOfficeID, 'ontop' => $onTopOfTariffOfFromOffice]);
           }
       }
    }

}