var weekly_breakfast_offset = weekly_lunch_offset = weekly_dinner_offset = 0;
var monthly_breakfast_offset = monthly_lunch_offset = monthly_dinner_offset = 0;
var trial_breakfast_offset = trial_lunch_offset = trial_dinner_offset = 0;
var rat_offset = 0;

$(document).ready(function(){
    load_trialmenu();
    load_weekly_package();
    load_monthly_package();

    $("input[name=trialitemtype]").click(function(){
        trial_breakfast_offset = trial_lunch_offset = trial_dinner_offset = 0;
        load_trialmenu();
    });

    $("input[name=weeklyitemtype]").click(function(){
        weekly_breakfast_offset = weekly_lunch_offset = weekly_dinner_offset = 0;
        load_weekly_package();
    });
    $("input[name=monthlyitemtype]").click(function(){
        monthly_breakfast_offset = monthly_lunch_offset = monthly_dinner_offset = 0;
        load_monthly_package();
    });
    /* Week Picker Code */
    var weekStart, weekEnd;
    $('#weekpicker').datepicker({
        showOtherMonths:true,
        selectOtherMonths:true,
        minDate: new Date(),
        onSelect:function(selectedDate,instance){
            
            var myDate = new Date(selectedDate);

            if($("#pills-monthly-tab").hasClass("active")){
                weekStart = new Date(myDate.getFullYear(),myDate.getMonth(),myDate.getDate());
                weekEnd = new Date(myDate.getFullYear(),myDate.getMonth(),(myDate.getDate()+29));
            }else{
                // weekStart = new Date(myDate.getFullYear(),myDate.getMonth(),myDate.getDate()-myDate.getDay());
                // weekEnd = new Date(myDate.getFullYear(),myDate.getMonth(),(myDate.getDate()-myDate.getDay())+6);
                weekStart = new Date(myDate.getFullYear(),myDate.getMonth(),myDate.getDate());
                weekEnd = new Date(myDate.getFullYear(),myDate.getMonth(),(myDate.getDate())+6);
            }
            
            completeWeek();
        },
        beforeShowDay:function(date){
            var cssClass = "";
            if(date >= weekStart && date <= weekEnd) {
                cssClass = "ui-datepicker-current-day";
            }
            return [true,cssClass];
        } 
    });

    $('#weekpicker').click(function(){
        calenderFirstLetterWeek();
        insertLeftRightArrow();
    }); 

    calenderFirstLetterWeek();
    insertLeftRightArrow();
});

function completeWeek() {
	window.setTimeout(function(){
		$(".ui-datepicker-current-day a").addClass("ui-state-active");
	},1);
}
function calenderFirstLetterWeek(){
	var weekDays = ["S","M","T","W","T","F","S"];
	$.each(weekDays,function(index,value){
		index=index+1;
		$('.ui-datepicker-calendar thead th:nth-child('+index+')').text(value);
	});
    completeWeek();
}
function insertLeftRightArrow() {
	$('.hasDatepicker .ui-datepicker-header .ui-datepicker-prev span').remove();
	$('.hasDatepicker .ui-datepicker-header .ui-datepicker-next span').remove();
	$('.hasDatepicker .ui-datepicker-header .ui-datepicker-prev.ui-corner-all').html('<img src="'+FRONT_IMAGES_URL+'rightarrow.png" alt="" class="img-fluid">');
	$('.hasDatepicker .ui-datepicker-header .ui-datepicker-next.ui-corner-all').html('<img src="'+FRONT_IMAGES_URL+'leftarrow.png" alt="" class="img-fluid">');	
    // $('.hasDatepicker .ui-datepicker-header .ui-datepicker-prev.ui-corner-all').addClass('ui-state-disabled');
}
$(document).on('keyup', '.breakfast-menu-item .mealcount', function(){
    var id = $(this).attr("id").match(/\d+/);
    let mealcount = $('#mealcount'+id).val();
    if(mealcount != "Add" && parseInt(mealcount) > 0 && $('#removemeal'+id).hide()) {
        $('#removemeal'+id).show(); 
    }
    var kitchen_id = $("#userid").val();
    addtocart(kitchen_id,id,2);
});
$(document).on('click', '.breakfast-menu-item .add-meal', function(){
    var id = $(this).attr("id").match(/\d+/);
    let mealcount = $('#mealcount'+id).val();
    if(mealcount == "Add" && $('#removemeal'+id).hide()) {
        mealcount = 1;
        $('#removemeal'+id).show(); 
        $('#mealcount'+id).val(parseInt(mealcount)) ;
        $('#btn-container'+id).css({'background-color':'#FCC647'});
        $('#mealcount'+id).css({'font-weight':'bold'});
        
    } else {
        mealcount = parseInt(mealcount)+1;
        $('#mealcount'+id).val(mealcount) ;
        $('#mealcount'+id).css({'font-weight':'bold'});
    }
    var kitchen_id = $("#userid").val();
    addtocart(kitchen_id,id,1);
});

$(document).on('click', '.breakfast-menu-item .remove-meal', function(){
    var id = $(this).attr("id").match(/\d+/);
    
    let mealcount = $('#mealcount'+id).val();
    
    if(mealcount <= 1) {
        mealcount = "Add"; 
        $('#mealcount'+id).val(mealcount);
        $('#removemeal'+id).hide();
        $('#mealcount'+id).css({'font-weight':'Normal'});

        $('#btn-container'+id).css({'background-color':'#FFFAEE'});
    } else {
        mealcount = parseInt(mealcount)-1;
        $('#mealcount'+id).val(mealcount);
        $('#mealcount'+id).css({'font-weight':'bold'});
        if($('#mealcount'+id).val(mealcount)==0 )
        {
            mealcount = 'Add';
            $('#btn-container'+id).css({'background-color':'transparent'});
        }

    }
    var kitchen_id = $("#userid").val();
    addtocart(kitchen_id,id,0);
});

