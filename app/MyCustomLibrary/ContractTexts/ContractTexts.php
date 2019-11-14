<?php
/**
 * Created by PhpStorm.
 * User: Gunay Karli
 * Date: 23/10/2019
 * Time: 09:18
 */

namespace App\MyCustomLibrary\ContractTexts;


use App\Customer;
use Carbon\Carbon;

class ContractTexts
{

    public static function getTextBeauftragung($customerID){
        $customer = Customer
            ::where('id', $customerID)
            ->first();
        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        $textBeauftragung = "\n1. Auftrag f�r Vodafone D2-Dienstleistungen: Bestandteil des Vertrages sind die Allgemeinen Gesch�ftsbedingungen und die Preisliste f�r Vodafone D2 Dienstleistungen.\nHinweis: Die Allgemeinen Gesch�ftsbedingungen f�r Vodafone D2 Dienstleistungen h�ngen in den Verkaufsr�umen aus.\n2. Begrenzung der monatilichen Entgelth�he: Mir ist bekannt, dass eine Begrenzung der monatlichen Entgelth�he (� 18 Telekommunikations-Kundenschutzverordnung) w�hrend der gesamten Vertragslaufzeit nicht m�glich ist, sondern nur im Rahmen eines CallYa-Mobilfunkvertrages realisiert werden kann. \n3. SCHUFA/Auskunfteien: Ich willige in den Datenaustausch mit der SCHUFA-Gesellschaft und den sonstigen Auskunfteien gem. Ziff. 11 der AGB f�r Vodafone D2-Dienstleistungen ein.\n\n
Datum: ". $dateTimeString.
            "\nUnterschrift des                      X\nAuftraggebers:                        ____________________________\nName in Druckbuchstaben:    ". $customer->contact_person ."\n\n";

        return $textBeauftragung;
    }

