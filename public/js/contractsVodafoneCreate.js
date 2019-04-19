$(document).ready(function()
{

    //**
    $('.sectionForPrivateCustomer').show();
    $('.sectionForBusinessCustomer').hide();

    // According to the selected customer type respective form is indicated.
    $('#customerTypes').change(function ()
    {
        selectedValue = $("input[name='customerType']:checked").val();
        if(selectedValue == 1){ // private/SOHo customer
            $('.sectionForPrivateCustomer').show();
            $('.sectionForBusinessCustomer').hide();
        }
        else if(selectedValue == 2){ // business customer
            $('.sectionForPrivateCustomer').hide();
            $('.sectionForBusinessCustomer').show();
        }
    });
});
