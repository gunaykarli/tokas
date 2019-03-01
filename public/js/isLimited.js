$(document).ready(function()
{

    //** If 'valid to' date of the tariff to be created is not defined then 'tariffValidToIndefined' checkbox is checked and 'tariffValidTo' is disabled
    $('#tariffValidToIndefinite').change(function () {
        if(this.checked === true)
            $('#tariffValidTo').hide();
        else
            $('#tariffValidTo').show();
    });

    //** If 'valid to' date of provision the tariff to be created is not defined then 'provisionValidToIndefinite' checkbox is checked and 'provisionValidTo' is disabled
    $('#provisionValidToIndefinite').change(function () {
        if(this.checked === true)
            $('#provisionValidTo').hide();
        else
            $('#provisionValidTo').show();
    });

    //** If tariff to be created is applied to all region the 'allRegion' checkbox is checked.
    $('.all-regions').show();
    $('#allRegions').change(function ()
    {
        if(this.checked === true)
            $('.all-regions').hide();
        else
            $('.all-regions').show();

    });

    //** If the tariff to be created is limited tariff then related form appear when the checkbox checked.
    $('.is-limited').hide();
    $('#isLimited').change(function()
    {
        if(this.checked === true)
            $('.is-limited').show();
        else
            $('.is-limited').hide();

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