    public static function getTextWerbebereitschaft($customerID){
        $customer = Customer
            ::where('id', $customerID)
            ->first();
        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        $textWerbebereitschaft = "\n[X] Ja, ich m�chte �ber Leistungen und Tarife von Vodafone* informiert werden. Vodafone* darf meine Bestandsdaten zum Zweck der Beratung, Marktforschung und Werbung f�r Vodafone*-Angebote verarbeiten und nutzen und meine Verkehrsdaten (Zeitpunkt, Dauer und Zielgasse) zur bedarfsgerechten Gestaltung f�r l�ngstens sechs Monate verwenden\n[X] Ja, Vodafone darf mich telefonisch und per SMS/MMS kontaktieren und �ber Vodafone-Angebote beraten. Ich kann diese Einwilligung jederzeit ganz oder teilweise f�r die Zukunft widerrufen.\n\n*Vodafone D2 GmbH und Vodafone AG & Co. KG.\nDie Daten d�rfen zwischen den beiden Unternehmen zu den vorgenannten Zwecken wechselseitig �bermittelt werden.\n
Hinweis: Ohne die vorstehende Einwilligung ist Vodafone im Rahmen der gesetzlichen Bestimmungen lediglich berechtigt, Ihnen Werbung f�r eigene Angebote per Text- oder Bildmitteilung an Ihr Telefon, per E-Mail an Ihre elektronische Postadresse und per Post an Ihre Anschrift zukommen zu lassen. Sie k�nnen der Nutzung Ihrer Telefonnummer und Adressen zu diesem Zwecke jederzeit schriftlich oder elektronisch widersprechen.\n\n
Datum: ". $dateTimeString .
            "\nUnterschrift des                      X\nAuftraggebers:                        ____________________________\nName in Druckbuchstaben:    " . $customer->contact_person . "\n\n";

        return $textWerbebereitschaft;
    }

public static $textA1 = "Sie dürfen den Tarif oder die Tarifoption nicht f�r Voice over IP und Peer to Peer nutzen.";

public static $textA2 = "Sie d�rfen den Tarif oder die Tarifoption nicht f�r Voice over IP nutzen.";

public static $textA3 = "Sie d�rfen den Tarif oder die Tarifoption nicht f�r Peer to Peer nutzen.";

public static $textB1 = "Sie haben 50 MB pro Monat f�r BlackBerry-Internet-Services inklusive. F�r Nutzung, die dar�ber hinaus geht, zahlen Sie 0,49 Euro pro MB.";

public static $textB2 = "Sie haben 500 MB pro Monat f�r BlackBerry-Internet-Services inklusive. F�r Nutzung, die dar�ber hinaus geht, zahlen Sie 0,49 Euro pro MB.";

public static $textC = "Sie haben eine Flat f�r SMS-Versand in alle deutschen Netze inklusive.";

public static $textD1 = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 300 MB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 7,2 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wenn Sie Ihr Inklusiv-Volumen im Abrechnungszeitraum aufgebraucht haben, wird Ihre Bandbreite auf 32kBit/s beschr�nkt. Dar�ber informieren wir Sie per SMS.";

public static $textD2 = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 500 MB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 14,4 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wir pr�fen w�hrend Ihrer Vertragslaufzeit, ob eine Datenoption f�r Sie besser w�re, behalten uns vor, diese mit einer monatlichen Laufzeit f�r Sie einzurichten oder Ihre Bandbreite auf 32 kBit/s zu beschr�nken, wenn Sie Ihr Inklusiv-Volumen verbraucht haben. Dar�ber informieren wir Sie per SMS.";

public static $textD3 = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 20 GB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 100 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wir pr�fen w�hrend Ihrer Vertragslaufzeit, ob eine Datenoption f�r Sie besser w�re, behalten uns vor, diese mit einer monatlichen Laufzeit f�r Sie einzurichten oder Ihre Bandbreite auf 32 kBit/s zu beschr�nken, wenn Sie Ihr Inklusiv-Volumen verbraucht haben. Dar�ber informieren wir Sie per SMS.";

public static $textE = "Sie d�rfen den Tarif nur als Privatperson nutzen. SMS und MMS d�rfen Sie nur manuell �ber Ihr Endger�t erstellen. Sie d�rfen den Tarif nicht weiterverkaufen, nicht unentgeltlich Dritten �berlassen und nicht zum Betrieb kommerzieller Dienste nutzen. Die Nutzung in einer station�ren Telefonanlage sowie zur Erbringung von Call-Center-Leistungen und f�r die Kommunikation zwischen Automaten ist unzul�ssig. Unzul�ssig ist auch der Aufbau von Verbindungen, bei denen Sie oder Dritte aufgrund der Verbindung Verm�gensvorteile erhalten, die von der Dauer der Verbindung abh�ngen, z.B. Verbindungen zu Werbehotlines.";

public static $textF = "Die Mindestlaufzeit betr�gt 24 Monate, die K�ndigungsfrist betr�gt 3 Monate. Der Vertrag ist, sofern nicht Abweichendes vereinbart ist, erstmals zum Ablauf des zweiten Vertragsjahres k�ndbar. Falls Sie nicht rechtzeitig k�ndigen, verl�ngert sich der Vertrag jeweils um ein weiteres Jahr.";

public static $textG1 = "Falls Sie in einem Abrechnungszeitraum mehr als 15.000 Minuten ins deutsche Vodafone-Mobilfunknetz telefonieren, d�rfen wir den Vertrag au�erordentlich k�ndigen.";

public static $textG2 = "Falls Sie in einem Abrechnungszeitraum mehr als 15000 Minuten in ein deutsches Telekommunikations-Netz telefonieren, d�rfen wir den Vertrag au�erordentlich k�ndigen.";

public static $textH = "Hauptkarte und DataSIMs haben eine gemeinsame Rufnummer, eine gemeinsame Rechnung und eine gemeinsame Mailbox. Sie k�nnen keine Verbindungen von DataSIM zu DataSIM herstellen und keine Vodafone-Services mit Festnetz-Nummer nutzen, wie z.B. Vodafone Zuhause oder Vodafone Office. Sie k�nnen nicht �ber mehrere Karten gleichzeitig Services derselben Kategorie nutzen, also z.B. jemanden anrufen oder identische Datendienste nutzen. Das Versenden und Empfangen von SMS und MMS ist auf eine Karte beschr�nkt, die Sie bis auf Weiteres selbst festlegen.";

public static $textBlack1 = "Sie haben 3000 SMS in alle deutschen Mobilfunknetze inklusive. F�r SMS, die dar�ber hinaus gehen, zahlen Sie 0,19 Euro pro SMS.";

public static $textBlack2 = "Nach 12 Monaten k�nnen Sie ein neues Handy erwerben. Mit Vertragsschluss beginnt erneut eine Mindestlaufzeit von 24 Monaten, die K�ndigungsfrist betr�gt 3 Monate.";

public static $textMIFPromoPreis = "Sie k�nnen mit dem Tarif auch telefonieren und SMS verschicken. Gespr�che in alle deutschen Netze kosten 0,29 Euro pro Minute im 60/60-Takt. SMS in alle deutschen Mobilfunknetze kosten 0,19 Euro pro SMS.";

public static $textRedFamily = "Sie k�nnen eine Vodafone Red Family S zu einem verg�nstigten Preis pro Monat zu diesen Tarifen buchen: Vodafone Red S, Red M, Red L und Red Premium. Die Vodafone Red Family S wird automatisch in den Tarif Vodafone Red S umgestellt, wenn Sie mehr als 15.000 Minuten ins deutsche Festnetz telefonieren, den Vertrag zu Ihrer Hauptkarte beenden, die Hauptkarte in einen Rahmenvertrag aufgenommen wird oder der Hauptkarte schon 4 Familienkarten zugeordnet sind.";

public static $textSmartS = "Sie zahlen 0,09 Euro pro Gespr�chsminute bei einem Abrechnungstakt von 60/60.";

public static $textSmartM = "Ihr Tarif beinhaltet ein Minutenpaket mit 300 Minuten pro Abrechnungszeitraum in alle deutschen Netze. F�r Minuten, die �ber dieses Minutenpaket hinaus gehen, zahlen Sie 0,29 Euro pro Min. Die Abrechung erfolgt im Takt 60/60.";

public static $textt8a = "Die Mindestlaufzeit betr�gt 24 Monate, die K�ndigungsfrist betr�gt 3 Monate. Der Vertrag ist, sofern nicht Abweichendes vereinbart ist, erstmals zum Ablauf des zweiten Vertragsjahres k�ndbar. Wird der Vertrag nicht rechtzeitig gek�ndigt, verl�ngert er sich jeweils automatisch um ein weiteres Jahr.";

public static $textt03 = "Sie d�rfen den Tarif nur als Privatkunde nutzen. SMS und MMS d�rfen Sie nur manuell �ber Ihr Endger�t erstellen. Sie d�rfen den Tarif nicht weiterverkaufen, nicht unentgeltlich Dritten �berlassen und nicht zum Betrieb kommerzieller Dienste nutzen. Die Nutzung in einer station�ren Telefonanlage sowie zur Erbringung von Call-Center-Leistungen und f�r die Kommunikation zwischen Automaten ist unzul�ssig. Unzul�ssig ist auch der Aufbau von Verbindungen, bei denen Sie oder Dritte aufgrund der Verbindung Verm�gensvorteile erhalten, die von der Dauer der Verbindung abh�ngen, z.B. Verbindungen zu Werbehotlines.";

public static $textt38j = "Wird eine SIM Karte in einem Abrechnungszeitraum mehr als 15.000 Minuten f�r nationale Standardgespr�che je deutsches Netz genutzt (Abrechnung minutengenau), ist Vodafone berechtigt, das Vertragsverh�ltnis au�erordentlich zu k�ndigen.";

public static $textt38k = "Falls Sie in einem Abrechnungszeitraum mehr als 15.000 Minuten ins deutsche Vodafone-Mobilfunknetz telefonieren, d�rfen wir den Vertrag au�erordentlich k�ndigen.";

public static $textt49d = "Nutzung nur f�r manuell �ber das Endger�t erstellte SMS zul�ssig. Die gewerbliche Nutzung ist ausgeschlossen. Alle �ber die Inklusivleistung von 3000 SMS hinausgehenden SMS werden gem�� den Konditionen des zugrundeliegenden Vertrages abgerechnet.";

public static $textt46b = "Sie d�rfen den Tarif oder die Tarifoption nicht f�r Voice over IP und Peer to Peer nutzen.";

public static $textt48l = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 200 MB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 14,4 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wir pr�fen w�hrend Ihrer Vertragslaufzeit, ob eine Datenoption f�r Sie besser w�re, behalten uns vor, diese mit einer monatlichen Laufzeit f�r Sie einzurichten oder Ihre Bandbreite auf 32 kBit/s zu beschr�nken, wenn Sie Ihr Inklusiv-Volumen verbraucht haben. Dar�ber informieren wir Sie per SMS.";

public static $textt05a = "Sie k�nnen zu Ihrer Vodafone-Hauptkarte mit Vertragslaufzeit 2 DataSIMs buchen. Je DataSIM im Tarif Vodafone Red S zahlen Sie 10 � extra pro Monat und haben 200 MB mehr Datenvolumen in der �bertragungsgeschwindigkeit Ihres zugrunde liegenden Tarifs. Hauptkarte und DataSIMs haben eine gemeinsame Rufnummer, eine gemeinsame Rechnung und eine gemeinsame Mailbox. Sie k�nnen keine Verbindungen von DataSIM zu DataSIM herstellen und keine Vodafone-Services mit Festnetz-Nummer nutzen, wie z.B. Vodafone Zuhause oder Vodafone Office. Sie k�nnen nicht �ber mehrere Karten gleichzeitig Services derselben Kategorie nutzen, also z.B. jemanden anrufen oder identische Datendienste nutzen. Das Versenden und Empfangen von SMS und MMS ist auf eine Karte beschr�nkt, die Sie bis auf Weiteres selbst festlegen.";

public static $textt06 = "Auf Ihrer 1. Rechnung berechnen wir Ihnen den Basispreis f�r den 1. Vertragsmonat nur anteilig und den Basispreis f�r den 2. Vertragsmonat im Voraus. In den folgenden Rechnungen sehen Sie dann auch den Basispreis des jeweils n�chsten Vertragsmonats. Eventuelle Rabatte ziehen wir jeweils ab. (Kunden im Rahmenvertrag sind hiervon ausgeschlossen.)";

public static $textt111 = "Die Nutzung f�r Peer-to-Peer Kommunikation ist nicht gestattet.";

public static $textt48m = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 500 MB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 21,6 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wir pr�fen w�hrend Ihrer Vertragslaufzeit, ob eine Datenoption f�r Sie besser w�re, behalten uns vor, diese mit einer monatlichen Laufzeit f�r Sie einzurichten oder Ihre Bandbreite auf 32 kBit/s zu beschr�nken, wenn Sie Ihr Inklusiv-Volumen verbraucht haben. Dar�ber informieren wir Sie per SMS.";

public static $textt05b = "Sie k�nnen zu Ihrer Vodafone-Hauptkarte mit Vertragslaufzeit 2 DataSIMs buchen. Je DataSIM im Tarif Vodafone Red M zahlen Sie 10 � extra pro Monat und haben 500 MB mehr Datenvolumen in der �bertragungsgeschwindigkeit Ihres zugrunde liegenden Tarifs. Hauptkarte und DataSIMs haben eine gemeinsame Rufnummer, eine gemeinsame Rechnung und eine gemeinsame Mailbox. Sie k�nnen keine Verbindungen von DataSIM zu DataSIM herstellen und keine Vodafone-Services mit Festnetz-Nummer nutzen, wie z.B. Vodafone Zuhause oder Vodafone Office. Sie k�nnen nicht gleichzeitig Services derselben Kategorie nutzen, also z.B. jemanden anrufen oder identische Datendienste nutzen. Das Versenden und Empfangen von SMS und MMS ist auf eine Karte beschr�nkt, die Sie bis auf Weiteres selbst festlegen.";

public static $textt48n = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 3 GB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 100 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wir pr�fen w�hrend Ihrer Vertragslaufzeit, ob eine Datenoption f�r Sie besser w�re, behalten uns vor, diese mit einer monatlichen Laufzeit f�r Sie einzurichten oder Ihre Bandbreite auf 32 kBit/s zu beschr�nken, wenn Sie Ihr Inklusiv-Volumen verbraucht haben. Dar�ber informieren wir Sie per SMS.";

public static $textt05c = "Sie k�nnen zu Ihrer Vodafone-Hauptkarte mit Vertragslaufzeit 2 DataSIMs buchen. Die 1. DataSIM ist kostenlos. F�r die 2. DataSIM im Tarif Vodafone Red L zahlen Sie 10 � extra pro Monat und haben 500 MB mehr Datenvolumen in der �bertragungsgeschwindigkeit Ihres zugrunde liegenden Tarifs. Hauptkarte und DataSIMs haben eine gemeinsame Rufnummer, eine gemeinsame Rechnung und eine gemeinsame Mailbox. Sie k�nnen keine Verbindungen von DataSIM zu DataSIM herstellen und keine Vodafone-Services mit Festnetz-Nummer nutzen, wie z.B. Vodafone Zuhause oder Vodafone Office. Sie k�nnen nicht gleichzeitig Services derselben Kategorie nutzen, also z.B. jemanden anrufen oder identische Datendienste nutzen. Das Versenden und Empfangen von SMS und MMS ist auf eine Karte beschr�nkt, die Sie bis auf Weiteres selbst festlegen.";

public static $textt48o = "F�rs Surfen im deutschen Vodafone-Netz �ber wap.vodafone.de und web.vodafone.de haben Sie ein Inklusiv-Volumen von 10 GB pro Abrechnungszeitraum. Die gr��tm�gliche Bandbreite ist 100 Mbit/s. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf die n�chsten 100 KB auf. Wir behalten uns vor, die Verbindung nach 24 Stunden automatisch zu trennen. Wir pr�fen w�hrend Ihrer Vertragslaufzeit, ob eine Datenoption f�r Sie besser w�re, behalten uns vor, diese mit einer monatlichen Laufzeit f�r Sie einzurichten oder Ihre Bandbreite auf 32 kBit/s zu beschr�nken, wenn Sie Ihr Inklusiv-Volumen verbraucht haben. Dar�ber informieren wir Sie per SMS.";

public static $textt04a = "Sie k�nnen eine Vodafone Red Family S zu einem verg�nstigten Preis pro Monat zu diesen Tarifen buchen: Vodafone Red S, Red M, Red L und Red Premium. Die Vodafone Red Family S wird automatisch in den Tarif Vodafone Red S umgestellt, wenn Sie mehr als 15.000 Minuten ins deutsche Festnetz telefonieren, den Vertrag zu Ihrer Hauptkarte beenden, die Hauptkarte in einen Rahmenvertrag aufgenommen wird oder der Hauptkarte schon 4 Familienkarten zugeordnet sind.";

public static $textt04b = "Sie k�nnen eine Vodafone Red Family M zu einem verg�nstigten Preis pro Monat zu diesen Tarifen buchen: Vodafone Red M, Red L und Red Premium. Die Vodafone Red Family M wird automatisch in den Tarif Vodafone Red M umgestellt, wenn Sie  mehr als 15.000 Minuten ins deutsche Festnetz telefonieren, den Vertrag zu Ihrer Hauptkarte beenden, die Hauptkarte in einen Rahmenvertrag aufgenommen wird oder der Hauptkarte schon 4 andere Familienkarten zugeordnet sind.";

public static $textt04c = "Sie k�nnen eine Vodafone Red Family L zu einem verg�nstigten Preis pro Monat zu diesen Tarifen buchen: Vodafone Red L und Red Premium. Die Vodafone Red Family L wird automatisch in den Tarif Vodafone Red L umgestellt, wenn Sie mehr als 15000 Minuten ins deutsche Festnetz telefonieren, den Vertrag zu Ihrer Hauptkarte beenden, Ihre Hauptkarte in einen Rahmenvertrag aufgenommen wird oder der Hauptkarte schon 4 andere Familienkarten zugeordnet sind.";

public static $textAuftragskopf = "Wenn Sie als Auftraggeber die Vodafone-Karte einem Dritten (=Teilnehmer) zur Nutzung �berlassen, k�nnen sie neben dem Kundenkennwort auf Wunsch auch ein Teilnehmerkennwort festlegen, das dem Teilnehmer eingeschr�nkte M�glichkeiten zur Dienstebestellung und Vertragsdaten�nderungen einr�umt. Den Umfang dieser M�glichkeiten entnehmen Sie bitte einem seperaten Merkblatt, das Ihnen auf Anforderung ausgeh�ndigt wird. Teilnehmerkennw�rter f�r Ihre Vodafone-Karten tragen Sie bitte in die Anlage f�r Zusatzdienste ein.";

public static $textAbbuchungserlaubnis1 = "Ich erm�chtige Vodafone D2 (VF D2) widerruflich, die Rechnungsbetr�ge von oben genanntem Konto im Lastschriftverfahren abzubuchen. Die Bedingungen f�r die Teilnahme am Lastschriftverfahren erkenne ich an. Bei Zuordnung der neuen Vodafone-Karte/n auf ein bereits bestehendes Vodafone-Kundenkonto gilt die hier angegebene Bankverbindung f�r das gesamte Kundenkonto.";

public static $textBestaetigt = "Best�tigt: JA";

public static $textAbbuchungserlaubnis2 = "Ich erm�chtige meine kontof�hrende Bank widerruflich, VF D2 allgemein gehaltene bank�bliche Angaben zur Bonit�tspr�fung zu erteilen, die im Zusammenhang mit der Inanspruchnahme von VF D2-Dienstleistungen erforderlich sind.";

public static $textPapierRechnung = "Die zur Verf�gungstellung einer Online-Rechnung erfolgt kostenfrei, eine Papierrechnung wird mit monatlich pro Kundenkonto (Preis lt.Preisliste) bepreist.";

public static $textOnlineRechnung = "Ich verzichte auf die Zusendung von Papierrechnungen und buche stattdessen den Dienst Vodafone-Online Rechnung zu den hierf�r geltenden Bedingungen.";

public static $textTarifMindestlaufzeit = "Die Mindestlaufzeit betr�gt 24 Monate, die K�ndigungsfrist betr�gt 3 Monate. Der Vertrag ist, sofern nicht Abweichendes vereinbart ist, erstmals zum Ablauf des zweiten Vertragsjahres k�ndbar. Wird der Vertrag nicht rechtzeitig gek�ndigt, verl�ngert er sich jeweils automatisch um ein weiteres Jahr.";

public static $textTarifWochenendPaketwechsel = "Aus dem von mir gew�hlten Tarif ist ein Tarifwechsel nur in ein anderes Vodafone-WochenendPaket m�glich. F�r Wechsel innerhalb der Vodafone-WochenendPakete gilt: Ein wechsel ist in ein Paket mit gr��erer Anzahl monatlicher Inklusivminuten ist monatlich zum Beginn eines Erfassungszeitraums m�glich. Sonstige Wechsel innerhalb der Tarife Vodafone-WochenendPaket 50/100/200/500 sind nur mit einer Frist von 3 Monaten seit Buchung m�glich.";

public static $textTarifKombiWochenendWechsel = "F�r Wechsel innerhalb der Vodafone KombiPakete 60/120/240/480/1200 gilt: Ein Wechsel in ein Paket mit gr��erer Anzahl monatlicher Inklusivminuten ist monatlich zum Beginn eines Erfassungszeitraums m�glich. Sonstige Wechsel innerhalb der Tarife KombiPakete 60/120/240/480/1200 sind nur mit einer Frist von 3 Monaten seit Buchung m�glich. Im �brigen sind Tarifwechsel ausgeschlossen.";

public static $textTarifDatentarife = "Ein Wechsel in einen anderen Datentarif ist w�hrend der Mindestlaufzeit nicht m�glich.";

public static $textTarifEinzugsermaechtigung = "Nur mit Einzugserm�chtigung";

public static $textTarifMinutenpaketWechsel = "Aus dem von mir gew�hlten Tarif ist ein Wechsel in enien Tarif mit niedrigerem monatlichen Basispreis bzw. Paketpreis erstmals 3 Monate nach erfolgter Einrichtung m�glich. Ein wechsel in einen Tarif mit h�heren Basispreis bzw. Paketpreis ist jederzeit m�glich. Im �brigen ergeben sich die Wechselm�glichkeiten und -konditionen aus der Preisliste.";

public static $textTarifSimOnlyMinutenpaketWechsel = "Tarifwechsel innerhalb der Vodafone MinutenPakete SIM only sind jederzeit m�glich, bei Wechsel in ein Vodafone MinutenPaket SIMonly mit weniger monatlichen inklusivminuten jedoch erstmalig nach drei Monaten. Tarifwechsel in Tarife, die bei erstmaligem Abschluss zum gleichzeitigen Erwerb eines verg�nstigen Mobiltelefons berechtigen, sind nur bei gleichzeitiger Verl�ngerung der Mindestlaufzeit des Vertrages auf 24 Monate. Im �brigen sind Tarifwechsel ausgeschlossen.";

public static $textTarifZuhauseTalk24 = "Sonderbedingungen/Leistungsumfang: Abweichend von der Leistungsbeschreibung f�r Vodafone D2-Dienstleistungen gelten f�r den Tarif Vodafone Zuhause FestnetzFlat folgende Besonderheiten:
a) Die Festnetznummer muss dem Vorwahlbereich entstammen, der der Zuhause-Adresse des Kunden entspricht. Bei sp�terer �nderung der Zuhause-Adresse wird dem Kunden von Vodafone D2 bei Bedarf eine neue Festnetznummer zugeteilt.
b) Die Nutzung des VF D2-Netzes ist - vorbehaltlich der Regelung in c) - r�umlich auf die Zuhause-Adresse beschr�nkt ('regionale Nutzung'). Diese Beschr�nkung wird VF D2 innerhalb der ersten 5 Tage nach Vertragsabschluss einrichten; die bis dahin m�gliche deutschlandweite Nutzung wird bei Inanspruchnahme zu den f�r die regionale Nutzung geltenden Preisen abgerechnet.
c) Abgehende Verbindungen zur Vodafone-KundenBetreuung (1216) und Notruf (112, 110) k�nnen abweichend von b) bis auf weiteres im Bereich
der von VF D2 national betriebene Funkstation in Anspruch genommen werden. VF D2 beh�lt sich vor, die Inanspruchnahme dieser Leistungen
ebenfalls auf die regionale Nutzung zu begrenzen.
d) In seinem ZuhauseBereich ist der Kunde unter seiner Festnetz-Nummer erreichbar, sobald die Portierung von seinem bisherigen Vertragspartner des Festnetzanschlusses durchgef�hrt wurde; die Portierung erfolgt zum im Rahmen des bisherigen Vertrages n�chstm�glichen K�ndigungstermin im Auftrag von Vodafone D2 zu BT (Germany) GmbH & Co. OHG. Bis zur erfolgreichen Portierung kann der Kunde 'Vodafone Zuhause mit Festnetznummer' f�r abgehende Verbindungen uneingeschr�nkt nutzen. Ziffer 4.8 der AGB f�r Vodafone D2-Dienstleistungen �ber die Abwicklung einer Portierung von Vodafone D2 zu einem anderen Anbieter findet f�r Festnetz-Nummern keine Anwendung; bei Beendigung des Vertrages mit Vodafone D2 f�llt die Festnetznummer des Kunden an den urspr�nglich ausgebenden Netzbetreiber zur�ck, sofern der Kunde zuvor keine Portierung �ber einen neuen Anbieter beauftragt hat und diese rechtzeitig bei Vodafone D2 eingegangen ist.
e) International Roaming (Nutzung der Vodafone-Karte im Ausland) ist ausgeschlossen. Dem Kunden steht eine Vodafone-Mailbox zur Verf�gung,
eine ProfiMailbox kann nicht eingerichtet werden. Mit Vodafone Zuhause stehen die �bertragungstechnologien GPRS und UMTS nicht zur
Verf�gung. Damit ist auch die Nutzung der auf diesen Technologien beruhenden Dienste - z.B. MMS, Videotelefonie, Logos, Klingelt�ne,
Ring-up-Tones, MeinAdressbuch usw.- ausgeschlossen.
f) Die Anbindung des Tarifs erfolgt �ber das Vodafone-Mobilfunknetz.
g) Die Registrierung der Festnetz-Nummer f�r Telefonbucheintrag und Auskunft kann erst nach Vertragsabschluss und erfolgreicher Portierung
erfolgen; hierzu wird dem Kunden ein Auftragsformular zugesandt. Bei abgehenden Verbindungen erfolgt keine Anzeige der Festnetz-Nummer als
Absenderkennung, es wird ausschlie�lich die Mobilfunk-Nummer des Kunden �bermittelt, sofern die Rufnummernunterdr�ckung vom Kunden
nicht aktiviert wurde.";


