$(document).ready(function()
{

    //** If tariff to be created has on-top, 'ontop' checkbox is checked.
    $('.on-top-dealer-dependency').hide();
    $('.on-top-dealers').hide();
    $('.on-top-categories').hide();
    $('.on-top-regions').hide();
    $('.on-top-amount').hide();


    // if there is an 'ontop' with the tariff to be created, 'ontop' check box is activated.
    $('#ontop').change(function ()
    {
        if(this.checked === true)
            $('.on-top-dealer-dependency').show();
        else{
            $('.on-top-dealer-dependency').hide();
            $('.on-top-dealer-dependency').hide();
            $('.on-top-dealers').hide();
            $('.on-top-categories').hide();
            $('.on-top-regions').hide();
            $('.on-top-amount').hide();
        }
    });

    // Which dealers will get the ontop...
    $('.on-top-dealer-dependency').change(function ()
    {
        selectedValue = $("input[name='ontopDealerDependency']:checked").val();

        if(selectedValue == 1){ // all dealers
            $('.on-top-amount').show();

            $('.on-top-dealers').hide();
            $('.on-top-categories').hide();
            $('.on-top-regions').hide();
        }
        else if(selectedValue == 2){ // selected dealers
            $('.on-top-amount').show();
            $('.on-top-dealers').show();

            $('.on-top-categories').hide();
            $('.on-top-regions').hide();
        }
        else if(selectedValue == 3){ // dealers with certain categories
            $('.on-top-categories').show();
            $('.on-top-amount').show();

            $('.on-top-dealers').hide();
            $('.on-top-regions').hide();
        }
        else if(selectedValue == 4){ // dealers in certain regions
            $('.on-top-regions').show();
            $('.on-top-amount').show();

            $('.on-top-dealers').hide();
            $('.on-top-categories').hide();
        }
    });
});
