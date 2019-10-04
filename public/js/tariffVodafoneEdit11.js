$(document).ready(function()
{
    //--begin: Default set up

    // Copy from the other tariff / select from the tariff list
    $('#tariffListDiv').hide();
    $('#lawTextListDiv').hide();


    /** begin: Amount limit of the tariff */
    // If the tariff to be created is amount limited tariff then related limit text field appears when the checkbox checked.
    // when the page is loaded visibility of the related element is set.
    var isTariffLimited = $("input[name='isLimited']").prop('checked');
    if(isTariffLimited === true)
        $('.is-limited').show();
    else
        $('.is-limited').hide();

    // when "isLimited" checkbox is changed
    $('#isLimited').change(function()
    {
        if(this.checked === true)
            $('.is-limited').show();
        else
            $('.is-limited').hide();

    });
    /** end: Amount limit of the tariff */

    /** begin: Status of the tariff*/
    // Default: set visibility of the elements that show "gültüg ab/gültüg bis" depending on the status of the tariff
    statusOfTariff = $("input[name='tariffStatus']").prop('checked');
    if(statusOfTariff === true){
        $('.tariffValidationDateDIV').show();
    }
    else{
        $('.tariffValidationDateDIV').hide();
    }

    // set visibility of the elements that show "gültüg ab gültüg bis" depending on the status of the tariff
    $('#tariffStatus').change(function(){
            if(this.checked === true){
                $('.tariffValidationDateDIV').show();
            }
            else{
                $('.tariffValidationDateDIV').hide();
            }
        }
    );
    /** end: Status of the tariff*/

    /** begin: Time limit of the tariff */
    // set if the tariff is unlimited (it is not related to the limit which indicates amount of the tariff...)
    // it means "valid_to" field of the tariff is null.
    // In this case "tariffValidToIndefinite" check box is "on"
    // when the page is loaded visibility of the related element is set.
    tariffValidToIndefinite = $("input[name='tariffValidToIndefinite']").prop('checked');
    if(tariffValidToIndefinite === true)
        $('#tariffValidTo').hide();
    else
        $('#tariffValidTo').show();

    // If 'valid to' date of the tariff to be created is not defined then 'tariffValidToIndefined' checkbox is checked and
    // 'tariffValidTo' is disabled
    $('#tariffValidToIndefinite').change(function () {
        if(this.checked === true)
            $('#tariffValidTo').hide();
        else
            $('#tariffValidTo').show();
    });
    /** end: Time limit of the tariff */

    // set the tariff's limit "valid from" and "to" input which is related to the dates that the amount of the tariff is valid.

    /** begin: Region of the tariff*/
    //** If tariff to be created is applied to all region the 'allRegion' checkbox is checked.
    $('.all-regions').show();
    $('#allRegions').change(function ()
    {
        if(this.checked === true)
            $('.all-regions').hide();
        else
            $('.all-regions').show();

    });
    /** end: Region of the tariff*/


    /** begin: property set */
    /** begin: All tariff advantages V3*/

    /** set up for DIV1 */
    $('#nameOfPropertySelectBox1').hide();
    $('#textOfValue1').hide();

    //$('#tariffAdvantagesDIV2').hide();
    $('#addNewAdvantageCheckbox2').hide();
    $('#nameOfPropertySelectBox2').hide();
    $('#textOfValue2').hide();

    $('#addNewAdvantageCheckbox1').change(function () {
        if($("input[name='addNewAdvantageCheckbox1']").prop('checked')){
            $('#nameOfPropertySelectBox1').show();
            $('#nameOfPropertySelectBox1').change(function () {
                if(this.value == 0){ // please select
                    $('#textOfValue1').hide();
                }
                else{ // telephony, internet, SMS or others are selected
                    $('#textOfValue1').show();
                    $('#addNewAdvantageCheckbox2').show();
                    $('#tariffAdvantagesDIV2').show();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox1').hide();
            $('#textOfValue1').hide();
        }
    });

    /** set up for DIV2 */
    $('#nameOfPropertySelectBox2').hide();
    $('#textOfValue2').hide();

    //$('#tariffAdvantagesDIV3').hide();
    $('#addNewAdvantageCheckbox3').hide();
    $('#nameOfPropertySelectBox3').hide();
    $('#textOfValue3').hide();

    $('#addNewAdvantageCheckbox2').change(function () {
        if($("input[name='addNewAdvantageCheckbox2']").prop('checked')){
            $('#nameOfPropertySelectBox2').show();
            $('#nameOfPropertySelectBox2').change(function () {
                if(this.value == 0){ // please select
                    $('#textOfValue2').hide();
                }
                else{ // telephony, internet, SMS or others are selected
                    $('#textOfValue2').show();
                    $('#addNewAdvantageCheckbox3').show();
                    $('#tariffAdvantagesDIV3').show();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox2').hide();
            $('#textOfValue2').hide();
        }
    });

    /** set up for DIV3 */
    $('#nameOfPropertySelectBox3').hide();
    $('#textOfValue3').hide();

    $('#addNewAdvantageCheckbox3').change(function () {
        if($("input[name='addNewAdvantageCheckbox3']").prop('checked')){
            $('#nameOfPropertySelectBox3').show();
            $('#nameOfPropertySelectBox3').change(function () {
                if(this.value == 0){ // please select
                    $('#textOfValue3').hide();
                }
                else{ // telephony, internet, SMS or others are selected
                    $('#textOfValue3').show();
                }
            });
        }
        else{
            $('#nameOfPropertySelectBox3').hide();
            $('#textOfValue3').hide();
        }
    });
    /** end: All advantages V3*/

    /** begin: editing process for DIV1, DIV2 and DIV3*/
    // when page loaded set visibility of elements are set...
    $('#addNewAdvantageCheckbox1').show();
    if($("input[name='addNewAdvantageCheckbox1']").prop('checked')){
        $('#nameOfPropertySelectBox1').show();
        $('#textOfValue1').show();
        $('#addNewAdvantageCheckbox2').show();
        if($("input[name='addNewAdvantageCheckbox2']").prop('checked')){
            $('#nameOfPropertySelectBox2').show();
            $('#textOfValue2').show();
            $('#addNewAdvantageCheckbox3').show();
            if($("input[name='addNewAdvantageCheckbox3']").prop('checked')){
                $('#nameOfPropertySelectBox3').show();
                $('#textOfValue3').show();
            }
        }
    }
    /** end: editing process*/

    /** begin: highlight set */
    $('#highlight1DIV').hide();
    $('#highlight2DIV').hide();
    $('#highlight3DIV').hide();
    $('#highlight4DIV').hide();
    $('#highlight5DIV').hide();
    $('#highlight6DIV').hide();
    $('#highlight7DIV').hide();
    $('#highlight8DIV').hide();

    // All highlights will be shown when "show highlight" button is clickted.
    $('#showHighlights').click(function () {
        var setHighlight1 = "";
        var setHighlight2 = "";
        var setHighlight3 = "";
        var setHighlight4 = "";
        var setHighlight5 = "";
        var setHighlight6 = "";

        $('#highlight1').val("")
        $('#highlight2').val("");
        $('#highlight3').val("");
        $('#highlight4').val("");
        $('#highlight5').val("");
        $('#highlight6').val("");
        $('#highlight7').val("");
        $('#highlight8').val("");

        // for after first click...to refresh the highlights
        $('#highlight1DIV').hide();
        $('#highlight2DIV').hide();
        $('#highlight3DIV').hide();
        $('#highlight4DIV').hide();
        $('#highlight5DIV').hide();
        $('#highlight6DIV').hide();
        $('#highlight7DIV').hide();
        $('#highlight8DIV').hide();

        if($("input[name='flatInternetCheckbox']").prop('checked') && $('#dataVolume').val() !== "" && $('#bandwidth').val() !== ""){//
            $('#highlight1DIV').show();

            if($("input[name='LTECapable']").prop('checked'))
                setHighlight1 = "Internet Flat - " + $('#dataVolume').val() + " GB" + " bis zu " + $('#bandwidth').val() + " Mbit/s" + " LTE-fähig";
            else
                setHighlight1 = "Internet Flat - " + $('#dataVolume').val() + " GB" + " bis zu " + $('#bandwidth').val() + " Mbit/s";

            $('#highlight1').val(setHighlight1);
        }
        else{
            $('#highlight1DIV').show();

            if($("input[name='LTECapable']").prop('checked'))
                setHighlight1 = "Internet Flat - " + $('#dataVolume').val() + " GB" + " bis zu " + $('#bandwidth').val() + " Mbit/s" + " - LTE-fähig";
            else
                setHighlight1 = "Internet Flat - " + $('#dataVolume').val() + " GB" + " bis zu " + $('#bandwidth').val() + " Mbit/s";

            $('#highlight1').val(setHighlight1);
        }

        if($("input[name='flatSMSCheckbox']").prop('checked')){
            $('#highlight2DIV').show();
            setHighlight2 = "SMS-Flat in alle dt. Netz";
            $('#highlight2').val(setHighlight2);
        }

        if($("input[name='flatTelephonyCheckbox']").prop('checked')){
            $('#highlight3DIV').show();
            setHighlight3 = "Telefonie-Flat in alle dt. Netz";
            $('#highlight3').val(setHighlight3);
        }



        // highlights from "new tariff advantages" section. (it can be set up after all the values saved to the db. OR as below)

        // begin: to add new highlight
        if($("input[name='addNewAdvantageCheckbox1']").prop('checked')){
            if($("#textOfValueSelectBox1 option:selected").val() != 0){ // if selected
                $('#highlight4DIV').show();
                setHighlight4 = $('#textOfValue1').val();
                $('#highlight4').val(setHighlight4);
            }
        }

        if($("input[name='addNewAdvantageCheckbox2']").prop('checked')){
            if($("#textOfValueSelectBox2 option:selected").val() != 0){ // if selected
                $('#highlight5DIV').show();
                setHighlight5 = $('#textOfValue2').val();
                $('#highlight5').val(setHighlight5);
            }
        }

        if($("input[name='addNewAdvantageCheckbox3']").prop('checked')){
            if($("#textOfValueSelectBox3 option:selected").val() != 0){ // if selected
                $('#highlight6DIV').show();
                setHighlight6 = $('#textOfValue3').val();
                $('#highlight6').val(setHighlight6);
            }
        }
        // end: to add new highlight
    });
    /** end: highlight set */

    /** begin: services */

    // when the page is been loaded, DIV including the item to change the services should be disabled.
    $('#serviceDIV *').prop('disabled',true);

    // After the page has been load, depending on the status of the "editServices" switch the DIV becomes active or passive
    $('#editServices').change(function () {
        if($("input[name='editServices']").prop('checked'))
            $('#serviceDIV *').prop('disabled',false);
        else
            $('#serviceDIV *').prop('disabled',true);
    });

    /** end: services */


    /** begin: Law text of the tariff*/
    // Default: set the law text options when the page is loaded
    lawTextOption = $("input[name='lawTextOption']:checked").val();
    if(lawTextOption == 1){ // Copy from the other tariff
        $('#tariffListDiv').show();
        $('#lawTextListDiv').hide();
    }
    else if(lawTextOption == 2){ //select from the tariff list
        $('#tariffListDiv').hide();
        $('#lawTextListDiv').show();
    }

    // According to the selected LAWTEXT input respective form is indicated.
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
    /** end: Law text of the tariff*/






});