public static $textTarifZuhauseTaktung = "F�r Verbindungen mit Vodafone Zuhause ins Dt. Festnetz gilt immer die 60/60-Taktung, auch wenn f�r ihren Mobilfunktarif im �brigen eine andere Taktung  vereinbart ist.";

public static $textTarifZuhauseBedingungH= "Sonderbedingungen/Leistungsumfang: Abweichend von der Leistungsbeschreibung f�r Vodafone D2-Dienstleistungen gelten f�r \"die Vodafone Zuhause-Funktionalit�t\" folgende Besonderheiten zum Leistungsumfang:\na) Vodafone D2 teilt dem Kunden zus�tzlich zu seiner Vodafone-Mobilfunknummer eine neue Festnetznummer aus dem Vorwahlbereich zu, der seiner jeweils aktuellen zuhause-Adresse entspricht. Die Zuteilung dieser Festnetznummer erfolgt sp�testens innerhalb von 6 Wochen nach Antrag des Kunden.\nb) Die Nutzung von \"Vodafone Zuhause\" ist r�umlich auf die festgelegte Zuhause-Adresse beschr�nkt. Den ZuhauseBereich wird Vodafone D2 innerhalb von 5 Tagen nach Beauftragung einrichten. Vodafone D2 erfasst bei jeder Verbindung zu Abrechnungszwecken, ob sich der Kunde innerhalb oder au�erhalb des ZuhauseBereichs aufh�lt. Die Abrechnung zu \"Vodafone Zuhause\"-Konditionen wird jeweils durch einen Signalton zu Beginn eines jeden Gespr�ches angezeigt (Die zus�tzlich visuelle Information im Display des Mobiltelefons wird nicht von allen Endger�ten unterst�tzt). Weitergehende M�glichkeiten und Konditionen des Vodafone Anruf Manager siehe Preisliste.\nc) Die Zubuchung einer Karte in einem Tarif \"Vodafone ZuhauseTalk oder -Talk24 (Zusatz zu Laufzeitvertrag)\" zu verg�nstigten Konditionen ist nicht m�glich.";


