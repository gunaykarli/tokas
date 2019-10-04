$(document).ready(function()
{

    //** If 'valid to' date of provision the tariff to be created is not defined then 'provisionValidToIndefinite' checkbox is checked and 'provisionValidTo' is disabled
    $('#provisionValidToIndefinite').change(function () {
        if(this.checked === true)
            $('#provisionValidTo').hide();
        else
            $('#provisionValidTo').show();
    });


    /* In property section, network and provider will take their value from the element of the form in the previous section
    $('#Netz').val($("#networkID option:selected" ).text());
    $('#networkID').change(function () {
        //$('#tariffName').val($("#networkID option:selected" ).text());
        $('#Netz').val($("#networkID option:selected" ).text());
    });
    $("#Netz").attr("disabled", "disabled");
    $("#Provider").attr("disabled", "disabled");
    */


});