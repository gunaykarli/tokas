<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['contract_type', 'provider_id', 'customer_id', 'salesperson_id', 'office_id', 'dealer_id', 'VO_id', 'contract_start', 'status'];

    /**
     * Define the relations
     */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function vfGsms(){
        return $this->hasMany(VfGsm::class);
    }

    public function vfPorting(){
        return $this->hasOne(VfPorting::class);
    }

    public function vfDcChange(){
        return $this->hasOne(VfDcChange::class);
    }

    /**
     * User defined functions
     */

    /** Execution forwarded from ContractController@forwardToStore */
    public static function store($customerID, $request){

        $contract = new Contract();

        $contract->contract_type = $request->contractType;
        $contract->provider_id = $request->providerID;
        $contract->customer_id = $customerID;
        $contract->salesperson_id = auth()->user()->id;
        $contract->office_id = auth()->user()->office_id;
        $contract->dealer_id = auth()->user()->dealer_id;
        $contract->VO_id = DealersMemberCode::where('dealer_id', auth()->user()->dealer_id)->first()->vodafone_UVP;
        //$contract->tariff_id has been excluded from the Contracts table...since there might be more than one tariff in the shopping cart.
        $contract->contract_start = $request->contractStartDate;
        $contract->status = 0;// Contract has been saved to the database without any control, First step...

        $contract->save();
    }
    /** Execution forwarded from ContractController@forwardToFinalize
     *
     * Changes status attribute of specific contract ($contractID) of the contract table depending on the current action.
     * For example if "Finalize Vertrag" button has been pushed,
     * "status" attribute of the contract table will be chanced to 1
     */
    public static function changeStatusOfContract($contractID, $status){
        $contract = Contract
            ::where('id', $contractID)
            ->first();
        $contract->status = $status;
        $contract->save();
    }

    // Mit der Funktion Contract::xmloac wird einzige Tag ausgegeben
    public static function xmloac($XMLFile, $tabs, $name){
        $text ='';
        for ($i=0;$i<$tabs;$i++){
            $text = $text . "\t";
        }
        $text = $text . "<" . $name . "/>\n";
        fwrite($XMLFile, $text);
    }

// Mit der Funktion xmlopen wird ein Start-Tag ausgegeben
    public static function xmlopen($XMLFile, $tabs, $name){
        $text ='';
        for ($i=0;$i<$tabs;$i++){
            $text .=  "\t";
        }
        $text = $text . "<" . $name . ">\n";
        fwrite($XMLFile, $text);
    }

// Mit der Funktion Contract::xmlclose wird ein Close-Tag ausgegeben
    public static function xmlclose($XMLFile, $tabs, $name){
        $text ='';
        for ($i=0;$i<$tabs;$i++){
            $text = $text . "\t";
        }
        $text = $text . "</" . $name . ">\n";
        fwrite($XMLFile, $text);
    }