public static $textTarifSuperFlat = "Der Kunde darf die Vodafone-Karte ausschlie�lich als Endkunde im daf�r  und nur zum Aufbau manuell �ber das Mobilfunkendger�t gew�hlter Verbindungen nutzen; unzul�ssig ist die Nutzung zum Betrieb von mehrwert- und Massenkommunikationsdiensten (z.B. Faxbroadcastdiensten, Telemarketing- oder Call-Center-Leistungen), zur Erbringung von entgeltlichen oder unentgeltlichen Zusammenschaltungs- oder sonstigen Telekommunikationsdienstleistungen f�r Dritte, zur Weitervermittlung von Mobilfunkteilnehmern im Vodafone-bnetz oder in andere Netze �ber die Vodafone-Karte sowie zur Herstellung von Verbindungen, bei denen der Anrufer aufgrund des Anrufs und/oder in Abh�ngigkeit von der Dauer der Verbingung Zahlungen der andere verm�genswerte Gegenleistungen Dritter erh�lt (z.B. Verbindungen zu Werbehotlines).";

public static $textTarifSuperFlatNF ="Wird eine Sim Karte in einem Abrechnungszeitraum mehr als 15.000 Minuten f�r nationale Standardgespr�che in das dt. Vodafone Netz genutzt (Abrechnung in 60/1 Taktung), ist Vodafone berechtigt, das Vertragsverh�ltnis au�erordentlich zu k�ndigen.";

public static $textTarifSuperFlatFV= "Wird eine SIM Karte in einem Abrechnungszeitraum mehr als insgesamt je 15.000 Minuten f�r nationale Standardgespr�che ins dt. Vodafone- und Festnetz genutzt (Abrechnung in 60/1 Taktung), ist Vodafone berechtigt, das Vertragsverh�ltnis au�erordentlich zu k�ndigen.";

public static $textTarifSuperFlatNV= "Wird eine Sim Karte in einem Abrechnugnszeitraum mehr als 15.000 Minuten f�r nationale Standardgespr�che in das dt. Vodafonenetz genutzt (Abrechnung in 60/1 Taktung), ist Vodafone berechtigt, das Vertragsverh�ltnis au�erordentlich zu k�ndigen.";

public static $textTarifSuperFlatWE= "Wird eine Sim Karte im Tarif Vodafone SuperFlat Wochenende SIMonly/Vodafone SuperFlat WOchenende in einem Abrechnungszeitraum mehr als 15.000 Minuten f�r nationale Standardgespr�che am WOchenende (Samstag und SOnntag) ins dt. Vodafone- und Festnetz genutzt (Abrechnung in 60/1 Taktung), ist Vodafone berechtigt, das Vertragsverh�ltnis au�erordentlich zu k�ndigen.";