$(document).on('click', '.customizable-modal-container .add-meal', function(){
    var id = $(this).attr("id").match(/\d+/);
    let mealcount = $('#mealcount_'+id).val();
    if(mealcount == "Add" && $('#removemeal_'+id).hide()) {
        mealcount = 1;
        // $('#removemeal_'+id).show(); 
        $('#mealcount_'+id).val(parseInt(mealcount)) ;
        // $('#btn-container'+id).css({'background-color':'#FCC647'});
        $('#mealcount_'+id).css({'font-weight':'bold'});
        
    } else {
        mealcount = parseInt(mealcount)+1;
        $('#mealcount_'+id).val(mealcount) ;
        $('#mealcount_'+id).css({'font-weight':'bold'});
    }
    
});

$(document).on('click', '.customizable-modal-container .remove-meal', function(){
    var id = $(this).attr("id").match(/\d+/);
    
    let mealcount = $('#mealcount_'+id).val();
    if(mealcount <= 1) {
        mealcount = 1; 
        $('#mealcount_'+id).val(mealcount);
        // $('#removemeal_'+id).hide();
        $('#mealcount_'+id).css({'font-weight':'Normal'});
    } else {
        mealcount = parseInt(mealcount)-1;
        $('#mealcount_'+id).val(mealcount);
        $('#mealcount_'+id).css({'font-weight':'bold'});
        if($('#mealcount_'+id).val(mealcount)==0 )
        {
            mealcount = '1';
        }

    }
    
});




