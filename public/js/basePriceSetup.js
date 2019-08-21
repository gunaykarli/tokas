$(document).ready(function(){
    alert("bt000n");


    $('#radioInLineGroups').change(function(){

        var providerID = $("input[name='providerID']:checked").val();
        var tariffGroupID = $("input[name='tariffGroup']:checked").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"/tariff/vodafone/fetch-base-price-of-tariffs-by-group",
            method:"Post",
            data:{providerID:providerID, tariffGroupID:tariffGroupID, _token:_token},
            success:function(responses) {
                // No need to list tariff groups since they are already there...
                // Just list the tariffs consisted of "out"
                $("#tableBody").empty();
                $("#tableBody").html(responses['out']);
            }
        })
    });
});