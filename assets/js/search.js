var offset = 0;
$(document).ready(function(){
    /* setTimeout(() => {
        loadkitchendata();
    }, 2000); */

    $("input[name=selectVariety]").click(function(){
        offset = 0;
        loadkitchendata();
    });
    
    $("input[name=mealtype]").click(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#cuisinetype").change(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#mealplan").change(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#price").change(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#rating").change(function(){
        offset = 0;
        loadkitchendata();
    });

    // initialize services
    /* const geocoder = new google.maps.Geocoder();
    const service = new google.maps.DistanceMatrixService();
    // build request
    const origin1 = { lat: 22.2648636003009, lng: 70.78461862561903 };
    const origin2 = "Mavdi Chowk, Rajkot";
    const destinationA = "Stockholm, Sweden";
    const destinationB = { lat: 50.087, lng: 14.421 };
    const request = {
        origins: [origin1, origin2],
        destinations: [destinationA, destinationB],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false,
    };
    // put request on page
    // console.log(JSON.stringify(request,null,2));

    service.getDistanceMatrix(request).then((response) => {
        // put response
        console.log(JSON.stringify(
          response,
          null,
          2
        ));
    }); */

    let filters = true;
	$('.filter_right_btn button').click(function(){

		if(filters == false){
			$('.searchkitchensection').show();
			$('.filter_right_btn img').attr('src',FRONT_IMAGES_URL+'close-btn.png');
			filters = true;
		} 
		else if(filters == true){
			$('.searchkitchensection').hide();
			$('.filter_right_btn img').attr('src',FRONT_IMAGES_URL+'Group10153.png');
			filters = false;
		}
	});

    $('.filter_right_btn button').click(function () {

        if (filters == false) {
            $('.searchkitchensection').show();
            $('.filter_right_btn img').attr('src', FRONT_IMAGES_URL + 'close-btn.png');
            filters = true;
        }
        else if (filters == true) {
            $('.searchkitchensection').hide();
            $('.filter_right_btn img').attr('src', FRONT_IMAGES_URL + 'Group10153.png');
            filters = false;
        }
    });
});
function loadkitchendata(){
    var itemtype = $("input[name=selectVariety]:checked").val();
    var mealtype = $("input[name=mealtype]:checked").val();
    var cuisinetype = $("#cuisinetype").val();
    var mealplan = $("#mealplan").val();
    var price = $("#price").val();
    var rating = $("#rating").val();
    var search_kitchen_meals = $("#search_kitchen_meals").val();

    var cust_latitude = $("#cust_latitude").val();
    var cust_longitude = $("#cust_longitude").val();
    var cust_location = $("#foodieslocation").html();
    
    $.ajax({
        url: SITE_URL+'search/loadkitchendata',
        type: 'POST',
        data: {offset:parseInt(offset),mealplan:mealplan,itemtype: itemtype,mealtype: mealtype,cuisinetype: cuisinetype,price: price,rating: rating,search_kitchen_meals:search_kitchen_meals, cust_location:cust_location, cust_latitude:cust_latitude, cust_longitude:cust_longitude},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".foodsectionsloadmorebtn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".foodsectionsloadmorebtn a").text('Loading...');
            if(parseInt(offset)==0){
                $('#kitchenlist').html("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+FRONT_IMAGES_URL+"loading-please-wait.gif'></div>");
            }else{
                $('#kitchenlist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+FRONT_IMAGES_URL+"loading-please-wait.gif'></div>");
            }
        },
        success: function(response){

            $('#kitchenlist .loading-image').remove();

            $("#countkitchen").html(parseInt(response.totalrows));
            if(parseInt(offset)==0){
                $("#kitchenlist").html(response.html);
            }else{
                $("#kitchenlist").append(response.html);
            }
            offset = parseInt(offset) + parseInt(PER_PAGE_KITCHEN);
            
            if(parseInt(offset) >= parseInt(response.totalrows)){
                $(".foodsectionsloadmorebtn").hide();
            }else{
                $(".foodsectionsloadmorebtn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".foodsectionsloadmorebtn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".foodsectionsloadmorebtn a").text('Load More');
        },
    });
}
function add_favorite_kitchen(kitchen_id){
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/addfavoritekitchen',
        type: 'POST',
        data: {kitchen_id: kitchen_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            toastr.success("Kitchen added to favorite.");
            $("#favorite_kitchen_"+kitchen_id).attr("onclick","remove_favorite_kitchen("+kitchen_id+")").html('<img src="'+FRONT_IMAGES_URL+'bookmarks.svg" alt="" class="img-fluid">');
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
function remove_favorite_kitchen(kitchen_id){
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/removefavoritekitchen',
        type: 'POST',
        data: {kitchen_id: kitchen_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            toastr.success("Kitchen removed to favorite.");
            $("#favorite_kitchen_"+kitchen_id).attr("onclick","add_favorite_kitchen("+kitchen_id+")").html('<i class="fa fa-bookmark-o" style="padding-top: 5px;color: #FCC647;"></i>');
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
