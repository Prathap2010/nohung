var lo_offset = ao_offset = 0;
$(document).ready(function(){
    $('#startdate,#enddate').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayBtn:"linked"
    });

    $("#discounttype").change(function(){
        if(this.value==0){
            $(".disc-val").html("%");
        }else{
            $(".disc-val").html("&#8377;");
        }
    });
    $("#searchofferform").on("submit", function(e){
        e.preventDefault();
    });
    $('#searchoffer').on("keyup", function(){
        lo_offset = ao_offset = 0;
        get_live_offers();
        get_archive_offers();
    });

    get_live_offers();
    get_archive_offers();
});
function get_live_offers(){
    var search = $("#searchoffer").val();
    
    $.ajax({
        url: SITE_URL+'offer/get-live-offers',
        type: 'POST',
        data: {offset:parseInt(lo_offset),search:search},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".lo.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".lo.load_more_btn a").text('Loading...');
            $('#lolist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+SITE_URL+"assets/images/loading-please-wait.gif'></div>");
        },
        success: function(response){

            $('#lolist .loading-image').remove();
            
            if(parseInt(lo_offset)==0){
                $("#lolist").html(response.html);
            }else{
                $("#lolist").append(response.html);
            }
            lo_offset = parseInt(lo_offset) + parseInt(PER_PAGE_OFFER);
            
            if(parseInt(lo_offset) >= parseInt(response.totalrows)){
                $(".lo.load_more_btn").hide();
            }else{
                $(".lo.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".lo.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".lo.load_more_btn a").text('Load More');
        },
    });
}
function get_archive_offers(){
    var search = $("#searchoffer").val();
    
    $.ajax({
        url: SITE_URL+'offer/get-archive-offers',
        type: 'POST',
        data: {offset:parseInt(ao_offset),search:search},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".ao.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".ao.load_more_btn a").text('Loading...');
        },
        success: function(response){

            if(parseInt(ao_offset)==0){
                $("#aolist").html(response.html);
            }else{
                $("#aolist").append(response.html);
            }
            ao_offset = parseInt(ao_offset) + parseInt(PER_PAGE_OFFER);
            
            if(parseInt(ao_offset) >= parseInt(response.totalrows)){
                $(".ao.load_more_btn").hide();
            }else{
                $(".ao.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".ao.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".ao.load_more_btn a").text('Load More');
        },
    });
}
function reset_form_modal(){
    $(".offermodal .form-group").removeClass("manage-error");
    $("#offerid,#title,#offercode,#discount,#startdate,#enddate,#starttime,#endtime,#usagelimit").val('');
    $("#discounttype").val("0");
    $(".disc-val").html("%");
    
    $("#myModal .modal-title").html("Add an Offer");
    $("#r5,#r11,#chk1").prop("checked",true);

    $("#btn_addoffer").attr("onclick","addoffer('add')").html("Create Offer");
}
function addoffer(type="add"){
                
    var title = $("#title").val().trim();
    var offercode = $("#offercode").val().trim();
    var discounttype = $("#discounttype").val();
    var discount = $("#discount").val();
    var startdate = $("#startdate").val();
    var enddate = $("#enddate").val();
    var starttime = $("#starttime").val();
    var endtime = $("#endtime").val();

    var isvalid = 1;
        
    if(title == ''){
        $("#titleelement").addClass("manage-error");
        toastr.error('Please enter offer title !');
        isvalid = 0;
    }else {
        if(title.length<2){
            $("#titleelement").addClass("manage-error");
            toastr.error('Offer title require minimum 2 characters !');
            isvalid = 0;
        }else{
            $("#titleelement").removeClass("manage-error");
        }
    }
    if(offercode == ''){
        $("#ocelement").addClass("manage-error");
        toastr.error('Please enter discount code !');
        isvalid = 0;
    }else {
        $("#ocelement").removeClass("manage-error");
    }
    if(discount == ""){
        $("#diselement").addClass("manage-error");
        toastr.error('Please enter discount !');
        isvalid = 0;
    }else{
        $("#diselement").removeClass("manage-error");
    }
    if(discount == ""){
        $("#diselement").addClass("manage-error");
        toastr.error('Please enter discount value !');
        isvalid = 0;
    }else{
        $("#diselement").removeClass("manage-error");
    }
    if(startdate == ''){
        $("#sdelement").addClass("manage-error");
        toastr.error('Please select start date !');
        isvalid = 0;
    }else {
        $("#sdelement").removeClass("manage-error");
    }
    if(enddate == ''){
        $("#edelement").addClass("manage-error");
        toastr.error('Please select end date !');
        isvalid = 0;
    }else{
        $("#edelement").removeClass("manage-error");
    }
    if(starttime == ''){
        $("#stelement").addClass("manage-error");
        toastr.error('Please select start time !');
        isvalid = 0;
    }else {
        $("#stelement").removeClass("manage-error");
    }
    if(endtime == ''){
        $("#etelement").addClass("manage-error");
        toastr.error('Please select end time !');
        isvalid = 0;
    }else{
        $("#etelement").removeClass("manage-error");
    } 
        
    if(isvalid ==1){
    
        var formData = new FormData($('#offerform')[0]);
        if(type=="add"){
            $.ajax({
                url: SITE_URL+"offer/add-offer",
                type: 'POST',
                data: formData,
                success: function(response){
                    if(response==1){
                        toastr.success('Offer successfully added.');
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
                    }else if(response==2){
                        toastr.error('Offer code already exist !');
                    }else if(response==0){
                        toastr.error('Offer not added !');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }else{

            $.ajax({
                url: SITE_URL+"offer/update-offer",
                type: 'POST',
                data: formData,
                success: function(response){
                    if(response==1){
                        toastr.success('Offer successfully updated.');
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
                    }else if(response==2){
                        toastr.error('Offer code already exist !');
                    }else if(response==0){
                        toastr.error('Offer not update !');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        
    }
}
function get_offer_detail(offerid){
    reset_form_modal();
    if(offerid!=""){
        $("#myModal .modal-title").html("Edit Offer");
        $("#btn_addoffer").attr("onclick","addoffer('edit')").html("Update Offer");
        $("#offerid").val(offerid);

        $.ajax({
            url: SITE_URL+'offer/get-offer-detail',
            type: 'POST',
            data: {offerid:offerid},
            dataType: 'json',
            // async: false,
            success: function(response){
                
                $("#title").val(response.title);
                $("#offercode").val(response.offercode);
                $("#discounttype").val(response.discounttype);
                $("#discount").val(response.discount);
                $(".disc-val").html((response.discounttype == 0 ? "%" : "&#8377;"));

                if(response.appliesto==1){
                    $("#r5").prop("checked",true);
                }else if(response.appliesto==2){
                    $("#r6").prop("checked",true);
                }else if(response.appliesto==3){
                    $("#r7").prop("checked",true);
                }else{
                    $("#r-all").prop("checked",true);
                }
                if(response.minrequirement==0){
                    $("#r11").prop("checked",true);
                }else if(response.minrequirement==1){
                    $("#r12").prop("checked",true);
                }else{
                    $("#r13").prop("checked",true);
                }

                if(response.usagelimit > 0){
                    $("#chk1").prop("checked",true);
                    $("#usagelimit").val(response.usagelimit);
                }else{
                    $("#chk1").prop("checked",false);
                    $("#usagelimit").val("");
                }

                $("#myModal").modal("show");
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            }
        });
    }
}
function deleteoffer(id){
    
    swal({
        title: "Are you sure you want to delete this offer ?",
        text: "",
        type: "warning",
        showCancelButton: true,   
        confirmButtonColor: "#FFA451",   
        confirmButtonText: "Yes",   
        closeOnConfirm: false }, 
        function(isConfirm){   
        if (isConfirm) {  
            $.ajax({
                url: SITE_URL + "offer/delete-offer",
                data: {id:id},
                // dataType: "json",
                type: "POST",
                success: function (data) {
                    $("#offer"+id).remove();
                    swal.close();
                }
            });  
        }
    });
}