// Mit der Funktion Contract::xmlclose wird ein Close-Tag ausgegeben
    public static function xmlrow($XMLFile, $tabs, $name, $value){
        $text ='';
        for ($i=0;$i<$tabs;$i++){
            $text = $text . "\t";
        }
        $text = $text . "<" . $name . ">" . $value . "</" . $name . ">\n";
        fwrite($XMLFile, $text);
    }
    public static function produceXMLForGsmVodafoneContract($contractID){
        // Fetch related data from the database...
        $contract = Contract
            ::where('id', $contractID)
            ->first();

        $customer = Customer
            ::where('id', $contract->customer_id)
            ->first();

        $customerContact = CustomerContact
            ::where('customer_id', $customer->id)
            ->first();

        $customerInvoiceAddress = CustomerInvoiceAddress
            ::where('customer_id', $customer->id)
            ->first();

        $customerPaymentTool = CustomerPaymentTool
            ::where('customer_id', $customer->id)
            ->first();

        // there may be more than one gsm...
        $mainCardVfGsm = VfGSM
            ::where('contract_id', $contract->id)
            ->first();

        // Fetch the VF-GSM with the current contract ID from "VfGsm" table
        $allCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->get();



        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        // Eine leere xml-Datei wird erstellt
        $XMLFile = fopen("C:/xampp\htdocs/UserDefined/XMLs-Tokas\XML-" . $dateTimeString . ".xml", "a+");
        fwrite($XMLFile, "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
        fwrite($XMLFile, "<Auftraege xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"DEU_ASYNC_ACT_DCS_PCRED_REQ_2018_001.xsd\">\n");

        Contract::xmlrow($XMLFile, 1, 'BatchId', $contract->id);
        Contract::xmlopen($XMLFile, 1, 'Aktivierung');

            Contract::xmlrow($XMLFile, 2, 'AuftragsId', $contract->id .'-'. $dateTimeString);
            Contract::xmlrow($XMLFile, 2, 'VOId', $contract->VO_id);
            Contract::xmlopen($XMLFile, 2, 'Kundendaten');

                if($customer->customer_type == 1 or $customer->customer_type == 2){// Private or SoHo customer
                    Contract::xmlopen($XMLFile, 3, 'Privatkunde');
                        Contract::xmlrow($XMLFile, 4, 'Anrede', $customer->salutation);
                        Contract::xmlrow($XMLFile, 4, 'Vorname', $customer->name);
                        Contract::xmlrow($XMLFile, 4, 'Name', $customer->surname);
                        Contract::xmlrow($XMLFile, 4, 'Strasse', trim($customerContact->street));
                        Contract::xmlrow($XMLFile, 4, 'Hausnummer', trim($customerContact->house_number));
                        Contract::xmlrow($XMLFile, 4, 'Ort', trim($customerContact->city));
                        Contract::xmlrow($XMLFile, 4, 'Land', 'D');
                        Contract::xmlrow($XMLFile, 4, 'Postleitzahl', trim($customerContact->postal_code));
                        Contract::xmlrow($XMLFile, 4, 'Ansprechpartner', trim($customer->contact_person));

                        if($customerInvoiceAddress->medium_type == 2) { // online
                            Contract::xmlrow($XMLFile, 4, 'EmailAdresse', trim($customerContact->email));
                        }
                        Contract::xmlrow($XMLFile, 4, 'Geburtsdatum', trim($customer->birth_date));

                        if($customer->identity_type == 1){// personal ausweis
                            Contract::xmlrow($XMLFile, 4, 'Personalausweisnummer', trim($customer->identity_card_number));                }
                        else if($customer->identity_type == 2){// foreign ausweis
                            Contract::xmlrow($XMLFile, 4, 'AuslaendischeAusweisnummer', trim($customer->identity_card_number));
                        }
                        Contract::xmlopen($XMLFile, 4, 'Kreditkarte');
                            Contract::xmlrow($XMLFile, 5, 'Kreditkartennummer', trim($customerPaymentTool->card_number));
                            Contract::xmlopen($XMLFile, 5, 'GueltigBis');
                                Contract::xmlrow($XMLFile, 6, 'Monat', trim($customerPaymentTool->valid_to_month));
                                Contract::xmlrow($XMLFile, 6, 'Jahr', trim($customerPaymentTool->valid_to_year));
                            Contract::xmlclose($XMLFile, 5, 'GueltigBis');
                            Contract::xmlrow($XMLFile, 5, 'Kreditinstitut', trim($customerPaymentTool->card_credit_institution));
                        Contract::xmlclose($XMLFile, 4, 'Kreditkarte');
                        Contract::xmlopen($XMLFile, 4, 'Bankverbindung');
                            Contract::xmlrow($XMLFile, 5, 'IBAN', trim($customerPaymentTool->IBAN));
                            Contract::xmlrow($XMLFile, 5, 'BIC', trim($customerPaymentTool->BIC));
                            if($customerPaymentTool->different_account_owner == 1){ // in case different_account_owner is true./** fetch the values from "Contract Related Address" table */
                                Contract::xmlrow($XMLFile, 5, 'Kontoinhaber', trim($customerPaymentTool->account_owner));
                                Contract::xmlrow($XMLFile, 5, 'Strasse', trim($customerContact->street));
                                Contract::xmlrow($XMLFile, 5, 'Hausnummer', trim($customerContact->house_number));
                                Contract::xmlrow($XMLFile, 5, 'Land', "D");
                                Contract::xmlrow($XMLFile, 5, 'Postleitzahl', trim($customerContact->postal_code));
                                Contract::xmlrow($XMLFile, 5, 'Ort', trim($customerContact->city));
                            }
                            else if($customerPaymentTool->different_account_owner == 0){
                                Contract::xmlrow($XMLFile, 5, 'Kontoinhaber', trim($customer->name). ' ' . trim($customer->surname));
                                Contract::xmlrow($XMLFile, 5, 'Strasse', trim($customerContact->street));
                                Contract::xmlrow($XMLFile, 5, 'Hausnummer', trim($customerContact->house_number));
                                Contract::xmlrow($XMLFile, 5, 'Land', "D");
                                Contract::xmlrow($XMLFile, 5, 'Postleitzahl', trim($customerContact->postal_code));
                                Contract::xmlrow($XMLFile, 5, 'Ort', trim($customerContact->city));
                            }
                        Contract::xmlclose($XMLFile, 4, 'Bankverbindung');
                        Contract::xmlopen($XMLFile, 4, 'Rechnung');

                            if($customerInvoiceAddress->salutation == 1) // Private or SoHo - Herr
                                Contract::xmlrow($XMLFile, 5, 'Anrede', 'Herr');
                            else if($customerInvoiceAddress->salutation == 2)// Private or SoHo - Frau
                                Contract::xmlrow($XMLFile, 5, 'Anrede', 'Frau');
                            else if($customerInvoiceAddress->salutation == 3)// Business - Firma
                                Contract::xmlrow($XMLFile, 5, 'Anrede', 'Firma');

                            if($customerInvoiceAddress->salutation == 3)// Business - Firma
                                Contract::xmlrow($XMLFile, 5, 'Firmenname1', trim($customerInvoiceAddress->company_name));
                            else{// Private or SoHo
                                Contract::xmlrow($XMLFile, 5, 'Vorname', trim($customerInvoiceAddress->name));
                                Contract::xmlrow($XMLFile, 5, 'Name', trim($customerInvoiceAddress->surname));
                            }
                            Contract::xmlrow($XMLFile, 5, 'Strasse', trim($customerInvoiceAddress->street));
                            Contract::xmlrow($XMLFile, 5, 'Hausnummer', trim($customerInvoiceAddress->house_number));
                            Contract::xmlrow($XMLFile, 5, 'Land', 'D');
                            Contract::xmlrow($XMLFile, 5, 'Postleitzahl', trim($customerInvoiceAddress->postal_code));
                            Contract::xmlrow($XMLFile, 5, 'Ort', trim($customerInvoiceAddress->city));
                            Contract::xmlrow($XMLFile, 5, 'Ansprechpartner', trim($customerInvoiceAddress->contact_person));

                            //Eintrag der Rechnungsmedium
                            if ($customerInvoiceAddress->medium_type == 2){ // online
                                Contract::xmlopen($XMLFile, 5, 'Rechnungsmedium');
                                    Contract::xmlrow($XMLFile, 6, 'Art', 'NurOnline');
                                Contract::xmlclose($XMLFile, 5, 'Rechnungsmedium');
                            }
                        Contract::xmlclose($XMLFile, 4, 'Rechnung');
                    Contract::xmlclose($XMLFile, 3, 'Privatkunde');
                }
                else if($customer->customer_type == 3){ // Business Customer
                    /** Complete */
                }

                if ($mainCardVfGsm->additional_contract == 1){
                    Contract::xmlrow($XMLFile, 3, 'Zusatzauftrag', 'ja');
                    Contract::xmlrow($XMLFile, 3, 'Kundennummer', $mainCardVfGsm->customer_number);
                    Contract::xmlrow($XMLFile, 3, 'Kennwort', trim($mainCardVfGsm->password));
                }
                else{
                    Contract::xmlrow($XMLFile, 3, 'Zusatzauftrag', 'nein');
                }

                if ($mainCardVfGsm->objection == 1){
                    Contract::xmlopen($XMLFile, 3, 'Widerspruch');
                        Contract::xmloac($XMLFile, 4, 'GegenNutzungVonBestandsUndVerbindungsdaten');
                    Contract::xmlclose($XMLFile, 3, 'Widerspruch');
                }

                Contract::xmlrow($XMLFile, 3, 'Erfassungsdatum', $contract->contract_start);
            Contract::xmlclose($XMLFile, 2, 'Kundendaten');

            /** begin: Teilnehmer Hauptkarte */

            Contract::xmlopen($XMLFile, 2, 'Produkte');
                $subscriberID = 1;
                foreach ($allCardsVfGsmInTheContract as $currentCardVfGsm){
                    // find the tariff included by the $currentCardVfGsm
                    $currentTariff = Tariff::where('id', $currentCardVfGsm->tariff_id)->first();

                    Contract::xmlopen($XMLFile, 3, 'Teilnehmer');
                        Contract::xmlopen($XMLFile, 4, 'GSM');
                            Contract::xmlrow($XMLFile, 5, 'TeilnehmerID', $subscriberID);
                            Contract::xmlopen($XMLFile, 5, 'Simkarte');
                                Contract::xmlrow($XMLFile, 6, 'VFSIMSeriennummer', $currentCardVfGsm->SIM_serial_number);

                                if ($currentTariff->tariff_code == "VFZH24FFN") {
                                        Contract::xmlopen($XMLFile, 6, 'IMEI');
                                            Contract::xmloac($XMLFile, 7, 'keineHardware');
                                        Contract::xmlclose($XMLFile, 6, 'IMEI');
                                }
                                else if(Plausibility::where('vodafone_tariff_id',VodafoneTariff::where('tariff_id', $currentTariff->id)->first()->id)->first()->subsidy_authorization == 1 and
                                        Plausibility::where('vodafone_tariff_id',VodafoneTariff::where('tariff_id', $currentTariff->id)->first()->id)->first()->IMEI_acquisition == 1){
                                        Contract::xmlopen($XMLFile, 6, 'IMEI');
                                            if($currentCardVfGsm->SIM_IMEI_type == 'Bestellung'){
                                                    Contract::xmloac($XMLFile, 7, 'Bestellung');
                                            }
                                            else if($currentCardVfGsm->SIM_IMEI_type == 'nachtraeglicheErfassung'){
                                                Contract::xmloac($XMLFile, 7, 'nachtraeglicheErfassung');
                                            }
                                            else if($currentCardVfGsm->SIM_IMEI_type == 'keineHardware'){
                                                Contract::xmloac($XMLFile, 7, 'keineHardware');
                                            }
                                            else
                                                Contract::xmlrow($XMLFile, 7, 'Nummer', $currentCardVfGsm->SIM_IMEI_type);
                                        Contract::xmlclose($XMLFile, 6, 'IMEI');
                                }
                            Contract::xmlclose($XMLFile, 5, 'Simkarte');
                            Contract::xmlrow($XMLFile, 5, 'Vertragsbeginn', $contract->contract_start);

                            Contract::xmlrow($XMLFile, 5, 'Tarif', $currentTariff->tariff_code);

                            Contract::xmlopen($XMLFile, 5, 'Dienste');
                                foreach ($currentCardVfGsm->supplementary_services as $supplementaryService) {
                                    Contract::xmlopen($XMLFile, 6, 'Zusatzdienst');
                                        Contract::xmlrow($XMLFile, 7, 'Name', $supplementaryService);
                                    Contract::xmlclose($XMLFile, 6, 'Zusatzdienst');
                                }

                                foreach ($currentCardVfGsm->data_services as $dataService) {
                                    Contract::xmlopen($XMLFile, 6, 'Datendienst');
                                        Contract::xmlrow($XMLFile, 7, 'Name', $dataService);
                                    Contract::xmlclose($XMLFile, 6, 'Datendienst');
                                }

                                if ($currentCardVfGsm->mailbox != 'KEINE') {
                                    Contract::xmlrow($XMLFile, 6, 'Mailbox', $currentCardVfGsm->mailbox);
                                }

                                if ($currentCardVfGsm->call_barring != 'KEINE') {
                                    Contract::xmlrow($XMLFile, 6, 'Anrufsperre', $currentCardVfGsm->call_barring);
                                }

                                Contract::xmlrow($XMLFile, 6, 'RufnummernAnzeige', $currentCardVfGsm->show_phone_numbers);
                            Contract::xmlclose($XMLFile, 5, 'Dienste');

                            Contract::xmlrow($XMLFile, 5, 'Verbindungsuebersicht', $currentCardVfGsm->connection_overview);

                            // the below rule is from "VF_ePOS_Schnittstellenspezifikation_CreditAktivierung_BSS_27_0_0" page 52
                            if ($currentCardVfGsm->connection_overview != "keine") {
                                Contract::xmlrow($XMLFile, 5, 'Zielrufnummerndarstellung', $currentCardVfGsm->represent_destination_number);
                            }

                            // the below rule is from "VF_ePOS_Schnittstellenspezifikation_CreditAktivierung_BSS_27_0_0" page 45
                            // related codes form "Plausi. für buchbare Tarife" and "Plausi. für buchbare Dienste"
                            if ((in_array("HAPPYZH_1", $currentCardVfGsm->supplementary_services)) or
                                ($currentTariff->tariff_code == "VFZH24FFN") or
                                ($currentTariff->tariff_code == "VFDSLZH1") or
                                ($currentTariff->tariff_code == "VFDSLZH3")){
                                //Eintrag der Zuhauseadresse wenn Dienst aktiviert
                                Contract::xmlopen($XMLFile, 5, 'VFZuhauseAdresse');
                                Contract::xmlrow($XMLFile, 6, 'Strasse', 'Deneme');
                                Contract::xmlrow($XMLFile, 6, 'Hausnummer', 'Deneme');
                                Contract::xmlrow($XMLFile, 6, 'Land', 'D');
                                Contract::xmlrow($XMLFile, 6, 'Postleitzahl', 'Deneme');
                                Contract::xmlrow($XMLFile, 6, 'Ort', 'Deneme');
                                Contract::xmlclose($XMLFile, 5, 'VFZuhauseAdresse');
                            }

                            //Eintrag der Zuhauseadresse wenn Dienst aktiviert
                            if (in_array("BEHINDR_1", $currentCardVfGsm->supplementary_services)) {
                                Contract::xmlopen($XMLFile, 5, 'Behindertennachweis');
                                Contract::xmlrow($XMLFile, 6, 'Behindertenausweis',  $currentCardVfGsm->disabled_card_id);
                                Contract::xmlrow($XMLFile, 6, 'GradDerBehinderung',  $currentCardVfGsm->disability_degree);
                                Contract::xmlclose($XMLFile, 5, 'Behindertennachweis');
                            }
                        Contract::xmlclose($XMLFile, 4, 'GSM');
                    Contract::xmlclose($XMLFile, 3, 'Teilnehmer');

                    $subscriberID++;
                }
            Contract::xmlclose($XMLFile, 2, 'Produkte');
            /** end: Teilnehmer Hauptkarte */
        Contract::xmlclose($XMLFile, 1, 'Aktivierung');

        Contract::xmlclose($XMLFile, 0, 'Auftraege');
    }
    public static function produceXMLForGsmVodafoneContractTRY1($contractID){

        /**
        if($customer->customer_type == 1 or $customer->customor_type == 2){ // private or SoHo customer

        }else if($customer->customer_type == 3 )// Business customer
        {

        }
         *
        $xmlActivateGSM->startElement(''); $xmlActivateGSM->text(XXX); $xmlActivateGSM->endElement(); //
        $xmlActivateGSM->startElement(''); $xmlActivateGSM->endElement(); //
         *
        fwrite($XMLFile, "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
        fwrite($XMLFile, "<Auftraege xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"DEU_ASYNC_ACT_DCS_PCRED_REQ_2018_001.xsd\">\n");
         */


        // Fetch related data from the database...
        $contract = Contract
            ::where('id', $contractID)
            ->first();

        $customer = Customer
            ::where('id', $contract->customer_id)
            ->first();

        $customerContact = CustomerContact
            ::where('customer_id', $customer->id)
            ->first();

        $customerInvoiceAddress = CustomerInvoiceAddress
            ::where('customer_id', $customer->id)
            ->first();

        $customerPaymentTool = CustomerPaymentTool
            ::where('customer_id', $customer->id)
            ->first();

        // there may be mor than one gsm...
        $VfGsm = VfGSM
            ::where('id', $contract->customer_id)
            ->get();


        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;


        $xmlActivateGSM = new \XMLWriter();
        $xmlActivateGSM->openMemory();
        $xmlActivateGSM->startDocument('1,0', 'UTF-8');
        $xmlActivateGSM->startElement('Auftraege');
        $xmlActivateGSM->startAttribute('xmlns:xsi');$xmlActivateGSM->text('http://www.w3.org/2001/XMLSchema-instance');
        $xmlActivateGSM->startAttribute('xsi:noNamespaceSchemaLocation');$xmlActivateGSM->text('DEU_ASYNC_ACT_DCS_PCRED_REQ_2018_001.xsd');

        $xmlActivateGSM->startElement('BatchId'); $xmlActivateGSM->text($contract->id); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 1, BatchId, $enti[ID]);
        $xmlActivateGSM->startElement('Aktivierung');

            $xmlActivateGSM->startElement('AuftragsId'); $xmlActivateGSM->text($contract->id .'-'. $dateTimeString); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 2, AuftragsId, $orderid);
            $xmlActivateGSM->startElement('VOId'); $xmlActivateGSM->text($contract->VO_id); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 2, VOId, $enti[VO]);
            $xmlActivateGSM->startElement('Kundendaten'); //Contract::xmlopen($XMLFile, 2, Kundendaten);

                $xmlActivateGSM->startElement('Privatkunde');// xmlopen($XMLFile, 3, $enti[Kundentyp]);

                    $xmlActivateGSM->startElement('Anrede'); $xmlActivateGSM->text($customer->salutation); $xmlActivateGSM->endElement(); // Contract::xmlrow($XMLFile, 4, Anrede, $enti[Anrede]);
                    $xmlActivateGSM->startElement('Vorname'); $xmlActivateGSM->text($customer->name); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, Vorname, trim($enti[Vorname]));
                    $xmlActivateGSM->startElement('Name'); $xmlActivateGSM->text($customer->surname); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, Name, trim($enti[Name]));
                    $xmlActivateGSM->startElement('Strasse'); $xmlActivateGSM->text($customerContact->street); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Strasse, trim($enti[Strasse]));
                    $xmlActivateGSM->startElement('Hausnummer'); $xmlActivateGSM->text($customerContact->house_number); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Hausnummer, trim($enti[Hausnummer]));
                    $xmlActivateGSM->startElement('Ort'); $xmlActivateGSM->text($customerContact->city); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Ort, trim($enti[Ort]));
                    $xmlActivateGSM->startElement('Land'); $xmlActivateGSM->text('D'); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Land, D);
                    $xmlActivateGSM->startElement('Postleitzahl'); $xmlActivateGSM->text($customerContact->postal_code); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Postleitzahl, trim($enti[PLZ]));
                    $xmlActivateGSM->startElement('Ansprechpartner'); $xmlActivateGSM->text($contract->contact_person); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, Ansprechpartner, trim($enti[Ansprechpartner]));

                    if($customerInvoiceAddress->medium_type == 2){// online invoice
                        $xmlActivateGSM->startElement('EmailAdresse'); $xmlActivateGSM->text($customerContact->email); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, EmailAdresse, trim($enti[Email]));
                    }

                    $xmlActivateGSM->startElement('Geburtsdatum'); $xmlActivateGSM->text($customer->birth_date); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, Geburtsdatum, trim($enti[Geburtsdatum]));

                    if($customer->identity_type == 1){// personal ausweis
                        $xmlActivateGSM->startElement('Personalausweisnummer'); $xmlActivateGSM->text($customer->identity_card_number); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, Personalausweisnummer, trim($enti[Ausweisnummer]));
                    }
                    else if($customer->identity_type == 2){// foreign ausweis
                        $xmlActivateGSM->startElement('AuslaendischeAusweisnummer'); $xmlActivateGSM->text($customer->identity_card_number); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 4, AuslaendischeAusweisnummer, trim($enti[Ausweisnummer]));        }
                    }

                    $xmlActivateGSM->startElement('Kreditkarte'); //xmlopen($XMLFile, 4, Kreditkarte);

                        $xmlActivateGSM->startElement('Kreditkartennummer'); $xmlActivateGSM->text($customerPaymentTool->card_number); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Kreditkartennummer, trim($enti[BankKartenNummer]));
                        $xmlActivateGSM->startElement('GueltigBis'); //xmlopen($XMLFile, 5, GueltigBis);
                            $xmlActivateGSM->startElement('Monat'); $xmlActivateGSM->text($customerPaymentTool->valid_to_month); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 6, Monat, trim($enti[BankKarteGueltigM]));
                            $xmlActivateGSM->startElement('Jahr'); $xmlActivateGSM->text($customerPaymentTool->valid_to_year); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 6, Jahr, trim($enti[BankKarteGueltigJ]));
                        $xmlActivateGSM->endElement(); //Contract::xmlclose($XMLFile, 5, GueltigBis);
                        $xmlActivateGSM->startElement('Kreditinstitut'); $xmlActivateGSM->text($customerPaymentTool->card_credit_institution); $xmlActivateGSM->endElement(); //Contract::xmlrow($XMLFile, 5, Kreditinstitut, trim($enti[BankKartenKreditInstitut]));
                    $xmlActivateGSM->endElement(); //Contract::xmlclose($XMLFile, 4, Kreditkarte);

                $xmlActivateGSM->endElement(); // Private***Contract::xmlclose($XMLFile, 3, $enti[Kundentyp]);
            $xmlActivateGSM->endElement(); // Contract::xmlclose($XMLFile, 2, Kundendaten);
        $xmlActivateGSM->endElement(); //Contract::xmlclose($XMLFile, 1, Aktivierung);
        $xmlActivateGSM->endElement();
        //Contract::xmlclose($XMLFile, 0, Auftraege);
        $xmlActivateGSM->endDocument();

        file_put_contents('C:\xampp\htdocs\UserDefined\XMLs-Tokas\XML-'. $dateTimeString . '.xml', $xmlActivateGSM->outputMemory());
    }
}
