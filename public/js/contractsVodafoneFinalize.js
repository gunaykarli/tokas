$(document).ready(function()
{
    //--begin: Default set up

    // Private, SoHo or Business
    $('#finalizeContractDiv').hide();

    //--end: Default set up


    $('#isContractReadyToFinalize').change(function ()
    {
        if(this.checked === true){
            $('#finalizeContractDiv').show();
        }
        else{
            $('#finalizeContractDiv').hide();
        }
    });
});
