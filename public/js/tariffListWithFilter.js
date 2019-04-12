$(document).ready(function(){

    $('#radioInLineProviders').change(function(){

        var providerID = $("input[name='provider']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        alert('radioInLineProviders: ' + providerID);

        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},

            success:function(responses)
            {
                alert('radioInLineProviders in success: ');
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

                // list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });

    $('#radioInLineGroups').change(function(){

        var providerID = $("input[name='provider']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        alert('tariffGroup: ' + tariffGroupID);

        $.ajax({
            //url:"/tariff/index/groups-tariff-list",
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},
            success:function(responses) {
                alert('radioInLineGroups-In success: ');
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses['out']);
            }
        })
    });

    $('#filterPortlet').change(function(){
        var providerID = $("input[name='provider']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        alert('filterPortlet: ' + maxBasePrice);

        $.ajax({
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},

            success:function(responses)
            {
                alert('filterPortlet: in success ');

                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });

    $('#reset').click(function(){

        var providerID = $("input[name='provider']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var _token = $('input[name="_token"]').val();


        alert('tariffGroup: ' + tariffGroupID);


        $.ajax({
            //url:"/tariff/index/groups-tariff-list",
            url:"/tariff/index/tariffs-with-filter",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, _token:_token},
            success:function(responses) {
                // Empty the filter parameters...
                $('#maxBasePrice').val('').empty();
                alert('radioInLineGroups-In success: ');
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });


});