public static $textTarifSuperFlatWE_NEW= "Die Vodafone-Tarife SUperFlat Wochenende und SUperFlat Wochenende mit Handy-5 beinhalten zus�tzlich einen monatlichen Mindestumsatz von 5,00 Euro f�r nicht in der SUperFlat WOchenende enthaltene Leistungen gem�� Preisliste. Der Mindestumsatz wird auf Telefonate aus dem deutschen Vodafone-Netz in alle deutschen Netze angerechnet, ausgenommen sind Konferenzverbindungen und SOnderrufnummern. Der Mindestumsatz wird ebenfalls auf SMS und MMS aus dem deutschen Vodafone Netz in alle deutschen Netze angerechnet, ausgenommen sind Sondernummern und SMS �ber MeinVodafone im Internet. Gebuchte Minuten- und/oder Messaging-Optionen werden nicht mit dem Mindestumsatz verrechnet, eine Anrechnung erfolgt dann ab �berschreiten der zugebuchten Leistungen.";

public static $textTarifSuperFlatWE_NEW2= "Wird eine SIM Karte im Tarif Vodafone SuperFlat Wochenende SIMonly/Vodafone SuperFlat Wochenende in einem Abrechnungszeitraum mehr als je 15.000 Minuten f�r nationale Standardgespr�che am Wochenende (Samstag und Sonntag) ins dt. Vodafone- und Festnetz genutzt (Abrechnung in 60/1 Taktung), ist Vodafone berechtigt, das Vertragsverh�ltnis au�erordentlich zu k�ndigen.";

public static $textTarifSuperFlatTK= "Die Einbringung der SIM-Karte in eine station�re Telefonanlage, die Nutzung zur Erbringung von CallCenter-Leistungen sowie eine Nutzung f�r die Kommunikation zwischen Automaten sind unzul�ssig. Unzul�ssig ist ferner der Aufbau von Verbindungen, bei denen der Kunde oder ein Dritter aufgrund der Verbindung von der Dauer der Verbindung abh�ngige Verm�gesnvorteile erh�lt (z.B. Verbindungen zu Werbehotlines).";

public static $textTarifInternetSMS="Nutzung nur f�r manuell �ber das Endger�t erstellte SMS zul�ssig. Die gewerbliche Nutzung ist ausgeschlossen. Alle �ber die Inklusivleistung von 3.000 SMS hinausgehenden SMS werden gem�� den Konditionen des zugrundeliegenden Vertrages abgerechnet.";

public static $textTarifInternetDV="Nutzung nur f�r manuell �ber das Endger�t erstellte SMS zul�ssig. Die gewerbliche Nutzung ist ausgeschlossen. Alle �ber die Inklusivleistung von 3000 SMS hinausgehenden SMS werden gem�� den Konditionen des zugrundeliegenden Vertrages abgerechnet.";

public static $textSMSInfoundPreis = "Sie haben 3000 SMS in alle deutschen Mobilfunknetze inklusive. F�r SMS, die dar�ber hinaus gehen, zahlen Sie 0,19 Euro pro SMS.";

public static $textTarifInternetNutzung="Der Kunde darf d. Vodafone-Karte ausschlie�lich als Endkunde im daf�r und nur f�r Verbindugnen, die manuell �ber die Hardware aufgebaut werden nutzen. Eine Weiterver�u�erung sowie unentgeltliche �berlassung des Dienstes an Dritte u. d. Nutzung zum Betrieb kommerzieller Dienste sind unzul�ssig. Bis zu einem Datenvolumen von 500 MB im jeweiligen Abrechnungszeitraum wird die jeweils aktuell maximal verf�gbare Bandbreite bereitgestellt, ab 500 MB stehen max. 64 kbit/s zur Verf�gung. Vodafone beh�lt sich vor, nach 24 h jeweils eine automatische Trennung der Verbindung durchzuf�hren.";

public static $textTarifInternetVOIP="Sie d�rfen den Tarif oder die Tarifoption nicht f�r Voice over IP und Peer to Peer nutzen.";

public static $textMCSNutzungsverhalten="Ergibt sich, dass es aufgrund des Nutzungsverhaltens des Kunden f�r diesen in einem Rechnugnszyklus g�nstiger gewesen w�re, wenn er eine Inklusivvolumen (Vodafone Mobile Connect Volume L / Vodafone Mobile COnnect Flat) gew�hlt h�tte, so wird f�r die Berechnung im akteullen Rechnungszyklus sowie f�r die weitere Vertragslaufzeit die f�r den Kunden im Referenzzeitraum g�nstige DAtentarifoption zugrunde gelegt. Der Kunde kann innerhalb von vier Wochen nach ERhalt der Mitteilung �ber die Umstellung der automatischen Festlegung widersprechen und eine der oberen genannten Tarifoptionen w�hlen. MAcht der Kunde von seinem Widerspruchsrecht keinen Gebrauch, so ist nach Ablauf der Widerspruchsfrist ein WEchsel w�hrend der Mindestlaufzeit in eine Datentarifoption mit geringerem monatlichen Paketpreis nicht m�glich. Die Minstestlaufzeit der eingereichten Tarifoption richtet sich nach der Mindestlaufzeit des zugrunde liegenden Vertrages im Tarif Vodafone Mobile Connect Sofort.";

public static $textMCSVertragsbestand="Wenn der Vodafone Zuhause DSL Vertrag nicht mehr besteht, wird der Tarif 'Vodafone MObile COnnect Sofort' durch den Tarif 'Vodafone Mobile Connect Starter' ersetzt.";

public static $textMCSVertragsbestand2="F�r die zu dem Tarif ztubuchbaren Datentarifoptionen 'Vodafone Mobile Connect Colume L' und 'Vodafone MObile Connect Flat' gelten die VOrzugspreise ebenfalls nur solange ein Vodafone Zuhause DSL Vertrag besteht.";

public static $tarivMCSVertragsbestand3="Der Tarif 'Vodafone Mobile Connect Sofort' kann nur von Kunden beauftragt werden, die bereits das Vodafone Zuhause DSL All-Inclusive-Paket gebucht haben. Pro DSL All-Inclusive-Paket darf nur ein Vertrag im Tarif 'Vodafone Mobile Connect Sofort' bestehen.";

public static $tarifMCFNutzung="Nutzung nur als Endkunde im daf�r ; kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Bis zu einem Datenvolumen von 5GB im geweiligen Abrechnugnszeitraum wird die jeweils aktuell maximal verf�gbare Bandbreite bereitgestellt; ab 5 GB stehen max. 64 kBit/s zur Verf�fung.";

public static $textVerbindungsUbersicht = "Soweit eine Verbindungs�bersicht beauftragt ist (s. Anlage f�r Zusatzdienste), werde ich Mitbenutzer gem�� Ziff. 9.3 der AGB f�r VF D2-Dienstleistungen auf die Speicherung und Mitteilung der Verbindungsdaten hinweisen. Ziff. 9 der AGB f�r VF D2-Dienstleistungen zum Umfang der Speicherung von Verbindungsdaten (auch ohne Verbindung�bersichten) habe ich zur Kenntnis genommen.";



public static $textVodafoneNummer = "Soweit m�glich, bitte ich um Zuteilung der in der Anlage f�r Zusatzdienste aufgef�hrten Vodafone-Nummer(n). Mir ist bekannt, dass die Zuteilung dieser Rufnummer(n) durch VF D2 nicht zugesichert werden kann und daher nicht Voraussetzung f�r das Zustandekommen des Vertrages ist. Die formale Zuteilung meiner Vodafone-Nummer(n) erfolgt mit der ersten Rechnung.";

public static $textTarifVodafoneMobileInternetFlat50 = "Nutzung nur als Endkunde im daf�r �blichen Umfang im dt. Vodafone Mobilfunk-Netz; kein Weiterverkauf, keine �berlassung and Dritte; kein Betrieb kommerzieller Dienste. Bis zu einem Datenvolumen von 20 GB im jeweiligen Abrechnungszeitraum wird die jeweils aktuell maximal verf�gbare Bandbreite Ihres Tarifs von bis zu 50 mbit/s bereitgestellt; ab 20 GB stehen max. 64 kbit/s zur Verf�gung.";

public static $textTarifVodafoneMobileInternetFlat51 = "Sie d�rfen den Tarif oder die Tarifoption nicht f�r Voice over IP und Peer to Peer nutzen.";

public static $textTarifVodafoneMobileInternetFlat52 = "Wir behalten uns vor, die Verbindung nach je 24 Stunden automatisch zu trennen. Am Ende jeder Verbindung, mindestens aber nach 24 Stunden, runden wir auf den n�chsten 100-KB-Block auf.";

