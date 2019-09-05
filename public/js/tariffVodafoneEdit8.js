$(document).ready(function()
{
    //--begin: Default set up

    // Copy from the other tariff / select from the tariff list
    $('#tariffListDiv').hide();
    $('#lawTextListDiv').hide();


    // set if the tariff is unlimited (it is not related to the limit which indicates amount of the tariff...) it means "valid_to" field of the tariff is null. In this case "tariffValidToIndefinite" check box is "on"
    tariffValidToIndefinite = $("input[name='tariffValidToIndefinite']").prop('checked');
    if(tariffValidToIndefinite === true)
        $('#tariffValidTo').hide();
    else
        $('#tariffValidTo').show();

    // set the tariff's limit "valid from" and "to" input which is related to the dates that the amount of the tariff is valid.
    isTariffLimited = $("input[name='isLimited']").val();
    if(isTariffLimited === 'on'){
        $('.is-limited').show();
    }
    else{
        $('.is-limited').hide();
    }

    //** If the tariff to be created is limited tariff then related form appear when the checkbox checked.
    $('#isLimited').change(function()
    {
        if(this.checked === true)
            $('.is-limited').show();
        else
            $('.is-limited').hide();

    });

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

    // Default: set visibility of the elements that show "gültüg ab/gültüg bis" depending on the status of the tariff
    statusOfTariff = $("input[name='tariffStatus']").prop('checked');

    alert("statusOfTarife: " + statusOfTariff);
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

    /** EDITABILITY OF THE SECTIONS

    /** set the editability of the tariffBasicsDIV including tariff basics to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    istariffDetailDIVEditable = $("input[name='editTariffBasics']").val();

    if(istariffDetailDIVEditable === 'off') {
        $("#tariffBasicsDIV").find("*").prop('disabled', true);
        //$("#tariffBasicsDIV").addClass("disabledbutton");
        //$('#tariffBasicsDIV:input[type=text]').prop('disabled', true);
        //$('#tariffDetailsDIV:input[type=text]').attr('disabled', 'disabled');
    }
    else
        $("#tariffBasicsDIV").find("*").prop('disabled', false);

    $('#editTariffBasics').change(function(){
            if(this.checked === true){
                $("#tariffBasicsDIV").find("*").prop('disabled', false);
            }
            else{
                $("#tariffBasicsDIV").find("*").prop('disabled', true);
            }
        }
    );

    /** set the editability of the regionsDIV including tariff regions info to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    editRegions = $("input[name='editRegions']").val();

    if(editRegions === 'off')
        $("#regionsDIV").find("*").prop('disabled', true);
    else
        $("#regionsDIV").find("*").prop('disabled', false);

    $('#editRegions').change(function(){
            if(this.checked === true){
                $("#regionsDIV").find("*").prop('disabled', false);
            }
            else{
                $("#regionsDIV").find("*").prop('disabled', true);
            }
        }
    );

    /** set the editability of the limitDIV including  the limit info to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    editLimit = $("input[name='editLimit']").val();

    if(editLimit === 'off')
        $("#limitDIV").find("*").prop('disabled', true);
    else
        $("#limitDIV").find("*").prop('disabled', false);

    $('#editLimit').change(function(){
            if(this.checked === true){
                $("#limitDIV").find("*").prop('disabled', false);
            }
            else{
                $("#limitDIV").find("*").prop('disabled', true);
            }
        }
    );

    /** set the editability of the propertiesDIV including  the property info to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    editProperties = $("input[name='editProperties']").val();

    if(editProperties === 'off')
        $("#propertiesDIV").find("*").prop('disabled', true);
    else
        $("#propertiesDIV").find("*").prop('disabled', false);

    $('#editProperties').change(function(){
            if(this.checked === true){
                $("#propertiesDIV").find("*").prop('disabled', false);
            }
            else{
                $("#propertiesDIV").find("*").prop('disabled', true);
            }
        }
    );

    /** set the editability of the plausibilityDIV including  the plausibility info to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    editPlausibility = $("input[name='editPlausibility']").val();

    if(editPlausibility === 'off')
        $("#plausibilityDIV").find("*").prop('disabled', true);
    else
        $("#plausibilityDIV").find("*").prop('disabled', false);

    $('#editPlausibility').change(function(){
            if(this.checked === true){
                $("#plausibilityDIV").find("*").prop('disabled', false);
            }
            else{
                $("#plausibilityDIV").find("*").prop('disabled', true);
            }
        }
    );

    /** set the editability of the serviceDIV including  the service info to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    editServices = $("input[name='editServices']").val();

    if(editServices === 'off')
        $("#serviceDIV").find("*").prop('disabled', true);
    else
        $("#serviceDIV").find("*").prop('disabled', false);

    $('#editServices').change(function(){
            if(this.checked === true){
                $("#serviceDIV").find("*").prop('disabled', false);
            }
            else{
                $("#serviceDIV").find("*").prop('disabled', true);
            }
        }
    );

    /** set the editability of the lawTextDIV including  the law text info to be edited.*/
    // when the page is loaded, all elements in the DIV will be disabled
    editLawTexts = $("input[name='editLawTexts']").val();
    alert('editLawTexts *' + editLawTexts);
    if(editServices === 'off')
        $("#lawTextDIV").find("*").prop('disabled', true);
    else
        $("#lawTextDIV").find("*").prop('disabled', false);

    $('#editLawTexts').change(function(){
            if(this.checked === true){
                $("#lawTextDIV").find("*").prop('disabled', false);
            }
            else{
                $("#lawTextDIV").find("*").prop('disabled', true);
            }
        }
    );

});
