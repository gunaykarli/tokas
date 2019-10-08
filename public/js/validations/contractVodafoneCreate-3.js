$(document).ready(function()
{
    alert('Enterr');
    //$('.IBAN').mask('DE99 9999 9999 9999 999 99');
    $('#IBAN').inputmask({"mask": "DE99 9999 9999 9999 9999 99"});

    $("#contractVodafoneCreateForm").validate({
        // Hidden fields are not validated
        ignore: ":hidden",

        /** rules **/
        rules: {
            additionalContractCustomerNumber: {
                required: {
                    depends: function(element){
                        if('on' === $('#additionalContract').val())
                            return true;
                        else
                            return false;
                    }
                },
                maxlength: 9,
            },
            // begin: rules for private customer section
            mainCustomerPassword: {
                required: true,
            },
            mainCustomerSalutation:{
                required: {
                    depends: function(element){
                        if('0' === $('#mainCustomerSalutation').val()){
                            //Set predefined value to blank.
                            $('#mainCustomerSalutation').val('');
                        }
                        return true;
                    }
                }
            },
            mainCustomerSurname:{
                required: true,
                maxlength:30,
            },
            mainCustomerName:{
                required: true,
                maxlength:30,
            },
            mainCustomerContactPerson:{
                required: true,
                maxlength:30,
            },
            mainCustomerBirthDate:{
                required: true,
            },
            mainCustomerIDCardType:{
                required: {
                    depends: function(element){
                        if('0' === $('#mainCustomerIDCardType').val()){
                            //Set predefined value to blank.
                            $('#mainCustomerIDCardType').val('');
                        }
                        return true;
                    }
                }
            },
            mainCustomerIDNumber:{
                required: true,
                digits: {
                    depends: function (element) {
                        if($('#mainCustomerIDCardType').val() == '1')
                            return true;
                        else
                            return false;
                    }
                },
                minlength:1,
                maxlength:10,
            },
            // end: rules for private customer section

            // -----

            // begin: rules for business customer section
            xxx:{
                required: true,
            },
            // end: rules for business customer section

            // -----

            // begin: rules for customer address section
            mainCustomerStreet:{
                required: true,
            },
            mainCustomerHouseNumber:{
                required: true,
            },
            mainCustomerCity:{
                required: true,
            },
            mainCustomerPostalCode:{
                required: true,
            },
            mainCustomerEmail:{
                email: {
                    depends: function (element) {
                        if($('#mainCustomerEmail').val() != '')
                            return true;
                        else
                            return false;
                    }
                },
            },
            mainCustomerEmailConfirmation:{
                equalTo: "#mainCustomerEmail"
            },
            mainCustomerAreaCode:{
                required: true,
                digits: true,
                minlength: 3,
                maxlength: 3,
            },
            mainCustomerTelephone:{
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 8,
            },
            // end: rules for customer address section

            // -----

            // begin: rules for payment method "Bankverbindung" customer section
            IBAN:{
                required: true,
                minlength: 22,
            },
            // end: rules for payment method "Bankverbindung" customer section

            // -----

            portingTelephoneNumber: {
                required: true,
            },
        },

        /** messages **/
        messages: {
            additionalContractCustomerNumber: {
                required: "Pflichtfeld",
                maxlength:"Das Feld darf maximal 9 Zeichen enthalten.",
            },
            // begin: messages for private customer section
            mainCustomerPassword: {
                required: "Pflichtfeld",
            },
            mainCustomerSalutation:{
                required: "Pflichtfeld",
            },
            mainCustomerSurname:{
                required: "Pflichtfeld",
                maxlength:"Das Feld darf maximal 30 Zeichen enthalten.",
            },
            mainCustomerName:{
                required: "Pflichtfeld",
                maxlength:"Das Feld darf maximal 30 Zeichen enthalten.",
            },
            mainCustomerContactPerson:{
                required: "Pflichtfeld",
                maxlength:"Das Feld darf maximal 30 Zeichen enthalten.",
            },
            mainCustomerBirthDate:{
                required: "Pflichtfeld",
            },
            mainCustomerIDCardType:{
                required: "Pflichtfeld",
            },
            mainCustomerIDNumber:{
                required: "Pflichtfeld",
                digits: "Bitte geben Sie nur Zahlen ein",
                minlength:"Das Feld darf minimal 1 Zeichen enthalten.",
                maxlength:"Das Feld darf maximal 10 Zeichen enthalten.",
            },
            // end: messages for private customer section

            // -----

            // begin: messages for business customer section
            xxx:{
                required: true,
            },
            // end: messages for business customer section

            // -----

            // begin: messages for customer address section
            mainCustomerStreet:{
                required: "Pflichtfeld",
            },
            mainCustomerHouseNumber:{
                required: "Pflichtfeld",
            },
            mainCustomerCity:{
                required: "Pflichtfeld",
            },
            mainCustomerPostalCode:{
                required: "Pflichtfeld",
            },
            mainCustomerEmail:{
                email: "Bitte eine gültige E-Mail-Adresse eintragen",
            },
            mainCustomerEmailConfirmation:{
                equalTo: "Bitte geben Sie die gleiche E-Mail-Adresse ein",
            },
            mainCustomerAreaCode:{
                required:  "Pflichtfeld",
                digits: "Bitte geben Sie nur Zahlen ein",
                minlength: "Das Feld darf minimal 3 Zeichen enthalten.",
                maxlength: "Das Feld darf minimal 3 Zeichen enthalten.",
            },
            mainCustomerTelephone:{
                required:  "Pflichtfeld",
                digits: "Bitte geben Sie nur Zahlen ein",
                minlength: "Das Feld darf minimal 8 Zeichen enthalten.",
                maxlength: "Das Feld darf minimal 8 Zeichen enthalten.",
            },
            // end: messages for customer address section

            // -----

            // begin: messages for payment method "Bankverbindung" customer section
            IBAN:{
                required:  "Pflichtfeld",
                minlength: "Bitte geben Sie eine gültige IBAN ein.",
            },
            // end: messages for payment method "Bankverbindung" customer section

            // -----

        },

        /** errorPlacement **/
        errorPlacement:
            function(error, element) {
                if (element.is(":radio"))
                    $("#" + $(element).attr('name') + "-ErrorSpan").html(error);
                else if (element.is(":checkbox"))
                    //$("#" + $(element).attr('name') + "-ErrorSpan").html(error);
                    error.appendTo(element.next());
                else{
                    $("#" + $(element).attr('name') + "-ErrorSpan").html(error);
                    //error.appendTo(element.next());
                    //error.insertAfter(element);
                    //error.appendTo(element.next().html($(element).attr('name')));
                    //alert ($("input[name='IMEIOption']:checked").val());
                }
            },
    })




});