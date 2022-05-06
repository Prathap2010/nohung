$(document).ready(function() { 
    
});

function skiptonext(type){

    if(type=="SI"){
        
        $(".si_bf_veg").each(function(index){
            var elementId = parseInt($(this).attr("id").match(/\d+/));
            var menuid = $("#id_si_bf_veg"+elementId).val();
            
            if(menuid=="" || menuid==undefined){

                $("#img_si_bf_veg"+elementId).attr("src",defaultimage);
                $("#image_si_bf_veg"+elementId).val('');
                $("#itemname_si_bf_veg"+elementId).val('');
                $("#itemprice_si_bf_veg"+elementId).val('');
                $("#itemqty_si_bf_veg"+elementId).val('');
                $("#itemname_si_bf_veg"+elementId).select2("val", "");
                $("#instock_si_bf_veg"+elementId).prop("checked", false);
    
                $("#el_image_si_bf_veg"+elementId).css("border", "0");
                $("#el_itemname_si_bf_veg"+elementId).css("border", "0");
                $("#el_itemprice_si_bf_veg"+elementId).css("border", "0");
                $("#el_itemqty_si_bf_veg"+elementId).css("border", "0");
            }
        });    
        $("html, body").animate({ scrollTop: $("#nonveg_si_section").offset().top }, 600);
    }
}

function additem(element,menu_type="breakfast"){

    var count = parseInt($("."+element+":last").attr("id").match(/\d+/))+1;

    var menutype_html = '';
    if (menu_type == "lunch_dinner"){
        menutype_html += '<td>\
                            <div class="form-group" id="el_menutype_si_lunch_'+ element + count + '" style="margin-bottom: 0;">\
                                <select type="text" class="menu-input s-input" name="menutype_'+ element + '[]" id="menutype_' + element + count +'">\
                                    <option value="1" selected>Lunch</option>\
                                    <option value="2">Dinner</option>\
                                    <option value="3">Lunch & Dinner</option>\
                                </select>\
                            </div>\
                        </td>';
    }
    var html = '<tr class="'+element+'" id="'+element+count+'">\
                    <td>\
                        <input type="hidden" id="cnt_'+element+count+'" name="cnt_'+element+'[]" value="'+count+'">\
                        <input type="hidden" id="id_'+element+count+'" name="id_'+element+'[]" value="">\
                        <input type="hidden" id="preimg_'+element+count+'" name="preimg_'+element+'[]" value="">\
                        <div class="upload-btn-wrapper" id="el_image_'+element+count+'">\
                            <button class="btn">\
                                <img id="img_'+element+count+'" src="'+KITCHEN_IMAGES_URL+'upload-icon.svg" class="uploaded-img">\
                            </button>\
                            <input type="file" name="image_'+element+count+'" id="image_'+element+count+'" onchange="checkfile($(this),\''+element+'\')" accept=".jpg,.jpeg,.png,.gif"/>\
                        </div>\
                    </td>\
                    <td>\
                        <div class="form-group" id="el_itemname_'+element+count+'" style="margin-bottom: 0;">\
                            <input type="text" class="menu-input" name="itemname_'+element+'[]" id="itemname_'+element+count+'" data-provide="itemname_'+element+count+'" placeholder="Enter Item Name">\
                        </div>\
                    </td>\
                    <td>\
                        <div class="form-group" id="el_itemprice_'+element+count+'" style="margin-bottom: 0;">\
                            <input type="text" class="menu-input s-input" name="itemprice_'+element+'[]" id="itemprice_'+element+count+'" placeholder="Price">\
                        </div>\
                    </td>\
                    <td>\
                        <div class="form-group" id="el_itemqty_'+element+count+'" style="margin-bottom: 0;">\
                            <input type="text" class="menu-input s-input" name="itemqty_'+element+'[]" id="itemqty_'+element+count+'" placeholder="Quantity">\
                        </div>\
                    </td>\
                    '+menutype_html+'\
                    <td>\
                        <div class="stock-radio">\
                            <input type="checkbox" name="instock_'+element+count+'" id="instock_'+element+count+'" value="1">\
                            <label for="instock_'+element+count+'">In stock</label>\
                        </div>\
                    </td>\
                    <td class="text-center">\
                        <a href="javascript:void(0)" class="add-menu-row addbtn_'+element+'" onclick="additem(\''+element+'\',\''+menu_type+'\')"><img src="'+KITCHEN_IMAGES_URL+'menu-plus.svg" alt=""></a>\
                        <a href="javascript:void(0)" class="rmbtn_'+element+'" onclick="removeitem(\''+element+count+'\')" style="display:none;"><img src="'+KITCHEN_IMAGES_URL+'trash.svg" alt=""></a>\
                    </td>\
                </tr>';

    $(".addbtn_"+element).hide();
    $(".rmbtn_"+element).show();

    $("#"+element+(count-1)).after(html);
    
    $("[data-provide='itemname_"+element+count+"']").each(function () {
        var $element = $(this);

        $element.select2({    
            allowClear: true,
            minimumInputLength: 1,     
            width: '100%',  
            placeholder: $element.attr("placeholder"),         
            createSearchChoice: function(term, data) {
                if ($(data).filter(function() {
                    return this.text.localeCompare(term) === 0;
                }).length === 0) {
                return {
                        id: term,
                        text: term
                    };
                }
            },
            ajax: {
                url: SITE_URL+"menu/searchitem",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term,
                    };
                },
                results: function (data) {            
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,                        
                                id: item.text
                            }
                        })
                    };
                }
            },
            initSelection: function (element, callback) {
                var itemname = $(element).val(); 

                if (itemname !== "" && itemname!=='0') {
                    $.ajax(SITE_URL+"menu/searchitem", {
                        data: {
                            id: itemname
                        },
                        type: "POST",
                        dataType: "json",
                    }).done(function (data) {
                        callback(data);    
                    });
                }
            }
        });
    });

}
function removeitem(element){

    $("#"+element).remove();
}

