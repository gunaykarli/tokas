$(document).ready(function() {
    //--begin: For dealer creating

    $('#limitedSales').change(function () {
        if(this.checked === true)
            $('#salesLimitDIV').show();
        else
            $('#salesLimitDIV').hide();
    });


    //--end: For dealer creating

    //--begin: For dealer editing

    // when the page is loaded visibility of the related element is set.
    var isDealerLimitedSales = $("input[name='limitedSales']").prop('checked');
    if(isDealerLimitedSales === true)
        $('#salesLimitDIV').show();
    else
        $('#salesLimitDIV').hide();

    // password change control
    $('#passwordDIV').hide();
    $('#passwordChange').change(function () {
        if(this.checked === true)
            $('#passwordDIV').show();
        else
            $('#passwordDIV').hide();
    });


    //--begin: For dealer editing


});