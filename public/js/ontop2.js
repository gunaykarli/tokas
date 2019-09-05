$(document).ready(function()
{

    //** If tariff to be created has on-top, 'ontop' checkbox is checked.
    //$('.on-top-dealer-dependency').show();
    $('.on-top-groups').hide();
    $('.on-top-tariffs').hide();

    $('.on-top-dealers').hide();
    $('.on-top-categories').hide();
    $('.on-top-regions').hide();
    $('.on-top-amount').hide();
    //$('.on-top-cloning').hide();


    // Determine the tariffs with on-top...
    $('.on-top-tariff-dependency').change(function ()
    {
        selectedValue = $("input[name='ontopTariffDependency']:checked").val();

        if(selectedValue == 1){ // all dealers
            $('.on-top-groups').hide();
            $('.on-top-tariffs').hide();
        }
        else if(selectedValue == 2){ // selected dealers
            $('.on-top-groups').show();
            $('.on-top-tariffs').hide();
        }
        else if(selectedValue == 3){ // dealers with certain categories
            $('.on-top-groups').hide();
            $('.on-top-tariffs').show();
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
            $('.on-top-cloning').hide();
        }
        else if(selectedValue == 2){ // selected dealers
            $('.on-top-amount').show();
            $('.on-top-dealers').show();

            $('.on-top-categories').hide();
            $('.on-top-regions').hide();
            $('.on-top-cloning').hide();
        }
        else if(selectedValue == 3){ // dealers with certain categories
            $('.on-top-categories').show();
            $('.on-top-amount').show();

            $('.on-top-dealers').hide();
            $('.on-top-regions').hide();
            $('.on-top-cloning').hide();
        }
        else if(selectedValue == 4){ // dealers in certain regions
            $('.on-top-regions').show();
            $('.on-top-amount').show();

            $('.on-top-dealers').hide();
            $('.on-top-categories').hide();
            $('.on-top-cloning').hide();
        }
        else if(selectedValue == 5){ // on top cloning
            $('.on-top-cloning').show();
            $('.on-top-amount').show();

            $('.on-top-dealers').hide();
            $('.on-top-categories').hide();
            $('.on-top-regions').hide();
        }
    });
});