function load_trialmenu(tab=""){
    var itemtype = $("input[name=trialitemtype]:checked").val();
    var userid = $("#userid").val();
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/load-trial-meal',
        type: 'POST',
        data: {userid:userid,trial_breakfast_offset:parseInt(trial_breakfast_offset),trial_lunch_offset:parseInt(trial_lunch_offset),trial_dinner_offset:parseInt(trial_dinner_offset),itemtype: itemtype},
        dataType: 'json',
        // async: false,
        success: function(response){
            
            if(tab=="" || tab=="breakfast"){
                var totalrows = response.breakfast.totalrows;
                var html = response.breakfast.html;
    
                if(parseInt(trial_breakfast_offset)==0){
                    $("#breakfast-trial-meal").html(html);
                }else{
                    $("#breakfast-trial-meal").append(html);
                }
                trial_breakfast_offset = parseInt(trial_breakfast_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(trial_breakfast_offset) >= parseInt(totalrows)){
                    $("#breakfast-trial-meal-lmbtn").hide();
                }else{
                    $("#breakfast-trial-meal-lmbtn").show();
                }
            }

            if(tab=="" || tab=="lunch"){
                var totalrows = response.lunch.totalrows;
                var html = response.lunch.html;
    
                if(parseInt(trial_lunch_offset)==0){
                    $("#lunch-trial-meal").html(html);
                }else{
                    $("#lunch-trial-meal").append(html);
                }
                trial_lunch_offset = parseInt(trial_lunch_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(trial_lunch_offset) >= parseInt(totalrows)){
                    $("#lunch-trial-meal-lmbtn").hide();
                }else{
                    $("#lunch-trial-meal-lmbtn").show();
                }
            }

            if(tab=="" || tab=="dinner"){
                var totalrows = response.dinner.totalrows;
                var html = response.dinner.html;
    
                if(parseInt(trial_dinner_offset)==0){
                    $("#dinner-trial-meal").html(html);
                }else{
                    $("#dinner-trial-meal").append(html);
                }
                trial_dinner_offset = parseInt(trial_dinner_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(trial_dinner_offset) >= parseInt(totalrows)){
                    $("#dinner-trial-meal-lmbtn").hide();
                }else{
                    $("#dinner-trial-meal-lmbtn").show();
                }
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}

function load_weekly_package(tab=""){
    var itemtype = $("input[name=weeklyitemtype]:checked").val();
    var userid = $("#userid").val();
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/load-package',
        type: 'POST',
        data: {userid:userid,breakfast_offset:parseInt(weekly_breakfast_offset),lunch_offset:parseInt(weekly_lunch_offset),dinner_offset:parseInt(weekly_dinner_offset),itemtype: itemtype,plantype:'weekly'},
        dataType: 'json',
        // async: false,
        success: function(response){
            
            if(tab=="" || tab=="breakfast"){
                var totalrows = response.breakfast.totalrows;
                var html = response.breakfast.html;

                if(parseInt(weekly_breakfast_offset)==0){
                    $("#breakfast-weekly-meal").html(html);
                }else{
                    $("#breakfast-weekly-meal").append(html);
                }
                weekly_breakfast_offset = parseInt(weekly_breakfast_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(weekly_breakfast_offset) >= parseInt(totalrows)){
                    $("#breakfast-weekly-meal-lmbtn").hide();
                }else{
                    $("#breakfast-weekly-meal-lmbtn").show();
                }
            }

            if(tab=="" || tab=="lunch"){
                var totalrows = response.lunch.totalrows;
                var html = response.lunch.html;

                if(parseInt(weekly_lunch_offset)==0){
                    $("#lunch-weekly-meal").html(html);
                }else{
                    $("#lunch-weekly-meal").append(html);
                }
                weekly_lunch_offset = parseInt(weekly_lunch_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(weekly_lunch_offset) >= parseInt(totalrows)){
                    $("#lunch-weekly-meal-lmbtn").hide();
                }else{
                    $("#lunch-weekly-meal-lmbtn").show();
                }
            }

            if(tab=="" || tab=="dinner"){
                var totalrows = response.dinner.totalrows;
                var html = response.dinner.html;

                if(parseInt(weekly_dinner_offset)==0){
                    $("#dinner-weekly-meal").html(html);
                }else{
                    $("#dinner-weekly-meal").append(html);
                }
                weekly_dinner_offset = parseInt(weekly_dinner_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(weekly_dinner_offset) >= parseInt(totalrows)){
                    $("#dinner-weekly-meal-lmbtn").hide();
                }else{
                    $("#dinner-weekly-meal-lmbtn").show();
                }
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}

function load_monthly_package(tab=""){
    var itemtype = $("input[name=monthlyitemtype]:checked").val();
    var userid = $("#userid").val();
   
    $.ajax({
        url: SITE_URL+'kitchen-detail/load-package',
        type: 'POST',
        data: {userid:userid,breakfast_offset:parseInt(monthly_breakfast_offset),lunch_offset:parseInt(monthly_lunch_offset),dinner_offset:parseInt(monthly_dinner_offset),itemtype: itemtype,plantype:'monthly'},
        dataType: 'json',
        // async: false,
        success: function(response){
            
            if(tab=="" || tab=="breakfast"){
                var totalrows = response.breakfast.totalrows;
                var html = response.breakfast.html;

                if(parseInt(monthly_breakfast_offset)==0){
                    $("#breakfast-monthly-meal").html(html);
                }else{
                    $("#breakfast-monthly-meal").append(html);
                }
                monthly_breakfast_offset = parseInt(monthly_breakfast_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(monthly_breakfast_offset) >= parseInt(totalrows)){
                    $("#breakfast-monthly-meal-lmbtn").hide();
                }else{
                    $("#breakfast-monthly-meal-lmbtn").show();
                }
            }

            if(tab=="" || tab=="lunch"){
                var totalrows = response.lunch.totalrows;
                var html = response.lunch.html;

                if(parseInt(monthly_lunch_offset)==0){
                    $("#lunch-monthly-meal").html(html);
                }else{
                    $("#lunch-monthly-meal").append(html);
                }
                monthly_lunch_offset = parseInt(monthly_lunch_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(monthly_lunch_offset) >= parseInt(totalrows)){
                    $("#lunch-monthly-meal-lmbtn").hide();
                }else{
                    $("#lunch-monthly-meal-lmbtn").show();
                }
            }

            if(tab=="" || tab=="dinner"){
                var totalrows = response.dinner.totalrows;
                var html = response.dinner.html;

                if(parseInt(monthly_dinner_offset)==0){
                    $("#dinner-monthly-meal").html(html);
                }else{
                    $("#dinner-monthly-meal").append(html);
                }
                monthly_dinner_offset = parseInt(monthly_dinner_offset) + parseInt(PER_PAGE_MENU_ITEM);
                
                if(parseInt(monthly_dinner_offset) >= parseInt(totalrows)){
                    $("#dinner-monthly-meal-lmbtn").hide();
                }else{
                    $("#dinner-monthly-meal-lmbtn").show();
                }
            }

        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}

function get_reviews(userid){
    
    $("#stars li").removeClass('hover selected');
    $("#review_rating,#review_message").val('');
    $("#foodqualitygood,#tastegood,#quantitygood").prop('checked', true);
    
    if(rat_offset==0){
        $("#reviewlist").html("");
    }
    if(userid!=""){
        $.ajax({
            url: SITE_URL+'kitchen-detail/get-reviews',
            type: 'POST',
            data: {userid:userid,offset:rat_offset},
            dataType: 'json',
            // async: false,
            success: function(response){

                var reviews = response.reviews;
                var html = "";

                if(reviews.length > 0){
                    for(var i=0; i<reviews.length; i++){

                        var image_foodquality = FRONT_IMAGES_URL+'like.png';
                        var image_taste = FRONT_IMAGES_URL+'like.png';
                        var image_quantity = FRONT_IMAGES_URL+'like.png';

                        if(reviews[i]['foodquality'] == 2){
                            image_foodquality = FRONT_IMAGES_URL+'like1.png';
                        }
                        
                        if(reviews[i]['taste'] == 2){
                            image_taste = FRONT_IMAGES_URL+'like1.png';
                        }

                        if(reviews[i]['quantity'] == 2){
                            image_quantity = FRONT_IMAGES_URL+'like1.png';
                        }
                        html += '<div class="customer-review-content">\
                                    <div class="review-header">\
                                        <div class="left-part">\
                                            <div class="review-icon-container">\
                                                <img src="'+reviews[i]['customerimage']+'" class="img-fluid" style="height: 88px;width: 88px;border-radius: 50%;">\
                                            </div>\
                                            <div class="name-rating">\
                                                <p class="heading">'+reviews[i]['customername']+'</p>\
                                                <div class="rating">\
                                                    <ul id="stars">\
                                                        <li class="star '+(reviews[i]['rating']<1?"":"hover selected")+'" title="Poor" data-value="1">\
                                                            <i class="fa fa-star fa-fw"></i>\
                                                        </li>\
                                                        <li class="star '+(reviews[i]['rating']<2?"":"hover selected")+'" title="Fair" data-value="2">\
                                                            <i class="fa fa-star fa-fw"></i>\
                                                        </li>\
                                                        <li class="star '+(reviews[i]['rating']<3?"":"hover selected")+'" title="Good" data-value="3">\
                                                            <i class="fa fa-star fa-fw"></i>\
                                                        </li>\
                                                        <li class="star '+(reviews[i]['rating']<4?"":"hover selected")+'" title="Excellent" data-value="4">\
                                                            <i class="fa fa-star fa-fw"></i>\
                                                        </li>\
                                                        <li class="star '+(reviews[i]['rating']<5?"":"hover selected")+'" title="WOW!!!" data-value="5">\
                                                            <i class="fa fa-star fa-fw"></i>\
                                                        </li>\
                                                    </ul>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="right-part">\
                                            <p class="hourago">'+reviews[i]['createddate']+'</p>\
                                        </div>\
                                        <div class="clearfix"></div>\
                                    </div>\
                                    <div class="review-body">\
                                        <p class="desc">'+reviews[i]['message']+'</p>\
                                        <ul class="food-status">\
                                            <li class="food-quality">Food Quality <span><img src="'+image_foodquality+'"></span></li>\
                                            <li class="taste">Taste <span><img src="'+image_taste+'"></span></li>\
                                            <li class="quantity">Quantity <span><img src="'+image_quantity+'"></span></li>\
                                        </ul>\
                                    </div>\
                                </div>';
                    }
                }else{
                    html += '<p style="color: #4a4a4a;font-size: 20px;">No any reviews available.</p>';
                }
                if(parseInt(rat_offset)==0){
                    $("#reviewlist").html(html);
                }else{
                    $("#reviewlist").append(html);
                }
                rat_offset = parseInt(rat_offset) + parseInt(PER_PAGE_REVIEWS);
                
                if(parseInt(rat_offset) >= parseInt(response.totalrows)){
                    $("#review-lmbtn").hide();
                }else{
                    $("#review-lmbtn").show();
                }

                $("#mdl_reviews_count").html(response.totalrows);
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }
}

function submit_review(){
    var userid = $("#userid").val();
    var rating = $("#review_rating").val();
    var review_message = $("#review_message").val();
    var isvalid=1;

    if(rating==""){
        toastr.error('Please select rating !');
        isvalid = 0;
    }
    if(review_message==""){
        toastr.error('Please enter review message !');
        isvalid = 0;
    }

    if(isvalid==1){
        var formData = new FormData($('#rating-form')[0]);
        formData.append("userid", userid);
        $.ajax({
            url: SITE_URL+"kitchen-detail/add-review",
            type: 'POST',
            data: formData,
            success: function(response){
                if(response==1){
                    toastr.success('Review successfully added.');

                    setTimeout(function(){
                        rat_offset = 0;
                        get_reviews(userid);
                    },2000);
                }else if(response==0){
                    toastr.error('Review not added !');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function get_package_detail(packageid,plantype){
    
    var userid = $("#userid").val();
    if(packageid!=""){
        $.ajax({
            url: SITE_URL+'kitchen-detail/get-package-detail',
            type: 'POST',
            data: {userid:userid,packageid:packageid},
            dataType: 'json',
            // async: false,
            success: function(response){

                var html = "";

                if(response){
                    var package = response.packagedetail;
                    var weeklypackage = response.weeklypackage;

                    var mealfor = choose_time = "";
                    if(package.mealfor==0){
                        mealfor = 'Breakfast';

                        choose_time = '<input type="radio" name="delivery-time" id="fulleleven" value="06:00-06:30"><label for="fulleleven">06:00-06:30</label>\
                            <input type="radio" name="delivery-time" id="halfeleven" value="06:30-07:00"><label for="halfeleven">06:30-07:00</label>\
                            <input type="radio" name="delivery-time" id="halftwelve" value="07:00-07:30"><label for="halftwelve">07:00-07:30</label>\
                            <input type="radio" name="delivery-time" id="halfone" value="07:30-8:00"><label for="halfone">07:30-08:00</label>\
                            <input type="radio" name="delivery-time" id="fulltwo" value="08:00-08:30"><label for="fulltwo">08:00-08:30</label>\
                            <input type="radio" name="delivery-time" id="halftwo" value="08:30-9:00"><label for="halftwo">08:30-09:00</label>';

                    }else if(package.mealfor==1){
                        mealfor = 'Lunch';

                        choose_time = '<input type="radio" name="delivery-time" id="fulleleven" value="11:00-11:30"><label for="fulleleven">11:00-11:30</label>\
                            <input type="radio" name="delivery-time" id="halfeleven" value="11:30-12:00"><label for="halfeleven">11:30-12:00</label>\
                            <input type="radio" name="delivery-time" id="halftwelve" value="12:30-13:00"><label for="halftwelve">12:30-1:00</label>\
                            <input type="radio" name="delivery-time" id="halfone" value="13:30-14:00"><label for="halfone">1:30-2:00</label>\
                            <input type="radio" name="delivery-time" id="fulltwo" value="14:00-14:30"><label for="fulltwo">2:00-2:30</label>\
                            <input type="radio" name="delivery-time" id="halftwo" value="14:30-15:00"><label for="halftwo">2:30-3:00</label>';

                    }else if(package.mealfor==2){
                        mealfor = 'Dinner';

                        choose_time = '<input type="radio" name="delivery-time" id="fulleleven" value="19:00-19:30"><label for="fulleleven">07:00-07:30</label>\
                            <input type="radio" name="delivery-time" id="halfeleven" value="19:30-20:00"><label for="halfeleven">07:30-08:00</label>\
                            <input type="radio" name="delivery-time" id="halftwelve" value="20:00-20:30"><label for="halftwelve">08:00-08:30</label>\
                            <input type="radio" name="delivery-time" id="halfone" value="20:30-21:00"><label for="halfone">08:30-09:00</label>\
                            <input type="radio" name="delivery-time" id="fulltwo" value="21:00-21:30"><label for="fulltwo">09:00-09:30</label>\
                            <input type="radio" name="delivery-time" id="halftwo" value="21:30-22:00"><label for="halftwo">09:30-10:00</label>';
                    }

                    $("#packagetitle").html(package.packagename);
                    $("#packageconfirm .modal-title").html(package.packagename);
                    $("#select-package-modal .modal-title").html(package.packagename);
                    $("#ord_packageid").val(package.id);
                    
                    $("#ord_mealplan").val(plantype);

                    $(".ui-datepicker-current-day a").removeClass("ui-state-active");
                    
                    var weekly_package_html = weekly_package_confirm_html = '';

                    var days = {"1":"Monday","2":"Tuesday","3":"Wednesday","4":"Thursday","5":"Friday","6":"Saturday","7":"Sunday"};
                    if(weeklypackage.length > 0){
                        for(var i=0; i<weeklypackage.length; i++){
                            var menuitemdetail = weeklypackage[i]['menuitemdetail'];
                            var menudata = weeklypackage[i]['menudata'];
                            var menuitem = [];
                            if(menuitemdetail.length > 0){
                                for(var j=0; j<menuitemdetail.length; j++){
                                    menuitem.push(menuitemdetail[j]['itemname']); 
                                }
                            }
                            menuitem = menuitem.join(" + ");
                            
                            if(menudata.length > 0){
                                for(var j=0; j<menudata.length; j++){
                                    menudata[j]['category'] = (package.mealfor==0)?(package.mealtype==0?"Veg":"Non Veg"):menudata[j]['category'];
                                }
                            }

                            weekly_package_html += '<div class="package-everyday-list-menu-content">\
                                                        <div class="left-part">\
                                                            <p class="heading">'+(days[i+1])+'</p>\
                                                            <p class="description menu_combination'+(i+1)+'">'+menuitem+'</p>\
                                                            <textarea style="display:none;" id="customize_package_menu_item_'+(i+1)+'">'+JSON.stringify(menuitemdetail)+'</textarea>\
                                                            <textarea style="display:none;" id="customize_package_item_'+(i+1)+'">'+JSON.stringify(menudata)+'</textarea>\
                                                            <textarea style="display:none;" id="extra_item_'+(i+1)+'"></textarea>\
                                                            <input type="hidden" id="weeklypackageid'+(i+1)+'" value="'+weeklypackage[i]['id']+'">\
                                                        </div>\
                                                        <div class="right-part">\
                                                            <a href="javascript:void(0)" class="btn-customize" data-toggle="modal" data-target="#customizable-modal" onclick="customize_package_item('+packageid+','+(i+1)+')">Customizable</a>\
                                                        </div>\
                                                    </div>';
                                                    
                            weekly_package_confirm_html += '<div class="package-everyday-list-menu-content">\
                                                                <div class="left-part">\
                                                                    <p class="heading">'+(days[i+1])+'</p>\
                                                                    <p class="description menu_combination'+(i+1)+'">'+menuitem+'</p>\
                                                                </div>\
                                                                <div class="right-part">\
                                                                    <p class="settime"></p>\
                                                                </div>\
                                                            </div>';
                        }   
                    }

                    if(package.mealtype == 0){
                        var mealtype = 'Veg'; 
                        var mealtypeimg = 'vegFood_icon.png';
                    }else{
                        var mealtype = 'Non-Veg'; 
                        var mealtypeimg = 'NonVegFood_icon.png';
                    }
                    var cuisinetype = 'South Indian Meals';
                    if(package.cuisinetype == 1){
                        cuisinetype = 'North Indian Meals';
                    }else if(package.cuisinetype == 1){
                        cuisinetype = 'Other Cuisine Meals';
                    }

                    $(".choose-time").html(choose_time); 
                    var html = '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">\
                                    <li class="nav-item" role="presentation">\
                                        <a class="nav-link padding-left0 active" id="pills-package-lunch-tab" data-toggle="pill" href="#pills-package-lunch" role="tab" aria-controls="pills-package-lunch" aria-selected="true">'+mealfor+'</a>\
                                    </li>\
                                    <li class="nav-item" role="presentation">\
                                        <a class="nav-link" id="pills-package-veg-tab" data-toggle="pill" href="#pills-package-lunch" role="tab" aria-controls="pills-package-veg" aria-selected="false"><span class="veg"><img src="'+FRONT_IMAGES_URL+mealtypeimg+'" alt="" class="img-fluid"></span>'+mealtype+'</a>\
                                    </li>\
                                    <li class="nav-item" role="presentation">\
                                        <a class="nav-link" id="pills-package-north-indian-meal-tab" data-toggle="pill" href="#pills-package-lunch" role="tab" aria-controls="pills-package-north-indian-meal" aria-selected="false">'+cuisinetype+'</a>\
                                    </li>\
                                </ul>\
                                <div class="tab-content" id="pills-tabContent">\
                                    <div class="tab-pane fade show active" id="pills-package-lunch" role="tabpanel" aria-labelledby="pills-package-lunch-tab">\
                                        <div class="package-everyday-list-menu-container">\
                                            '+weekly_package_html+'\
                                            \
                                        </div>\
                                        <div class="package-order-per-week">\
                                            <div class="left-part">\
                                                <p class="order-for-week"><span class="orderyellow">₹ <span id="orderweeklyprice">'+parseFloat(package.weeklyprice)+'</span></span> Order for a week</p>\
                                                <input type="hidden" id="orderweeklyprice_input" value="'+parseFloat(package.weeklyprice)+'">\
                                            </div>\
                                            <div class="right-part">\
                                                <a href="javascript:void(0)" class="btn-select-this-package" data-toggle="modal" data-target="#select-package-modal" onclick="open_date_select_modal()">Select this package <img src="'+FRONT_IMAGES_URL+'right-arrow.png" alt="" class="img-fluid"></a>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="tab-pane fade" id="pills-package-veg " role="tabpanel" aria-labelledby="pills-package-veg-tab">\
                                    </div>\
                                    <div class="tab-pane fade" id="pills-package-north-indian-meal" role="tabpanel" aria-labelledby="pills-package-north-indian-meal-tab">\
                                    </div>\
                                </div>';

                    $("#package_detail").html(html);

                    /* var checkout_btn = '<a href="'+SITE_URL+'login" class="btn-make-payment"><span>Add to Cart</span><img src="'+FRONT_IMAGES_URL+'right-arrow.png" alt="" class="img-fluid"></a>';
                    
                    if(is_loggedIn == 1){
                    } */
                        
                    var checkout_btn = '<a href="javascript:void(0)" class="btn-make-payment" onclick="addtocart_package()"><span>Add to Cart</span><img src="'+FRONT_IMAGES_URL+'right-arrow.png" alt="" class="img-fluid"></a>';   

                    var html = '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">\
                                    <li class="nav-item" role="presentation">\
                                        <a class="nav-link padding-left0 active" id="pills-package-lunch-tab" data-toggle="pill" href="#pills-package-lunch" role="tab" aria-controls="pills-package-lunch" aria-selected="true">'+mealfor+'</a>\
                                    </li>\
                                    <li class="nav-item" role="presentation">\
                                        <a class="nav-link" id="pills-package-veg-tab" data-toggle="pill" href="#pills-package-lunch" role="tab" aria-controls="pills-package-veg" aria-selected="false"><span class="veg"><img src="'+FRONT_IMAGES_URL+mealtypeimg+'" alt="" class="img-fluid"></span>'+mealtype+'</a>\
                                    </li>\
                                    <li class="nav-item" role="presentation">\
                                        <a class="nav-link" id="pills-package-north-indian-meal-tab" data-toggle="pill" href="#pills-package-lunch" role="tab" aria-controls="pills-package-north-indian-meal" aria-selected="false">'+cuisinetype+'</a>\
                                    </li>\
                                </ul>\
                                <div class="tab-content" id="pills-tabContent">\
                                    <div class="tab-pane fade show active" id="pills-package-lunch" role="tabpanel" aria-labelledby="pills-package-lunch-tab">\
                                        <div class="package-everyday-list-menu-container">\
                                            '+weekly_package_confirm_html+'\
                                            \
                                        </div>\
                                        <div class="package-order-per-week">\
                                            <div class="left-part">\
                                                <p class="order-for-week"><span class="orderyellow">₹ <span id="confirmorderweeklyprice">'+parseFloat(package.weeklyprice)+'</span></span> Order for a week</p>\
                                                <input type="hidden" id="confirmorderprice_input" value="'+parseFloat(package.weeklyprice)+'">\
                                            </div>\
                                            <div class="right-part">\
                                                <a href="javascript:void(0)" class="btn-back" data-dismiss="modal"><img src="'+FRONT_IMAGES_URL+'right-arrow.png" alt="" class="img-fluid"><span>Back</span></a>\
                                                '+checkout_btn+'\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="tab-pane fade" id="pills-package-veg " role="tabpanel" aria-labelledby="pills-package-veg-tab">\
                                    </div>\
                                    <div class="tab-pane fade" id="pills-package-north-indian-meal" role="tabpanel" aria-labelledby="pills-package-north-indian-meal-tab">\
                                    </div>\
                                </div>';

                    $("#package_confirm_detail").html(html);

                }

            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }
}
function customize_package_item(packageid, daysIndex){
    var customize_package_item = JSON.parse($("#customize_package_item_"+daysIndex).val());
    var extra_item = $("#extra_item_"+daysIndex).val()!=""?JSON.parse($("#extra_item_"+daysIndex).val()):[];

    $("#customizable_modal_data").html("");
    if(customize_package_item.length > 0){
        var html = "";
        for(var i=0; i<customize_package_item.length; i++){
            
            html += '<div class="customizable-content">\
                        <p class="heading">'+customize_package_item[i]['category']+'</p>';

            var menuitems = customize_package_item[i]['menuitems']; 
            for(var j=0; j<menuitems.length; j++){

                var checked = '';
                var qty = 1;
                var qtybtnClass = "";
                if(extra_item.length > 0){
                    for(var m=0; m<extra_item.length; m++){
                        if(extra_item[m]['menuid'] == menuitems[j]['id']){
                            checked = 'checked';
                            qty = extra_item[m]['qty'];
                            qtybtnClass = "visibility-visible";
                        }
                    }
                }
                

                html += '<div class="customize-main">\
                            <div class="left-part">\
                                <div class="checkbox checkbox-success">\
                                    <input id="chk'+menuitems[j]['id']+'" class="styled checkmenuitem" type="checkbox" name="chk'+menuitems[j]['id']+'" value="1" '+checked+'>\
                                    <label for="chk'+menuitems[j]['id']+'">'+menuitems[j]['itemname']+'</label>\
                                </div>\
                            </div>\
                            <div class="right-part">\
                                <div class="btn-container qtybtn'+menuitems[j]['id']+' '+qtybtnClass+'">\
                                    <button class="remove-meal" id="removemeal_'+menuitems[j]['id']+'">-</button>\
                                     <input type="button" value="'+parseInt(qty)+'" class="mealcount" id="mealcount_'+menuitems[j]['id']+'">\
                                    <button class="add-meal" id="addmeal_'+menuitems[j]['id']+'">+</button>\
                                </div>\
                                <p class="extra">₹'+parseFloat(menuitems[j]['itemprice']).toFixed(2)+' extra</p>\
                                <input type="hidden" id="itemprice_'+menuitems[j]['id']+'" value="'+parseFloat(menuitems[j]['itemprice']).toFixed(2)+'">\
                                <input type="hidden" id="itemname_'+menuitems[j]['id']+'" value="'+menuitems[j]['itemname']+'">\
                            </div>\
                        </div>';
            }
            html += '</div>';
        }
        html += '<div class="btn-container">\
                    <a href="javascript:void(0)" class="btn-done" onclick="add_extra_item('+packageid+','+daysIndex+')">Done</a>\
                </div>';
        $("#customizable_modal_data").html(html);
        
        /* Customizable Section code */
        $(".checkmenuitem").change(function(){
            var menuid = $(this).attr("id").match(/\d+/);
            if($(this).prop("checked") == true){
                $('.customizablemodal .customizable-content .btn-container.qtybtn'+menuid).addClass('visibility-visible'); 
                $('.customizablemodal .customizable-content .btn-container.qtybtn'+menuid).removeClass('visibility-hidden');     
            }  else if($(this).prop("checked") == false){
                $('.customizablemodal .customizable-content .btn-container.qtybtn'+menuid).addClass('visibility-hidden'); 
                $('.customizablemodal .customizable-content .btn-container.qtybtn'+menuid).removeClass('visibility-visible');       
            }
        });
    }

}
function add_extra_item(packageid,daysIndex){
    var extra_item = [];
    var order_item = [];
    var amount = 0;
    var default_item = $("#customize_package_menu_item_"+daysIndex).val()!=""?JSON.parse($("#customize_package_menu_item_"+daysIndex).val()):[];

    var weeklypackageid = $("#weeklypackageid"+daysIndex).val();

    $(".checkmenuitem").each(function(){
        var menuid = $(this).attr("id").match(/\d+/);
        if($(this).prop("checked") == true){
            var itemname = $("#itemname_"+menuid).val(); 
            var itemprice = $("#itemprice_"+menuid).val();   
            var qty = $("#mealcount_"+menuid).val(); 
            amount += (parseFloat(itemprice) * parseInt(qty));
            
            extra_item.push({'menuid':parseInt(menuid),'itemname':itemname,'itemprice':itemprice,'qty':qty});

        }
    });

    
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/addextraitem',
        type: 'POST',
        data: {packageid:packageid,weeklypackageid:weeklypackageid,extra_item: JSON.stringify(extra_item)},
        dataType: 'json',
        // async: false,
        success: function(response){
            if(response.status == 1){
                toastr.success("Extra item added !");
                $("#orderweeklyprice").html(parseFloat(response.order_price).toFixed(2));
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });

    $.each(default_item,function(index,value){
        
        var quantity = (default_item[index]['qty'] > 0 ? default_item[index]['qty'] : 0);

        $(".checkmenuitem").each(function(){
            var menuid = $(this).attr("id").match(/\d+/);
            if($(this).prop("checked") == true){
                var itemname = $("#itemname_"+menuid).val(); 
                var itemprice = $("#itemprice_"+menuid).val();   
                var qty = $("#mealcount_"+menuid).val(); 
               
                if(parseInt(default_item[index]['menuid']) == parseInt(menuid)){
                    quantity = 0;
                    if(default_item[index]['qty']==0){
                        quantity = 1 + parseInt(qty); 
                    }else{
                        quantity = parseInt(default_item[index]['qty']) + parseInt(qty);
                    }
                }
            }
        });
        var default_itemname = ((parseInt(quantity) > 0) ? parseInt(quantity)+" " : "") + default_item[index]['item'];
        /* order_item.push({
            "id":default_item[index]['id'],
            "weeklypackageid":default_item[index]['weeklypackageid'],
            "item":default_item[index]['item'],
            "itemname":default_itemname,
            "menuid":default_item[index]['menuid'],
            "price":default_item[index]['price'],
            "qty":quantity,
        }); */
        order_item.push(default_itemname);
    });
    order_item = order_item.join(" + ");

    var orderweeklyprice = $("#orderweeklyprice_input").val();
    amount = parseFloat(orderweeklyprice) + parseFloat(amount);
    // $("#orderweeklyprice").html(parseFloat(amount).toFixed(2));
    
    $(".menu_combination"+daysIndex).html(order_item);
    
    $("#customizable-modal").modal("hide");

    $("#extra_item_"+daysIndex).val(JSON.stringify(extra_item));
}
function check_date(){
    var isvalid = 1;
    $("#datetimeerror").html("");
    var weekDays = ["S","M","T","W","T","F","S"];
	$.each(weekDays,function(index,value){
		index=index+1;
		
	});
    // alert($("#weekpicker").val());
    if($(".ui-datepicker-current-day").length <= 1){
        isvalid = 0;
    }
    
    var selectedDate = $("#weekpicker").val()
    var dateArray = [];
    var myDate = new Date(selectedDate);

    var weekStart, weekEnd;
    if($("#pills-monthly-tab").hasClass("active")){
        weekStart = new Date(myDate.getFullYear(),myDate.getMonth(),myDate.getDate());
        weekEnd = new Date(myDate.getFullYear(),myDate.getMonth(),(myDate.getDate()+29));
    }else{
        /* weekStart = new Date(myDate.getFullYear(),myDate.getMonth(),myDate.getDate()-myDate.getDay());
        weekEnd = new Date(myDate.getFullYear(),myDate.getMonth(),(myDate.getDate()-myDate.getDay())+6); */
        weekStart = new Date(myDate.getFullYear(),myDate.getMonth(),myDate.getDate());
        weekEnd = new Date(myDate.getFullYear(),myDate.getMonth(),(myDate.getDate())+6);
    }
    
    var dd = weekStart.getDate();
    var mm = weekStart.getMonth();
    var yy = weekStart.getFullYear();

    var dd2 = weekEnd.getDate();
    var mm2 = weekEnd.getMonth();
    var yy2 = weekEnd.getFullYear();

    dd = (dd < 10) ? dd.toString().padStart(2, "0") : dd; 
    mm = (parseInt(mm) + 1); 
    mm = (mm < 10) ? "0"+mm : mm; 

    dd2 = (dd2 < 10) ? dd2.toString().padStart(2, "0") : dd2; 
    mm2 = (parseInt(mm2) + 1); 
    mm2 = (mm2 < 10) ? "0"+mm2 : mm2; 
    
    var weekStart = dd+"/"+mm+"/"+yy;
    var weekEnd = dd2+"/"+mm2+"/"+yy2;

    /* $(".ui-datepicker-current-day").each(function(index){
        var dd = $(this).find('a').text();
        var mm = $(this).attr('data-month');
        var yy = $(this).attr('data-year');

        dd = (dd < 10) ? dd.padStart(2, "0") : dd; 
        mm = (parseInt(mm) + 1); 
        mm = (mm < 10) ? "0"+mm : mm; 
        
        var date = dd+"/"+mm+"/"+yy;
        dateArray.push(date);
    }); */
    
    if($("input[name=delivery-time]:checked").length == 0){
        isvalid = 0;
    }

    if(isvalid){
        var time = $("input[name=delivery-time]:checked").val().split("-");
        
        $("#packageconfirm").modal("show");
        $(".settime").html($("input[name=delivery-time]:checked").val());

        var orderweeklyprice = $("#orderweeklyprice").html();
        $("#confirmorderweeklyprice").html(parseFloat(orderweeklyprice).toFixed(2));
        $("#confirmorderprice_input").val(parseFloat(orderweeklyprice).toFixed(2));
        
        $("#ord_delivery_startdate").val(weekStart);
        $("#ord_delivery_enddate").val(weekEnd);

        $("#ord_delivery_fromtime").val(time[0]);
        $("#ord_delivery_totime").val(time[1]);
        
    }else{
        $("#datetimeerror").html("<div class='alert alert-danger'>Please select date & time !</div>");
    }
}


function check_cart_item_exists(kitchenid)
{
    $.ajax({
        url: SITE_URL+'kitchen-detail/cardItemCheck',
        type: 'POST',
        data: {kitchenId:kitchenid},
        dataType: 'json',
        // async: false,
        success: function(response){
            if(response.type == 1){
            }else if(response.type == 2){
              
                swal({
                    title: "Items already in cart",
                    text: "Your cart contains items from other kitchen. Would you like to reset your cart for adding items from this kitchen?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    // confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart_package(packageid);
                                }
                            }
                        });
                    }
                });
            
            }else if(response.type == 3){
            
                swal({
                    title: "Already added trial meal in cart",
                    text: "Your cart contains items from trial meal. Would you like to reset your cart for adding packages in cart?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart_package(packageid);
                                }
                            }
                        });
                    }
                });
            }else if(response.type == 4){
              
                var meal = "Breakfast";
                if(response.mealfor == 1){
                    meal = "Lunch";
                }else if(response.mealfor == 2){
                    meal = "Dinner";
                }
                swal({
                    title: "Items already in cart",
                    text: "Your cart contains already package is added for "+meal+". Would you like to reset your cart for adding package from other meal ?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart_package(packageid);
                                }
                            }
                        });
                    }
                });           
            }
            return response.type;
        }
    });
}
function open_date_select_modal(){
    $("#datetimeerror").html("");
    $(".ui-datepicker-current-day a").removeClass("ui-state-active");
    $(".ui-datepicker-calendar td").removeClass("ui-datepicker-current-day");

    $("input[name=delivery-time]").prop("checked", false);
 
}

function addtocart_package(packageid){
    
    var formdata = new FormData($('#package_form')[0]);

    $.ajax({
        url: SITE_URL+'kitchen-detail/addtocart-package',
        type: 'POST',
        data: formdata,
        dataType: 'json',
        // async: false,
        success: function(response){
            if(response.cartcount==0){
                $("#cart_count_header").removeClass("base-count");
                $("#cart_count_header").html('');
            }else{
                $("#cart_count_header").html(response.cartcount);
                $("#cart_count_header").addClass("base-count");
            }
            if(response.type == 1){
                
                toastr.success('Package successfully added to cart.');
                setTimeout(function(){window.location.reload();},2000);

            }else if(response.type == 2){
              
                swal({
                    title: "Items already in cart",
                    text: "Your cart contains items from other kitchen. Would you like to reset your cart for adding items from this kitchen?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart_package(packageid);
                                }
                            }
                        });
                    }
                });
            
            }else if(response.type == 3){
            
                swal({
                    title: "Already added trial meal in cart",
                    text: "Your cart contains items from trial meal. Would you like to reset your cart for adding packages in cart?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart_package(packageid);
                                }
                            }
                        });
                    }
                });

            }else if(response.type == 4){
              
                var meal = "Breakfast";
                if(response.mealfor == 1){
                    meal = "Lunch";
                }else if(response.mealfor == 2){
                    meal = "Dinner";
                }
                swal({
                    title: "Items already in cart",
                    text: "Your cart contains already package is added for "+meal+". Would you like to reset your cart for adding package from other meal ?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart_package(packageid);
                                }
                            }
                        });
                    }
                });
            
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function add_favorute_kitchen(){
    var kitchen_id = $("#userid").val();

    $.ajax({
        url: SITE_URL+'kitchen-detail/addfavoritekitchen',
        type: 'POST',
        data: {kitchen_id: kitchen_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            toastr.success("Kitchen added to favorite.");
            $("#favorite_kitchen").attr({"onclick":"remove_favorute_kitchen()","title":"Remove to Favourite"}).html('<img src="'+FRONT_IMAGES_URL+'Grou9902.png" alt="" class="img-fluid">');
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
function remove_favorute_kitchen(){
    var kitchen_id = $("#userid").val();

    $.ajax({
        url: SITE_URL+'kitchen-detail/removefavoritekitchen',
        type: 'POST',
        data: {kitchen_id: kitchen_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            toastr.success("Kitchen removed to favorite.");
            $("#favorite_kitchen").attr({"onclick":"add_favorute_kitchen()","title":"Add to Favourite"}).html('<img src="'+FRONT_IMAGES_URL+'Grou45649902.png" class="img-fluid">');
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
