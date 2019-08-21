$(document).ready(function(){

    alert("booş");

    $('#radioInLineProviders').change(function(){
        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var statusOfTariffs = $("input[name='statusOfTariffs']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();


        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, statusOfTariffs:statusOfTariffs, maxBasePrice:maxBasePrice, _token:_token},

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
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, statusOfTariffs:statusOfTariffs, maxBasePrice:maxBasePrice, _token:_token},
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
        var maxBasePrice = $("#minBasePrice").val();
        var minSpeed = $("#minSpeed").val();
        var minBandWidth = $("#minBandWidth").val();

        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, statusOfTariffs:statusOfTariffs, maxBasePrice:maxBasePrice, minSpeed:minSpeed, minBandWidth:minBandWidth, _token:_token},

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
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, _token:_token},
            success:function(responses) {
                // Empty the filter parameters...
                $('#maxBasePrice').val('').empty();
                $('#minSpeed').val('').empty();
                $('#minBandWidth').val('').empty();

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
         var maxBasePrice = $("#maxBasePrice").val();
         var minSpeed = $("#minSpeed").val();
         var minBandWidth = $("#minBandWidth").val();
         var _token = $('input[name="_token"]').val();

         $.ajax({
             url:"/tariff/index/change-status-of-tariff",
             method:"Post",
             data:{tariffID:tariffID, providerID:providerID, tariffGroupID:tariffGroupID, statusOfTariffs:statusOfTariffs, maxBasePrice:maxBasePrice, minSpeed:minSpeed, minBandWidth:minBandWidth, _token:_token},
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