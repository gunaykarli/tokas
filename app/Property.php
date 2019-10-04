<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    public function tariffs(){
        return $this->belongsToMany(Tariff::class, 'property_tariff')
            ->withPivot('amount_of_value', 'text_of_value')
            ->withTimestamps();
    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setProperties_V1_20190911($tariff, $request){

        // If new property is created, first of all the property should be save to the "property" table. And then its value is attached the pivot table (tariff_property)
        if($request->newPropertyCheckbox == 'on'){
            $newProperty = new Property();
            $newProperty->name = $request->newPropertyAttribute;
            $newProperty->category = 'Tarifvorteile';
            $newProperty->data_type = 'string';
            $newProperty->unit = '';
            $newProperty->save();

            $tariff->properties()->attach($newProperty->id, ['value' => $request->newPropertyValue]);
        }

        // According to inputOfProperties in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_property) of Property and Tariff is set.
        // Since inputOfProperties takes its names' values from the Property table.,
        // we need to check if the key exist in the array inputOfProperty, if so, use the value sent from the form. */

        $properties = Property::all();
        foreach($properties as $property){
            if($property->data_type == 'boolean')
                //if($request->booleanInputOfProperties[$property->id] != Null)//****array_key_exists('first', $search_array)
                if(array_key_exists($property->id, $request->booleanInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => 1]);
                else
                    $tariff->properties()->attach($property->id, ['value' => 0]);
            else
                //if($request->textInputOfProperties[$property->id] != Null)
                if(array_key_exists($property->id, $request->textInputOfProperties))
                    if($request->textInputOfProperties[$property->id] != null) // if the value of property listed in GUI is not empty
                        $tariff->properties()->attach($property->id, ['value' => $request->textInputOfProperties[$property->id]]);
        }
    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setProperties_V2_20190912($tariff, $request){

        // tariff advantages
        // data volume
        $tariff->properties()->attach(Property::where('name', 'Datenvolumen')->first()->id, ['value' => $request->dataVolume]);
        // bandwidth
        $tariff->properties()->attach(Property::where('name', 'max-Bandbreite')->first()->id, ['value' => $request->bandwidth]);
        // LTECapable
        if($request->LTECapable == 'on')
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['value' => 0]);

        // Mobile Internet
        // telephony
        if($request->valueOfTelephonyCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['value' => $request->valueOfTelephonyText]);
        // telephony
        if($request->valueOfInternetCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['value' => $request->valueOfInternetText]);
        // SMS
        if($request->valueOfSMSCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['value' => $request->valueOfSMSText]);

    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setProperties_V3_20190918($tariff, $request){


        /** Mobile Internet */
        // data volume
        $tariff->properties()->attach(Property::where('name', 'Datenvolumen')->first()->id, ['text_of_value' => 'GB', 'amount_of_value' => $request->dataVolume]);
        // bandwidth
        $tariff->properties()->attach(Property::where('name', 'max-Bandbreite')->first()->id, ['text_of_value' => 'Mbit/s', 'amount_of_value' => $request->bandwidth]);
        // LTECapable
        if($request->LTECapable == 'on')
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['text_of_value' => 'LTE-fähig', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['text_of_value' => 'LTE-fähig', 'amount_of_value' => 0]);



        /** tariff advantages */
        // for all net flat
        // telephony
        if($request->flatTelephonyCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);
        // Internet
        if($request->flatInternetCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);
        // SMS
        if($request->flatSMSCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);


        // add new tariff advantages
        // 1. new tariff advantages
        if($request->addNewAdvantageCheckbox1 == 'on'){
            if($request->nameOfPropertySelectBox1 != 0){
                if($request->textOfValueSelectBox1 != 0){
                    if($request->textOfValueSelectBox1 == 1){ // add new value
                        if($request->amountOfValue1 != '' && $request->textOfValue1 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox1 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => $request->amountOfValue1]);
                            else if($request->nameOfPropertySelectBox1 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => $request->amountOfValue1]);
                            else if($request->nameOfPropertySelectBox1 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => $request->amountOfValue1]);
                            else if($request->nameOfPropertySelectBox1 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => $request->amountOfValue1]);
                        }
                    }
                    else{ // add one of values already in DB
                        if($request->amountOfValue1 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox1 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValueSelectBox1, 'amount_of_value' => $request->amountOfValue1]);
                            else if($request->nameOfPropertySelectBox1 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValueSelectBox1, 'amount_of_value' => $request->amountOfValue1]);
                            else if($request->nameOfPropertySelectBox1 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValueSelectBox1, 'amount_of_value' => $request->amountOfValue1]);
                            else if($request->nameOfPropertySelectBox1 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValueSelectBox1, 'amount_of_value' => $request->amountOfValue1]);
                        }
                    }
                }
            }
        }

        // 2. new tariff advantages
        if($request->addNewAdvantageCheckbox2 == 'on'){
            if($request->nameOfPropertySelectBox2 != 0){
                if($request->textOfValueSelectBox2 != 0){
                    if($request->textOfValueSelectBox2 == 1){ // add new value
                        if($request->amountOfValue2 != '' && $request->textOfValue2 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox2 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => $request->amountOfValue2]);
                            else if($request->nameOfPropertySelectBox2 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => $request->amountOfValue2]);
                            else if($request->nameOfPropertySelectBox2 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => $request->amountOfValue2]);
                            else if($request->nameOfPropertySelectBox2 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => $request->amountOfValue2]);
                        }
                    }
                    else{ // add one of values already in DB
                        if($request->amountOfValue2 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox2 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValueSelectBox2, 'amount_of_value' => $request->amountOfValue2]);
                            else if($request->nameOfPropertySelectBox2 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValueSelectBox2, 'amount_of_value' => $request->amountOfValue2]);
                            else if($request->nameOfPropertySelectBox2 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValueSelectBox2, 'amount_of_value' => $request->amountOfValue2]);
                            else if($request->nameOfPropertySelectBox2 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValueSelectBox2, 'amount_of_value' => $request->amountOfValue2]);
                        }
                    }
                }
            }
        }

        // 3. new tariff advantages
        if($request->addNewAdvantageCheckbox3 == 'on'){
            if($request->nameOfPropertySelectBox3 != 0){
                if($request->textOfValueSelectBox3 != 0){
                    if($request->textOfValueSelectBox3 == 1){ // add new value
                        if($request->amountOfValue3 != '' && $request->textOfValue3 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox3 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => $request->amountOfValue3]);
                            else if($request->nameOfPropertySelectBox3 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => $request->amountOfValue3]);
                            else if($request->nameOfPropertySelectBox3 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => $request->amountOfValue3]);
                            else if($request->nameOfPropertySelectBox3 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => $request->amountOfValue3]);
                        }
                    }
                    else{ // add one of values already in DB
                        if($request->amountOfValue3 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox3 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValueSelectBox3, 'amount_of_value' => $request->amountOfValue3]);
                            else if($request->nameOfPropertySelectBox3 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValueSelectBox3, 'amount_of_value' => $request->amountOfValue3]);
                            else if($request->nameOfPropertySelectBox3 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValueSelectBox3, 'amount_of_value' => $request->amountOfValue3]);
                            else if($request->nameOfPropertySelectBox3 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValueSelectBox3, 'amount_of_value' => $request->amountOfValue3]);
                        }
                    }
                }
            }
        }

        // 4. new tariff advantages
        if($request->addNewAdvantageCheckbox4 == 'on'){
            if($request->nameOfPropertySelectBox4 != 0){
                if($request->textOfValueSelectBox4 != 0){
                    if($request->textOfValueSelectBox4 == 1){ // add new value
                        if($request->amountOfValue4 != '' && $request->textOfValue4 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox4 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue4, 'amount_of_value' => $request->amountOfValue4]);
                            else if($request->nameOfPropertySelectBox4 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue4, 'amount_of_value' => $request->amountOfValue4]);
                            else if($request->nameOfPropertySelectBox4 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue4, 'amount_of_value' => $request->amountOfValue4]);
                            else if($request->nameOfPropertySelectBox4 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue4, 'amount_of_value' => $request->amountOfValue4]);
                        }
                    }
                    else{ // add one of values already in DB
                        if($request->amountOfValue4 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox4 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValueSelectBox4, 'amount_of_value' => $request->amountOfValue4]);
                            else if($request->nameOfPropertySelectBox4 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValueSelectBox4, 'amount_of_value' => $request->amountOfValue4]);
                            else if($request->nameOfPropertySelectBox4 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValueSelectBox4, 'amount_of_value' => $request->amountOfValue4]);
                            else if($request->nameOfPropertySelectBox4 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValueSelectBox4, 'amount_of_value' => $request->amountOfValue4]);
                        }
                    }
                }
            }
        }

        // 5. new tariff advantages
        if($request->addNewAdvantageCheckbox5 == 'on'){
            if($request->nameOfPropertySelectBox5 != 0){
                if($request->textOfValueSelectBox5 != 0){
                    if($request->textOfValueSelectBox5 == 1){ // add new value
                        if($request->amountOfValue5 != '' && $request->textOfValue5 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox5 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue5, 'amount_of_value' => $request->amountOfValue5]);
                            else if($request->nameOfPropertySelectBox5 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue5, 'amount_of_value' => $request->amountOfValue5]);
                            else if($request->nameOfPropertySelectBox5== 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue5, 'amount_of_value' => $request->amountOfValue5]);
                            else if($request->nameOfPropertySelectBox5 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue5, 'amount_of_value' => $request->amountOfValue5]);
                        }
                    }
                    else{ // add one of values already in DB
                        if($request->amountOfValue5 != ''){
                            // depending on the value of the elements in GUI, save them to the pivot table
                            if($request->nameOfPropertySelectBox5 == 1) // telephony
                                $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValueSelectBox5, 'amount_of_value' => $request->amountOfValue5]);
                            else if($request->nameOfPropertySelectBox5 == 2) // internet
                                $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValueSelectBox5, 'amount_of_value' => $request->amountOfValue5]);
                            else if($request->nameOfPropertySelectBox5 == 3) // SMS
                                $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValueSelectBox5, 'amount_of_value' => $request->amountOfValue5]);
                            else if($request->nameOfPropertySelectBox5 == 4) // internet
                                $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValueSelectBox5, 'amount_of_value' => $request->amountOfValue5]);
                        }
                    }
                }
            }
        }
    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setProperties($tariff, $request){


        /** Mobile Internet */
        // data volume
        $tariff->properties()->attach(Property::where('name', 'Datenvolumen')->first()->id, ['text_of_value' => 'GB', 'amount_of_value' => $request->dataVolume]);
        // bandwidth
        $tariff->properties()->attach(Property::where('name', 'max-Bandbreite')->first()->id, ['text_of_value' => 'Mbit/s', 'amount_of_value' => $request->bandwidth]);
        // LTECapable
        if($request->LTECapable == 'on')
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['text_of_value' => 'LTE-fähig', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['text_of_value' => 'LTE-fähig', 'amount_of_value' => 0]);



        /** tariff advantages */
        // for all net flat
        // telephony
        if($request->flatTelephonyCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);
        // Internet
        if($request->flatInternetCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);
        // SMS
        if($request->flatSMSCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);


        // add new tariff advantages
        // 1. new tariff advantages
        if($request->addNewAdvantageCheckbox1 == 'on'){
            if($request->nameOfPropertySelectBox1 != 0){
                if($request->textOfValue1 != ''){
                    // depending on the value of the elements in GUI, save them to the pivot table
                    if($request->nameOfPropertySelectBox1 == 1) // telephony
                        $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox1 == 2) // internet
                        $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox1 == 3) // SMS
                        $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox1 == 4) // other
                        $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                }
            }
        }

        // 2. new tariff advantages
        if($request->addNewAdvantageCheckbox2 == 'on'){
            if($request->nameOfPropertySelectBox2 != 0){
                if($request->textOfValue2 != ''){
                    // depending on the value of the elements in GUI, save them to the pivot table
                    if($request->nameOfPropertySelectBox2 == 1) // telephony
                        $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox2 == 2) // internet
                        $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox2 == 3) // SMS
                        $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox2 == 4) // other
                        $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                }
            }
        }

        // 3. new tariff advantages
        if($request->addNewAdvantageCheckbox3 == 'on'){
            if($request->nameOfPropertySelectBox3 != 0){
                if($request->textOfValue3 != ''){
                    // depending on the value of the elements in GUI, save them to the pivot table
                    if($request->nameOfPropertySelectBox3 == 1) // telephony
                        $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox3 == 2) // internet
                        $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox3 == 3) // SMS
                        $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox3 == 4) // other
                        $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                }
            }
        }

    }

    /**
     * forwated from VodafoneTariffController@update
     */
    public function updateProperties_V1_20190930($tariff, $request){
        // According to inputOfProperties in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_property) of Property and Tariff is set.
        // Since inputOfProperties takes its names' values from the Property table.,
        // we need to check if the key exist in the array inputOfProperty, if so, use the value sent from the form. */

        // First, detach all properties of the tariff in the related pivot table...
        $tariff->properties()->detach();

        $properties = Property::all();
        foreach($properties as $property){
            if($property->data_type == 'boolean')
                if(array_key_exists($property->id, $request->booleanInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => 1]);
                else
                    $tariff->properties()->attach($property->id, ['value' => 0]);
            else
                if(array_key_exists($property->id, $request->textInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => $request->textInputOfProperties[$property->id]]);
        }
    }

    /**
     * forwated from VodafoneTariffController@update
     */
    public function updateProperties($tariff, $request){
        // According to inputOfProperties in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_property) of Property and Tariff is set.
        // Since inputOfProperties takes its names' values from the Property table.,
        // we need to check if the key exist in the array inputOfProperty, if so, use the value sent from the form. */

        // First, detach all properties of the tariff in the related pivot table...
        $tariff->properties()->detach();

        /** Mobile Internet */
        // data volume
        $tariff->properties()->attach(Property::where('name', 'Datenvolumen')->first()->id, ['text_of_value' => 'GB', 'amount_of_value' => $request->dataVolume]);
        // bandwidth
        $tariff->properties()->attach(Property::where('name', 'max-Bandbreite')->first()->id, ['text_of_value' => 'Mbit/s', 'amount_of_value' => $request->bandwidth]);
        // LTECapable
        if($request->LTECapable == 'on')
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['text_of_value' => 'LTE-fähig', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'LTE-fähig')->first()->id, ['text_of_value' => 'LTE-fähig', 'amount_of_value' => 0]);



        /** tariff advantages */
        // for all net flat
        // telephony
        if($request->flatTelephonyCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);
        // Internet
        if($request->flatInternetCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);
        // SMS
        if($request->flatSMSCheckbox == 'on')
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 1]);
        else
            $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => 'Alle Netze Flat', 'amount_of_value' => 0]);


        // add new tariff advantages
        // 1. new tariff advantages
        if($request->addNewAdvantageCheckbox1 == 'on'){
            if($request->nameOfPropertySelectBox1 != 0){
                if($request->textOfValue1 != ''){
                    // depending on the value of the elements in GUI, save them to the pivot table
                    if($request->nameOfPropertySelectBox1 == 1) // telephony
                        $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox1 == 2) // internet
                        $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox1 == 3) // SMS
                        $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox1 == 4) // other
                        $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue1, 'amount_of_value' => null]);
                }
            }
        }

        // 2. new tariff advantages
        if($request->addNewAdvantageCheckbox2 == 'on'){
            if($request->nameOfPropertySelectBox2 != 0){
                if($request->textOfValue2 != ''){
                    // depending on the value of the elements in GUI, save them to the pivot table
                    if($request->nameOfPropertySelectBox2 == 1) // telephony
                        $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox2 == 2) // internet
                        $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox2 == 3) // SMS
                        $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox2 == 4) // other
                        $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue2, 'amount_of_value' => null]);
                }
            }
        }

        // 3. new tariff advantages
        if($request->addNewAdvantageCheckbox3 == 'on'){
            if($request->nameOfPropertySelectBox3 != 0){
                if($request->textOfValue3 != ''){
                    // depending on the value of the elements in GUI, save them to the pivot table
                    if($request->nameOfPropertySelectBox3 == 1) // telephony
                        $tariff->properties()->attach(Property::where('name', 'Telefonie')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox3 == 2) // internet
                        $tariff->properties()->attach(Property::where('name', 'Internet')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox3 == 3) // SMS
                        $tariff->properties()->attach(Property::where('name', 'SMS')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                    else if($request->nameOfPropertySelectBox3 == 4) // other
                        $tariff->properties()->attach(Property::where('name', 'Sonstige')->first()->id, ['text_of_value' => $request->textOfValue3, 'amount_of_value' => null]);
                }
            }
        }
    }


}
