$(document).ready(function(){

    $('#radioInLineGroups').change(function(){

        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/vodafone/tariffs-with-filter",
            method:"Post",
            data:{tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},
            success:function(responses) {
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses['out']);
            }
        })
    });

    $('#filterPortlet').change(function(){
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var maxBasePrice = $("#maxBasePrice").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/vodafone/tariffs-with-filter",
            method:"Post",
            data:{tariffGroupID:tariffGroupID, maxBasePrice:maxBasePrice, _token:_token},

            success:function(responses)
            {
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });

    $('#reset').click(function(){
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/vodafone/tariffs-with-filter",
            method:"Post",
            data:{tariffGroupID:tariffGroupID, _token:_token},
            success:function(responses) {
                // Empty the filter parameters...
                $('#maxBasePrice').val('').empty();

                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses["out"]);
            }
        })
    });


});