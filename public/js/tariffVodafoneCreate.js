$(document).ready(function()
{
    //--begin: Default set up

    // Copy from the other tariff / select from the tariff list
    $('#tariffListDiv').hide();
    $('#lawTextListDiv').hide();


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



});
