$(document).ready(function()
{
    alert('Enteredg');
    // it will ve shown if IMEI option 3 is selected...
    $('#IMEINumber-Div').hide();

    // IMEI option is set up; IMEINumber by customer
    $('#IMEIOptions').change(function ()
    {
        selectedValue = $("input[name='IMEIOption']:checked").val();
        if(selectedValue == 3){ // enter IMEINumber by customer
            $('#IMEINumber-Div').show();
        }
        else
            $('#IMEINumber-Div').hide();
    });


    $("#enterSimEmeiServices").validate({

            rules: {
                SIMNumber: {
                    required: true,
                    digits:true,
                    minlength: 14,
                    maxlength:14,
                },

                IMEIOption: {
                    required: true,
                },

                IMEINumber:{
                    /*
                    required:{
                        function(){
                            if($("input[name='IMEIOption']:checked").val() == 3)
                                return true;
                            else
                                return false;
                        }
                    },
                    */
                    digits:true,
                    minlength: 15,
                    maxlength:15,
                },

                connectionFee: {
                    required: true,
                },
            },
            messages: {

                SIMNumber: {
                    required: "Bitte geben Sie eine gültige SIM-Nummer ein",
                    digits: "Bitte geben Sie nur Zahlen ein",
                    minlength: "Die SIM-Nummer sollte 14-stellig sein",
                    maxlength: "Die SIM-Nummer sollte 14-stellig sein",
                },

                IMEIOption: {
                    required: "Bitte wählen Sie eine Option",
                },

                IMEINumber: {
                    //required: "Bitte geben Sie Zahlen ein",
                    digits: "Bitte geben Sie nur Zahlen ein",
                    minlength: "Die SIM-Nummer sollte 15-stellig sein",
                    maxlength: "Die SIM-Nummer sollte 15-stellig sein",
                },

                connectionFee: {
                    required: "Bitte wählen Sie eine Option",
                },
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio"))
                    $("#" + $(element).attr('name') + "-ErrorSpan").html(error);
                else if (element.is(":checkbox"))
                    error.appendTo(element.next());
                else{
                    //alert ($("input[name='IMEIOption']:checked").val());
                    $("#" + $(element).attr('name') + "-ErrorSpan").html(error);
                    //error.insertAfter(element);
                    //error.appendTo(element.next().html($(element).attr('name')));
                }
            },
    })
});