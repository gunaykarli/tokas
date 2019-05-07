$(document).ready(function()
{
    //--begin: Default set up

    // Private, SoHo or Business
    $('.sectionForPrivateCustomer').show();
    $('.sectionForBusinessCustomer').hide();

    // Contract Type: default is new
    $('.sectionForDCChange').hide();
    $('.sectionForPorting').hide();

    // Additional Contract
    $('#additionalContractCustomerNumberLabel').hide();
    $('#additionalContractCustomerNumber').hide();

    // Different account owner text field and address section should be hidden as a default.
    $('#accountOwnerDiv').hide();
    $('.differentAccountOwnerAddressDiv').hide();

    // Invoice Type
    $('.onlineInvoiceDiv').hide();
    $('.differentInvoiceAddress').hide();

    //--end: Default set up

    // According to the selected CUSTOMER type respective form is indicated.
    $('#customerTypes').change(function ()
    {
        alert('customerTypes has been changed');
        selectedValue = $("input[name='customerType']:checked").val();
        if(selectedValue == 1 || selectedValue == 3){ // private/SOHo customer
            $('.sectionForPrivateCustomer').show();
            $('.sectionForBusinessCustomer').hide();
        }
        else if(selectedValue == 2){ // business customer
            $('.sectionForPrivateCustomer').hide();
            $('.sectionForBusinessCustomer').show();
        }
    });

    // According to the selected CONTRACT type, respective form is indicated.
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

    // In case a different account owner
    $('#isAccountOwnerDifferent').change(function ()
    {
        if(this.checked === true){
            $('#accountOwnerDiv').show();
            $('.differentAccountOwnerAddressDiv').show();
        }
        else{
            $('#accountOwnerDiv').hide();
            $('.differentAccountOwnerAddressDiv').hide();
        }
    });
    // In case a different account owner and different account owner address
    $('#isAccountOwnerAddressDifferent').change(function (){
        if(this.checked === true)
            $('.differentAccountOwnerAddress').show();
        else
            $('.differentAccountOwnerAddress').hide();
    });

    // ADDITIONAL contract
    $('#additionalContract').change(function (){
        if(this.checked === true){
            $('#additionalContractCustomerNumber').show();
            $('#additionalContractCustomerNumberLabel').show();
        }
        else{
            $('#additionalContractCustomerNumberLabel').hide();
            $('#additionalContractCustomerNumber').hide();
        }
    });

    // Invoice Type
    $('#invoiceTypes').change(function ()
    {
        selectedValueInvoiceType = $("input[name='invoiceType']:checked").val();
        if(selectedValueInvoiceType == 1){//paper invoice
            $('.onlineInvoiceDiv').hide();
            $('.paperInvoiceDiv').show();
        }
        else if(selectedValueInvoiceType == 2){//online invoice
            $('.paperInvoiceDiv').hide();
            $('.onlineInvoiceDiv').show();
        }
    });

    // Invoice Type - Different Invoice address
    $('#isInvoiceAddressDifferent').change(function ()
    {
        if(this.checked === true){
            $('.differentInvoiceAddress').show();
        }
        else{
            $('.differentInvoiceAddress').hide();
        }
    });

});
