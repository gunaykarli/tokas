<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchestra\Parser\Xml\Facade as XmlParser;



class Contract extends Model
{
    protected $fillable = ['contract_type', 'provider_id', 'customer_id', 'salesperson_id', 'office_id', 'dealer_id', 'VO_id', 'status'];

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

    /** Execution forwarded from ContractController@store */
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
        //$contract->contract_start = $request->contractStartDate;
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

    /** begin: functions group for producing XML file for the contract */
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

        // there may be more than one gsm like additional gsm...
        $mainCardVfGsm = VfGSM
            ::where('contract_id', $contract->id)
            ->where('additional_tariff', 0) // 0 means the tariff is not additional, main.
            ->first();

        // Fetch the VF-GSM with the current contract ID from "VfGsm" table
        $allCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->get();

//dd( $contractID);

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

                Contract::xmlrow($XMLFile, 3, 'Erfassungsdatum', $mainCardVfGsm->contract_start);
            Contract::xmlclose($XMLFile, 2, 'Kundendaten');

            /** begin: Teilnehmer Hauptkarte */
            Contract::xmlopen($XMLFile, 2, 'Produkte');
                $subscriberID = 1;
                foreach ($allCardsVfGsmInTheContract as $currentCardVfGsm){
                    // find the tariff included by the $currentCardVfGsm
                    $currentTariff = Tariff
                        ::where('id', $currentCardVfGsm->tariff_id)
                        ->first();
                    Contract::xmlopen($XMLFile, 3, 'Teilnehmer');
                        Contract::xmlopen($XMLFile, 4, 'GSM');
                            Contract::xmlrow($XMLFile, 5, 'TeilnehmerID', $subscriberID);
                            Contract::xmlopen($XMLFile, 5, 'Simkarte');
                                Contract::xmlrow($XMLFile, 6, 'VFSIMSeriennummer', $currentCardVfGsm->SIM_serial_number);

                                if($currentTariff->tariff_code == 'VFZH24FFN'){
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
                            Contract::xmlrow($XMLFile, 5, 'Vertragsbeginn', $currentCardVfGsm->contract_start);

                            Contract::xmlrow($XMLFile, 5, 'Tarif', $currentTariff->tariff_code);

                            Contract::xmlopen($XMLFile, 5, 'Dienste');
                                foreach($currentCardVfGsm->supplementary_services as $supplementaryService){
                                    Contract::xmlopen($XMLFile, 6, 'Zusatzdienst');
                                        Contract::xmlrow($XMLFile, 7, 'Name', $supplementaryService);
                                    Contract::xmlclose($XMLFile, 6, 'Zusatzdienst');
                                }

                                foreach($currentCardVfGsm->data_services as $dataService){
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
                } // end: foreach ($allCardsVfGsmInTheContract as $currentCardVfGsm)
            Contract::xmlclose($XMLFile, 2, 'Produkte');
            /** end: Teilnehmer Hauptkarte */
        Contract::xmlclose($XMLFile, 1, 'Aktivierung');

        Contract::xmlclose($XMLFile, 0, 'Auftraege');
    }
    /** end: functions group for producing XML file for the contract */


    public static function printVodafoneContract($contractID){
        // Die fpdf Daten werden inkludiert
        include (app_path() . 'public/libraries/pdfPrint/CreditRequestTexte.php');
        include (app_path() . 'public/libraries/pdfPrint/fpdf4credit.php');
        //include (app_path() . 'public/libraries/pdfPrint/fpdi.php');


        // Fetch related data from the database...
        $contract = Contract
            ::where('id', $contractID)
            ->first();

        $tariff = Tariff::find($contract->tariff_id);

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

        // there may be more than one gsm like additional gsm...
        $mainCardVfGsm = VfGSM
            ::where('contract_id', $contract->id)
            ->where('additional_tariff', 0) // 0 means the tariff is not additional, main.
            ->first();

        // Fetch the VF-GSM with the current contract ID from "VfGsm" table
        $allCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->get();

        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        $eins = 1; //Setzen des Startpunktes f�r die Nummerierung der einzelnen Abs�tze
        $zwei = 1;

        if($tariff->code != "VFZH24FFN"){

            //$DocAdresse = getTarif($enti[Tarif], TarifInfoDoc);
            $DocAdresse = "keine";


            if($DocAdresse != "keine"){

                $GLOBALS["festport"] = "ja";

                $pdf = new FPDI();
                $DocAdresse = "../../../" . getTarif($enti[Tarif], TarifInfoDoc);

                $pagecount = $pdf->setSourceFile($DocAdresse);
                $tplidx = $pdf->importPage(1);
                $pdf->addPage();
                $pdf->useTemplate($tplidx);

                $GLOBALS["festport"] = "nein";


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Kopfzeile
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->AddPage(P);
                $pdf->SetMargins(10,22);
                $y=22;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[AuftragsTyp]."\n".$enti[Vertragsbeginn]."\n".$enti[Kundenkennwort]);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetXY(10,$y);
                $pdf->MultiCell(90,2.5,$textAuftragskopf);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Privatkunde
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '.$enti[Kundentyp],1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[Anrede]."\n".''."\n".$enti[Name]."\n".$enti[Vorname]."\n".substr($enti[Geburtsdatum],8,2).".".substr($enti[Geburtsdatum],5,2).".".substr($enti[Geburtsdatum],0,4)."\n".$enti[Ausweisnummer]."\n\n".$enti[BankKartenKreditInstitut]."\n\n".$enti[BankKartenNummer]."\n".$enti[BankKarteGueltigM]." / ".$enti[BankKarteGueltigJ]);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anschrift
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Stra�e:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[Strasse]." ".$enti[Hausnummer]."\n".$enti[PLZ]." ".$enti[Ort]."\n"."0049"." / ".$enti[Kontaktrufnummer]."\n".$enti[Email]."\n".$enti[Ansprechpartner]);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Rechnungsanschrift falls verf�gbar
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if ($enti[AbweichendeRechnungsanschrift]== "JA"){
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Rechnungsanschrift',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(35,3.5,'Name/Firma:'."\n".'Ansprechpartner:'."\n".'Telefon:'."\n".'Stra�e u. Postfach:'."\n".'PLZ, Ort:');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x+42,$y);
                    $pdf->MultiCell(35,3.5,$enti[RechnungVorname]." ".$enti[RechnungNachname]."\n".$enti[RechnungAnsprechpartner]."\n"."049 / / "."\n".$enti[RechnungStrasse].' '.$enti[RechnungHausnummer]."\n".$enti[RechnungPLZ].' '.$enti[RechnungOrt]);

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Papier Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Papier Rechnung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,$textPapierRechnung."\n\n");

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Online Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if($enti[RechnungsArt]==NurOnline){
                    $eins++;
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Online Rechnung',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,3.0,$textOnlineRechnung."\n\n");

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Bankverbindung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Bankverbindung/Auskunfts-/Einzugserm�chtigung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                if($enti[IBAN] == ""){
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'Konto Nr.:'."\n".'BLZ:'."\n".'Verwendungszweck:');
                }else{
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'IBAN:'."\n".'BIC:'."\n".'Verwendungszweck:');
                }

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                if($enti[IBAN] == ""){
                    $pdf->MultiCell(35,3.5,' '."\n".$enti[Kontonummer]."\n".$enti[Bankleitzahl]."\n".'Vodafone Rechnung');
                }else{
                    $pdf->MultiCell(50,3.5,' '."\n".$enti[IBAN]."\n".$enti[BIC]."\n".'Vodafone Rechnung');
                }

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textAbbuchungserlaubnis1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textBestaetigt);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textAbbuchungserlaubnis2);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,'Datum: '.$Date."\n".'Unterschrift des '."\n".'Kontoinhabers:       X___________________'."\n".'Name:                          '.$enti[Kontoinhaber]);
                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Auftrag f�r Vodafone Dienstleistungen
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Auftrag f�r Vodafone-D2-Dienstleistungen',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,"Anzahl der Vodafone-Karten insgesamt: ".$gesamtkarten."\ndavon im Tarif \n");
                $y=$pdf->GetY()+1;


                //Erste Karte aus Hauptdatensatz nehmen
                $kartenart[0] = $enti;

                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);
                }


                //Schleife durchl�uft Hauptkarte + alle Mehrkarten
                for ($j=0;$j<$gesamtkarten;$j++){

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);

                    $rechtliches = explode (",", getTarif($kartenart[$j][Tarif], Rechtstexte));
                    $textanzahl = count ($rechtliches);

                    $bar = 2;
                    for ($foo=0;$foo<$textanzahl;$foo++){
                        if ($$rechtliches[$foo]){
                            $bar++;
                        }
                    }

                    for ($i=1; $i<$bar; $i++){
                        if ($i != $bar-1){
                            $exponenttext .= $i . ",";
                        }else{
                            $exponenttext .= $i;
                        }
                    }

                    if(($kartenart[$j][Tarif]=="FLATSFFOS")||($kartenart[$j][Tarif]=="FLATSFFMS")||($kartenart[$j][Tarif]=="DFLATSFFO")||($kartenart[$j][Tarif]=="DFLATSFFM"))$ZusatzBlattVFV="JA";

                    /*
                     ------------------------------------------------------------------
                     -DER HINZUGEF�GTE CODEABSCHNITT F�R TARIF RED S SPEZIAL (SIM ONLY)-
                     */
                    if ($kartenart[$j][Tarif]=="DPAASOS"){
                        if ($enti[VO]=="80855791"){

                        }elseif($enti[VO]=="80210035"){

                        }elseif($enti[VO]=="30855553"){

                        }elseif($enti[VO]=="80855786"){

                        }elseif($enti[VO]=="80855789"){

                        }else{
                            $enti[VO] = "80215378";
                        }
                    }
                    //------------------------------------------------------------------

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->Write(3.5,$RichtigeTarifName." ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->subWrite(3.5, $exponenttext, '', 5, 4);
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Write(3.5,"\n");
                    $pdf->Write(3.5,"1 Karte, Serien-Nummer: ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->Write(3.5,$kartenart[$j][Sim]."\n");


                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $pdf->Cell(3,2.5,"1) ",0,L);
                    $pdf->MultiCell(90,2.5,$textTarifMindestlaufzeit);
                    $y=$pdf->GetY()+1;

                    /*
                     for ($rechtszaehler=0;$rechtszaehler<$textanzahl;$rechtszaehler++){

                        $y=$pdf->GetY()+1;

                        $pdf->SetFont('Arial','',7);
                        $pdf->SetY($y);

                        if ($$rechtliches[$rechtszaehler]){

                        $pdf->Cell(3,2.5,$rechtszaehler+2 .") ",0,L);
                        $pdf->MultiCell(90,2.5,$$rechtliches[$rechtszaehler],0,L);
                        $y=$pdf->GetY()+1;
                        }
                        }
                        */

                    $rechtReiheA = 2;
                    foreach ($rechtliches as $key => $value){
                        $RechtsText = getRecht($value);
                        if($RechtsText){
                            $pdf->Cell(3,2.5,"$rechtReiheA) ",0,L);
                            $pdf->MultiCell(90,2.5,$RechtsText,0,L);
                            $y=$pdf->GetY()+1;
                            $rechtReiheA++;
                        }
                    }

                    $y=$pdf->GetY()+1;
                }


                $pdf->SetFont('Arial','B',7.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,"Etwaige gebuchte Zusatzdienste/Tarifoptionen gem�� Anlage f�r Zusatzdienste\nSonstige Bemerkungen:");
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Verbindungs�bersicht / Nutzung von Daten
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Verbindungs�bersicht/Nutzung von Daten',1);
                $y=$pdf->GetY()+1;
                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,$textVerbindungs�bersicht,0,L);

                $y=$pdf->GetY()+1;

                if ($enti[Werbeverweigerung]!='JA'){
                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $y = $pdf->GetY();
                    if ($y>222)$pdf->ManualPageBreak();
                    $pdf->MultiCell(90,2.5,$textWerbebereitschaft,1,L);

                    $y=$pdf->GetY();
                }

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $y = $pdf->GetY();
                if ($y>222)$pdf->ManualPageBreak();
                $pdf->MultiCell(90,2.5,$textBeauftragung,1,L);
                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vertriebsorganisation
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Vertriebsorganisation',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->Write(3.0,"VO-Nummer: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$enti[VO]."\nWir best�tigen hiermit die Richtigkeit der Kundenangaben\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->Write(3.0,"Datum: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$Date."\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->MultiCell(90,3.0,"Unterschrift der \nVertriebsorganisation:                 __________________________");

                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anlage f�r Zusatzdienste
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $normal="JA";
                $pdf->AddPage(P);
                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',9);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.0,"Anlage f�r Zusatzdienste und \nzum Eintrag in Telefon-/Telefaxverzeichnisse und zur Auskunftserteilung",1,C);


                $y=$pdf->GetY()+5;
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Kunden-Name: ".$enti[Vorname]." ".$enti[Name]."                                                   Kundenauftrag vom: ".substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4)."\nKunden-Nr.:",0,L);


                $y=$pdf->GetY()+5;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $y=$pdf->GetY()+10;

                //Tabellenkopf schreiben
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(50,4.5,'Seriennummer',1);
                $pdf->SetXY($x+50,$y);
                $LineBegin=$pdf->GetY();
                $pdf->MultiCell(130,4.5,"Zus�tzliche Informationen zu den Karten\n",1);
                $aufzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen
                $hochzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen


                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $kartenart[0] = $enti; //Erste Karte aus Hauptdatensatz nehmen


                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);

                }

                for ($j=0;$j<$gesamtkarten;$j++){ //Schleife durchl�uft Hauptkarte + alle Mehrkarten

                    $pdf->SetFont('Arial','',8.5);
                    $y=$pdf->GetY();
                    $pdf->SetXY($x,$y);

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->MultiCell(50,4.5,$kartenart[$j][Sim]."\n".$RichtigeTarifName."\n\n\n\n\n\n\n",L,L);
                    //Dienste in Rohfassung aus der Datenbank lesen und in Array schreiben
                    $Datendienste = explode (",", $kartenart[$j][Datendienste]);
                    $DaNum = count($Datendienste);
                    $WeitereDienste = explode (",", $kartenart[$j][WeitereDienste]);
                    $WeNum = count($WeitereDienste);
                    $DienstNamen = "";

                    //Konstrukt um die Mailbox als Dienst anzuzeigen
                    if ($kartenart[$j][Mailbox]!='KEINE'){
                        $DienstNamen = getSonderdienst($kartenart[$j][Mailbox], DienstName);

                    }
                    $RechteArray = array();

                    //Dienstnamen aufl�sen und in Variable schreiben
                    for ($i=1;$i<$DaNum;$i++){
                        $DienstNamen = $DienstNamen . ", ". getSonderdienst($Datendienste[$i], DienstName);
                        $RTA= count(explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }
                    for ($i=1;$i<$WeNum;$i++){
                        if($WeitereDienste[$i] == "NOACTFEE" || $WeitereDienste[$i] == "MRKBEGSAP" || $WeitereDienste[$i] == "NOACFEDAT"){
                            $DienstNamen = $DienstNamen . ", Anschlusspreisbefreiung";
                        }else if($WeitereDienste[$i] == "YOUAGEVAL"){
                            $DienstNamen = $DienstNamen . ", VF Young check on age";
                        }else if($WeitereDienste[$i] == "YOUABIAGE"){
                            $DienstNamen = $DienstNamen . ", VF Young f�r Minderj�hrige";
                        }else if($WeitereDienste[$i]=="PYPCHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPSOCIAL"){ $DienstNamen = $DienstNamen . "Social Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PACHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PASOCIAL"){ 	$DienstNamen = $DienstNamen . "Social Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 10 Euro/Mon., ";
                        }else{
                            $DienstNamen = $DienstNamen . ", ". getSonderdienst($WeitereDienste[$i], DienstName);
                        }
                        $RTA= count(explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));

                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }


                    $RechtsTextAnzahl = count($RechteArray);
                    for ($i=0;$i<=$RechtsTextAnzahl;$i++){
                        if (strlen($$RechteArray[$i])>1){
                            $RechteBlaBla = $RechteBlaBla . "\n\n".$aufzaehler++ .") ". $$RechteArray[$i];
                        }
                    }

                    //Pflichtdienste aufschl�sseln und in Array schreiben
                    $Tarifpflichten=explode(",", getTarif($kartenart[$j][Tarif], Pflichten));
                    $vertragsbedingungen = "";
                    $zaehler = 1;

                    //Zuhause Adresse in Variable schreiben wenn Dienst aktiviert ist
                    if (in_array("HAPPYZH_1", $WeitereDienste)){
                        $ZuhauseAdresse = "Zuhause-Adresse: Der ZuhauseBereich soll f�r Ihre im folgenden aufgef�hrte Adresse eingerichtet werden.\nStrasse                 ".$kartenart[$j][ZuhauseStrasse]." ".$kartenart[$j][ZuhauseHausnummer]."\nPLZ, Ort               ".$kartenart[$j][ZuhausePLZ]." ".$kartenart[$j][ZuhauseOrt];

                        if (in_array("HAPPYZH_1", $Tarifpflichten)){
                            $vertragsbedingungen = "";
                        }
                        else{
                            $vertragsbedingungen = $zaehler++.")".$textDienstZuhauseOption1."\n\n".$zaehler++.")".$textDienstZuhauseOption2."\n\n";
                        }
                    }

                    else {
                        $ZuhauseAdresse = "";
                    }


                    $pdf->SetXY($x+50,$y);
                    $pdf->MultiCell(130,4.5,"Grundgeb�hr: ".$kartenart[$j][GG]." Euro \nZusatzdienste / Tarifoptionen: ".$DienstNamen."\nAnrufsperren: ".getSonderdienst($kartenart[$j][Anrufsperre], DienstName)."\nVertragsbeginn: ".DateChanger($kartenart[$j][Vertragsbeginn])."\nZus�tzliche Vertragsbedingungen:\n".$vertragsbedingungen.$RechteBlaBla."\n\nVerbindungs�bersich: ".$kartenart[$j][Verbindungsuebersicht]."\nMobilfunknummernanzeige: ".getSonderdienst($kartenart[$j][RufNummerUebermittlung], DienstName)."\nTeilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".$ZuhauseAdresse,1,L);


                    //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                    $y=$pdf->GetY();
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,60,$y);
                    $pdf->Line(10,$LineBegin,10,$y);

                }


                $y=$pdf->GetY()+20;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Datum: ".$Date."                                                                            Datum:".$Date,0,L);

                $y=$pdf->GetY()+20;

                //Unterschrift von Allen
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Stempel/\nUnterschrift\ndes H�ndlers   ___________________________________\n                          Wir best�tigen hiermit die\n                          Richtigkeit der Kundenangaben",0,L);

                $pdf->SetXY($x+90,$y);
                $pdf->MultiCell(180,4.5,"\nUnterschrift\ndes Kunden   ___________________________________",0,L);


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone Stars
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if ($enti[Stars]=='JA'){

                    if (($enti[StarsWerbungSMS]=='perSMS')||($enti[StarsWerbungEmail]=='perEmail'))$Werbung="X";ELSE $Werbung=" ";
                    if ($enti[StarsWerbungSMS]=='perSMS')$perSMS="X";ELSE $perSMS=" ";
                    if ($enti[StarsWerbungEmail]=='perEmail')$perEmail="X";ELSE $perEmail=" ";

                    $pdf->AddPage(P);

                    $pdf->SetFont('Arial','',10);
                    $pdf->SetXY(10,10);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars');

                    $x=10;
                    $y=25;

                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars - Gleich mitmachen und anmelden!');

                    $y=$pdf->GetY()+4;

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Steigen Sie ein bei Vodafone-Stars, sammeln sie Punkte und tauschen Sie diese gegen Top-Pr�mien ein!');

                    $y=$pdf->GetY()+4;


                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone-Handy-Nummer:                                                                    [] CallYa        [X] Laufzeitvertrag');

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Ich nutze das Handy �berwiegend');

                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'(Angabe freiwillig)');

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"[X]\n\n\n[".$Werbung."]\n\n\n\n[X]");

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,"Ja, ich will mit der oben genannten Rufnummer bei Vodafone-Stars mitmachen, Punkte sammeln und gegen attraktive Pr�mien einl�sen.\n\nJa, ich will regelm��ig �ber Neuigkeiten bei Vodafone-Stars informiert werden.\n[".$perEmail."]  per Email\n[".$perSMS."]  per SMS\n\nJa, ich akzeptiere die Teilnahmebedingungen von Vodafone Stars.");
                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,'(Diese k�nnen in den Verkaufsr�umen eingesehen werden, im Internet unter www.vodafone.de/vodafonestars und �ber Vodafone-InfoFax Nr. 365 abgerufen sowie unter der Service Nr. 22 44 99 kostenlos aus dem VF D2-Netz abgeh�rt werden)');

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Einwilligung zur Nutzung meiner Bestands- und Verbindungsdaten");

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Ich willige - jetzt widerruflich - darin ein, dass Vodafone D2\n- meine Verkehrsdaten (Daten, die bei der Bereitstellung und Erbringung von Telekommunikationsdienstleistungen erhoben werden) zur Vermarktung und bedarfsgerechten Gestaltung von Vodafone-Telekommunikationsdienstleistungen oder zur Bereitstellung von Diensten mit Zusatznutzen f�r l�ngstens 6 Monate nach Rechnungsversand speichert, verarbeitet und nutzt;\n- mich zu Werbezwecken (auch automatisiert) anruft oder mir per Telefax oder in Form elektronischer nachrichten Werbung zusendet und\n- meine Bestandsdaten (Daten, die erhoben werden, um das Vertragsverh�ltnis einschlie�lich seiner inhaltlichen Ausgestaltung zu begr�nden oder zu �ndern) verarbeitet und nutzt, soweit dies zur Kundenberatung, Werbung und Marktforschung erforderlich ist.\n\nOhne Einwilligung bleiben etwaige gesetzliche Werbebeschr�nkungen bestehen.\n\nDatum:                                     ".$Date."\nUnterschrift des                        x\nAuftraggebers:                         __________________________________________\nName in Druckbuchstaben                    ",1);
                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Sofern unten ein abweichender Nutzer der Vodafone-Karte eingetragen ist, wird dieser anstatt des Vertragspartners der oben genannten Rufnummer als Teilnehmer von Vodafone-Stars registriert. Ich erteile hiermit meine Zustimmung, dass statt mir selbst der Nutzer Teilnehmer von Vodafone-Stars wird.");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Unterschrift des Vertragspartners,                              Datum\nder oben genannten Rufnummer\n\nVor-/Nachname\nin Druckbuchstaben");

                    $y=$pdf->GetY()+2;
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,205,$y);

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Adresse des Nutzers der Vodafone-Karte");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3,"Vor-/Nachname\nggf. Firma\n\nStra�e, Nr.\n\nPLZ, Ort\n\nE-Mail\n\nGeburtsdatum");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Mir ist bekannt, dass meine mit der Teilnahme verbundenen personenbezogenen Daten gem�� den geltenden Datenschutzbestimmungen verarbeitet und nur f�r Zwecke der Durchf�hrung des Programms Vodafone-Stars genutzt werden");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date."                              VO-ID: ".$enti[VO]);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Unterschrift des Nutzers,                                            Datum                                             (Eintrag erfolgt durch Vodafone-D2)\nfalls abweichend vom Vertragspartner");

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Mehr Infos zu Vodafone-Stars gibt's unter 22 44 88 oder im Internet unter www.vodafone.de/vodafonestars.\n................................................................................................................................................................................................................");

                    $y=$pdf->GetY();
                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Bitte vollst�ndig ausf�llen und unterschrieben zur�ckfaxen an:               [X]Teilnehmer wurde bereits �ber Vodafone-ePOS-Direct-Import Client angemeldet!\nVodafone D2 GmbH, Abteilung VCS, Fax: 0 21 02 / 98 65 75 ");

                }

            }
            else{

                //*********************************************************************************************************************
                //*********************************************************************************************************************
                //*********************************************************************************************************************

                $pdf=new \FPDI();
                $pdf->SetMargins(10,22);
                $pdf->AddPage();


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Kopfzeile
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //$pdf->Image('Images/vf_logo.png', 145,5);

                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[AuftragsTyp]."\n".$enti[Vertragsbeginn]."\n".$enti[Kundenkennwort]);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetXY(10,$y);
                $pdf->MultiCell(90,2.5,$textAuftragskopf);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Privatkunde
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '.$enti[Kundentyp],1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');
                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[Anrede]."\n".''."\n".$enti[Name]."\n".$enti[Vorname]."\n".substr($enti[Geburtsdatum],8,2).".".substr($enti[Geburtsdatum],5,2).".".substr($enti[Geburtsdatum],0,4)."\n".$enti[Ausweisnummer]."\n\n".$enti[BankKartenKreditInstitut]."\n\n".$enti[BankKartenNummer]."\n".$enti[BankKarteGueltigM]." / ".$enti[BankKarteGueltigJ]);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anschrift
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Stra�e:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(60,3.7,$enti[Strasse]." ".$enti[Hausnummer]."\n".$enti[PLZ]." ".$enti[Ort]."\n"."0049"." / ".$enti[Kontaktrufnummer]."\n".$enti[Email]."\n".$enti[Ansprechpartner]);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Zuhause Adresse falls verf�gbar
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /*Seit Version 3.2 nicht mehr verf�gbar
                $ZuhauseDienstCheck = explode (",", $enti[WeitereDienste]);
                if (($enti[ZuhauseAdresse] == 'OTHER') && (in_array("HAPPYZH_1", $ZuhauseDienstCheck))){
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Zuhause-Adresse',1);
                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(35,3.5,'Stra�e:'."\n".'PLZ, Ort:');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x+38,$y);
                    $pdf->MultiCell(35,3.5,$enti[ZuhauseStrasse]." ".$enti[ZuhauseHausnummer]."\n".$enti[ZuhausePLZ]." ".$enti[ZuhauseOrt]);
                    $y=$pdf->GetY()+1;
                    }
                if (umbruch($x, $y)=='spalte'){
                    $x=115;
                    $y=22;
                    }
                if (umbruch($x, $y)=='seite'){
                    $x=10;
                    $y=22;
                    $pdf->AddPage(P);
                $pdf->CreditHead();
                    }
                */


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Rechnungsanschrift falls verf�gbar
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if ($enti[AbweichendeRechnungsanschrift]== "JA"){
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Rechnungsanschrift',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(35,3.5,'Name/Firma:'."\n".'Ansprechpartner:'."\n".'Telefon:'."\n".'Stra�e u. Postfach:'."\n".'PLZ, Ort:');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x+42,$y);
                    $pdf->MultiCell(35,3.5,$enti[RechnungVorname]." ".$enti[RechnungNachname]."\n".$enti[RechnungAnsprechpartner]."\n"."049 / / "."\n".$enti[RechnungStrasse].' '.$enti[RechnungHausnummer]."\n".$enti[RechnungPLZ].' '.$enti[RechnungOrt]);

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Papier Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Papier Rechnung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,$textPapierRechnung."\n\n");

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Online Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if($enti[RechnungsArt]==NurOnline){
                    $eins++;
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Online Rechnung',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,3.0,$textOnlineRechnung."\n\n");

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Bankverbindung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Bankverbindung/Auskunfts-/Einzugserm�chtigung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                if($enti[IBAN] == ""){
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'Konto Nr.:'."\n".'BLZ:'."\n".'Verwendungszweck:');
                }else{
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'IBAN:'."\n".'BIC:'."\n".'Verwendungszweck:');
                }

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                if($enti[IBAN] == ""){
                    $pdf->MultiCell(35,3.5,' '."\n".$enti[Kontonummer]."\n".$enti[Bankleitzahl]."\n".'Vodafone Rechnung');
                }else{
                    $pdf->MultiCell(50,3.5,' '."\n".$enti[IBAN]."\n".$enti[BIC]."\n".'Vodafone Rechnung');
                }

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textAbbuchungserlaubnis1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textBestaetigt);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textAbbuchungserlaubnis2);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,'Datum: '.$Date."\n".'Unterschrift des '."\n".'Kontoinhabers:       X___________________'."\n".'Name:                          '.$enti[Kontoinhaber]);
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Auftrag f�r Vodafone Dienstleistungen
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Auftrag f�r Vodafone-D2-Dienstleistungen',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,"Anzahl der Vodafone-Karten insgesamt: ".$gesamtkarten."\ndavon im Tarif \n");
                $y=$pdf->GetY()+1;


                //Erste Karte aus Hauptdatensatz nehmen
                $kartenart[0] = $enti;

                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);
                }

                //Schleife durchl�uft Hauptkarte + alle Mehrkarten
                for ($j=0;$j<$gesamtkarten;$j++){

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);

                    $rechtliches = explode (",", getTarif($kartenart[$j][Tarif], Rechtstexte));
                    $textanzahl = count ($rechtliches);

                    $bar = 2;
                    for ($foo=0;$foo<$textanzahl;$foo++){
                        if ($$rechtliches[$foo]){
                            $bar++;
                        }
                    }

                    for ($i=1; $i<$bar; $i++){
                        if ($i != $bar-1){
                            $exponenttext .= $i . ",";
                        }else{
                            $exponenttext .= $i;
                        }
                    }

                    if(($kartenart[$j][Tarif]=="FLATSFFOS")||($kartenart[$j][Tarif]=="FLATSFFMS")||($kartenart[$j][Tarif]=="DFLATSFFO")||($kartenart[$j][Tarif]=="DFLATSFFM"))$ZusatzBlattVFV="JA";

                    /*
                    ------------------------------------------------------------------
                    -DER HINZUGEF�GTE CODEABSCHNITT F�R TARIF RED S SPEZIAL (SIM ONLY)-
                    */
                    if ($kartenart[$j][Tarif]=="DPAASOS"){
                        if ($enti[VO]=="80855791"){

                        }elseif($enti[VO]=="80210035"){

                        }elseif($enti[VO]=="30855553"){

                        }elseif($enti[VO]=="80855786"){

                        }elseif($enti[VO]=="80855789"){

                        }else{
                            $enti[VO] = "80215378";
                        }
                    }
                    //------------------------------------------------------------------

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->Write(3.5,$RichtigeTarifName." ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->subWrite(3.5, $exponenttext, '', 5, 4);
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Write(3.5,"\n");
                    $pdf->Write(3.5,"1 Karte, Serien-Nummer: ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->Write(3.5,$kartenart[$j][Sim]."\n");


                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $pdf->Cell(3,2.5,"1) ",0,L);
                    $pdf->MultiCell(90,2.5,$textTarifMindestlaufzeit);
                    $y=$pdf->GetY()+1;

                    /*
                    for ($rechtszaehler=0;$rechtszaehler<$textanzahl;$rechtszaehler++){

                        //$y=$pdf->GetY()+1;

                        $pdf->SetFont('Arial','',7);
                        $pdf->SetY($y);

                        if ($$rechtliches[$rechtszaehler]){
                            $pdf->Cell(3,2.5,$rechtszaehler+2 .") ",0,L);
                            $pdf->MultiCell(90,2.5,$$rechtliches[$rechtszaehler],0,L);
                            $y=$pdf->GetY()+1;
                        }

                    }
                    */

                    $rechtReihe = 2;
                    foreach ($rechtliches as $key => $value){
                        $RechtsText = getRecht($value);
                        if($RechtsText){
                            $pdf->Cell(3,2.5,"$rechtReihe) ",0,L);
                            $pdf->MultiCell(90,2.5,$RechtsText,0,L);
                            $y=$pdf->GetY()+1;
                            $rechtReihe++;
                        }
                    }

                    $y=$pdf->GetY()+1;
                }


                $pdf->SetFont('Arial','B',7.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,"Etwaige gebuchte Zusatzdienste/Tarifoptionen gem�� Anlage f�r Zusatzdienste\nSonstige Bemerkungen:");
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Verbindungs�bersicht / Nutzung von Daten
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Verbindungs�bersicht/Nutzung von Daten',1);
                $y=$pdf->GetY()+1;
                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,$textVerbindungs�bersicht,0,L);

                $y=$pdf->GetY()+1;

                if ($enti[Werbeverweigerung]!='JA'){
                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $y = $pdf->GetY();
                    if ($y>222)$pdf->ManualPageBreak();
                    $pdf->MultiCell(90,2.5,$textWerbebereitschaft,1,L);

                    $y=$pdf->GetY();
                }

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $y = $pdf->GetY();
                if ($y>222)$pdf->ManualPageBreak();
                $pdf->MultiCell(90,2.5,$textBeauftragung,1,L);
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Ihr Vodafone Kundennummern
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                /*
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Ihre Vodafone-Kunden-Nummern:',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,$textVodafoneNummer,0,L);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,"Kunden-Nummern: ".$enti[Kundennummer]."\nIch habe meine Vodafone-Karte(n) und die g�ltige(n) Preisliste(n) erhalten.\n\nDatum: ".$Date."\nUnterschrift:             X_______________________________");

                $y=$pdf->GetY()+1;
                */

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vertriebsorganisation
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Vertriebsorganisation',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->Write(3.0,"VO-Nummer: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$enti[VO]."\nWir best�tigen hiermit die Richtigkeit der Kundenangaben\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->Write(3.0,"Datum: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$Date."\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->MultiCell(90,3.0,"Unterschrift der \nVertriebsorganisation:                 __________________________");

                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anlage f�r Zusatzdienste
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $normal="JA";
                $pdf->AddPage(P);
                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',9);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.0,"Anlage f�r Zusatzdienste und \nzum Eintrag in Telefon-/Telefaxverzeichnisse und zur Auskunftserteilung",1,C);

                /*
                $y=$pdf->GetY()+5;
                $x=10;
                $pdf->SetX($x);
                $pdf->SetY($y);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Write(4.0,"Kunden-Name:");
                $x=$pdf->GetX()+20;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Write(4.0,$enti[Vorname]." ".$enti[Name]);

                $x=$pdf->GetX()+70;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Write(4.0,"Kundenauftrag vom:");
                $x=$pdf->GetX()+15;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Write(4.0,substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4));

                $x=10;
                $y=27;
                $pdf->SetXY($x,$y);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Write(4.0,"Kunden-Nr.:");
                $x=$pdf->GetX()+20;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Write(4.0,$enti[Vorname]);

                $x=10;
                $y=27;
                $pdf->SetXY($x,$y);
                */


                $y=$pdf->GetY()+5;
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Kunden-Name: ".$enti[Vorname]." ".$enti[Name]."                                                   Kundenauftrag vom: ".substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4)."\nKunden-Nr.:",0,L);


                $y=$pdf->GetY()+5;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $y=$pdf->GetY()+10;

                //Tabellenkopf schreiben
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(50,4.5,'Seriennummer',1);
                $pdf->SetXY($x+50,$y);
                $LineBegin=$pdf->GetY();
                $pdf->MultiCell(130,4.5,"Zus�tzliche Informationen zu den Karten\n",1);
                $aufzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen
                $hochzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen


                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $kartenart[0] = $enti; //Erste Karte aus Hauptdatensatz nehmen


                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);

                }

                for ($j=0;$j<$gesamtkarten;$j++){ //Schleife durchl�uft Hauptkarte + alle Mehrkarten

                    $pdf->SetFont('Arial','',8.5);
                    $y=$pdf->GetY();
                    $pdf->SetXY($x,$y);

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->MultiCell(50,4.5,$kartenart[$j][Sim]."\n".$RichtigeTarifName."\n\n\n\n\n\n\n",L,L);
                    //Dienste in Rohfassung aus der Datenbank lesen und in Array schreiben
                    $Datendienste = explode (",", $kartenart[$j][Datendienste]);
                    $DaNum = count($Datendienste);
                    $WeitereDienste = explode (",", $kartenart[$j][WeitereDienste]);
                    $WeNum = count($WeitereDienste);
                    $DienstNamen = "";


                    //Konstrukt um die Mailbox als Dienst anzuzeigen
                    if ($kartenart[$j][Mailbox]!='KEINE'){
                        $DienstNamen = getSonderdienst($kartenart[$j][Mailbox], DienstName);

                    }
                    $RechteArray = array();

                    //Dienstnamen aufl�sen und in Variable schreiben
                    for ($i=1;$i<$DaNum;$i++){
                        $DienstNamen = $DienstNamen . ", ". getSonderdienst($Datendienste[$i], DienstName);
                        $RTA= count(explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }

                    for ($i=1;$i<$WeNum;$i++){
                        if($WeitereDienste[$i] == "NOACTFEE" || $WeitereDienste[$i] == "MRKBEGSAP" || $WeitereDienste[$i] == "NOACFEDAT"){
                            $DienstNamen = $DienstNamen . ", Anschlusspreisbefreiung";
                        }else if($WeitereDienste[$i] == "YOUAGEVAL"){
                            $DienstNamen = $DienstNamen . ", VF Young check on age";
                        }else if($WeitereDienste[$i] == "YOUABIAGE"){
                            $DienstNamen = $DienstNamen . ", VF Young f�r Minderj�hrige";
                        }else if($WeitereDienste[$i]=="PYPCHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPSOCIAL"){ $DienstNamen = $DienstNamen . "Social Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PACHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PASOCIAL"){ 	$DienstNamen = $DienstNamen . "Social Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 10 Euro/Mon., ";
                        }else{
                            $DienstNamen = $DienstNamen . ", ". getSonderdienst($WeitereDienste[$i], DienstName);
                        }
                        $RTA= count(explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));

                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }





                    $RechtsTextAnzahl = count($RechteArray);
                    for ($i=0;$i<=$RechtsTextAnzahl;$i++){
                        if (strlen($$RechteArray[$i])>1){
                            $RechteBlaBla = $RechteBlaBla . "\n\n".$aufzaehler++ .") ". $$RechteArray[$i];
                        }
                    }



                    //Pflichtdienste aufschl�sseln und in Array schreiben
                    $Tarifpflichten=explode(",", getTarif($kartenart[$j][Tarif], Pflichten));
                    $vertragsbedingungen = "";
                    $zaehler = 1;

                    //Zuhause Adresse in Variable schreiben wenn Dienst aktiviert ist
                    if (in_array("HAPPYZH_1", $WeitereDienste)){
                        $ZuhauseAdresse = "Zuhause-Adresse: Der ZuhauseBereich soll f�r Ihre im folgenden aufgef�hrte Adresse eingerichtet werden.\nStrasse                 ".$kartenart[$j][ZuhauseStrasse]." ".$kartenart[$j][ZuhauseHausnummer]."\nPLZ, Ort               ".$kartenart[$j][ZuhausePLZ]." ".$kartenart[$j][ZuhauseOrt];

                        if (in_array("HAPPYZH_1", $Tarifpflichten)){
                            $vertragsbedingungen = "";
                        }
                        else{
                            $vertragsbedingungen = $zaehler++.")".$textDienstZuhauseOption1."\n\n".$zaehler++.")".$textDienstZuhauseOption2."\n\n";
                        }
                    }

                    else {
                        $ZuhauseAdresse = "";
                    }



                    /*

                    if (in_array("VFZHMFLAT", $WeitereDienste)){
                        $vertragsbedingungen = $vertragsbedingungen. $zaehler++.") ".$textDienstZuhauseFlatrate1."\n\n".$zaehler++.") ".$textDienstZuhauseFlatrate2."\n\n";
                            }

                    if (in_array("VFZHINTFL", $WeitereDienste)){
                        $vertragsbedingungen =$vertragsbedingungen. $zaehler++.")".$textDienstHappyInternational1."\n\n".$zaehler++.") ".$textDienstHappyInternational2."\n\n";
                        }

                    if (in_array("STUDRAB", $WeitereDienste)){
                        $vertragsbedingungen =$vertragsbedingungen. $zaehler++.")".$textDienstStudentenrabatt."\n\n";
                        }


                    */








                    $pdf->SetXY($x+50,$y);
                    $pdf->MultiCell(130,4.5,"Grundgeb�hr: ".$kartenart[$j][GG]." Euro \nZusatzdienste / Tarifoptionen: ".$DienstNamen."\nAnrufsperren: ".getSonderdienst($kartenart[$j][Anrufsperre], DienstName)."\nVertragsbeginn: ".DateChanger($kartenart[$j][Vertragsbeginn])."\nZus�tzliche Vertragsbedingungen:\n".$vertragsbedingungen.$RechteBlaBla."\n\nVerbindungs�bersich: ".$kartenart[$j][Verbindungsuebersicht]."\nMobilfunknummernanzeige: ".getSonderdienst($kartenart[$j][RufNummerUebermittlung], DienstName)."\nTeilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".$ZuhauseAdresse,1,L);





                    //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                    $y=$pdf->GetY();
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,60,$y);
                    $pdf->Line(10,$LineBegin,10,$y);





                }





                $y=$pdf->GetY()+20;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Datum: ".$Date."                                                                            Datum:".$Date,0,L);


                $y=$pdf->GetY()+20;



                //Unterschrift von Allen
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Stempel/\nUnterschrift\ndes H�ndlers   ___________________________________\n                          Wir best�tigen hiermit die\n                          Richtigkeit der Kundenangaben",0,L);

                $pdf->SetXY($x+90,$y);
                $pdf->MultiCell(180,4.5,"\nUnterschrift\ndes Kunden   ___________________________________",0,L);


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone Stars
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if ($enti[Stars]=='JA'){

                    if (($enti[StarsWerbungSMS]=='perSMS')||($enti[StarsWerbungEmail]=='perEmail'))$Werbung="X";ELSE $Werbung=" ";
                    if ($enti[StarsWerbungSMS]=='perSMS')$perSMS="X";ELSE $perSMS=" ";
                    if ($enti[StarsWerbungEmail]=='perEmail')$perEmail="X";ELSE $perEmail=" ";






                    $pdf->AddPage(P);


                    $pdf->SetFont('Arial','',10);
                    $pdf->SetXY(10,10);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars');





                    $x=10;
                    $y=25;

                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars - Gleich mitmachen und anmelden!');

                    $y=$pdf->GetY()+4;

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Steigen Sie ein bei Vodafone-Stars, sammeln sie Punkte und tauschen Sie diese gegen Top-Pr�mien ein!');

                    $y=$pdf->GetY()+4;


                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone-Handy-Nummer:                                                                    [] CallYa        [X] Laufzeitvertrag');

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Ich nutze das Handy �berwiegend');

                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'(Angabe freiwillig)');

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"[X]\n\n\n[".$Werbung."]\n\n\n\n[X]");

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,"Ja, ich will mit der oben genannten Rufnummer bei Vodafone-Stars mitmachen, Punkte sammeln und gegen attraktive Pr�mien einl�sen.\n\nJa, ich will regelm��ig �ber Neuigkeiten bei Vodafone-Stars informiert werden.\n[".$perEmail."]  per Email\n[".$perSMS."]  per SMS\n\nJa, ich akzeptiere die Teilnahmebedingungen von Vodafone Stars.");
                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,'(Diese k�nnen in den Verkaufsr�umen eingesehen werden, im Internet unter www.vodafone.de/vodafonestars und �ber Vodafone-InfoFax Nr. 365 abgerufen sowie unter der Service Nr. 22 44 99 kostenlos aus dem VF D2-Netz abgeh�rt werden)');

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Einwilligung zur Nutzung meiner Bestands- und Verbindungsdaten");

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Ich willige - jetzt widerruflich - darin ein, dass Vodafone D2\n- meine Verkehrsdaten (Daten, die bei der Bereitstellung und Erbringung von Telekommunikationsdienstleistungen erhoben werden) zur Vermarktung und bedarfsgerechten Gestaltung von Vodafone-Telekommunikationsdienstleistungen oder zur Bereitstellung von Diensten mit Zusatznutzen f�r l�ngstens 6 Monate nach Rechnungsversand speichert, verarbeitet und nutzt;\n- mich zu Werbezwecken (auch automatisiert) anruft oder mir per Telefax oder in Form elektronischer nachrichten Werbung zusendet und\n- meine Bestandsdaten (Daten, die erhoben werden, um das Vertragsverh�ltnis einschlie�lich seiner inhaltlichen Ausgestaltung zu begr�nden oder zu �ndern) verarbeitet und nutzt, soweit dies zur Kundenberatung, Werbung und Marktforschung erforderlich ist.\n\nOhne Einwilligung bleiben etwaige gesetzliche Werbebeschr�nkungen bestehen.\n\nDatum:                                     ".$Date."\nUnterschrift des                        x\nAuftraggebers:                         __________________________________________\nName in Druckbuchstaben                    ",1);
                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Sofern unten ein abweichender Nutzer der Vodafone-Karte eingetragen ist, wird dieser anstatt des Vertragspartners der oben genannten Rufnummer als Teilnehmer von Vodafone-Stars registriert. Ich erteile hiermit meine Zustimmung, dass statt mir selbst der Nutzer Teilnehmer von Vodafone-Stars wird.");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Unterschrift des Vertragspartners,                              Datum\nder oben genannten Rufnummer\n\nVor-/Nachname\nin Druckbuchstaben");

                    $y=$pdf->GetY()+2;
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,205,$y);

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Adresse des Nutzers der Vodafone-Karte");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3,"Vor-/Nachname\nggf. Firma\n\nStra�e, Nr.\n\nPLZ, Ort\n\nE-Mail\n\nGeburtsdatum");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Mir ist bekannt, dass meine mit der Teilnahme verbundenen personenbezogenen Daten gem�� den geltenden Datenschutzbestimmungen verarbeitet und nur f�r Zwecke der Durchf�hrung des Programms Vodafone-Stars genutzt werden");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date."                              VO-ID: ".$enti[VO]);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Unterschrift des Nutzers,                                            Datum                                             (Eintrag erfolgt durch Vodafone-D2)\nfalls abweichend vom Vertragspartner");


                    $y=$pdf->GetY()+1;


                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Mehr Infos zu Vodafone-Stars gibt's unter 22 44 88 oder im Internet unter www.vodafone.de/vodafonestars.\n................................................................................................................................................................................................................");

                    $y=$pdf->GetY();
                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Bitte vollst�ndig ausf�llen und unterschrieben zur�ckfaxen an:               [X]Teilnehmer wurde bereits �ber Vodafone-ePOS-Direct-Import Client angemeldet!\nVodafone D2 GmbH, Abteilung VCS, Fax: 0 21 02 / 98 65 75 ");

                }

                if(($enti[FNI]!=0) && ($Tarif[$Info]="VFZH24FFN")){

                    /* if($enti[FNI]!=0)

                    $pdf->setSourceFile('portierungsformular.pdf');
                    $tplidx = $pdf->importPage(1);//Seitenzahl
                    $pdf->addPage();
                    $pdf->useTemplate($tplidx, 0, 0, 210);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY(45,36.5);
                    $pdf->MultiCell(40,30,$enti[Name]);
                    $pdf->SetXY(45,43.5);
                    $pdf->MultiCell(40,30,$enti[Vorname]);
                    $pdf->SetXY(45,50);
                    $pdf->MultiCell(40,30,$enti[Strasse]." ".$enti[Hausnummer]);
                    $pdf->SetXY(45,57.5);
                    $pdf->MultiCell(140,30,$enti[PLZ]."                                                       ".$enti[Ort]);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetXY(77,189);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetXY(174,197);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetXY(45,213);
                    $pdf->MultiCell(100,40,$enti[Vorname]." ".$enti[Name]);
                    */
                }

                if($ZusatzBlattVFV=="NEIN") { /*|| if($getSonderdienst=="24MIN60")  {*/

                    /* Hier wird die Zusatzvereinbarung.pdf ab dem 03.10.2011 als Bild ausgegeben
                    $pdf->addPage();
                    $pdf->Image('zusatzvereinbarung.jpg', 0,0,210,297);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY(45,36.5);
                    $pdf->MultiCell(40,30,$enti[Name]);
                    $pdf->SetXY(45,43.5);
                    $pdf->MultiCell(40,30,$enti[Vorname]);
                    $pdf->SetXY(45,50);
                    $pdf->MultiCell(40,30,$enti[Strasse]." ".$enti[Hausnummer]);
                    $pdf->SetXY(45,57.5);
                    $pdf->MultiCell(140,30,$enti[PLZ]."                                                       ".$enti[Ort]);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetXY(77,189);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetXY(174,197);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetXY(45,213);
                    $pdf->MultiCell(100,40,$enti[Vorname]." ".$enti[Name]);
                    */


                }


            }

        }
    }
    public static function printVodafoneContract_short($contractID){
        // Die fpdf Daten werden inkludiert
        include (app_path() . 'public/libraries/pdfPrint/CreditRequestTexte.php');
        include (app_path() . 'public/libraries/pdfPrint/fpdf4credit.php');
        //include (app_path() . 'public/libraries/pdfPrint/fpdi.php');
        include ('C:\xampp\htdocs\UserDefined\TokasDraft\public\libraries\pdfPrint\CreditRequestTexte.php');


        // Fetch related data from the database...
        $contract = Contract
            ::where('id', $contractID)
            ->first();

        $tariff = Tariff::find($contract->tariff_id);

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

        // there may be more than one gsm like additional gsm...
        $mainCardVfGsm = VfGSM
            ::where('contract_id', $contract->id)
            ->where('additional_tariff', 0) // 0 means the tariff is not additional, main.
            ->first();

        // Fetch the VF-GSM with the current contract ID from "VfGsm" table
        $allCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->get();

        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        $eins = 1; //Setzen des Startpunktes f�r die Nummerierung der einzelnen Abs�tze
        $zwei = 1;

        if($tariff->code != "VFZH24FFN"){

                //$DocAdresse = getTarif($enti[Tarif], TarifInfoDoc);
                $DocAdresse = "keine";



                //*********************************************************************************************************************
                //*********************************************************************************************************************
                //*********************************************************************************************************************

                $pdf=new \FPDI();
                $pdf->SetMargins(10,22);
                $pdf->AddPage();


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Kopfzeile
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //$pdf->Image('Images/vf_logo.png', 145,5);

                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,"[AuftragsTyp]"."\n"."[Vertragsbeginn]"."\n"."[Kundenkennwort]");

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetXY(10,$y);
                $pdf->MultiCell(90,2.5, "textAuftragskopf");

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Privatkunde
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '."[Kundentyp]",1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');
                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,"[Anrede]" ."\n".''."\n"."[Name]"."\n"."[Vorname]"."\n".substr("[Geburtsdatum]",8,2).".".substr("[Geburtsdatum]",5,2).".".substr("[Geburtsdatum]",0,4)."\n"."[Ausweisnummer]"."\n\n"."[BankKartenKreditInstitut]"."\n\n"."[BankKartenNummer]"."\n"."[BankKarteGueltigM]"." / "."[BankKarteGueltigJ]");

                $y=$pdf->GetY()+1;


        }
        $pdf->Output();

    }




    /**
     * forwarded from "app/Http/Controllers/ContractController@forwardToReadXML"
     */
    public static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public static function readXML(Request $request){
        if($request->hasFile('XMLFile')) {
            $deneXML = simplexml_load_file($request->file('XMLFile')->getRealPath());
            $deneXMLStr = str_replace(array('<Bestaetigung />', '<Bestaetigung/>'), '<Bestaetigung>Comfirmation<Bestaetigung/>', $deneXML->asXML());

            dd(Contract::get_string_between($deneXMLStr, '<Fehlertext>', '</Fehlertext>'));

            if(stristr($deneXMLStr, "Portierung")) // for a case insenstive version of this function.
                dd("Portierung");
            else if(strstr($deneXMLStr, "Aktivierung"))
                dd('Aktivierung');



        }
    }
    public static function readXML_(Request $request){

        if($request->hasFile('XMLFile')) {
            $deneXML = simplexml_load_file($request->file('XMLFile')->getRealPath());
            $readXMLFile = XmlParser::load($request->file('XMLFile')->getRealPath());
            //$readXMLFile = simplexml_load_file($request->file('XMLFile')->getRealPath());
            //str_replace( '<Bestaetigung />', '<Bestaetigung>Comfirmation<Bestaetigung />',$readXMLFile ) ;
            /*
            $error = $readXMLFile->parse([
                'id' => ['uses' => 'user.id'],
                'email' => ['uses' => 'user.email'],
                'followers' => ['uses' => 'user::followers'],
            ]);
            */
            dd($readXMLFile);

            $case1 = $readXMLFile->parse([
                'caseAktivierung' => ['uses' => 'Aktivierung.BatchId'],
            ]);

            $case2 = $readXMLFile->parse([
                'casePortierung' => ['uses' => 'Portierung.BatchId'],
            ]);

            if ($case1['caseAktivierung'] != null){
                $case1 = $readXMLFile->parse([
                    '$comfirmation' => ['uses' => 'Aktivierung.Antwortstatus.Bestaetigung'],
                ]);
                if($case1['$comfirmation'] == "Comfirmation")
                    dd($case1['$comfirmation']);
                dd("stop");

                $error = $readXMLFile->parse([
                    'errorText' => ['uses' => 'Aktivierung.Antwortstatus.Auftragsfehler.Fehlertext'],
                ]);
            }
            else if($case2['casePortierung'] != null){
                $error = $readXMLFile->parse([
                    'errorText' => ['uses' => 'Portierung.Antwortstatus.Auftragsfehler.Fehlertext'],
                ]);
            }


            dd($error['errorText']);
        }
        return back();
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
