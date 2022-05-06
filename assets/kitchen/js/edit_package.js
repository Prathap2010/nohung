$(document).ready(function(){
    $("#weeklyprice").on('keyup', function(){
        var weeklyactualprice = $("#inputweeklyactualprice").val();

        if(this.value!="" && parseFloat(this.value)>0){

            var variation = (parseFloat(this.value) * 100 / parseFloat(weeklyactualprice)) - 100;
            $("#weeklypricevariayion").html(parseFloat(variation).toFixed(2)+"%");

            var remaindays = 30;
            var temp = parseInt(remaindays) / 7; 
            var weeks = parseInt(temp);
            var extradays = parseInt(remaindays) - (7 * parseInt(weeks));

            var monthlyprice = parseFloat(this.value) * parseInt(weeks);

            var monthlyactualprice = $("#inputmonthlyactualprice").val();

            for(var i=0; i<parseInt(extradays);i++){
                var price = $("#totalprice"+(i+1)).val();
                if(price!=""){
                    monthlyprice += parseFloat(price);
                }
            }
            $("#monthlyprice").val(parseFloat(monthlyprice).toFixed(2))
            var variation = (parseFloat(monthlyprice) * 100 / parseFloat(monthlyactualprice)) - 100;
            $("#monthlypricevariayion").html(parseFloat(variation).toFixed(2)+"%");
        }
    });
    $("#monthlyprice").on('keyup', function(){
        var monthlyactualprice = $("#inputmonthlyactualprice").val();

        if(this.value!="" && parseFloat(this.value)>0){

            var variation = (parseFloat(this.value) * 100 / parseFloat(monthlyactualprice)) - 100;
            $("#monthlypricevariayion").html(parseFloat(variation).toFixed(2)+"%");
        }
    });
    calculateactualprice();
    $(".qty").TouchSpin({
        min:1,
        verticalbuttons: true,
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus'
    });
});
function openrightbar(days){
    $(".chkitem").prop("checked", false);
    $(".set-menu-body").show();
    $(".set-menu-body-2").hide();
    $(".set-default-menu .selecteditem:first").prop("checked", true);
    $("#selecteddays").val(days);

    var menuid = $("#menuid"+days).val();

    if(menuid!=""){
        menuid = JSON.parse(menuid);
        if(menuid.length > 0){

            for(var i=0;i<menuid.length;i++){
                if(menuid[i]['qty'] > 0){
                    $("#qty"+menuid[i]['menuid']).val(parseInt(menuid[i]['qty']));
                }
                $("#meniitemdetailid"+menuid[i]['menuid']).val(menuid[i]['id']);
                $("#chk"+menuid[i]['menuid']).prop("checked", true);
            }
            /* if(menuid.indexOf(',') > -1){
                menuid = menuid.split(",");
                for(var i=0;i<menuid.length;i++){
                    $("#chk"+menuid[i]).prop("checked", true);
                }
            }else{
                $("#chk"+menuid).prop("checked", true);
            } */
        }
    }
}   
function setdefaultitem(){
    
    $("#menu1error").html("");
    if($(".chkitem:checked").length > 0){
        $(".set-menu-body").hide();
        $(".set-menu-body-2").show();
        var days = $("#selecteddays").val();

        var defailtdishitem = $("#defailtdishitem"+days).val();

        var html = "";
        var menuidArr = [];
        var menunameArr = [];
        var totalprice = 0;
        $('.category_item').each(function(){
            var category = $(this).attr("id");
            var CATEGORYcap = capitalizeFirstLetter(category.replace("_"," "));
            
            if($(".set-menu-body #"+category+" .chkitem:checked").length > 0){
                
                html += '<div class="set-default-menu">\
                            <div class="default-title">'+CATEGORYcap+'</div>\
                            <div class="default-menu-items">';

                        $(".set-menu-body #"+category+" .chkitem:checked").each(function(index){
                            var menuid = $(this).attr("id").match(/\d+/);
                            var itemname = $(this).attr("data-itemname"); 
                            var itemprice = $(this).attr("data-itemprice"); 
                            
                            // menuidArr.push(menuid);
                            // menunameArr.push(itemname);
                            
                            var checked = "";
                            if(defailtdishitem!=""){
                                if(defailtdishitem.indexOf(',') > -1){
                                    var defailtdishitemarr = defailtdishitem.split(",");
                                    for(var i=0;i<defailtdishitemarr.length;i++){
                                        if(parseInt(defailtdishitemarr[i])==parseInt(menuid)){
                                            checked = "checked";                                            
                                        }
                                    }
                                }else{
                                    if(parseInt(defailtdishitem)==parseInt(menuid)){
                                        checked = "checked";
                                    }
                                }
                            }
                            if(checked==""){
                                checked = (index==0)?"checked":"";
                            }
                            
                            qty = "";
                            //if(category=="bread"){
                                if($("#qty"+menuid).val()!=""){
                                    qty = parseInt($("#qty"+menuid).val());
                                    itemname = (parseInt(qty) > 1 ? parseInt(qty)+" " : "")+itemname;
                                }
                            //}
                            menuidArr.push({"id":$("#meniitemdetailid"+menuid).val(),"menuid":parseInt(menuid).toString(),"itemname":itemname,"qty":qty,"price":parseFloat(itemprice).toFixed()});
                            menunameArr.push(itemname);

                            if(qty!=""){
                                totalprice += (parseFloat(itemprice) * parseInt(qty)) ;
                            }else{
                                totalprice += parseFloat(itemprice);
                            }

                            html += '<input type="radio" id="defaultitem'+menuid+'" name="defaultitem_'+category+'" class="selecteditem" '+checked+'>\
                                    <label for="defaultitem'+menuid+'">'+itemname+'</label>';
                        }); 
                
                html += '</div></div>';   
            } 
        }); 
        $("#menuid"+days).val(JSON.stringify(menuidArr));
        $("#textmenuid"+days).html(menunameArr.join(', '));
        $("#totalprice"+days).val(parseFloat(totalprice).toFixed(2));
        $("#texttotalprice"+days).html('₹'+parseFloat(totalprice).toFixed(2));
        $("#defaultitemdata").html(html);
        
        calculateactualprice();
    }else{
        $("#menu1error").html("Please check atleast one item !");
    }
}
function addmeal(){
    var days = $("#selecteddays").val();
    var selectedItemArr = [];

    $(".selecteditem:checked").each(function(){
        var menuid = $(this).attr("id").match(/\d+/);
        selectedItemArr.push(menuid);
    });
    $("#defailtdishitem"+days).val(selectedItemArr.join(','));
    $("#hide").click();
}
function createpackage(){
    var weeklyprice = $("#weeklyprice").val();
    var monthlyprice = $("#monthlyprice").val();

    var isvalid = 1;
    if(weeklyprice==0){
        $("#wpelement").addClass("manage-error");
        // notifyme.create({title:"Weekly Price",text:"Please enter weekly price !",type:"alert"});
        toastr.error('Please enter weekly price !')
        isvalid = 0;
    }else{
        $("#wpelement").removeClass("manage-error");
    }
    if(monthlyprice==0){
        $("#mpelement").addClass("manage-error");
        // notifyme.create({title:"Monthly Price",text:"Please enter monthly price !",type:"alert"});
        toastr.error('Please enter monthly price !')
        isvalid = 0;
    }else{
        $("#mpelement").removeClass("manage-error");
    }
    if(isvalid==1){
        var formData = new FormData($('#packageform')[0]);
        $.ajax({
            url: SITE_URL+"package/create-package",
            type: 'POST',
            data: formData,
            success: function(response){
                if(response > 0){
                    // notifyme.create({title:"Package",text:"Package successfully created.",type:"success"});
                    toastr.success('Package successfully created.')

                    setTimeout(function(){
                        window.location.href = SITE_URL+"package";
                    },1500);
                }else if(response==0){
                    // notifyme.create({title:"Package",text:"Packages not create !",type:"alert"});
                    toastr.error('Packages not create !')
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
function calculateactualprice(){
    var totalprice = 0;
    $(".totalprice").each(function(){
        if(this.value!=""){
            totalprice += parseFloat(this.value)
        }
    });
    $("#weeklyactualprice").html("₹"+parseFloat(totalprice).toFixed(2));
    $("#inputweeklyactualprice").val(parseFloat(totalprice).toFixed(2));
    
    var weeklyprice = $("#weeklyprice").val();
    var monthlyprice = $("#monthlyprice").val();
    if(weeklyprice!="" && parseFloat(totalprice)>0){

        var variation = (parseFloat(weeklyprice) * 100 / parseFloat(totalprice)) - 100;
        $("#weeklypricevariayion").html(parseFloat(variation).toFixed(2)+"%");
    }
    if(monthlyprice!="" && parseFloat(0)>0){

        var variation = (parseFloat(0) * 100 / parseFloat(monthlyprice)) - 100;
        $("#monthlypricevariayion").html(parseFloat(variation).toFixed(2)+"%");
    }
    var startday = $("#startday").val();
    var startdate = $("#startdate").val();
    var date = new Date(startdate);
    var firstDay = new Date(date. getFullYear(), date. getMonth(), 1);
    var lastDay = new Date(date. getFullYear(), date. getMonth() + 1, 0);
    
    // var lastDayWithSlashes = (lastDay.getDate()) + '/' + (lastDay.getMonth() + 1) + '/' + lastDay.getFullYear();
    var lastDay = lastDay.getDate();
    // console.log(lastDay);
    
    // var remaindays = parseInt(lastDay) - parseInt(startday) + 1;
    // var temp = parseInt(remaindays) / 7; 
    // var weeks = parseInt(temp);
    // var extradays = parseInt(remaindays) - (7 * parseInt(weeks));

    var remaindays = 30;
    var temp = parseInt(remaindays) / 7; 
    var weeks = parseInt(temp);
    var extradays = parseInt(remaindays) - (7 * parseInt(weeks));

    var montlyactualprice = parseFloat(totalprice) * parseInt(weeks);

    for(var i=0; i<parseInt(extradays);i++){
        var price = $("#totalprice"+(i+1)).val();
        if(price!=""){
            montlyactualprice += parseFloat(price);
        }
    }
    $("#monthlyactualprice").html("₹"+parseFloat(montlyactualprice).toFixed(2));
    $("#inputmonthlyactualprice").val(parseFloat(montlyactualprice).toFixed(2));

    $("#weeklyprice").val(parseFloat(totalprice).toFixed(2)).keyup();
    $("#monthlyprice").val(parseFloat(montlyactualprice).toFixed(2)).keyup();
}