public static $textTarifVodafoneMobileInternetFlat53 = "Mindestlaufzeit des Tarifes: 24 Monate, K�ndigungsfrist: 3 Monate; der Tarif ist erstmalig zum Ende der Mindestlaufzeit k�ndbar; wird nicht (rechtzeitig) gek�ndigt, verl�ngert er sich jeweils automatisch um ein weiteres Jahr.";

public static $textTarifVodafoneMobileInternetFlat1 = "Mindestlaufzeit des Tarifes: 24 Monate, K�ndigungsfrist: 3 Monate; der Tarif ist erstmalig zum Ende der Mindestlaufzeit k�ndbar; wird nicht (rechtzeitig) gek�ndigt, verl�ngert sie/er sich jeweils automatisch um ein weiteres Jahr.";

public static $textTarifVodafoneMobileInternetFlat2 = "Sie d�rfen den Tarif oder die Tarifoption nicht f�r Voice over IP und Peer to Peer nutzen.";

public static $textTarifVodafoneMobileInternetFlat336 = "Nutzung nur als Endkunde im daf�r �blichen Umfang: kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Bis zu einem Datenvolumen von 5 GB im jeweiligen Abrechungszeitraum wird jeweils die aktuell maximal verf�gbare Bandbreite Ihres Tarifs von bis zu 3,2 mbit/s bereitgestellt; ab 5 GB stehen max 64 kbit/s zur Verf�gung.";

public static $textTarifVodafoneMobileInternetFlat372 = "Nutzung nur als Endkunde im daf�r �blichen Umfang: kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Bis zu einem Datenvolumen von 5 GB im jeweiligen Abrechungszeitraum wird jeweils die aktuell maximal verf�gbare Bandbreite Ihres Tarifs von bis zu 7,2 mbit/s bereitgestellt; ab 5 GB stehen max 64 kbit/s zur Verf�gung.";

public static $textTarifVodafoneMobileInternetFlat3144 = "Nutzung nur als Endkunde im daf�r �blichen Umfang: kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Bis zu einem Datenvolumen von 5 GB im jeweiligen Abrechungszeitraum wird jeweils die aktuell maximal verf�gbare Bandbreite Ihres Tarifs von bis zu 14,4 mbit/s bereitgestellt; ab 5 GB stehen max 64 kbit/s zur Verf�gung.";

public static $textTarifVodafoneMobileInternetFlat3216 = "Nutzung nur als Endkunde im daf�r �blichen Umfang: kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Bis zu einem Datenvolumen von 5 GB im jeweiligen Abrechungszeitraum wird jeweils die aktuell maximal verf�gbare Bandbreite Ihres Tarifs von bis zu 21,6 mbit/s bereitgestellt; ab 5 GB stehen max 64 kbit/s zur Verf�gung.";

public static $textTarifVodafoneMobileInternetFlat4 = "Da das LTE Zuhause Internet Paket mit der von mir gew�nschten Bandbreite nicht zur Verf�gung steht, bin ich damit einverstanden, dass das gew�nschte Paket mit einer geringeren Bandbreite, jedoch mit dem vereinbarten Inklusiv-Datenvolumen / Monat zur Verff�gung gestellt wird.";

public static $textTarifVodafoneMobileInternetFlat5 = "Der Wechsel in einen SIMonly Tarif ist w�hrend der Mindestlaufzeit nicht m�glich.";

public static $textTarifVodafoneMobileInternetFlat72Promo = "Nutzung nur als Endkunde im daf�r �blichen Umfang: kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Die MobileInternet Flat 7,2 Promo enth�lt unbegrenztes Daten�bertragungsvolumen im deutschen Vodafone-Netz. Bis zu einem Datenvolumen von 1 GB steht Ihnen im jeweiligen Abrechnungszeitraum die aktuell maximal verf�gbare Bandbreite von bis zu 7,2 Mbit/s zur Verf�gung, danach max. 64 Kbit/s.";

public static $textTarifVodafoneMobileInternetFlat216Promo = "Nutzung nur als Endkunde im daf�r �blichen Umfang: kein Weiterverkauf, keine �berlassung an Dritte; kein Betrieb kommerzieller Dienste. Die MobileInternet Flat 21,6 Promo enth�lt unbegrenztes Daten�bertragungsvolumen im deutschen Vodafone-Netz. Bis zu einem Datenvolumen von 3 GB steht Ihnen im jeweiligen Abrechnungszeitraum die aktuell maximal verf�gbare Bandbreite von bis zu 21,6 Mbit/s zur Verf�gung, danach max. 64 Kbit/s.";

public static $textTarifMIFAPN = "Bei einem MobileInternet-Tarif oder einer MobileInternet-Option gilt Ihr Inklusiv-Volumen nur f�r den APN web.vodafone.de und nur im deutschen Vodafone-Mobilfunknetz.";

public static $textDienstZuhauseFlatrate1 = "Die Mindestlaufzeit betr�gt 3 Monate. Die K�ndigungsfrist betr�gt 2 Wochen. Die Option ist erstmalig zum Ablauf der Mindestlaufzeit k�ndbar. Wird die Option nicht rechtzeitig gek�ndigt, verl�ngert sich die Option jeweils automatisch um drei Monate. Bei Buchung mit Vodafone KombiComfort filt im Hinblick auf die Mindestlaufzeit der Tarifoption abweichend: DIe Mindestlaufzeit betr�gt 24 Monate. Die K�ndigungsfrist betr�gt 3 Monate. Die Option ist erstmalig zum Ende der Mindestlaufzeit k�ndbar. Wird die Option nicht rechtzeitig gek�ndigt, verl�ngert sie sich geweils automatisch um 12 Monate. Die Tarifoption endet automatisch mit Beendigung der Vodafone ZuhauseOption oder des Vodafone-Vertrages �ber die Hauptkarte.";

public static $textDienstZuhauseFlatrate2 = "Die Tarifoption Vodafone ZuhauseFlatrate und -HappyInternational gelten nicht f�r Rufumleitungen und Konferenzverbindungen. Der Kunde darf die Vodafone-Karte ausschlie�lich als Endkunde im daf�r  und nur zum Aufbau manuell �ber das Mobilfunkendger�t gew�hlter Verbindungen nutzen; unzul�ssig ist insbesondere die Nutzung zum Betrieb von Mehrwert- oder Massenkommunikationsdiensten (z.B. Faxbroadcastdiensten, Telemarketing- oder Call-Center-Leistungen), zur Erbringung von entgeltlichen oder unentgeltlichen Zusammenschaltungs- oder sonstigen Telekommunikationdiesnstleistungen f�r Dritte, zur Weitervermittlung von mobilfunkteilnehmern im Vodafone-Netz oder in andere netze �ber die Vodafone-Karte und zur Herstellung von Verbindungen, bei denen der Anrufer aufgrund des Anrufs und/oder in Abh�ngingkeit von der Dauert der Verbundung Zahlungen oder andere verm�genswerte Gegendienstleistungen Dritter erh�lt (z.B. Verbindungen zu Werbehotlines).";

public static $textDienstZuhauseOption1 = "F�r Verbindugnen mit der Vodafone ZuhauseOption ins dt. Festnetz gilt immer die 60/60 Taktung, auch wenn f�r Ihren Mobilfunktarif im �brigen eine andere Taktung vereinbart ist.";

public static $textDienstZuhauseOption2 = "Die Mindestlaufzeit betr�gt 2 Wochen. Die Option ist erstmalig zum Ablauf der Mindwestlaufzeit k�ndbar. Wird die Iotion nicht rechtzeitig gek�ndigt, verl�ngert sich die Option jeweils automatisch um drei Monate. Die Tarifoption endet automatisch mit Beendigung des Vodafone-Vertrages �ber die Hauptkarte. Abweichend von der Leistungsbeschreibung f�r Vodafone D2-Dienstleistungen gelten f�r die \"Vodafone Zuhause-Funktionalit�t\" folgende Vesonderheiten zum Leisuntsumfang:\na) Vodafone D2 teilt dem Kunden zus�tzluich zu seiner Vodafone-Mobilfunknummer eine neue Festnetznummer aus dem Vorwahlbereich zu, der seiner jeweils aktuellen Zuhause-adresse entspricht. Die Zuteilung dieser Festnetznummer erfolgt sp�testens innerhalb von 6 Wochen nach Antrag des Kunden.\nb) Die Nutzung von \"Vodafone Zuhause\" ist r�umlich auf die festgelegte Zuhause-Adresse beschr�nkt. Den ZuhauseBereich wird Vodafone D2 innerhalb von 5 Tagen nach Beauftragung einrichen. Vodafone D2 erfasst bei jeder Verbindung zu Abrechnungszwecken, ob sich der Kunde innerhalb oder au�erhalb des Zuhause Bereichs aufh�lt. Die Abrechnung zu \"Vodafone Zuhause\" -Konditionen wird jeweils durch einen Signalton zu Beginn eines jeden Gespr�ches angezeigt (Die zus�tzliche visuelle Information im Display des Mobiltelefons wird nicht von allen Endger�ten unterst�tz).\nc) Pro Hauptkarte in einem Tarif mit Mindestlaufzeit kann nur eine Karte in einem Tarif \"Vodafone ZuhauseTalk (Zusatz zu Laufzeitvertrag)\" zugebucht werden; die Hauptkarte darf keinem Gro�kundenrahmenvertrag zugeordnet sein und kenier sonstigen Rabattvereinbarung unterliegen.";

