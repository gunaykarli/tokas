$(document).ready(function()
{

    //**
    $('.sectionForPrivateCustomer').show();
    $('.sectionForBusinessCustomer').hide();

    // According to the selected CUSTOMER type respective form is indicated.
    $('#customerTypes').change(function ()
    {
        alert('customerTypes has been chnaged');
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

    // According to the selected CONTRACT type respective form is indicated.
    $('#contractTypes').change(function ()
    {
        selectedValueContractType = $("input[name='contractType']:checked").val();
        if(selectedValueContractType == 1){ //New Contract
            $('.sectionForDCChange').hide();
            $('.sectionForPorting').hide();
        }
        else if(selectedValueContractType == 2){ // Porting
            $('.sectionForPorting').show();
            $('.sectionForDCChange').hide();

        }
        else{ // DC Change
            $('.sectionForDCChange').show();
            $('.sectionForPorting').hide();
        }
    });
});
