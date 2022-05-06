var offset = 0;
$(document).ready(function(){
    $('#startdate').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayBtn:"linked"
    });
    if(packages > 0){
        load_packages();
    }
});
function load_packages(){
    
    $.ajax({
        url: SITE_URL+'package/load-packages',
        type: 'POST',
        data: {offset:parseInt(offset)},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".load_more_btn a").text('Loading...');
        },
        success: function(response){

            if(parseInt(offset)==0){
                $("#packagelist").html(response.html);
            }else{
                $("#packagelist").append(response.html);
            }
            offset = parseInt(offset) + parseInt(PER_PAGE_PACKAGE);
            
            if(parseInt(offset) >= parseInt(response.totalrows)){
                $(".load_more_btn").hide();
            }else{
                $(".load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".load_more_btn a").text('Load More');
        },
    });
}
function deletepackage(id){
    
    swal({
        title: "Are you sure you want to delete this package ?",
        text: "",
        type: "warning",
        showCancelButton: true,   
        confirmButtonColor: "#FFA451",   
        confirmButtonText: "Yes",   
        closeOnConfirm: false }, 
        function(isConfirm){   
        if (isConfirm) {   
            $.ajax({
                url: SITE_URL + "package/delete-package",
                data: {id:id},
                // dataType: "json",
                type: "POST",
                success: function (data) {
                    $("#package"+id).remove();
                    swal.close();
                }
            });
        }
    });
}
function addpackage(){

    var packageid = $("#packageid").val().trim();
    var packagename = $("#packagename").val().trim();
    var startdate = $("#startdate").val();
    var plantype = $(".plantype:checked").length;
    
    var isvalid = 1;
        
    if(packagename == ''){
        $("#pnelement").addClass("manage-error");
        toastr.error('Please enter package name !');
        isvalid = 0;
    }else {
        $("#pnelement").removeClass("manage-error");
    }
    if(startdate == ''){
        $("#sdelement").addClass("manage-error");
        toastr.error('Please select start date !')
        isvalid = 0;
    }else {
        $("#sdelement").removeClass("manage-error");
    }
    if(plantype == 0){
        toastr.error('Please select atleat one plan !')
        isvalid = 0;
    }

    if(isvalid ==1){
        
        var formData = new FormData($('#packageform')[0]);
        $.ajax({
            url: SITE_URL+"package/add-package",
            type: 'POST',
            data: formData,
            success: function(response){
                if(response > 0){
                    /* if(packageid==""){
                        notifyme.create({title:"Packages",text:"Package successfully added.",type:"success"});
                    }else{
                        notifyme.create({title:"Packages",text:"Package successfully updated.",type:"success"});
                    } */
                    setTimeout(function(){
                        window.location.href = SITE_URL+"package/edit-package/"+response.trim();
                    },1500);
                }else if(response==-2){
                    toastr.error('Packages already exist !')
                }else if(response==0){
                    toastr.error('Packages not added !')
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
    }
}
function openpopup(id=""){
    $("#packageid,#packagename,#startdate").val("");
    $("#pnelement,#sdelement").removeClass("manage-error");
    $('#northindian,#veg,#breakfast,#including_saturday,#including_sunday').prop("checked",true);
    $('#weekly').prop("checked",true);
    $('#monthly').prop("checked",false);
    $("#packageModal .modal-title").html("Create Package");

    if(id!=""){
        $("#packageModal .modal-title").html("Edit Package");
        var packagename = $("#packagename"+id).val();
        var cuisinetype = $("#cuisinetype"+id).val();
        var mealtype = $("#mealtype"+id).val();
        var mealfor = $("#mealfor"+id).val();
        var weeklyplantype = $("#weeklyplantype"+id).val();
        var monthlyplantype = $("#monthlyplantype"+id).val();
        var startdate = $("#startdate"+id).val();
        var including_saturday = $("#including_saturday"+id).val();
        var including_sunday = $("#including_sunday"+id).val();

        $("#packageid").val(id);
        $("#packagename").val(packagename);
        $("#startdate").val(startdate);
        if(cuisinetype==0){
            $('#southindian').prop("checked",true);
        }else if(cuisinetype==1){
            $('#northindian').prop("checked",true);
        }else if(cuisinetype==2){
            $('#othercuisine').prop("checked",true);
        }
        if(mealtype==0){
            $('#veg').prop("checked",true);
        }else if(mealtype==1){
            $('#nonveg').prop("checked",true);
        }
        if(mealfor==0){
            $('#breakfast').prop("checked",true);
        }else if(mealfor==1){
            $('#lunch').prop("checked",true);
        }else if(mealfor==2){
            $('#dinner').prop("checked",true);
        }
        if(weeklyplantype==0){
            $('#weekly').prop("checked",false);
        }else if(weeklyplantype==1){
            $('#weekly').prop("checked",true);
        }
        if(monthlyplantype==0){
            $('#monthly').prop("checked",false);
        }else if(monthlyplantype==1){
            $('#monthly').prop("checked",true);
        }
        if(including_saturday==0){
            $('#including_saturday').prop("checked",false);
        }else if(including_saturday==1){
            $('#including_saturday').prop("checked",true);
        }
        if(including_sunday==0){
            $('#including_sunday').prop("checked",false);
        }else if(including_sunday==1){
            $('#including_sunday').prop("checked",true);
        }
    }
}
