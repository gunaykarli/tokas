//== Class definition
var WizardDemo = function () {
    //== Base elements
    var wizardEl = $('#m_wizard');
    var formEl = $('#m_form');
    var validator;
    var wizard;
    alert(19100);
    
    //== Private functions
    var initWizard = function () {
        //== Initialize form wizard
        wizard = new mWizard('m_wizard', {
            startStep: 1
        });

        //== Validation before going to next page
        wizard.on('beforeNext', function(wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        })

        //== Change event
        wizard.on('change', function(wizard) {
            mUtil.scrollTop();
        });

        //== Change event
        wizard.on('change', function(wizard) {
            if (wizard.getStep() === 1) {
                alert('geri geldi');
            }           
        });
    }

    var initValidation = function() {
        validator = formEl.validate({
            //== Validate only visible fields
            ignore: ":hidden",

            //== Validation rules
            rules: {
                //=== Client Information(step 1)
                //== Client details
                name: {
                    required: false
                },

                e_mail: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                },

                //== Mailing address
                address: {
                    required: true
                },

                city: {
                    required: true
                },
                country: {
                    required: true
                },

                //=== Client Information(step 2)
                //== Account Details
                account_username: {
                    required: true,
                    minlength: 4
                },
                account_password: {
                    required: true,
                    minlength: 6
                },

                //== Client Settings
                account_group: {
                     required: true
                },
                'account_communication[]': {
                    required: true
                },

                //=== Client Information(step 3)
                //== Billing Information
                billing_card_name: {
                    required: true
                },
                billing_card_number: {
                    required: true,
                    creditcard: true
                },
                billing_card_exp_month: {
                    required: true
                },
                billing_card_exp_year: {
                    required: true
                },
                billing_card_cvv: {
                    required: true,
                    minlength: 2,
                    maxlength: 3
                },

                //== Billing Address1
                billing_address_1: {
                    required: true
                },
                billing_address_2: {
                    
                },
                billing_city: {
                    required: true
                },
                billing_state: {
                    required: true
                },
                billing_zip: {
                    required: true,
                    number: true
                },
                billing_delivery: {
                    required: true
                },

                //=== Confirmation(step 4)
                accept: {
                    required: true
                }
            },

            //== Validation messages
            messages: {
                'account_communication[]': {
                    required: 'You must select at least one communication option'
                },
                accept: {
                    required: "You must accept the Terms and Conditions agreement!"
                } 
            },
            
            //== Display error  
            invalidHandler: function(event, validator) {     
                mUtil.scrollTop();

                swal({
                    "title": "", 
                    "text": "There are some errors in your submission. Please correct them.", 
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                });
            },

            //== Submit valid form
            submitHandler: function (form) {
                success.show();
                error.show();
                form[0].submit(); //submit the form
                alert('333');
            }
        });   
    }

    var initSubmit = function() {
        var btn = formEl.find('[data-wizard-action="submit"]');

        btn.on('click', function(e) {
            e.preventDefault();

            if (validator.form()) {
                //== See: src\js\framework\base\app.js
                mApp.progress(btn);
                //mApp.block(formEl);

                //== See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                    success: function() {
                        mApp.unprogress(btn);
                        //mApp.unblock(formEl);

                        swal({
                            "title": "", 
                            "text": "The application has been successfully submitted!", 
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                        alert('66-reset');
                        //mApp.reset(formEl);
                    }

                });
                alert('44');
            }
            alert('55');
            //location.href="index";
        });


    }
    alert('22');
    return {
        // public functions
        init: function() {
            wizardEl = $('#m_wizard');
            formEl = $('#m_form');

            initWizard(); 
            initValidation();
            initSubmit();
            alert('Sayfa yüklendi-3');
        }
    };

}();

jQuery(document).ready(function() {    
    WizardDemo.init();
});
