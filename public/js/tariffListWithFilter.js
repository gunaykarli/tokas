$(document).ready(function(){

    $('#radioInLineProviders').change(function(){

        var providerID = $("input[name='provider']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        alert('radioInLineProviders: ' + providerID);

        $.ajax({
            url:"/tariff/index/tariff-groups",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},

            success:function(responses)
            {
                alert('radioInLineProviders in success: ');
                $("#radioInLineGroups").empty();

                $("#radioInLineGroups").append( "<label class='m-radio'>");
                $("#radioInLineGroups").append( "<input type='radio' name='tariffGroup' id='tariffGroup' class='m-radio' checked value=" + 0 + ">" + "All");
                $("#radioInLineGroups").append( "<span></span>" + "</label>");

                $.each(responses["tariffGroups"], function(key, value) {
                    $("#radioInLineGroups").append( "<label class='m-radio'>");
                    $("#radioInLineGroups").append( "<input type='radio' name='tariffGroup' id='tariffGroup' class='m-radio' value=" + value.id + ">" + value.name );
                    $("#radioInLineGroups").append( "<span></span>" + "</label>");
                });

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
            url:"/tariff/index/groups-tariff-list",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},
            success:function(data) {
                alert('radioInLineGroups-In success: ');
                $("#tableBody").empty();
                $("#tableBody").html(data);
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

                $("#radioInLineGroups").empty();

                $("#radioInLineGroups").append( "<label class='m-radio'>");
                $("#radioInLineGroups").append( "<input type='radio' name='tariffGroup' id='tariffGroup' class='m-radio' checked value=" + 0 + ">" + "All");
                $("#radioInLineGroups").append( "<span></span>" + "</label>");

                if(!(responses["tariffGroups"] == ""))
                    $.each(responses["tariffGroups"], function(key, value) {
                        $("#radioInLineGroups").append( "<label class='m-radio'>");
                        $("#radioInLineGroups").append( "<input type='radio' name='tariffGroup' id='tariffGroup' class='m-radio' value=" + value.id + ">" + value.name );
                        $("#radioInLineGroups").append( "<span></span>" + "</label>");
                    });

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

        $('#maxBasePrice').val('').empty();
        $.ajax({
            url:"/tariff/index/groups-tariff-list",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, _token:_token},
            success:function(data) {
                alert('radioInLineGroups-In success: ');
                $("#tableBody").empty();
                $("#tableBody").html(data);
            }
        })
    });


});