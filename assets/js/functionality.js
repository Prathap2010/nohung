
$(window).on('load',function(){
	// $('.homekitchensection').hide();
	$('.hero-area13 .contact-kitchen-rider').hide();
	$('.hero-area11 .contact-kitchen-rider').hide();
	$('.breakfast-menu-item .remove-meal1').hide(); 
});

$(document).ready(function(){
	
	
	/* let mealcount1 = $('.breakfast-menu-item .mealcount1').val();
	$('.breakfast-menu-item .add-meal1').click(function(){

		if(mealcount1 == "Add" && $('.breakfast-menu-item .remove-meal1').hide()) {
			mealcount1 = 1;
			$('.breakfast-menu-item .remove-meal1').show(); 
			$('.breakfast-menu-item .mealcount1').val(parseInt(mealcount1)) ;
			$('.breakfast-menu-item .btn-container').css({'background-color':'#FCC647'});
			$('.breakfast-menu-item .mealcount1').css({'font-weight':'bold'});
			
		} else {
			mealcount1 = parseInt(mealcount1)+1;
			$('.breakfast-menu-item .mealcount1').val(mealcount1) ;
			$('.breakfast-menu-item .mealcount1').css({'font-weight':'bold'});
		}
		
	});

	$('.breakfast-menu-item .remove-meal1').click(function(){
		if(mealcount1 <= 1) {
			mealcount1 = "Add"; 
			$('.breakfast-menu-item .mealcount1').val(mealcount1) ;
			$('.breakfast-menu-item .remove-meal1').hide();
			$('.breakfast-menu-item .mealcount1').css({'font-weight':'Normal'});
		} else {
			mealcount1 = parseInt(mealcount1)-1;
			$('.breakfast-menu-item .mealcount1').val(mealcount1) ;
			$('.breakfast-menu-item .mealcount1').css({'font-weight':'bold'});
			if($('.breakfast-menu-item .mealcount1').val(mealcount1)==0 )
			{
				mealcount = 'Add';
				$('.breakfast-menu-item .btn-container').css({'background-color':'transparent'});
			}

		}
		
	}); */


	/* let display_meal_filters = false;
	$('.display-meal-filters').click(function(){

		if(display_meal_filters == false){
			$('.homekitchensection').show();
			$('.display-meal-filters img').attr('src',FRONT_IMAGES_URL+'close-btn.png');
			display_meal_filters = true;
		} 
		else if(display_meal_filters == true){
			$('.homekitchensection').hide();
			$('.display-meal-filters img').attr('src',FRONT_IMAGES_URL+'Group10153.png');
			display_meal_filters = false;
		}
	}); */

	$('.hero-area13 .callingButton').mouseenter(function(){
		$('.hero-area13 .contact-kitchen-rider').show();		
	});
	$('.hero-area13').click(function(){
		$('.hero-area13 .contact-kitchen-rider').hide();		
	});

	$('.hero-area11 .callingButton').mouseenter(function(){
		$('.hero-area11 .contact-kitchen-rider').show();		
	});
	$('.hero-area11').click(function(){
		$('.hero-area11 .contact-kitchen-rider').hide();		
	});

	$('#stars li').on('mouseover', function(){
		var onStar = parseInt($(this).attr('data-value'), 10); 
		$(this).removeClass("selected");
		$(this).parent().children('li.star').each(function(e){
			if (e < onStar) {  
				$(this).addClass('hover selected');  
				
				$("#review_rating").val(parseInt(onStar));
			}  else {  
				$(this).removeClass('hover selected');     
				
				$("#review_rating").val(parseInt(onStar));
			}
		});
		
	});
	$('#stars li').on('click', function(){
		var onStar = parseInt($(this).data('value'), 10); // The star currently selected
		var stars = $(this).parent().children('li.star');
		
		for (i = 0; i < stars.length; i++) {
			$(stars[i]).removeClass('selected');
		}
		
		for (i = 0; i < onStar; i++) {
			$(stars[i]).addClass('selected');
		}
		
		var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);

		$("#review_rating").val(parseInt(ratingValue));
	});

	$('.food-experience .right-part input[type="radio"]').focus(function(){
		$('.food-experience .right-part label img').css('opacity','1');
	});

	$("#search-form").submit(function(e){
		e.preventDefault();
		var search = $("#search_kitchen_meals").val();

		window.location.href = SITE_URL+'search/'+search;

	});
});
