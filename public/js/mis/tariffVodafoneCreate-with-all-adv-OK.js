$(document).ready(function()
{
    //--begin: Default set up

    // Copy from the other tariff / select from the tariff list
    $('#tariffListDiv').hide();
    $('#lawTextListDiv').hide();

    $('#newPropertyAttributeDIV').hide();
    $('#newPropertyValueDIV').hide();


    //--end: Default set up

    // According to the selected CUSTOMER type respective form is indicated.
    $('#lawTextOptionDiv').change(function ()
    {
        selectedValue = $("input[name='lawTextOption']:checked").val();
        if(selectedValue == 1){ // Copy from the other tariff
            $('#tariffListDiv').show();
            $('#lawTextListDiv').hide();
        }
        else if(selectedValue == 2){ //select from the tariff list
            $('#tariffListDiv').hide();
            $('#lawTextListDiv').show();
        }
    });

    // begin: property set

    // for tariff advantages

    /** begin: All advantages V2*/

    /** set up for DIV1*/
    $('#nameOfPropertySelectBox1').hide();
    $('#textOfValueSelectBox1').hide();
    $('#amountOfValue1').hide();
    $('#textOfValue1').hide();

    $('#tariffAdvantagesDIV2').hide();
    $('#addNewAdvantageCheckbox2').hide();
    $('#nameOfPropertySelectBox2').hide();
    $('#textOfValueSelectBox2').hide();
    $('#amountOfValue2').hide();
    $('#textOfValue2').hide();

    $('#addNewAdvantageCheckbox1').change(function () {
        if($("input[name='addNewAdvantageCheckbox1']").prop('checked')){

            $('#nameOfPropertySelectBox1').show();
            var selectedItemOfNameOfPropertySelectBox1 = 0;
            $('#nameOfPropertySelectBox1').change(function () {
                selectedItemOfNameOfPropertySelectBox1 = this.value;
                if(selectedItemOfNameOfPropertySelectBox1 != 0){

                    var selectedItemOfTextOfValueSelectBox1=0;
                    $('#textOfValueSelectBox1').show();
                    $('#textOfValueSelectBox1').change(function(){
                        selectedItemOfTextOfValueSelectBox1=this.value;
                        if(this.value == 0){ // please select
                            $('#amountOfValue1').hide();
                            $('#textOfValue1').hide();
                        }
                        else if(this.value == 1){ // new value
                            $('#amountOfValue1').show();
                            $('#textOfValue1').show();
                            $('#tariffAdvantagesDIV2').show();
                            $('#addNewAdvantageCheckbox2').show();
                        }
                        else if(this.value == 2 ){ // alle netze flat
                            $('#amountOfValue1').hide();
                            $('#textOfValue1').hide();
                            $('#tariffAdvantagesDIV2').show();
                            $('#addNewAdvantageCheckbox2').show();
                        }
                        else{ // values already in DB
                            $('#amountOfValue1').show();
                            $('#textOfValue1').hide();
                            $('#tariffAdvantagesDIV2').show();
                            $('#addNewAdvantageCheckbox2').show();
                        }
                    });
                }
                else{
                    $('#textOfValueSelectBox1').hide();
                    $('#amountOfValue1').hide();
                    $('#textOfValue1').hide();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox1').hide();
            $('#textOfValueSelectBox1').hide();
            $('#amountOfValue1').hide();
            $('#textOfValue1').hide();
        }
    });

    /** set up for DIV2 */
    $('#nameOfPropertySelectBox2').hide();
    $('#textOfValueSelectBox2').hide();
    $('#amountOfValue2').hide();
    $('#textOfValue2').hide();

    $('#tariffAdvantagesDIV3').hide();
    $('#addNewAdvantageCheckbox3').hide();
    $('#nameOfPropertySelectBox3').hide();
    $('#textOfValueSelectBox3').hide();
    $('#amountOfValue3').hide();
    $('#textOfValue3').hide();

    $('#addNewAdvantageCheckbox2').change(function () {
        if($("input[name='addNewAdvantageCheckbox2']").prop('checked')){

            $('#nameOfPropertySelectBox2').show();
            var selectedItemOfNameOfPropertySelectBox2 = 0;
            $('#nameOfPropertySelectBox2').change(function () {
                selectedItemOfNameOfPropertySelectBox2 = this.value;
                if(selectedItemOfNameOfPropertySelectBox2 != 0){

                    var selectedItemOfTextOfValueSelectBox2=0;
                    $('#textOfValueSelectBox2').show();
                    $('#textOfValueSelectBox2').change(function(){
                        selectedItemOfTextOfValueSelectBox2=this.value;
                        if(this.value == 0){ // please select
                            $('#amountOfValue2').hide();
                            $('#textOfValue2').hide();
                        }
                        else if(this.value == 1){ // new value
                            $('#amountOfValue2').show();
                            $('#textOfValue2').show();
                            $('#tariffAdvantagesDIV3').show();
                            $('#addNewAdvantageCheckbox3').show();
                            alert('show');
                        }
                        else if(this.value == 2 ){ // alle netze flat
                            $('#amountOfValue2').hide();
                            $('#textOfValue2').hide();
                            $('#tariffAdvantagesDIV3').show();
                            $('#addNewAdvantageCheckbox3').show();
                        }
                        else{ // values already in DB
                            $('#amountOfValue2').show();
                            $('#textOfValue2').hide();
                            $('#tariffAdvantagesDIV3').show();
                            $('#addNewAdvantageCheckbox3').show();
                        }
                    });
                }
                else{
                    $('#textOfValueSelectBox2').hide();
                    $('#amountOfValue2').hide();
                    $('#textOfValue2').hide();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox2').hide();
            $('#textOfValueSelectBox2').hide();
            $('#amountOfValue2').hide();
            $('#textOfValue2').hide();
        }
    });

    /** set up for DIV3 */
    $('#nameOfPropertySelectBox3').hide();
    $('#textOfValueSelectBox3').hide();
    $('#amountOfValue3').hide();
    $('#textOfValue3').hide();

    $('#tariffAdvantagesDIV4').hide();
    $('#addNewAdvantageCheckbox4').hide();
    $('#nameOfPropertySelectBox4').hide();
    $('#textOfValueSelectBox4').hide();
    $('#amountOfValue4').hide();
    $('#textOfValue4').hide();

    $('#addNewAdvantageCheckbox3').change(function () {
        if($("input[name='addNewAdvantageCheckbox3']").prop('checked')){

            $('#nameOfPropertySelectBox3').show();
            var selectedItemOfNameOfPropertySelectBox3 = 0;
            $('#nameOfPropertySelectBox3').change(function () {
                selectedItemOfNameOfPropertySelectBox3 = this.value;
                if(selectedItemOfNameOfPropertySelectBox3 != 0){

                    var selectedItemOfTextOfValueSelectBox3=0;
                    $('#textOfValueSelectBox3').show();
                    $('#textOfValueSelectBox3').change(function(){
                        selectedItemOfTextOfValueSelectBox3=this.value;
                        if(this.value == 0){ // please select
                            $('#amountOfValue3').hide();
                            $('#textOfValue3').hide();
                        }
                        else if(this.value == 1){ // new value
                            $('#amountOfValue3').show();
                            $('#textOfValue3').show();
                            $('#tariffAdvantagesDIV4').show();
                            $('#addNewAdvantageCheckbox4').show();
                        }
                        else if(this.value == 2 ){ // alle netze flat
                            $('#amountOfValue3').hide();
                            $('#textOfValue3').hide();
                            $('#tariffAdvantagesDIV4').show();
                            $('#addNewAdvantageCheckbox4').show();
                        }
                        else{ // values already in DB
                            $('#amountOfValue3').show();
                            $('#textOfValue3').hide();
                            $('#tariffAdvantagesDIV4').show();
                            $('#addNewAdvantageCheckbox4').show();
                        }
                    });
                }
                else{
                    $('#textOfValueSelectBox3').hide();
                    $('#amountOfValue3').hide();
                    $('#textOfValue3').hide();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox3').hide();
            $('#textOfValueSelectBox3').hide();
            $('#amountOfValue3').hide();
            $('#textOfValue3').hide();
        }
    });

    /** set up for DIV4 */
    $('#nameOfPropertySelectBox4').hide();
    $('#textOfValueSelectBox4').hide();
    $('#amountOfValue4').hide();
    $('#textOfValue4').hide();

    $('#tariffAdvantagesDIV5').hide();
    $('#addNewAdvantageCheckbox5').hide();
    $('#nameOfPropertySelectBox5').hide();
    $('#textOfValueSelectBox5').hide();
    $('#amountOfValue5').hide();
    $('#textOfValue5').hide();

    $('#addNewAdvantageCheckbox4').change(function () {
        if($("input[name='addNewAdvantageCheckbox4']").prop('checked')){

            $('#nameOfPropertySelectBox4').show();
            var selectedItemOfNameOfPropertySelectBox4 = 0;
            $('#nameOfPropertySelectBox4').change(function () {
                selectedItemOfNameOfPropertySelectBox4 = this.value;
                if(selectedItemOfNameOfPropertySelectBox4 != 0){

                    var selectedItemOfTextOfValueSelectBox4=0;
                    $('#textOfValueSelectBox4').show();
                    $('#textOfValueSelectBox4').change(function(){
                        selectedItemOfTextOfValueSelectBox4=this.value;
                        if(this.value == 0){ // please select
                            $('#amountOfValue4').hide();
                            $('#textOfValue4').hide();
                        }
                        else if(this.value == 1){ // new value
                            $('#amountOfValue4').show();
                            $('#textOfValue4').show();
                            $('#tariffAdvantagesDIV5').show();
                            $('#addNewAdvantageCheckbox5').show();
                        }
                        else if(this.value == 2 ){ // alle netze flat
                            $('#amountOfValue4').hide();
                            $('#textOfValue4').hide();
                            $('#tariffAdvantagesDIV5').show();
                            $('#addNewAdvantageCheckbox5').show();
                        }
                        else{ // values already in DB
                            $('#amountOfValue4').show();
                            $('#textOfValue4').hide();
                            $('#tariffAdvantagesDIV5').show();
                            $('#addNewAdvantageCheckbox5').show();
                        }
                    });
                }
                else{
                    $('#textOfValueSelectBox4').hide();
                    $('#amountOfValue4').hide();
                    $('#textOfValue4').hide();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox4').hide();
            $('#textOfValueSelectBox4').hide();
            $('#amountOfValue4').hide();
            $('#textOfValue4').hide();
        }
    });


    /** set up for DIV5 */

    $('#nameOfPropertySelectBox5').hide();
    $('#textOfValueSelectBox5').hide();
    $('#amountOfValue5').hide();
    $('#textOfValue5').hide();

    $('#addNewAdvantageCheckbox5').change(function () {
        if($("input[name='addNewAdvantageCheckbox5']").prop('checked')){

            $('#nameOfPropertySelectBox5').show();
            var selectedItemOfNameOfPropertySelectBox5 = 0;
            $('#nameOfPropertySelectBox5').change(function () {
                selectedItemOfNameOfPropertySelectBox5 = this.value;
                if(selectedItemOfNameOfPropertySelectBox5 != 0){

                    var selectedItemOfTextOfValueSelectBox5=0;
                    $('#textOfValueSelectBox5').show();
                    $('#textOfValueSelectBox5').change(function(){
                        selectedItemOfTextOfValueSelectBox5=this.value;
                        if(this.value == 0){ // please select
                            $('#amountOfValue5').hide();
                            $('#textOfValue5').hide();
                        }
                        else if(this.value == 1){ // new value
                            $('#amountOfValue5').show();
                            $('#textOfValue5').show();
                        }
                        else if(this.value == 2 ){ // alle netze flat
                            $('#amountOfValue5').hide();
                            $('#textOfValue5').hide();
                        }
                        else{ // values already in DB
                            $('#amountOfValue5').show();
                            $('#textOfValue5').hide();
                        }
                    });
                }
                else{
                    $('#textOfValueSelectBox5').hide();
                    $('#amountOfValue5').hide();
                    $('#textOfValue5').hide();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox5').hide();
            $('#textOfValueSelectBox5').hide();
            $('#amountOfValue5').hide();
            $('#textOfValue5').hide();
        }
    });



    /** end: All advantages V2*/


    /** begin: tariff advantages V1*/
    // when the page is loaded
    $('#valueOfTelephonyTextDIV').hide();
    $('#valueOfInternetTextDIV').hide();
    $('#valueOfSMSTextDIV').hide();

    // telephony
    $('#amountOfValueForTelephony').hide();
    $('#textOfValueForTelephony').hide();

    $('#telephonyDIV1').hide();
    $('#amountOfValueForTelephony1').hide();
    $('#textOfValueForTelephony1').hide();

    var selectedValueOfTelephonySelectBox=0;
    $('#textOfValueForTelephonySelectBox').change(function()
    {
        selectedValueOfTelephonySelectBox=this.value;
        if(this.value == 0){ // please select
            $('#amountOfValueForTelephony').hide();
            $('#textOfValueForTelephony').hide();
            $('#telephonyDIV1').hide();
        }
        else if(this.value == 1){ // new value
            $('#amountOfValueForTelephony').show();
            $('#textOfValueForTelephony').show();
            $('#telephonyDIV1').show();
        }
        else if(this.value === 2 ){ // alle netze flat
            $('#amountOfValueForTelephony').hide();
            $('#textOfValueForTelephony').hide();
            $('#telephonyDIV1').show();
        }
        else{ // values already in DB
            $('#amountOfValueForTelephony').show();
            $('#textOfValueForTelephony').hide();
            $('#telephonyDIV1').show();
        }
    });

    // internet
    $('#amountOfValueForInternet').hide();
    $('#textOfValueForInternet').hide();

    var selectedValueOfInternetSelectBox=0;
    $('#textOfValueForInternetSelectBox').change(function()
    {
        selectedValueOfInternetSelectBox=this.value;
        if(this.value == 0){ // please select
            $('#amountOfValueForInternet').hide();
            $('#textOfValueForInternet').hide();
        }
        else if(this.value == 1){ // new value
            $('#amountOfValueForInternet').show();
            $('#textOfValueForInternet').show();
        }
        else if(this.value === 2 ){ // alle netze flat
            $('#amountOfValueForInternet').hide();
            $('#textOfValueForInternet').hide();
        }
        else{ // values already in DB
            $('#amountOfValueForInternet').show();
            $('#textOfValueForInternet').hide();
        }
    });

    //SMS
    $('#amountOfValueForSMS').hide();
    $('#textOfValueForSMS').hide();

    var selectedValueOfSMSSelectBox=0;
    $('#textOfValueForSMSSelectBox').change(function()
    {
        selectedValueOfSMSSelectBox=this.value;
        if(this.value == 0){ // please select
            $('#amountOfValueForSMS').hide();
            $('#textOfValueForSMS').hide();
        }
        else if(this.value == 1){ // new value
            $('#amountOfValueForSMS').show();
            $('#textOfValueForSMS').show();
        }
        else if(this.value === 2 ){ // alle netze flat
            $('#amountOfValueForSMS').hide();
            $('#textOfValueForSMS').hide();
        }
        else{ // values already in DB
            $('#amountOfValueForSMS').show();
            $('#textOfValueForSMS').hide();
        }
    });

    //** value for Telephony-Internet-SMS text field will be visible if valueOf(Telephony-Internet-SMS)Checkbox is unchecked.
    $('#valueOfTelephonyCheckbox').change(function()
    {
        if(this.checked === true){
            $('#valueOfTelephonyTextDIV').hide();
        }
        else{
            $('#valueOfTelephonyTextDIV').show();
        }
    });
    $('#valueOfInternetCheckbox').change(function()
    {
        if(this.checked === true){
            $('#valueOfInternetTextDIV').hide();
        }
        else{
            $('#valueOfInternetTextDIV').show();
        }
    });
    $('#valueOfSMSCheckbox').change(function()
    {
        if(this.checked === true){
            $('#valueOfSMSTextDIV').hide();
        }
        else{
            $('#valueOfSMSTextDIV').show();
        }
    });
    // end: property set

    /** end: tariff advantages V1*/


    /** begin: highlight set */
    $('#saveAndContinue').click(function () {
        var setHighlight1 = "";
        var setHighlight2 = "";
        var setHighlight3 = "";
        var setHighlight4 = "";
        var setHighlight5 = "";
        var setHighlight6 = "";
        var setHighlight7 = "";
        var setHighlight8 = "";
        $('#highlight1').val("");
        $('#highlight2').val("");
        $('#highlight3').val("");
        $('#highlight4').val("");
        $('#highlight5').val("");
        $('#highlight6').val("");
        $('#highlight7').val("");
        $('#highlight8').val("");


        if($("input[name='flatTelephonyCheckbox']").prop('checked')){
            setHighlight1 = "Telefonie-Flat in alle dt. Netz";
            $('#highlight1').val(setHighlight1);
        }

        if($("input[name='flatSMSCheckbox']").prop('checked')){
            setHighlight2 = "SMS-Flat in alle dt. Netz";
            $('#highlight2').val(setHighlight2);
        }

        if($("input[name='flatInternetCheckbox']").prop('checked') && $('#dataVolume').val() !== "" && $('#bandwidth').val() !== ""){//
            if($("input[name='LTECapable']").prop('checked'))
                setHighlight3 = "Internet Flat - " + $('#dataVolume').val() + " GB" + " bis zu " + $('#bandwidth').val() + " Mbit/s" + " LTE-fähig";
            else
                setHighlight3 = "Internet Flat - " + $('#dataVolume').val() + " GB" + " bis zu " + $('#bandwidth').val() + " Mbit/s";

            $('#highlight3').val(setHighlight3);
        }

        // highlight from "new tariff advantages" section.
        // it can be set up after all the values saved to the db. OR as below

        // begin: to add new highlight
        if($("input[name='addNewAdvantageCheckbox1']").prop('checked')){
            if($("#textOfValueSelectBox1 option:selected").val() != 0){ // if selected
                if($("#textOfValueSelectBox1 option:selected").val() == 1){ // new value for highlight
                    alert('setHighlightX: ' + $("#textOfValueSelectBox1 option:selected").val());

                    setHighlight4 = $('#amountOfValue1').val() + " " + $('#textOfValue1').val();
                    $('#highlight4').val(setHighlight4);
                }
                else{
                    alert('setHighlightX: ' + $("#textOfValueSelectBox1 option:selected").val());
                    setHighlight4 = $('#amountOfValue1').val() + " " + $("#textOfValueSelectBox1 option:selected").val();
                    $('#highlight4').val(setHighlight4);
                }
            }
        }

        if($("input[name='addNewAdvantageCheckbox2']").prop('checked')){
            if($("#textOfValueSelectBox2 option:selected").val() != 0){ // if selected
                if($("#textOfValueSelectBox2 option:selected").val() == 1){ // new value for highlight
                    alert('setHighlightY: ' + $("#textOfValueSelectBox2 option:selected").val());

                    setHighlight5 = $('#amountOfValue2').val() + " " + $('#textOfValue2').val();
                    $('#highlight5').val(setHighlight5);
                }
                else{
                    alert('setHighlightX: ' + $("#textOfValueSelectBox2 option:selected").val());
                    setHighlight5 = $('#amountOfValue2').val() + " " + $("#textOfValueSelectBox2 option:selected").val();
                    $('#highlight5').val(setHighlight5);
                }
            }
        }

        if($("input[name='addNewAdvantageCheckbox3']").prop('checked')){
            if($("#textOfValueSelectBox3 option:selected").val() != 0){ // if selected
                if($("#textOfValueSelectBox3 option:selected").val() == 1){ // new value for highlight
                    alert('setHighlightY: ' + $("#textOfValueSelectBox3 option:selected").val());

                    setHighlight6 = $('#amountOfValue3').val() + " " + $('#textOfValue3').val();
                    $('#highlight6').val(setHighlight6);
                }
                else{
                    alert('setHighlightX: ' + $("#textOfValueSelectBox3 option:selected").val());
                    setHighlight6 = $('#amountOfValue3').val() + " " + $("#textOfValueSelectBox3 option:selected").val();
                    $('#highlight6').val(setHighlight6);
                }
            }
        }

        if($("input[name='addNewAdvantageCheckbox4']").prop('checked')){
            if($("#textOfValueSelectBox4 option:selected").val() != 0){ // if selected
                if($("#textOfValueSelectBox4 option:selected").val() == 1){ // new value for highlight
                    alert('setHighlightY: ' + $("#textOfValueSelectBox4 option:selected").val());

                    setHighlight7 = $('#amountOfValue4').val() + " " + $('#textOfValue4').val();
                    $('#highlight7').val(setHighlight7);
                }
                else{
                    alert('setHighlightX: ' + $("#textOfValueSelectBox4 option:selected").val());
                    setHighlight7 = $('#amountOfValue4').val() + " " + $("#textOfValueSelectBox4 option:selected").val();
                    $('#highlight7').val(setHighlight7);
                }
            }
        }

        if($("input[name='addNewAdvantageCheckbox5']").prop('checked')){
            if($("#textOfValueSelectBox5 option:selected").val() != 0){ // if selected
                if($("#textOfValueSelectBox5 option:selected").val() == 1){ // new value for highlight
                    alert('setHighlightY: ' + $("#textOfValueSelectBox5 option:selected").val());

                    setHighlight8 = $('#amountOfValue5').val() + " " + $('#textOfValue5').val();
                    $('#highlight8').val(setHighlight8);
                }
                else{
                    alert('setHighlightX: ' + $("#textOfValueSelectBox5 option:selected").val());
                    setHighlight8 = $('#amountOfValue5').val() + " " + $("#textOfValueSelectBox5 option:selected").val();
                    $('#highlight8').val(setHighlight8);
                }
            }
        }

        // end: to add new highlight

    });



    // when the page is loaded
    $('#newHighlightText1').hide();
    $('#newHighlightDIVGROUP2').hide();
    $('#newHighlightText2').hide();
    $('#newHighlightDIVGROUP3').hide();
    $('#newHighlightText3').hide();

    $('#newHighlightCheckbox1').change(function()
    {
        if(this.checked === true){
            $('#newHighlightText1').show();
            $('#newHighlightDIVGROUP2').show();
            $('#newHighlightText2').hide();

            $('#newHighlightDIVGROUP3').hide();
        }
        else{
            $('#newHighlightText1').hide();
            $('#newHighlightDIVGROUP2').hide();
            $('#newHighlightCheckbox2').attr('checked', false);// not working
            $('#newHighlightText2').hide();

            $('#newHighlightDIVGROUP3').hide();
            $('#newHighlightCheckbox3').attr('checked', false);// not working
        }
    });

    $('#newHighlightCheckbox2').change(function()
    {
        if(this.checked === true){
            $('#newHighlightText2').show();
            $('#newHighlightDIVGROUP3').show();
            $('#newHighlightText3').hide();
        }
        else{
            $('#newHighlightText2').hide();
            $('#newHighlightDIVGROUP3').hide();
            $('#newHighlightText3').hide();
            $('#newHighlightCheckbox3').attr('checked', false);// not working
        }
    });

    $('#newHighlightCheckbox3').change(function()
    {
        if(this.checked === true){
            $('#newHighlightText3').show();
        }
        else{
            $('#newHighlightText3').hide();
        }
    });

    /** end: highlight set */



});