public static $textDienstHappyInternational1 = "Die Tarifoptionen Vodafone ZuhauseFlatrate und -HappyInternational gelten nicht f�r Rufumleitungen und Konferenzverbindungen. Der Kunde darf die Vodafone-Karte ausschlie�lich als Endkunde im daf�r �blichen Umfang und nur zum Aufbau manuell �ber das Mobilfunkenger�t gew�hlter Verbindungen nutzen; unzul�ssig ist insbesondere die Nutzung zum Betrieb von Mehrwert- oder Massenkommunikationsdiensten (z.B. Faxbroadcastdiensten, Telemarketing- oder Call-Center.Leistungen), zur Erbringung von entgeltlichen oder unentgeltlichen Zusammenschaltungs- oder sonstigen Telekommunikationsdienstleistungen f�r Dritte, zur WEitervermittlung von Mobilfunkteilnehmern im Vodafone-Netz oder in andere Netze �ber die Vodafone-Karte und zur Herstellung von Verbindungen, bei denen der Anrufer aufgrund des Anrufs und/oder in abh�ngigkeit von der Dauer der Verbindungs Zahlungem oder ander verm�genswerte Gegenleistungen Dritter erh�lt (z.b. Verbindungen zu Werbehotlines).";

public static $textDienstHappyInternational2 = "Die Tarifoption Vodafone HappyInternational (\"HappyInternational\") setzt zu jedem Zeitpunkt einen Vodafone-Kundenvertrag einschlie�lich der Tarifoption Vodafone Zuhause Option und Vodafone Zuhause Flatrate oder einen Vodafone Kundenvertrag in einem der Tarife Vodafone SuperFlat, -SuperFlat(SIM Only) oder -Zuhause Talk24 voraus. Die Mindestlaufzeit von happyInternational betr�gt 24 Monate; sofern der Vodafone-Kundenvertrag bei Buchung von HappyInternational eine k�rzere verbleibende Mindestlaufzeit als 24 Monate aufweist, verk�rzt sich die Mindestlaufzeit von HappyInternational au fden gleichen Zeitraum. Wird die Mindestlaufzeit des Vodafone-Kundenvertrages verl�ngert, verl�ngert sich die Mindestlaufzeit von HappyInternational entsprechend. HappyInternational ist erstmalig zum Ende der jeweiligen Mindestlaufzeit k�ndbar. Wird HappyInternational nicht (rechtzeitig) gek�ndigt, verl�ngert es sich jeweils automatisch um ein Jahr.";

public static $textDienstHappyWochenendeAbend = "Zus�tzlicher monatlicher Paketpreis/Aufpreis gem�� Preisliste f�r Vodafone-MinutenPakete. Die Mindestlaufzeit der Option betr�gt 3 Monate; die K�ndigungsfrist 2 Wochen. Die Option ist erstamals zum Ende der Mindestlaufzeit k�ndbar. Wird nicht (rechtzeitig) gek�ndigt, verl�ngert sich die Option automatisch jeweils um 1 Monat.";

public static $textDienstSmsFremdnetzPaket = "Zus�tzlicher monatlicher Paketpreis/Aufpreis gem�� Preisliste f�r Vodafone-MinutenPakete.";

public static $textDienstHappyLiveBroadband = "Vertragsbestandteil ist die Tarifoption Happy Live! Broadband. Der monatliche Basispreis erh�ht sich dadurch um 2,50 Euro monatlich gegen�ber dem in der Preisliste zum heweiligen gebuchten Tarif ausgewiesenen monatlichen Basispreis. Dies gilt auch im Fall eines oder mehrerer Tarifwechsel nach Tarifoptionen. Die K�ndigungsfrist f�r die Tarifoption HappyLive! Broadband betr�gt 3 monate, die Mindestlaufzeit 24 Monate, beginnend mit der Unterzeichnung dieses Auftrages. Die Tarifoption ist erstmals zum Ende der Mindestlaufzeit k�ndbar. Wird die Tarifoption nicht (rechtzeitig) gek�ndigt, verl�ngert sie sich jeweils automatisch um einen Monat. Der Erh�hungsbetrag wird auf der Rechnung gesondert ausgewiesen.";

public static $textDienstMusikPaket = "Mtl. Paketpreis 10 EUR f�r 10 Music-Downloads und 1 Std. RadioDJ (minutengenaue Abrechnung bei Channel- o. Collectionwechsel u. am Verbindungsende). Nicht genutzte Inklusivleistungen sind jeweils nicht in den Folgemonat �bertragbar. Die Dienste sind nur im Vodafone live!-Portal mit f. d. Dienst geeignetem Handy nutzbar. Die Mindestlaufzeit der Tarifoption/des Zusatzdienstes betr�gt 24 Monate, die K�ndigungsfrist 2 Wochen. Die Tarifoption/ der Zusatzdienst ist erstmals zum Ende der Mindestlaufzeit k�ndbar. Wird nicht gek�ndigt, verl�ngert sich die Tarifoption/ der Zusatzdienst jeweils um einen weiteren Monat.";

public static $textDienstWebContentTime1 = "Bei vorhandener HSDPA-Versorgung und HSDPA f�higem Endger�t ist HSDPA bis 31.07.2007 ohne zus�tzliche Berechnung nutzbar. Danach werden f�r eine HSDPA-Freischaltung 5,00 EUR/Monat berechnet. Eine Voice-over-IP-Nutzung wird ab dem 08.07.2007 technisch unterbunden.";

public static $textDienstWebContentTime2 = "Die Mindestvertragslaufzeit der Tarifoption/ des Zusatzdienstes betr�gt 24 Monate, die K�ndigungsfrist 3 Monate. Die Tarifoptio/ der Zusatzdienst ist erstmalig zum Ende der Mindestlaufzeit k�ndbar. Wird nicht gek�ndigt, verl�ngert sich die Tarifoption/ der Zusatzdienst jeweils um ein weiteres Jahr.";

//public static $textDienstStudentenrabatt = "Der Studenten-Vorteil wird nur gew�hrt, sofern und solange die folgenden Voraussetzungen erf�llt sind:\n- Eine aktuelle Legitimationsbescheinigung (= deutsche Immatrikulationsbescheinigung, deutscher Studentenausweis, deutscher Sch�lerausweis einer allgemeinbildenden oder Berufschule, deutscher Wehr- oder Ersatzdienstausweis oder deutscher Ausweis �ber die Teilnahme an einem freiwilligen sozialen Jahr) wird Vodafone bei Vertragsabschlu� vorgelegt.\n- Das Alter betr�gt maximal 30 Jahre.\n- EIne Lastschrift-Einzugserm�chtigung wird erteilt.\n- Es liegt kein sonstiger mobilfunkvertrag mit Studenten-Konditionen bei einem Mobilfunkanbieter im Vodafone D2-Netz vor.\n- Die Vodafone-Karte darf keinem Gro�kundenrahmenvertrag zugeordnet sein und keiner sonstigen Rabattvereinbarung unterliegen.\nDer Studenten- Vorteil wird f�r folgende Dauer gew�hrt:\n- F�r Wehrpflichtige, Zivildienstleistende und Absolventeneines freiwilligen sozialen Jahres max. 1 Jahr\n- im �brigen solange die oben genannten Voraussetzungen erf�llt bleiben und eine aktuelle Legitimationsbescheinigung j�hrlich vorgelegt wird.\nMir ist bekannt, dass eine automatische Umstellung der Vodafone-Karte in den von mir gew�hlten Ausgangstarif ohne Studenten-Vorteil erfolgt, wenn eine der oben genannten Voraussetzungen nicht vorliegt oder sp�ter entf�llt oder wenn der Vertrag �ber die Vodafone-karte auf eine andere Person �bertragen wird.\nDie Konditionen des Studenten-Vorteils ergeben sich erg�nzend zu der Preisliste f�r Vodafone-Tarife aus dem Tarif-Flyer Studenten-Rabatt.\n\nLegitimation f�r Studenten-Rabatt:\n Ort der (Hoch-)Schule/T�tigkeit:   public static $enti[StudentOrt] \n Geburtsdatum:                       public static $enti[StudentGeburtsdatum] ";