function savemenu(element){
    var isvalid = 1;
    
    $("."+element).each(function(index){
        var elementId = element+parseInt($(this).attr("id").match(/\d+/));
        var image = $("#image_"+elementId).val();
        var preimage = $("#preimg_"+elementId).val();
        var itemname = $("#itemname_"+elementId).val();
        var itemprice = $("#itemprice_"+elementId).val();
        var itemqty = $("#itemqty_"+elementId).val();

        if(image == '' && preimage == ""){
            $("#el_image_"+elementId).css("border", "1px solid #f00");
            toastr.error('Please select '+(index+1)+' image !');
            isvalid = 0;
        }else{
            $("#el_image_"+elementId).css("border", "0");
        }
        if(itemname == ''){
            $("#el_itemname_"+elementId).css("border", "1px solid #f00");
            toastr.error('Please enter '+(index+1)+' item name !');
            isvalid = 0;
        }else{
            $("#el_itemname_"+elementId).css("border", "0");
        }
        if(itemprice == ''){
            $("#el_itemprice_"+elementId).css("border", "1px solid #f00");
            toastr.error('Please enter '+(index+1)+' item price !');
            isvalid = 0;
        }else{
            $("#el_itemprice_"+elementId).css("border", "0");
        }
        if(itemqty == ''){
            $("#el_itemqty_"+elementId).css("border", "1px solid #f00");
            toastr.error('Please enter '+(index+1)+' item qty !');
            isvalid = 0;
        }else{
            $("#el_itemqty_"+elementId).css("border", "0");
        }
    });

    if(isvalid==1){
        var formData = new FormData($('#'+element+'_form')[0]);
        $.ajax({
            url: SITE_URL+"menu/savebreakfast",
            type: 'POST',
            data: formData,
            success: function(response){
                if(response==1){
                    toastr.success('Menu saved successfully !');
                    if(element=="si_bf_veg"){
                        setTimeout(function(){ $("html, body").animate({ scrollTop: $("#nonveg_si_section").offset().top }, 600); },2000);
                    }else if(element=="si_bf_nonveg"){
                        setTimeout(function(){ $("#si_lunch").click(); },2000);
                    }else if(element=="ni_bf_veg"){
                        setTimeout(function(){ $("html, body").animate({ scrollTop: $("#nonveg_ni_section").offset().top }, 600); },2000);
                    }else if(element=="ni_bf_nonveg"){
                        setTimeout(function(){ $("#ni_lunch").click(); },2000);
                    }else if(element=="oi_bf_veg"){
                        setTimeout(function(){ $("html, body").animate({ scrollTop: $("#nonveg_oi_section").offset().top }, 600); },2000);
                    }else if(element=="oi_bf_nonveg"){
                        setTimeout(function(){ $("#oi_lunch").click(); },2000);
                    }
                    
                    /* setTimeout(function(){
                        window.location.href=SITE_URL;
                    },2000); */
                }else if(response==0){
                    toastr.error('Menu not added !');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function savelunchordinnermenu(element){
    var isvalid = 1;
    /* $(".category_"+element).each(function(index){
        var category = $(this).val();
        var cat = category.replace(' ','_').toLowerCase();
        var elementID = element+"_"+cat;
        
        $("."+elementID).each(function(i){
            var elementId = elementID+parseInt($(this).attr("id").match(/\d+/));
            var image = $("#image_"+elementId).val();
            var preimage = $("#preimg_"+elementId).val();
            var itemname = $("#itemname_"+elementId).val();
            var itemprice = $("#itemprice_"+elementId).val();
            var itemqty = $("#itemqty_"+elementId).val();
    
            if(image == '' && preimage == ""){
                $("#el_image_"+elementId).css("border", "1px solid #f00");
                notifyme.create({title:"Image "+(index+1)+" - "+category,text:"This field is required !",type:"alert"});
                isvalid = 0;
            }else{
                $("#el_image_"+elementId).css("border", "0");
            }
            if(itemname == ''){
                $("#el_itemname_"+elementId).css("border", "1px solid #f00");
                notifyme.create({title:"Item Name "+(index+1)+" - "+category,text:"This field is required !",type:"alert"});
                isvalid = 0;
            }else{
                $("#el_itemname_"+elementId).css("border", "0");
            }
            if(itemprice == ''){
                $("#el_itemprice_"+elementId).css("border", "1px solid #f00");
                notifyme.create({title:"Item Price "+(index+1)+" - "+category,text:"This field is required !",type:"alert"});
                isvalid = 0;
            }else{
                $("#el_itemprice_"+elementId).css("border", "0");
            }
            if(itemqty == ''){
                $("#el_itemqty_"+elementId).css("border", "1px solid #f00");
                notifyme.create({title:"Item Qty "+(index+1)+" - "+category,text:"This field is required !",type:"alert"});
                isvalid = 0;
            }else{
                $("#el_itemqty_"+elementId).css("border", "0");
            }
        });
    }); */

    if(isvalid==1){
        var formData = new FormData($('#'+element+'_form')[0]);
        $.ajax({
            url: SITE_URL+"menu/savelunchordinner",
            type: 'POST',
            data: formData,
            success: function(response){
                if(response==1){
                    toastr.success('Menu saved successfully !');
                    /* if(element=="si_lunch"){
                        setTimeout(function(){ $("#si_dinner").click(); },2000);
                    }else if(element=="si_dinner"){
                        setTimeout(function(){ window.location.reload(); },2000);
                    }else if(element=="ni_lunch"){
                        setTimeout(function(){ $("#ni_dinner").click(); },2000);
                    }else if(element=="ni_dinner"){
                        // setTimeout(function(){ window.location.reload(); },2000);
                    }else if(element=="oi_lunch"){
                        setTimeout(function(){ $("#oi_dinner").click(); },2000);
                    }else if(element=="oi_dinner"){
                        setTimeout(function(){ window.location.reload(); },2000);
                    } */
                    setTimeout(function () { window.location.reload(); }, 2000);
                    /* setTimeout(function(){
                        window.location.href=SITE_URL;
                    },2000); */
                }else if(response==0){
                    toastr.error('Menu not added !');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}