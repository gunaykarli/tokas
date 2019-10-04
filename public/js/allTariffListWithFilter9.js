$(document).ready(function(){

alert('group');
    $('#radioInLineProviders').change(function(){
        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var statusOfTariffs = $("input[name='statusOfTariffs']:checked").val();
        var networkID = $("#networkID").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var minDataVolume = $("#minDataVolume").val();
        var minBandWidth = $("#minBandWidth").val();
        var allNetFlatTelephony = $("input[name='allNetFlatTelephony']").prop('checked');
        var allNetFlatInternet = $("input[name='allNetFlatInternet']").prop('checked');
        var allNetFlatSMS = $("input[name='allNetFlatSMS']").prop('checked');
        var _token = $('input[name="_token"]').val();


        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{_token:_token,
                providerID:providerID,
                tariffGroupID:tariffGroupID,
                statusOfTariffs:statusOfTariffs,
                networkID:networkID,
                maxBasePrice:maxBasePrice,
                minDataVolume:minDataVolume,
                minBandWidth:minBandWidth,
                allNetFlatTelephony:allNetFlatTelephony,
                allNetFlatInternet:allNetFlatInternet,
                allNetFlatSMS:allNetFlatSMS
            },
            success:function(responses)
            {
                // list the tariff groups
                $("#radioInLineGroups").empty();

                $("#radioInLineGroups").append( "<label class='m-radio'>");
                $("#radioInLineGroups").append( "<input type='radio' name='tariffGroup' id='tariffGroup' class='m-radio' checked value=" + 0 + ">" + "All");
                $("#radioInLineGroups").append( "<span></span>" + "</label>");

                $.each(responses["tariffGroups"], function(key, value) {
                    $("#radioInLineGroups").append( "<label class='m-radio'>");
                    $("#radioInLineGroups").append( "<input type='radio' name='tariffGroup' id='tariffGroup' class='m-radio' value=" + value.id + ">" + value.name );
                    $("#radioInLineGroups").append( "<span></span>" + "</label>");
                });

                // list the tariffs consisted of "out" sent by "TariffController@fetchTariffsWithFilter"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });

    $('#radioInLineGroups').change(function(){

        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var statusOfTariffs = $("input[name='statusOfTariffs']:checked").val();
        var networkID = $("#networkID").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var minDataVolume = $("#minDataVolume").val();
        var minBandWidth = $("#minBandWidth").val();
        var allNetFlatTelephony = $("input[name='allNetFlatTelephony']").prop('checked');
        var allNetFlatInternet = $("input[name='allNetFlatInternet']").prop('checked');
        var allNetFlatSMS = $("input[name='allNetFlatSMS']").prop('checked');
        var _token = $('input[name="_token"]').val();


        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{_token:_token,
                providerID:providerID,
                tariffGroupID:tariffGroupID,
                statusOfTariffs:statusOfTariffs,
                networkID:networkID,
                maxBasePrice:maxBasePrice,
                minDataVolume:minDataVolume,
                minBandWidth:minBandWidth,
                allNetFlatTelephony:allNetFlatTelephony,
                allNetFlatInternet:allNetFlatInternet,
                allNetFlatSMS:allNetFlatSMS
            },
            success:function(responses) {
                // list the tariffs consisted of "out" sent by "TariffController@fetchTariffsWithFilter"
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses['out']);
            }
        })
    });

    $('#filterPortlet').change(function(){
        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var statusOfTariffs = $("input[name='statusOfTariffs']:checked").val();
        var networkID = $("#networkID").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var minDataVolume = $("#minDataVolume").val();
        var minBandWidth = $("#minBandWidth").val();
        var allNetFlatTelephony = $("input[name='allNetFlatTelephony']").prop('checked');
        var allNetFlatInternet = $("input[name='allNetFlatInternet']").prop('checked');
        var allNetFlatSMS = $("input[name='allNetFlatSMS']").prop('checked');
        var _token = $('input[name="_token"]').val();


        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{_token:_token,
                providerID:providerID,
                tariffGroupID:tariffGroupID,
                statusOfTariffs:statusOfTariffs,
                networkID:networkID,
                maxBasePrice:maxBasePrice,
                minDataVolume:minDataVolume,
                minBandWidth:minBandWidth,
                allNetFlatTelephony:allNetFlatTelephony,
                allNetFlatInternet:allNetFlatInternet,
                allNetFlatSMS:allNetFlatSMS
            },

            success:function(responses)
            {
                // list the tariffs consisted of "out" sent by "TariffController@fetchTariffsWithFilter"
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });

    $('#reset').click(function(){

        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var statusOfTariffs = $("input[name='statusOfTariffs']:checked").val();

        //var networkID = $("#networkID").val();
        //var maxBasePrice = $("#maxBasePrice").val();
        var minDataVolume = $("#minDataVolume").val();
        var minBandWidth = $("#minBandWidth").val();
        var allNetFlatTelephony = $("input[name='allNetFlatTelephony']").prop('checked');
        var allNetFlatInternet = $("input[name='allNetFlatInternet']").prop('checked');
        var allNetFlatSMS = $("input[name='allNetFlatSMS']").prop('checked');
        var _token = $('input[name="_token"]').val();

        var networkID = 0;
        var maxBasePrice = "";

        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{_token:_token,
                providerID:providerID,
                tariffGroupID:tariffGroupID,
                statusOfTariffs:statusOfTariffs,
                networkID:networkID,
                maxBasePrice:maxBasePrice,
                minDataVolume:minDataVolume,
                minBandWidth:minBandWidth,
                allNetFlatTelephony:allNetFlatTelephony,
                allNetFlatInternet:allNetFlatInternet,
                allNetFlatSMS:allNetFlatSMS
            },
            success:function(responses) {
                alert("Eprty");
                // Empty the filter parameters...
                $('#maxBasePrice').val('').empty();
                $('#minDataVolume').val('').empty();
                $('#minBandWidth').val('').empty();
                $('#networkID').attr('selected',0);
                $('#allNetFlatTelephony').attr('checked',false);
                $('#allNetFlatInternet').attr('checked',false);
                $('#allNetFlatSMS').attr('checked',false);

               alert($('#allNetFlatTelephony').prop('checked'));
                if($('#allNetFlatTelephony').prop('checked') === true){
                    $('#allNetFlatTelephony').attr('checked',false);
                }



                // list the tariffs consisted of "out" sent by "TariffController@fetchTariffsWithFilter"
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });

    $('#tableBody').click('.btn-danger', function (element) {
         $(element.target).css('background-color', 'green');
         //alert(element.target.id);
         // tariff id of the tariff whose status is going to be changed is taken
         var tariffID = element.target.id;

        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var statusOfTariffs = $("input[name='statusOfTariffs']:checked").val();
        var networkID = $("#networkID").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var minDataVolume = $("#minDataVolume").val();
        var minBandWidth = $("#minBandWidth").val();
        var allNetFlatTelephony = $("input[name='allNetFlatTelephony']").prop('checked');
        var allNetFlatInternet = $("input[name='allNetFlatInternet']").prop('checked');
        var allNetFlatSMS = $("input[name='allNetFlatSMS']").prop('checked');
        var _token = $('input[name="_token"]').val();

         $.ajax({
             url:"/tariff/index/change-status-of-tariff",
             method:"Post",
             data:{_token:_token,
                 tariffID:tariffID,
                 providerID:providerID,
                 tariffGroupID:tariffGroupID,
                 statusOfTariffs:statusOfTariffs,
                 networkID:networkID,
                 maxBasePrice:maxBasePrice,
                 minDataVolume:minDataVolume,
                 minBandWidth:minBandWidth,
                 allNetFlatTelephony:allNetFlatTelephony,
                 allNetFlatInternet:allNetFlatInternet,
                 allNetFlatSMS:allNetFlatSMS
             },
             success:function(responses) {

                 // list the tariffs consisted of "out" sent by "TariffController@fetchTariffsWithFilter"
                 // No need to list tariff groups since they are already there...
                 // Just list the tariffs consisted of "out"
                 $("#tableBody").empty();
                 $("#tableBody").html(responses['out']);
             }
         })
     });
    /*
       $('#tableBody').on('click', '.btn-danger', function(element){
           $(element.target).css('background-color', 'yellow');
           alert(element.target.id);
       });
    */


});