public static $text200MB = "Der Kunde darf d. Vodafone-Karte ausschlie�lich als Endkunde im daf�r �blichen Umfang und nur f�r Verbindungen, die manuell �ber die Hardware aufgebaut werden, nutzen. Eine Weiterver�u�erung sowie unentgeltliche �berlassung des Dienstes an Dritte u. d. Nutzung zum Betrieb kommerzieller Dienste sind unzul�ssig. Bis zu einem Datenvolumen von 200 MB im jeweiligen Abrechnungszeitraum wird die jeweils aktuell maximal verf�gbare Bandbreite bereitgestellt, ab 200 MB stehen max. 64 kbit/s zur Verf�gung. Vodafone beh�lt sich vor, nach 24 h jeweils eine automatische Trennung der Verbindung durchzuf�hren.";

public static $textZHFNTarifwechsel = "Tarifwechsel in andere Mobilfunktarife sind ausgeschlossen.";

public static $textPrivatnutzungKarte = "Sie d�rfen als Kunde die Vodafone-Karte ausschlie�lich als Privatkunde im daf�r �blichen Umfang und nur f�r Verbindungen, die manuell �ber die Hardware aufgebaut werden, nutzen. Eine Weiterver�u�erung sowie unentgeltliche �berlassung des Dienstes an Dritte u. d. Nutzung zum Betrieb kommerzieller Dienste sind unzul�ssig. Beim Surfen im deutschen Vodafone-Netz auf http-basierten Internet-Seiten (�ber die APN wap.vodafone.de und web.vodafone.de.), f�llt ein Preis von 0,19 Euro pro MB an. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf den n�chsten 100 KBBlock auf. Die maximal verf�gbare Bandbreite ist 7,2 MBit/s. Vodafone pr�ft ab Einrichtung des Tarifes w�hrend Ihrer Vertragslaufzeit, ob eine zus�tzliche Datenoption f�r Ihr Nutzungsverhalten g�nstiger w�re und richtet diese mit einer monatlichen Laufzeit f�r Sie ein. Vodafone informiert Sie dar�ber per SMS. Vodafone beh�lt sich vor, nach 24 h jeweils eine automatische Trennung der Verbindung durchzuf�hren.";

public static $textTarifSuper100SMS = "Nutzung nur f�r manuell �ber das Endger�t erstellte SMS zul�ssig. Die gewerbliche Nutzung ist ausgeschlossen. Alle �ber die Inklusivleistung von 100 SMS hinausgehenden SMS werden gem�� den Konditionen des zugrundeliegenden Vertrages abgerechnet.";

public static $textTarifSuper50SMS = "Nutzung nur f�r manuell �ber das Endger�t erstellte SMS zul�ssig. Die gewerbliche Nutzung ist ausgeschlossen. Alle �ber die Inklusivleistung von 50 SMS hinausgehenden SMS werden gem�� den Konditionen des zugrundeliegenden Vertrages abgerechnet.";

public static $textTarifSuperDatenvolumen = "Die Nutzung des inklusiven Datenvolumens ist nur mit Handy gestattet. F�r die Nutzung mit einem Computer, einem ans Handy angeschlossenen oder drahtlos verbundenen Computers gilt das inklusive Datenvolumen nicht, diese wird gem�� ihrem Tarif berechnet.";

public static $textDienstBILDplusDigital = " Vodafone BILDplus DIGITAL Promo24
� Zugang zu Nachrichten von BILDplus Digital und Bundesliga bei BILD
� 500 MB Highspeed-Volumen zus�tzlich inklusive
� Nach 24 Monaten endet der Zugang zu BILDplus Digital und Bundesliga bei BILD sowie das 500 MB Highspeed-Volumen automatisch
� Inhaltlich verantwortlich f�r BILDplus Digital und Bundesliga bei Bild Nachrichten und die Applikation selbst ist die Axel Springer AG, es gelten die Bedingungen der Axel Springer AG. Das Angebot erfolgt im Namen und Rechnung von Vodafone";

public static $textDienstDatenOptionM = "Die Tarifoption hat eine Mindestlaufzeit von 24 Monaten, die aber sp�testens mit der Mindestlaufzeit des zugrunde liegenden Vodafone-Vertrags endet.Das Inklusiv-Datenvolumenbetr�gt 200 MB im jeweiligen Abrechnungszeitraum, bei Nutzung �ber 200 MB hinaus f�llt ein Preis von 2,50 Euro pro 50 MB-Block an. Die maximal verf�gbare Bandbreite ist 7,2 Mbit/s. Vodafone beh�lt sich vor, nach 24 h jeweils eine automatische Trennung der Verbindung durchzuf�hren.Sie d�rfen die Tarifoption nur mit Ihrem internetf�higen Handy nutzen. Mit einem Computer, einem ans Handy angeschlossenen oder drahtlos verbundenen Computer d�rfen Sie die Tarifoption nicht nutzen. Sie d�rfen die Tarifoption nicht f�r Voice over IP, Instant Messaging und Peer to Peer nutzen. Durch den zugrunde liegenden Vodafone-Vertrag entstehen weitere Kosten.";

public static $textDienstDatenOptionS = "Die Tarifoption hat eine Mindestlaufzeit von 24 Monaten, die aber sp�testens mit der Mindestlaufzeit des zugrunde liegenden Vodafone-Vertrags endet. Das Inklusiv-Datenvolumenbetr�gt 50 MB im jeweiligen Abrechnungszeitraum, bei Nutzung �ber 50 MB hinaus f�llt ein Preis von 0,19 Euro pro MB an. Pro Verbindung, mindestens aber nach 24 Stunden, runden wir auf den n�chsten 100 KB-Block auf. Die maximal verf�gbare Bandbreite ist 7,2 Mbit/s. Vodafone pr�ft ab Einrichtung des Tarifes w�hrend Ihrer Vertragslaufzeit, ob eine zus�tzliche Datenoption f�r Ihr Nutzungsverhalten g�nstiger w�re und richtet diese mit einer monatlichen Laufzeit f�r Sie ein. Vodafone informiert Sie dar�ber per SMS. Vodafone beh�lt sich vor, nach 24 h jeweils eine automatische Trennung der Verbindung durchzuf�hren.Sie d�rfen die Tarifoption nur mit Ihrem internetf�higen Handy nutzen. Mit einem Computer, einem ans Handy angeschlossenen oder drahtlos verbundenen Computer d�rfen Sie die Tarifoption nicht nutzen. Sie d�rfen die Tarifoption nicht f�r Voice over IP, Instant Messaging und Peer to Peer nutzen. Durch den zugrunde liegenden Vodafone-Vertrag entstehen weitere Kosten.";

public static $textBlackBerryInternet = "Sie haben 50 MB pro Monat f�r BlackBerry-Internet-Services inklusive. F�r Nutzung, die dar�ber hinaus geht, zahlen Sie 0,49 Euro pro MB.";

public static $basic100sim1 = "mtl. Paketpreis 14,99 � f�r 24 Monate, danach mtl. 19,99�. Mindestlaufzeit 24 Monate, einmalige Anschlusskosten 29,99 �.";

public static $basic100sim2 = "Tarif enth�lt 100 Min. in alle dt. Netze und ins dt. Festnetz sowie 100 SMS in alle dt. Netze. Beim Surfen im dt. Vodafone-Netz steht Ihnen ein Inklusiv-Datenvolumen von 200 MB/Monat (statt regul�r 100 MB) zur Verf�gung. Bei Nutzung bis 200 MB pro Abrechnungszeitraum steht Ihnen eine Bandbreite von bis zu 7,2 MBit/s zur Verf�gung, danach bis zu 64 KBit/s.";

public static $basic100sim3 = "F�r Nutzung �ber Inklusiv-Leistungen hinaus ggf. weitere Kosten je nach Verbrauch, z. B. Standardgespr�che in dt. Mobilfunknetze 0,29 �/Min. (60/60-Takt) oder 0,19 �/Standard-SMS.";

public static $basic100sim4 = "Tethering, Voice-over-IP- und Peer-to-Peer-Kommunikation nicht gestattet.";

public static $basic100sim5 = "Nicht verbrauchte Inklusiv-Leistungen nicht in den Folgemonat �bertragbar.";

}