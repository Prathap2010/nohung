<?php
$si_breakfast = array();
if(!empty($menudata)){
    $si_breakfast = $menudata['southind']['breakfast'];
    $si_lunch = $menudata['southind']['lunch'];
    // $si_dinner = $menudata['southind']['dinner'];

    $ni_breakfast = $menudata['northind']['breakfast'];
    $ni_lunch = $menudata['northind']['lunch'];
    // $ni_dinner = $menudata['northind']['dinner'];

    $oi_breakfast = $menudata['otherind']['breakfast'];
    $oi_lunch = $menudata['otherind']['lunch'];
    // $oi_dinner = $menudata['otherind']['dinner'];
}
if($menucount > 0){ ?>    
    <script>
    var defaultimage = '<?= KITCHEN_IMAGES_URL.'upload-icon.svg'?>';
    </script>
    <style>
        .select2-container{
            padding: 0 !important;
        }
        .select2-container a{
            height: 100% !important;
        }
        .table td, .table th {
            padding: 0.5rem;
        }
    </style>
    <div class="offerManagementWrap">
        <div class="offermanageTopHeading">
            <h2>Master Menu</h2>
        </div>
    
        <div class="verticalTabSection">
            <div class="row">
                <div class="col-lg-3">
                    <div class="tabVerticalContents">
                        <span>Type of Cuisine</span>
                        <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="SouthIndian-tab" data-toggle="tab" href="#SouthIndian" role="tab" aria-controls="SouthIndian" aria-selected="true">
                                    South Indian
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="NorthIndian-tab" data-toggle="tab" href="#NorthIndian" role="tab" aria-controls="NorthIndian" aria-selected="false">North Indian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="OtherIndian-tab" data-toggle="tab" href="#OtherIndian" role="tab" aria-controls="OtherIndian" aria-selected="false">Other Cuisine</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.col-md-4 -->
                <div class="col-lg-9">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="SouthIndian" role="tabpanel" aria-labelledby="SouthIndian-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#SouthIndianBreakfast" role="tab">Breakfast</a>
                                </li>
                                <li class="nav-item">
                                    <a id="si_lunch" class="nav-link" data-toggle="tab" href="#SouthIndianLunch" role="tab">Lunch & Dinner</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a id="si_dinner" class="nav-link" data-toggle="tab" href="#SouthIndianDinner" role="tab">Dinner</a>
                                </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="SouthIndianBreakfast" role="tabpanel">
                                    <div class="southIndiaBreakFastContent">
                                        <div class="vegAndNon_veg">
                                            <h1 style="visibility: hidden;">Hello</h1>
                                            <span><img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg</span>
                                        </div>
                                        <form action="#" id="si_bf_veg_form" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="elementname" value="si_bf_veg">
                                            <input type="hidden" id="cuisinetype" name="cuisinetype" value="0">
                                            <input type="hidden" id="menutype" name="menutype" value="0">
                                            <input type="hidden" id="itemtype" name="itemtype" value="0">
                                            <div class="table-responsive">    
                                                <table class="table">    
                                                    <?php if(!empty($si_breakfast)){ 
                                                        $vegbflength = !empty($si_breakfast['veg'])?count($si_breakfast['veg']):1;
                                                        for($i=0; $i<$vegbflength;$i++){ 
                                                            $id = $i+1;
                                                            if(!empty($si_breakfast['veg']) && isset($si_breakfast['veg'][$i])){
                                                                $mastermenuid = $si_breakfast['veg'][$i]['id'];
                                                                $imagesrc = MENU.$si_breakfast['veg'][$i]['image'];
                                                                $itemname = $si_breakfast['veg'][$i]['itemname'];
                                                                $itemprice = $si_breakfast['veg'][$i]['itemprice'];
                                                                $itemdetail = $si_breakfast['veg'][$i]['itemdetail'];
                                                                $instock = ($si_breakfast['veg'][$i]['instock']==1)?"checked":"";
                                                            }else{
                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                            }
                                                            ?>
        
                                                            <tr class="si_bf_veg" id="si_bf_veg<?=$id?>">
                                                                <td>
                                                                    <input type="hidden" id="cnt_si_bf_veg<?=$id?>" name="cnt_si_bf_veg[]" value="<?=$id?>">
                                                                    <input type="hidden" id="id_si_bf_veg<?=$id?>" name="id_si_bf_veg[]" value="<?=$mastermenuid?>">
                                                                    <input type="hidden" id="preimg_si_bf_veg<?=$id?>" name="preimg_si_bf_veg[]" value="<?=(isset($si_breakfast['veg'][$i]))?$si_breakfast['veg'][$i]['image']:""?>">
                                                                    <div class="upload-btn-wrapper" id="el_image_si_bf_veg<?=$id?>">
                                                                        <button class="btn">
                                                                            <img id="img_si_bf_veg<?=$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                        </button>
                                                                        <input type="file" name="image_si_bf_veg<?=$id?>" id="image_si_bf_veg<?=$id?>" onchange="checkfile($(this),'si_bf_veg')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemname_si_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" placeholder="Enter Item Name" class="menu-input" name="itemname_si_bf_veg[]" id="itemname_si_bf_veg<?=$id?>" value="<?=$itemname?>" data-provide="itemname_si_bf_veg<?=$id?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemprice_si_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" placeholder="Price" class="menu-input s-input" name="itemprice_si_bf_veg[]" id="itemprice_si_bf_veg<?=$id?>" value="<?=$itemprice?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemqty_si_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" placeholder="Quantity" class="menu-input s-input" name="itemqty_si_bf_veg[]" id="itemqty_si_bf_veg<?=$id?>" value="<?=$itemdetail?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="stock-radio">
                                                                        <input type="checkbox" name="instock_si_bf_veg<?=$id?>" id="instock_si_bf_veg<?=$id?>" value="1" <?=$instock?>>
                                                                        <label for="instock_si_bf_veg<?=$id?>">In stock</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_si_bf_veg" onclick="additem('si_bf_veg')" style="<?php if($id!=$vegbflength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                    <a href="javascript:void(0)" class="rmbtn_si_bf_veg" onclick="removeitem('si_bf_veg<?=$id?>')" style="<?php if($id==$vegbflength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function() { 
                                                                        $("[data-provide='itemname_si_bf_veg<?=$id?>']").each(function () {
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
                                                                    });
                                                                </script>
                                                            </tr>
                                                        <?php } ?>                                                
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </form>
                                        <div class="southIndiaFooterButton">
                                            <a href="javascript:void(0)" onclick="skiptonext('SI')">Skip to Next >></a>
                                            <button type="submit" onclick="savemenu('si_bf_veg')">Save & Next</button>
                                        </div>
    
                                        <div class="vegAndNon_veg" id="nonveg_si_section">
                                            <h1 style="visibility: hidden;">Hello</h1>
                                            <span><img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt="">Non-Veg</span>
                                        </div>
                                        <form action="#" id="si_bf_nonveg_form" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="elementname" value="si_bf_nonveg">
                                            <input type="hidden" id="cuisinetype" name="cuisinetype" value="0">
                                            <input type="hidden" id="menutype" name="menutype" value="0">
                                            <input type="hidden" id="itemtype" name="itemtype" value="1">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <?php if(!empty($si_breakfast)){ 
                                                        $nonvegbflength = !empty($si_breakfast['nonveg'])?count($si_breakfast['nonveg']):1;
                                                        for($i=0; $i<$nonvegbflength;$i++){ 
                                                            $id = $i+1;
                                                            if(!empty($si_breakfast['nonveg']) && isset($si_breakfast['nonveg'][$i])){
                                                                $mastermenuid = $si_breakfast['nonveg'][$i]['id'];
                                                                $imagesrc = MENU.$si_breakfast['nonveg'][$i]['image'];
                                                                $itemname = $si_breakfast['nonveg'][$i]['itemname'];
                                                                $itemprice = $si_breakfast['nonveg'][$i]['itemprice'];
                                                                $itemdetail = $si_breakfast['nonveg'][$i]['itemdetail'];
                                                                $instock = ($si_breakfast['nonveg'][$i]['instock']==1)?"checked":"";
                                                            }else{
                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                            }
                                                            ?>
        
                                                            <tr class="si_bf_nonveg" id="si_bf_nonveg<?=$id?>">
                                                                <td>
                                                                    <input type="hidden" id="cnt_si_bf_nonveg<?=$id?>" name="cnt_si_bf_nonveg[]" value="<?=$id?>">
                                                                    <input type="hidden" id="id_si_bf_nonveg<?=$id?>" name="id_si_bf_nonveg[]" value="<?=$mastermenuid?>">
                                                                    <input type="hidden" id="preimg_si_bf_nonveg<?=$id?>" name="preimg_si_bf_nonveg[]" value="<?=(isset($si_breakfast['nonveg'][$i]))?$si_breakfast['nonveg'][$i]['image']:""?>">
                                                                    <div class="upload-btn-wrapper" id="el_image_si_bf_nonveg<?=$id?>">
                                                                        <button class="btn">
                                                                            <img id="img_si_bf_nonveg<?=$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                        </button>
                                                                        <input type="file" name="image_si_bf_nonveg<?=$id?>" id="image_si_bf_nonveg<?=$id?>" onchange="checkfile($(this),'si_bf_nonveg')" accept=".jpg,.jpeg,.png,.gif" value=""/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemname_si_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input" name="itemname_si_bf_nonveg[]" id="itemname_si_bf_nonveg<?=$id?>" value="<?=$itemname?>" data-provide="itemname_si_bf_nonveg<?=$id?>" placeholder="Enter Item Name">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemprice_si_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemprice_si_bf_nonveg[]" id="itemprice_si_bf_nonveg<?=$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemqty_si_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemqty_si_bf_nonveg[]" id="itemqty_si_bf_nonveg<?=$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="stock-radio">
                                                                        <input type="checkbox" name="instock_si_bf_nonveg<?=$id?>" id="instock_si_bf_nonveg<?=$id?>" value="1" <?=$instock?>>
                                                                        <label for="instock_si_bf_nonveg<?=$id?>">In stock</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_si_bf_nonveg" onclick="additem('si_bf_nonveg')" style="<?php if($id!=$nonvegbflength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                    <a href="javascript:void(0)" class="rmbtn_si_bf_nonveg" onclick="removeitem('si_bf_nonveg<?=$id?>')" style="<?php if($id==$nonvegbflength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function() { 
                                                                        $("[data-provide='itemname_si_bf_nonveg<?=$id?>']").each(function () {
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
                                                                    });
                                                                </script>
                                                            </tr>
                                                        <?php } ?>                                                
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </form>
                                        <div class="southIndiaFooterButton">
                                            <button type="submit" onclick="savemenu('si_bf_nonveg')">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="SouthIndianLunch" role="tabpanel">
                                    <div class="meal-tab" id="SouthIndianLunchVeg" role="tabpanel" aria-labelledby="SouthIndianLunchVeg-tab">
                                        <div class="southIndiaBreakFastContent">
                                            <form action="#" id="si_lunch_form" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="elementname" value="si_lunch">
                                                <input type="hidden" id="cuisinetype" name="cuisinetype" value="0">
                                                <!-- <input type="hidden" id="menutype" name="menutype" value="1"> -->
                                                <input type="hidden" id="itemtype" name="itemtype" value="0">
                                                <div class="vegAndNon_veg">
                                                    <ul class="nav nav-tabs">
                                                        <?php foreach($this->MenuLunchCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link <?=($key==1?'active':'')?>" data-toggle="tab" href="#SILV-<?=$cat?>" role="tab"><?=$value?></a>
                                                                <input type="hidden" name="category_si_lunch[]" id="category_si_lunch<?=$key?>" value="<?=$value?>" class="category_si_lunch">
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="food-type">
                                                        <span class="veg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg
                                                        </span>
                                                        <span class="nonveg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt=""> Non Veg
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="tab-content">
                                                    <?php foreach($this->MenuLunchCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                        <div class="tab-pane <?=($key==1?'active':'')?>" id="SILV-<?=$cat?>" role="tabpanel">
                                                            <div class="table-responsive">
                                                                <table class="table">                                                    
                                                                    <?php //if(!empty($si_lunch)){ 
                                                                        $lunchlength = !empty($si_lunch[$value])?count($si_lunch[$value]):1;
                                                                        for($i=0; $i<$lunchlength;$i++){ 
                                                                            $id = $i+1;
                                                                            if(!empty($si_lunch[$value]) && isset($si_lunch[$value][$i])){
                                                                                $mastermenuid = $si_lunch[$value][$i]['id'];
                                                                                $imagesrc = MENU.$si_lunch[$value][$i]['image'];
                                                                                $itemname = $si_lunch[$value][$i]['itemname'];
                                                                                $itemprice = $si_lunch[$value][$i]['itemprice'];
                                                                                $itemdetail = $si_lunch[$value][$i]['itemdetail'];
                                                                                $instock = ($si_lunch[$value][$i]['instock']==1)?"checked":"";
                                                                                $menu_type = $si_lunch[$value][$i]['menutype'];
                                                                            }else{
                                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = $menu_type = "";
                                                                            }
                                                                            ?>
        
                                                                            <tr class="si_lunch_<?=$cat?>" id="si_lunch_<?=$cat.$id?>">
                                                                                <td>
                                                                                    <input type="hidden" id="cnt_si_lunch_<?=$cat.$id?>" name="cnt_si_lunch_<?=$cat?>[]" value="<?=$id?>">
                                                                                    <input type="hidden" id="id_si_lunch_<?=$cat.$id?>" name="id_si_lunch_<?=$cat?>[]" value="<?=$mastermenuid?>">
                                                                                    <input type="hidden" id="preimg_si_lunch_<?=$cat.$id?>" name="preimg_si_lunch_<?=$cat?>[]" value="<?=(isset($si_lunch[$value][$i]))?$si_lunch[$value][$i]['image']:""?>">
                                                                                    <div class="upload-btn-wrapper" id="el_image_si_lunch_<?=$cat.$id?>">
                                                                                        <button class="btn">
                                                                                            <img id="img_si_lunch_<?=$cat.$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                                        </button>
                                                                                        <input type="file" name="image_si_lunch_<?=$cat.$id?>" id="image_si_lunch_<?=$cat.$id?>" onchange="checkfile($(this),'si_lunch_<?=$cat?>')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemname_si_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input" name="itemname_si_lunch_<?=$cat?>[]" id="itemname_si_lunch_<?=$cat.$id?>" value="<?=$itemname?>" data-provide="itemname_si_lunch_<?=$cat.$id?>" placeholder="Enter Item Name">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemprice_si_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input s-input" name="itemprice_si_lunch_<?=$cat?>[]" id="itemprice_si_lunch_<?=$cat.$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemqty_si_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input s-input" name="itemqty_si_lunch_<?=$cat?>[]" id="itemqty_si_lunch_<?=$cat.$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_menutype_si_lunch_<?= $cat . $id ?>" style="margin-bottom: 0;">
                                                                                        <select type="text" class="menu-input s-input" name="menutype_si_lunch_<?= $cat ?>[]" id="menutype_si_lunch_<?= $cat . $id ?>">
                                                                                            <option value="1" <?= ($menu_type == "" || $menu_type == "1" ? "selected" : "") ?>>Lunch</option>
                                                                                            <option value="2" <?= ($menu_type == "2" ? "selected" : "") ?>>Dinner</option>
                                                                                            <option value="3" <?= ($menu_type == "3" ? "selected" : "") ?>>Lunch & Dinner</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="stock-radio">
                                                                                        <input type="checkbox" name="instock_si_lunch_<?=$cat.$id?>" id="instock_si_lunch_<?=$cat.$id?>" value="1" <?=$instock?>>
                                                                                        <label for="instock_si_lunch_<?=$cat.$id?>">In stock</label>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_si_lunch_<?=$cat?>" onclick="additem('si_lunch_<?=$cat?>','lunch_dinner')" style="<?php if($id!=$lunchlength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                                    <a href="javascript:void(0)" class="rmbtn_si_lunch_<?=$cat?>" onclick="removeitem('si_lunch_<?=$cat.$id?>')" style="<?php if($id==$lunchlength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                                </td>
                                                                                <script>
                                                                                    $(document).ready(function() { 
                                                                                        $("[data-provide='itemname_si_lunch_<?=$cat.$id?>']").each(function () {
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
                                                                                    });
                                                                                </script>
                                                                            </tr>
                                                                        <?php } ?>                                                
                                                                    <?php //} ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                            <div class="southIndiaFooterButton">
                                                <button type="submit" onclick="savelunchordinnermenu('si_lunch')">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php /* 
                                <div class="tab-pane" id="SouthIndianDinner" role="tabpanel">
                                    <div class="meal-tab" id="SouthIndianDinnerVeg" role="tabpanel" aria-labelledby="SouthIndianDinnerVeg-tab">
                                        <div class="southIndiaBreakFastContent">
                                            <form action="#" id="si_dinner_form" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="elementname" value="si_dinner">
                                                <input type="hidden" id="cuisinetype" name="cuisinetype" value="0">
                                                <input type="hidden" id="menutype" name="menutype" value="2">
                                                <input type="hidden" id="itemtype" name="itemtype" value="0">
                                                <div class="vegAndNon_veg">
                                                    <ul class="nav nav-tabs">
                                                        <?php foreach($this->MenuDinnerCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link <?=($key==1?'active':'')?>" data-toggle="tab" href="#SIDV-<?=$cat?>" role="tab"><?=$value?></a>
                                                                <input type="hidden" name="category_si_dinner[]" id="category_si_dinner<?=$key?>" value="<?=$value?>" class="category_si_dinner">
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="food-type">
                                                        <span class="veg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg
                                                        </span>
                                                        <span class="nonveg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt=""> Non Veg
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="tab-content">
                                                    <?php foreach($this->MenuDinnerCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                        <div class="tab-pane <?=($key==1?'active':'')?>" id="SIDV-<?=$cat?>" role="tabpanel">
                                                            <table class="table">                                                    
                                                                <?php //if(!empty($si_lunch)){ 
                                                                    $dinnerlength = !empty($si_dinner[$value])?count($si_dinner[$value]):1;
                                                                    for($i=0; $i<$dinnerlength;$i++){ 
                                                                        $id = $i+1;
                                                                        if(!empty($si_dinner[$value]) && isset($si_dinner[$value][$i])){
                                                                            $mastermenuid = $si_dinner[$value][$i]['id'];
                                                                            $imagesrc = MENU.$si_dinner[$value][$i]['image'];
                                                                            $itemname = $si_dinner[$value][$i]['itemname'];
                                                                            $itemprice = $si_dinner[$value][$i]['itemprice'];
                                                                            $itemdetail = $si_dinner[$value][$i]['itemdetail'];
                                                                            $instock = ($si_dinner[$value][$i]['instock']==1)?"checked":"";
                                                                        }else{
                                                                            $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                            $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                                        }
                                                                        ?>
    
                                                                        <tr class="si_dinner_<?=$cat?>" id="si_dinner_<?=$cat.$id?>">
                                                                            <td>
                                                                                <input type="hidden" id="cnt_si_dinner_<?=$cat.$id?>" name="cnt_si_dinner_<?=$cat?>[]" value="<?=$id?>">
                                                                                <input type="hidden" id="id_si_dinner_<?=$cat.$id?>" name="id_si_dinner_<?=$cat?>[]" value="<?=$mastermenuid?>">
                                                                                <input type="hidden" id="preimg_si_dinner_<?=$cat.$id?>" name="preimg_si_dinner_<?=$cat?>[]" value="<?=(isset($si_dinner[$value][$i]))?$si_dinner[$value][$i]['image']:""?>">
                                                                                <div class="upload-btn-wrapper" id="el_image_si_dinner_<?=$cat.$id?>">
                                                                                    <button class="btn">
                                                                                        <img id="img_si_dinner_<?=$cat.$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                                    </button>
                                                                                    <input type="file" name="image_si_dinner_<?=$cat.$id?>" id="image_si_dinner_<?=$cat.$id?>" onchange="checkfile($(this),'si_dinner_<?=$cat?>')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemname_si_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input" name="itemname_si_dinner_<?=$cat?>[]" id="itemname_si_dinner_<?=$cat.$id?>" value="<?=$itemname?>" data-provide="itemname_si_dinner_<?=$cat.$id?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemprice_si_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input s-input" name="itemprice_si_dinner_<?=$cat?>[]" id="itemprice_si_dinner_<?=$cat.$id?>" value="<?=$itemprice?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemqty_si_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input s-input" name="itemqty_si_dinner_<?=$cat?>[]" id="itemqty_si_dinner_<?=$cat.$id?>" value="<?=$itemdetail?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="stock-radio">
                                                                                    <input type="checkbox" name="instock_si_dinner_<?=$cat.$id?>" id="instock_si_dinner_<?=$cat.$id?>" value="1" <?=$instock?>>
                                                                                    <label for="instock_si_dinner_<?=$cat.$id?>">In stock</label>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a href="javascript:void(0)" class="add-menu-row addbtn_si_dinner_<?=$cat?>" onclick="additem('si_dinner_<?=$cat?>')" style="<?php if($id!=$dinnerlength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                                <a href="javascript:void(0)" class="rmbtn_si_dinner_<?=$cat?>" onclick="removeitem('si_dinner_<?=$cat.$id?>')" style="<?php if($id==$dinnerlength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                            </td>
                                                                            <script>
                                                                                $(document).ready(function() { 
                                                                                    $("[data-provide='itemname_si_dinner_<?=$cat.$id?>']").each(function () {
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
                                                                                });
                                                                            </script>
                                                                        </tr>
                                                                    <?php } ?>                                                
                                                                <?php //} ?>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="southIndiaFooterButton">
                                                    <button type="submit" onclick="savelunchordinnermenu('si_dinner')">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> */ ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="NorthIndian" role="tabpanel" aria-labelledby="NorthIndian-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#NorthIndianBreakfast" role="tab">Breakfast</a>
                                </li>
                                <li class="nav-item">
                                    <a id="ni_lunch" class="nav-link" data-toggle="tab" href="#NorthIndianLunch" role="tab">Lunch & Dinner</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a id="ni_dinner" class="nav-link" data-toggle="tab" href="#NorthIndianDinner" role="tab">Dinner</a>
                                </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="NorthIndianBreakfast" role="tabpanel">
                                    <div class="southIndiaBreakFastContent">
                                        <div class="vegAndNon_veg">
                                            <h1 style="visibility: hidden;">Hello</h1>
                                            <span><img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg</span>
                                        </div>
                                        <form action="#" id="ni_bf_veg_form" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="elementname" value="ni_bf_veg">
                                            <input type="hidden" id="cuisinetype" name="cuisinetype" value="1">
                                            <input type="hidden" id="menutype" name="menutype" value="0">
                                            <input type="hidden" id="itemtype" name="itemtype" value="0">
                                            <div class="table-responsive">
                                                <table class="table">    
                                                    <?php if(!empty($ni_breakfast)){ 
                                                        $vegbflength = !empty($ni_breakfast['veg'])?count($ni_breakfast['veg']):1;
                                                        for($i=0; $i<$vegbflength;$i++){ 
                                                            $id = $i+1;
                                                            if(!empty($ni_breakfast['veg']) && isset($ni_breakfast['veg'][$i])){
                                                                $mastermenuid = $ni_breakfast['veg'][$i]['id'];
                                                                $imagesrc = MENU.$ni_breakfast['veg'][$i]['image'];
                                                                $itemname = $ni_breakfast['veg'][$i]['itemname'];
                                                                $itemprice = $ni_breakfast['veg'][$i]['itemprice'];
                                                                $itemdetail = $ni_breakfast['veg'][$i]['itemdetail'];
                                                                $instock = ($ni_breakfast['veg'][$i]['instock']==1)?"checked":"";
                                                            }else{
                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                            }
                                                            ?>
        
                                                            <tr class="ni_bf_veg" id="ni_bf_veg<?=$id?>">
                                                                <td>
                                                                    <input type="hidden" id="cnt_ni_bf_veg<?=$id?>" name="cnt_ni_bf_veg[]" value="<?=$id?>">
                                                                    <input type="hidden" id="id_ni_bf_veg<?=$id?>" name="id_ni_bf_veg[]" value="<?=$mastermenuid?>">
                                                                    <input type="hidden" id="preimg_ni_bf_veg<?=$id?>" name="preimg_ni_bf_veg[]" value="<?=(isset($ni_breakfast['veg'][$i]))?$ni_breakfast['veg'][$i]['image']:""?>">
                                                                    <div class="upload-btn-wrapper" id="el_image_ni_bf_veg<?=$id?>">
                                                                        <button class="btn">
                                                                            <img id="img_ni_bf_veg<?=$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                        </button>
                                                                        <input type="file" name="image_ni_bf_veg<?=$id?>" id="image_ni_bf_veg<?=$id?>" onchange="checkfile($(this),'ni_bf_veg')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemname_ni_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input" name="itemname_ni_bf_veg[]" id="itemname_ni_bf_veg<?=$id?>" value="<?=$itemname?>" data-provide="itemname_ni_bf_veg<?=$id?>" placeholder="Enter Item Name">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemprice_ni_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemprice_ni_bf_veg[]" id="itemprice_ni_bf_veg<?=$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemqty_ni_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemqty_ni_bf_veg[]" id="itemqty_ni_bf_veg<?=$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="stock-radio">
                                                                        <input type="checkbox" name="instock_ni_bf_veg<?=$id?>" id="instock_ni_bf_veg<?=$id?>" value="1" <?=$instock?>>
                                                                        <label for="instock_ni_bf_veg<?=$id?>">In stock</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_ni_bf_veg" onclick="additem('ni_bf_veg')" style="<?php if($id!=$vegbflength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                    <a href="javascript:void(0)" class="rmbtn_ni_bf_veg" onclick="removeitem('ni_bf_veg<?=$id?>')" style="<?php if($id==$vegbflength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function() { 
                                                                        $("[data-provide='itemname_ni_bf_veg<?=$id?>']").each(function () {
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
                                                                    });
                                                                </script>
                                                            </tr>
                                                        <?php } ?>                                                
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </form>
                                        <div class="southIndiaFooterButton">
                                            <a href="javascript:void(0)" onclick="skiptonext('NI')">Skip to Next >></a>
                                            <button type="submit" onclick="savemenu('ni_bf_veg')">Save & Next</button>
                                        </div>
    
                                        <div class="vegAndNon_veg" id="nonveg_ni_section">
                                            <h1 style="visibility: hidden;">Hello</h1>
                                            <span><img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt="">Non-Veg</span>
                                        </div>
                                        <form action="#" id="ni_bf_nonveg_form" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="elementname" value="ni_bf_nonveg">
                                            <input type="hidden" id="cuisinetype" name="cuisinetype" value="1">
                                            <input type="hidden" id="menutype" name="menutype" value="0">
                                            <input type="hidden" id="itemtype" name="itemtype" value="1">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <?php if(!empty($ni_breakfast)){ 
                                                        $nonvegbflength = !empty($ni_breakfast['nonveg'])?count($ni_breakfast['nonveg']):1;
                                                        for($i=0; $i<$nonvegbflength;$i++){ 
                                                            $id = $i+1;
                                                            if(!empty($ni_breakfast['nonveg']) && isset($ni_breakfast['nonveg'][$i])){
                                                                $mastermenuid = $ni_breakfast['nonveg'][$i]['id'];
                                                                $imagesrc = MENU.$ni_breakfast['nonveg'][$i]['image'];
                                                                $itemname = $ni_breakfast['nonveg'][$i]['itemname'];
                                                                $itemprice = $ni_breakfast['nonveg'][$i]['itemprice'];
                                                                $itemdetail = $ni_breakfast['nonveg'][$i]['itemdetail'];
                                                                $instock = ($ni_breakfast['nonveg'][$i]['instock']==1)?"checked":"";
                                                            }else{
                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                            }
                                                            ?>
        
                                                            <tr class="ni_bf_nonveg" id="ni_bf_nonveg<?=$id?>">
                                                                <td>
                                                                    <input type="hidden" id="cnt_ni_bf_nonveg<?=$id?>" name="cnt_ni_bf_nonveg[]" value="<?=$id?>">
                                                                    <input type="hidden" id="id_ni_bf_nonveg<?=$id?>" name="id_ni_bf_nonveg[]" value="<?=$mastermenuid?>">
                                                                    <input type="hidden" id="preimg_ni_bf_nonveg<?=$id?>" name="preimg_ni_bf_nonveg[]" value="<?=(isset($ni_breakfast['nonveg'][$i]))?$ni_breakfast['nonveg'][$i]['image']:""?>">
                                                                    <div class="upload-btn-wrapper" id="el_image_ni_bf_nonveg<?=$id?>">
                                                                        <button class="btn">
                                                                            <img id="img_ni_bf_nonveg<?=$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                        </button>
                                                                        <input type="file" name="image_ni_bf_nonveg<?=$id?>" id="image_ni_bf_nonveg<?=$id?>" onchange="checkfile($(this),'ni_bf_nonveg')" accept=".jpg,.jpeg,.png,.gif" value=""/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemname_ni_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input" name="itemname_ni_bf_nonveg[]" id="itemname_ni_bf_nonveg<?=$id?>" value="<?=$itemname?>" data-provide="itemname_ni_bf_nonveg<?=$id?>" placeholder="Enter Item Name">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemprice_ni_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemprice_ni_bf_nonveg[]" id="itemprice_ni_bf_nonveg<?=$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemqty_ni_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemqty_ni_bf_nonveg[]" id="itemqty_ni_bf_nonveg<?=$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="stock-radio">
                                                                        <input type="checkbox" name="instock_ni_bf_nonveg<?=$id?>" id="instock_ni_bf_nonveg<?=$id?>" value="1" <?=$instock?>>
                                                                        <label for="instock_ni_bf_nonveg<?=$id?>">In stock</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_ni_bf_nonveg" onclick="additem('ni_bf_nonveg')" style="<?php if($id!=$nonvegbflength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                    <a href="javascript:void(0)" class="rmbtn_ni_bf_nonveg" onclick="removeitem('ni_bf_nonveg<?=$id?>')" style="<?php if($id==$nonvegbflength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function() { 
                                                                        $("[data-provide='itemname_ni_bf_nonveg<?=$id?>']").each(function () {
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
                                                                    });
                                                                </script>
                                                            </tr>
                                                        <?php } ?>                                                
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </form>
                                        <div class="southIndiaFooterButton">
                                            <button type="submit" onclick="savemenu('ni_bf_nonveg')">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="NorthIndianLunch" role="tabpanel">
                                    <div class="meal-tab" id="SouthIndianLunchVeg" role="tabpanel" aria-labelledby="SouthIndianLunchVeg-tab">
                                        <div class="southIndiaBreakFastContent">
                                            <form action="#" id="ni_lunch_form" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="elementname" value="ni_lunch">
                                                <input type="hidden" id="cuisinetype" name="cuisinetype" value="1">
                                                <!-- <input type="hidden" id="menutype" name="menutype" value="1"> -->
                                                <input type="hidden" id="itemtype" name="itemtype" value="0">
                                                <div class="vegAndNon_veg">
                                                    <ul class="nav nav-tabs">
                                                        <?php foreach($this->MenuLunchCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link <?=($key==1?'active':'')?>" data-toggle="tab" href="#NILV-<?=$cat?>" role="tab"><?=$value?></a>
                                                                <input type="hidden" name="category_ni_lunch[]" id="category_ni_lunch<?=$key?>" value="<?=$value?>" class="category_ni_lunch">
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="food-type">
                                                        <span class="veg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg
                                                        </span>
                                                        <span class="nonveg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt=""> Non Veg
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="tab-content">
                                                    <?php foreach($this->MenuLunchCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                        <div class="tab-pane <?=($key==1?'active':'')?>" id="NILV-<?=$cat?>" role="tabpanel">
                                                            <div class="table-responsive">
                                                                <table class="table">                                                    
                                                                    <?php //if(!empty($si_lunch)){ 
                                                                        $lunchlength = !empty($ni_lunch[$value])?count($ni_lunch[$value]):1;
                                                                        for($i=0; $i<$lunchlength;$i++){ 
                                                                            $id = $i+1;
                                                                            if(!empty($ni_lunch[$value]) && isset($ni_lunch[$value][$i])){
                                                                                $mastermenuid = $ni_lunch[$value][$i]['id'];
                                                                                $imagesrc = MENU.$ni_lunch[$value][$i]['image'];
                                                                                $itemname = $ni_lunch[$value][$i]['itemname'];
                                                                                $itemprice = $ni_lunch[$value][$i]['itemprice'];
                                                                                $itemdetail = $ni_lunch[$value][$i]['itemdetail'];
                                                                                $instock = ($ni_lunch[$value][$i]['instock']==1)?"checked":"";
                                                                                $menu_type = $ni_lunch[$value][$i]['menutype'];
                                                                            }else{
                                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = $menu_type = "";
                                                                            }
                                                                            ?>
        
                                                                            <tr class="ni_lunch_<?=$cat?>" id="ni_lunch_<?=$cat.$id?>">
                                                                                <td>
                                                                                    <input type="hidden" id="cnt_ni_lunch_<?=$cat.$id?>" name="cnt_ni_lunch_<?=$cat?>[]" value="<?=$id?>">
                                                                                    <input type="hidden" id="id_ni_lunch_<?=$cat.$id?>" name="id_ni_lunch_<?=$cat?>[]" value="<?=$mastermenuid?>">
                                                                                    <input type="hidden" id="preimg_ni_lunch_<?=$cat.$id?>" name="preimg_ni_lunch_<?=$cat?>[]" value="<?=(isset($ni_lunch[$value][$i]))?$ni_lunch[$value][$i]['image']:""?>">
                                                                                    <div class="upload-btn-wrapper" id="el_image_ni_lunch_<?=$cat.$id?>">
                                                                                        <button class="btn">
                                                                                            <img id="img_ni_lunch_<?=$cat.$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                                        </button>
                                                                                        <input type="file" name="image_ni_lunch_<?=$cat.$id?>" id="image_ni_lunch_<?=$cat.$id?>" onchange="checkfile($(this),'ni_lunch_<?=$cat?>')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemname_ni_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input" name="itemname_ni_lunch_<?=$cat?>[]" id="itemname_ni_lunch_<?=$cat.$id?>" value="<?=$itemname?>" data-provide="itemname_ni_lunch_<?=$cat.$id?>" placeholder="Enter Item Name">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemprice_ni_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input s-input" name="itemprice_ni_lunch_<?=$cat?>[]" id="itemprice_ni_lunch_<?=$cat.$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemqty_ni_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input s-input" name="itemqty_ni_lunch_<?=$cat?>[]" id="itemqty_ni_lunch_<?=$cat.$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_menutype_ni_lunch_<?= $cat . $id ?>" style="margin-bottom: 0;">
                                                                                        <select type="text" class="menu-input s-input" name="menutype_ni_lunch_<?= $cat ?>[]" id="menutype_ni_lunch_<?= $cat . $id ?>">
                                                                                            <option value="1" <?= ($menu_type == "" || $menu_type == "1" ? "selected" : "") ?>>Lunch</option>
                                                                                            <option value="2" <?= ($menu_type == "2" ? "selected" : "") ?>>Dinner</option>
                                                                                            <option value="3" <?= ($menu_type == "3" ? "selected" : "") ?>>Lunch & Dinner</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="stock-radio">
                                                                                        <input type="checkbox" name="instock_ni_lunch_<?=$cat.$id?>" id="instock_ni_lunch_<?=$cat.$id?>" value="1" <?=$instock?>>
                                                                                        <label for="instock_ni_lunch_<?=$cat.$id?>">In stock</label>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_ni_lunch_<?=$cat?>" onclick="additem('ni_lunch_<?=$cat?>','lunch_dinner')" style="<?php if($id!=$lunchlength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                                    <a href="javascript:void(0)" class="rmbtn_ni_lunch_<?=$cat?>" onclick="removeitem('ni_lunch_<?=$cat.$id?>')" style="<?php if($id==$lunchlength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                                </td>
                                                                                <script>
                                                                                    $(document).ready(function() { 
                                                                                        $("[data-provide='itemname_ni_lunch_<?=$cat.$id?>']").each(function () {
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
                                                                                    });
                                                                                </script>
                                                                            </tr>
                                                                        <?php } ?>                                                
                                                                    <?php //} ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                            <div class="southIndiaFooterButton">
                                                <button type="submit" onclick="savelunchordinnermenu('ni_lunch')">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php /* 
                                <div class="tab-pane" id="NorthIndianDinner" role="tabpanel">
                                    <div class="meal-tab" id="SouthIndianDinnerVeg" role="tabpanel" aria-labelledby="SouthIndianDinnerVeg-tab">
                                        <div class="southIndiaBreakFastContent">
                                            <form action="#" id="ni_dinner_form" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="elementname" value="ni_dinner">
                                                <input type="hidden" id="cuisinetype" name="cuisinetype" value="1">
                                                <input type="hidden" id="menutype" name="menutype" value="2">
                                                <input type="hidden" id="itemtype" name="itemtype" value="0">
                                                <div class="vegAndNon_veg">
                                                    <ul class="nav nav-tabs">
                                                        <?php foreach($this->MenuDinnerCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link <?=($key==1?'active':'')?>" data-toggle="tab" href="#NIDV-<?=$cat?>" role="tab"><?=$value?></a>
                                                                <input type="hidden" name="category_ni_dinner[]" id="category_ni_dinner<?=$key?>" value="<?=$value?>" class="category_ni_dinner">
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="food-type">
                                                        <span class="veg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg
                                                        </span>
                                                        <span class="nonveg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt=""> Non Veg
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="tab-content">
                                                    <?php foreach($this->MenuDinnerCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                        <div class="tab-pane <?=($key==1?'active':'')?>" id="NIDV-<?=$cat?>" role="tabpanel">
                                                            <table class="table">                                                    
                                                                <?php //if(!empty($si_lunch)){ 
                                                                    $dinnerlength = !empty($ni_dinner[$value])?count($ni_dinner[$value]):1;
                                                                    for($i=0; $i<$dinnerlength;$i++){ 
                                                                        $id = $i+1;
                                                                        if(!empty($ni_dinner[$value]) && isset($ni_dinner[$value][$i])){
                                                                            $mastermenuid = $ni_dinner[$value][$i]['id'];
                                                                            $imagesrc = MENU.$ni_dinner[$value][$i]['image'];
                                                                            $itemname = $ni_dinner[$value][$i]['itemname'];
                                                                            $itemprice = $ni_dinner[$value][$i]['itemprice'];
                                                                            $itemdetail = $ni_dinner[$value][$i]['itemdetail'];
                                                                            $instock = ($ni_dinner[$value][$i]['instock']==1)?"checked":"";
                                                                        }else{
                                                                            $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                            $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                                        }
                                                                        ?>
    
                                                                        <tr class="ni_dinner_<?=$cat?>" id="ni_dinner_<?=$cat.$id?>">
                                                                            <td>
                                                                                <input type="hidden" id="cnt_ni_dinner_<?=$cat.$id?>" name="cnt_ni_dinner_<?=$cat?>[]" value="<?=$id?>">
                                                                                <input type="hidden" id="id_ni_dinner_<?=$cat.$id?>" name="id_ni_dinner_<?=$cat?>[]" value="<?=$mastermenuid?>">
                                                                                <input type="hidden" id="preimg_ni_dinner_<?=$cat.$id?>" name="preimg_ni_dinner_<?=$cat?>[]" value="<?=(isset($ni_dinner[$value][$i]))?$ni_dinner[$value][$i]['image']:""?>">
                                                                                <div class="upload-btn-wrapper" id="el_image_ni_dinner_<?=$cat.$id?>">
                                                                                    <button class="btn">
                                                                                        <img id="img_ni_dinner_<?=$cat.$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                                    </button>
                                                                                    <input type="file" name="image_ni_dinner_<?=$cat.$id?>" id="image_ni_dinner_<?=$cat.$id?>" onchange="checkfile($(this),'ni_dinner_<?=$cat?>')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemname_ni_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input" name="itemname_ni_dinner_<?=$cat?>[]" id="itemname_ni_dinner_<?=$cat.$id?>" value="<?=$itemname?>" data-provide="itemname_ni_dinner_<?=$cat.$id?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemprice_ni_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input s-input" name="itemprice_ni_dinner_<?=$cat?>[]" id="itemprice_ni_dinner_<?=$cat.$id?>" value="<?=$itemprice?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemqty_ni_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input s-input" name="itemqty_ni_dinner_<?=$cat?>[]" id="itemqty_ni_dinner_<?=$cat.$id?>" value="<?=$itemdetail?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="stock-radio">
                                                                                    <input type="checkbox" name="instock_ni_dinner_<?=$cat.$id?>" id="instock_ni_dinner_<?=$cat.$id?>" value="1" <?=$instock?>>
                                                                                    <label for="instock_ni_dinner_<?=$cat.$id?>">In stock</label>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a href="javascript:void(0)" class="add-menu-row addbtn_ni_dinner_<?=$cat?>" onclick="additem('ni_dinner_<?=$cat?>')" style="<?php if($id!=$dinnerlength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                                <a href="javascript:void(0)" class="rmbtn_ni_dinner_<?=$cat?>" onclick="removeitem('ni_dinner_<?=$cat.$id?>')" style="<?php if($id==$dinnerlength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                            </td>
                                                                            <script>
                                                                                $(document).ready(function() { 
                                                                                    $("[data-provide='itemname_ni_dinner_<?=$cat.$id?>']").each(function () {
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
                                                                                });
                                                                            </script>
                                                                        </tr>
                                                                    <?php } ?>                                                
                                                                <?php //} ?>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="southIndiaFooterButton">
                                                    <button type="submit" onclick="savelunchordinnermenu('ni_dinner')">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> */ ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="OtherIndian" role="tabpanel" aria-labelledby="OtherIndian-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#OtherIndianBreakfast" role="tab">Breakfast</a>
                                </li>
                                <li class="nav-item">
                                    <a id="oi_lunch" class="nav-link" data-toggle="tab" href="#OtherIndianLunch" role="tab">Lunch & Dinner</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a id="oi_dinner" class="nav-link" data-toggle="tab" href="#OtherIndianDinner" role="tab">Dinner</a>
                                </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="OtherIndianBreakfast" role="tabpanel">
                                    <div class="southIndiaBreakFastContent">
                                        <div class="vegAndNon_veg">
                                            <h1 style="visibility: hidden;">Hello</h1>
                                            <span><img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg</span>
                                        </div>
                                        <form action="#" id="oi_bf_veg_form" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="elementname" value="oi_bf_veg">
                                            <input type="hidden" id="cuisinetype" name="cuisinetype" value="2">
                                            <input type="hidden" id="menutype" name="menutype" value="0">
                                            <input type="hidden" id="itemtype" name="itemtype" value="0">
                                            <div class="table-responsive">
                                                <table class="table">    
                                                    <?php if(!empty($oi_breakfast)){ 
                                                        $vegbflength = !empty($oi_breakfast['veg'])?count($oi_breakfast['veg']):1;
                                                        for($i=0; $i<$vegbflength;$i++){ 
                                                            $id = $i+1;
                                                            if(!empty($oi_breakfast['veg']) && isset($oi_breakfast['veg'][$i])){
                                                                $mastermenuid = $oi_breakfast['veg'][$i]['id'];
                                                                $imagesrc = MENU.$oi_breakfast['veg'][$i]['image'];
                                                                $itemname = $oi_breakfast['veg'][$i]['itemname'];
                                                                $itemprice = $oi_breakfast['veg'][$i]['itemprice'];
                                                                $itemdetail = $oi_breakfast['veg'][$i]['itemdetail'];
                                                                $instock = ($oi_breakfast['veg'][$i]['instock']==1)?"checked":"";
                                                            }else{
                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                            }
                                                            ?>
        
                                                            <tr class="oi_bf_veg" id="oi_bf_veg<?=$id?>">
                                                                <td>
                                                                    <input type="hidden" id="cnt_oi_bf_veg<?=$id?>" name="cnt_oi_bf_veg[]" value="<?=$id?>">
                                                                    <input type="hidden" id="id_oi_bf_veg<?=$id?>" name="id_oi_bf_veg[]" value="<?=$mastermenuid?>">
                                                                    <input type="hidden" id="preimg_oi_bf_veg<?=$id?>" name="preimg_oi_bf_veg[]" value="<?=(isset($oi_breakfast['veg'][$i]))?$oi_breakfast['veg'][$i]['image']:""?>">
                                                                    <div class="upload-btn-wrapper" id="el_image_oi_bf_veg<?=$id?>">
                                                                        <button class="btn">
                                                                            <img id="img_oi_bf_veg<?=$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                        </button>
                                                                        <input type="file" name="image_oi_bf_veg<?=$id?>" id="image_oi_bf_veg<?=$id?>" onchange="checkfile($(this),'oi_bf_veg')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemname_oi_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input" name="itemname_oi_bf_veg[]" id="itemname_oi_bf_veg<?=$id?>" value="<?=$itemname?>" data-provide="itemname_oi_bf_veg<?=$id?>" placeholder="Enter Item Name">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemprice_oi_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemprice_oi_bf_veg[]" id="itemprice_oi_bf_veg<?=$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemqty_oi_bf_veg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemqty_oi_bf_veg[]" id="itemqty_oi_bf_veg<?=$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="stock-radio">
                                                                        <input type="checkbox" name="instock_oi_bf_veg<?=$id?>" id="instock_oi_bf_veg<?=$id?>" value="1" <?=$instock?>>
                                                                        <label for="instock_oi_bf_veg<?=$id?>">In stock</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_oi_bf_veg" onclick="additem('oi_bf_veg')" style="<?php if($id!=$vegbflength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                    <a href="javascript:void(0)" class="rmbtn_oi_bf_veg" onclick="removeitem('oi_bf_veg<?=$id?>')" style="<?php if($id==$vegbflength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function() { 
                                                                        $("[data-provide='itemname_oi_bf_veg<?=$id?>']").each(function () {
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
                                                                                                term: itemname
                                                                                            },
                                                                                            type: "POST",
                                                                                            dataType: "json",
                                                                                        }).done(function (data) {
                                                                                            callback(data[0]);    
                                                                                        });
                                                                                    }
                                                                                }
                                                                            });
                                                                        });
                                                                    });
                                                                </script>
                                                            </tr>
                                                        <?php } ?>                                                
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </form>
                                        <div class="southIndiaFooterButton">
                                            <a href="javascript:void(0)" onclick="skiptonext('OI')">Skip to Next >></a>
                                            <button type="submit" onclick="savemenu('oi_bf_veg')">Save & Next</button>
                                        </div>
    
                                        <div class="vegAndNon_veg" id="nonveg_oi_section">
                                            <h1 style="visibility: hidden;">Hello</h1>
                                            <span><img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt="">Non-Veg</span>
                                        </div>
                                        <form action="#" id="oi_bf_nonveg_form" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="elementname" value="oi_bf_nonveg">
                                            <input type="hidden" id="cuisinetype" name="cuisinetype" value="2">
                                            <input type="hidden" id="menutype" name="menutype" value="0">
                                            <input type="hidden" id="itemtype" name="itemtype" value="1">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <?php if(!empty($oi_breakfast)){ 
                                                        $nonvegbflength = !empty($oi_breakfast['nonveg'])?count($oi_breakfast['nonveg']):1;
                                                        for($i=0; $i<$nonvegbflength;$i++){ 
                                                            $id = $i+1;
                                                            if(!empty($oi_breakfast['nonveg']) && isset($oi_breakfast['nonveg'][$i])){
                                                                $mastermenuid = $oi_breakfast['nonveg'][$i]['id'];
                                                                $imagesrc = MENU.$oi_breakfast['nonveg'][$i]['image'];
                                                                $itemname = $oi_breakfast['nonveg'][$i]['itemname'];
                                                                $itemprice = $oi_breakfast['nonveg'][$i]['itemprice'];
                                                                $itemdetail = $oi_breakfast['nonveg'][$i]['itemdetail'];
                                                                $instock = ($oi_breakfast['nonveg'][$i]['instock']==1)?"checked":"";
                                                            }else{
                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                            }
                                                            ?>
        
                                                            <tr class="oi_bf_nonveg" id="oi_bf_nonveg<?=$id?>">
                                                                <td>
                                                                    <input type="hidden" id="cnt_oi_bf_nonveg<?=$id?>" name="cnt_oi_bf_nonveg[]" value="<?=$id?>">
                                                                    <input type="hidden" id="id_oi_bf_nonveg<?=$id?>" name="id_oi_bf_nonveg[]" value="<?=$mastermenuid?>">
                                                                    <input type="hidden" id="preimg_oi_bf_nonveg<?=$id?>" name="preimg_oi_bf_nonveg[]" value="<?=(isset($oi_breakfast['nonveg'][$i]))?$oi_breakfast['nonveg'][$i]['image']:""?>">
                                                                    <div class="upload-btn-wrapper" id="el_image_oi_bf_nonveg<?=$id?>">
                                                                        <button class="btn">
                                                                            <img id="img_oi_bf_nonveg<?=$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                        </button>
                                                                        <input type="file" name="image_oi_bf_nonveg<?=$id?>" id="image_oi_bf_nonveg<?=$id?>" onchange="checkfile($(this),'oi_bf_nonveg')" accept=".jpg,.jpeg,.png,.gif" value=""/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemname_oi_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input" name="itemname_oi_bf_nonveg[]" id="itemname_oi_bf_nonveg<?=$id?>" value="<?=$itemname?>" data-provide="itemname_oi_bf_nonveg<?=$id?>" placeholder="Enter Item Name">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemprice_oi_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemprice_oi_bf_nonveg[]" id="itemprice_oi_bf_nonveg<?=$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group" id="el_itemqty_oi_bf_nonveg<?=$id?>" style="margin-bottom: 0;">
                                                                        <input type="text" class="menu-input s-input" name="itemqty_oi_bf_nonveg[]" id="itemqty_oi_bf_nonveg<?=$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="stock-radio">
                                                                        <input type="checkbox" name="instock_oi_bf_nonveg<?=$id?>" id="instock_oi_bf_nonveg<?=$id?>" value="1" <?=$instock?>>
                                                                        <label for="instock_oi_bf_nonveg<?=$id?>">In stock</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_oi_bf_nonveg" onclick="additem('oi_bf_nonveg')" style="<?php if($id!=$nonvegbflength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                    <a href="javascript:void(0)" class="rmbtn_oi_bf_nonveg" onclick="removeitem('oi_bf_nonveg<?=$id?>')" style="<?php if($id==$nonvegbflength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function() { 
                                                                        $("[data-provide='itemname_oi_bf_nonveg<?=$id?>']").each(function () {
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
                                                                                                term: itemname
                                                                                            },
                                                                                            type: "POST",
                                                                                            dataType: "json",
                                                                                        }).done(function (data) {
                                                                                            callback(data[0]);    
                                                                                        });
                                                                                    }
                                                                                }
                                                                            });
                                                                        });
                                                                    });
                                                                </script>
                                                            </tr>
                                                        <?php } ?>                                                
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </form>
                                        <div class="southIndiaFooterButton">
                                            <button type="submit" onclick="savemenu('oi_bf_nonveg')">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="OtherIndianLunch" role="tabpanel">
                                    <div class="meal-tab" id="SouthIndianLunchVeg" role="tabpanel" aria-labelledby="SouthIndianLunchVeg-tab">
                                        <div class="southIndiaBreakFastContent">
                                            <form action="#" id="oi_lunch_form" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="elementname" value="oi_lunch">
                                                <input type="hidden" id="cuisinetype" name="cuisinetype" value="2">
                                                <!-- <input type="hidden" id="menutype" name="menutype" value="1"> -->
                                                <input type="hidden" id="itemtype" name="itemtype" value="0">
                                                <div class="vegAndNon_veg">
                                                    <ul class="nav nav-tabs">
                                                        <?php foreach($this->MenuLunchCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link <?=($key==1?'active':'')?>" data-toggle="tab" href="#OILV-<?=$cat?>" role="tab"><?=$value?></a>
                                                                <input type="hidden" name="category_oi_lunch[]" id="category_oi_lunch<?=$key?>" value="<?=$value?>" class="category_oi_lunch">
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="food-type">
                                                        <span class="veg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg
                                                        </span>
                                                        <span class="nonveg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt=""> Non Veg
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="tab-content">
                                                    <?php foreach($this->MenuLunchCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                        <div class="tab-pane <?=($key==1?'active':'')?>" id="OILV-<?=$cat?>" role="tabpanel">
                                                            <div class="table-responsive">
                                                                <table class="table">                                                    
                                                                    <?php //if(!empty($si_lunch)){ 
                                                                        $lunchlength = !empty($oi_lunch[$value])?count($oi_lunch[$value]):1;
                                                                        for($i=0; $i<$lunchlength;$i++){ 
                                                                            $id = $i+1;
                                                                            if(!empty($oi_lunch[$value]) && isset($oi_lunch[$value][$i])){
                                                                                $mastermenuid = $oi_lunch[$value][$i]['id'];
                                                                                $imagesrc = MENU.$oi_lunch[$value][$i]['image'];
                                                                                $itemname = $oi_lunch[$value][$i]['itemname'];
                                                                                $itemprice = $oi_lunch[$value][$i]['itemprice'];
                                                                                $itemdetail = $oi_lunch[$value][$i]['itemdetail'];
                                                                                $instock = ($oi_lunch[$value][$i]['instock']==1)?"checked":"";
                                                                                $menu_type = $oi_lunch[$value][$i]['menutype'];
                                                                            }else{
                                                                                $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                                $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = $menu_type = "";
                                                                            }
                                                                            ?>
        
                                                                            <tr class="oi_lunch_<?=$cat?>" id="oi_lunch_<?=$cat.$id?>">
                                                                                <td>
                                                                                    <input type="hidden" id="cnt_oi_lunch_<?=$cat.$id?>" name="cnt_oi_lunch_<?=$cat?>[]" value="<?=$id?>">
                                                                                    <input type="hidden" id="id_oi_lunch_<?=$cat.$id?>" name="id_oi_lunch_<?=$cat?>[]" value="<?=$mastermenuid?>">
                                                                                    <input type="hidden" id="preimg_oi_lunch_<?=$cat.$id?>" name="preimg_oi_lunch_<?=$cat?>[]" value="<?=(isset($oi_lunch[$value][$i]))?$oi_lunch[$value][$i]['image']:""?>">
                                                                                    <div class="upload-btn-wrapper" id="el_image_oi_lunch_<?=$cat.$id?>">
                                                                                        <button class="btn">
                                                                                            <img id="img_oi_lunch_<?=$cat.$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                                        </button>
                                                                                        <input type="file" name="image_oi_lunch_<?=$cat.$id?>" id="image_oi_lunch_<?=$cat.$id?>" onchange="checkfile($(this),'oi_lunch_<?=$cat?>')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemname_oi_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input" name="itemname_oi_lunch_<?=$cat?>[]" id="itemname_oi_lunch_<?=$cat.$id?>" value="<?=$itemname?>" data-provide="itemname_oi_lunch_<?=$cat.$id?>" placeholder="Enter Item Name">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemprice_oi_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input s-input" name="itemprice_oi_lunch_<?=$cat?>[]" id="itemprice_oi_lunch_<?=$cat.$id?>" value="<?=$itemprice?>" placeholder="Price">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_itemqty_oi_lunch_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                        <input type="text" class="menu-input s-input" name="itemqty_oi_lunch_<?=$cat?>[]" id="itemqty_oi_lunch_<?=$cat.$id?>" value="<?=$itemdetail?>" placeholder="Quantity">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group" id="el_menutype_oi_lunch_<?= $cat . $id ?>" style="margin-bottom: 0;">
                                                                                        <select type="text" class="menu-input s-input" name="menutype_oi_lunch_<?= $cat ?>[]" id="menutype_oi_lunch_<?= $cat . $id ?>">
                                                                                            <option value="1" <?= ($menu_type == "" || $menu_type == "1" ? "selected" : "") ?>>Lunch</option>
                                                                                            <option value="2" <?= ($menu_type == "2" ? "selected" : "") ?>>Dinner</option>
                                                                                            <option value="3" <?= ($menu_type == "3" ? "selected" : "") ?>>Lunch & Dinner</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="stock-radio">
                                                                                        <input type="checkbox" name="instock_oi_lunch_<?=$cat.$id?>" id="instock_oi_lunch_<?=$cat.$id?>" value="1" <?=$instock?>>
                                                                                        <label for="instock_oi_lunch_<?=$cat.$id?>">In stock</label>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <a href="javascript:void(0)" class="add-menu-row addbtn_oi_lunch_<?=$cat?>" onclick="additem('oi_lunch_<?=$cat?>','lunch_dinner')" style="<?php if($id!=$lunchlength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                                    <a href="javascript:void(0)" class="rmbtn_oi_lunch_<?=$cat?>" onclick="removeitem('oi_lunch_<?=$cat.$id?>')" style="<?php if($id==$lunchlength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                                </td>
                                                                                <script>
                                                                                    $(document).ready(function() { 
                                                                                        $("[data-provide='itemname_oi_lunch_<?=$cat.$id?>']").each(function () {
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
                                                                                    });
                                                                                </script>
                                                                            </tr>
                                                                        <?php } ?>                                                
                                                                    <?php //} ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                            <div class="southIndiaFooterButton">
                                                <button type="submit" onclick="savelunchordinnermenu('oi_lunch')">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php /* 
                                <div class="tab-pane" id="OtherIndianDinner" role="tabpanel">
                                    <div class="meal-tab" id="SouthIndianDinnerVeg" role="tabpanel" aria-labelledby="SouthIndianDinnerVeg-tab">
                                        <div class="southIndiaBreakFastContent">
                                            <form action="#" id="oi_dinner_form" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="elementname" value="oi_dinner">
                                                <input type="hidden" id="cuisinetype" name="cuisinetype" value="2">
                                                <input type="hidden" id="menutype" name="menutype" value="2">
                                                <input type="hidden" id="itemtype" name="itemtype" value="0">
                                                <div class="vegAndNon_veg">
                                                    <ul class="nav nav-tabs">
                                                        <?php foreach($this->MenuDinnerCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link <?=($key==1?'active':'')?>" data-toggle="tab" href="#OIDV-<?=$cat?>" role="tab"><?=$value?></a>
                                                                <input type="hidden" name="category_oi_dinner[]" id="category_oi_dinner<?=$key?>" value="<?=$value?>" class="category_oi_dinner">
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="food-type">
                                                        <span class="veg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg
                                                        </span>
                                                        <span class="nonveg">
                                                            <img src="<?= KITCHEN_IMAGES_URL?>Non_chicken.svg" alt=""> Non Veg
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="tab-content">
                                                    <?php foreach($this->MenuDinnerCategory as $key=>$value){ 
                                                            $cat = str_replace(" ","_",strtolower($value)); ?>
                                                        <div class="tab-pane <?=($key==1?'active':'')?>" id="OIDV-<?=$cat?>" role="tabpanel">
                                                            <table class="table">                                                    
                                                                <?php //if(!empty($si_lunch)){ 
                                                                    $dinnerlength = !empty($oi_dinner[$value])?count($oi_dinner[$value]):1;
                                                                    for($i=0; $i<$dinnerlength;$i++){ 
                                                                        $id = $i+1;
                                                                        if(!empty($oi_dinner[$value]) && isset($oi_dinner[$value][$i])){
                                                                            $mastermenuid = $oi_dinner[$value][$i]['id'];
                                                                            $imagesrc = MENU.$oi_dinner[$value][$i]['image'];
                                                                            $itemname = $oi_dinner[$value][$i]['itemname'];
                                                                            $itemprice = $oi_dinner[$value][$i]['itemprice'];
                                                                            $itemdetail = $oi_dinner[$value][$i]['itemdetail'];
                                                                            $instock = ($oi_dinner[$value][$i]['instock']==1)?"checked":"";
                                                                        }else{
                                                                            $imagesrc = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                                                            $mastermenuid = $itemname = $itemprice = $itemdetail = $instock = "";
                                                                        }
                                                                        ?>
    
                                                                        <tr class="oi_dinner_<?=$cat?>" id="oi_dinner_<?=$cat.$id?>">
                                                                            <td>
                                                                                <input type="hidden" id="cnt_oi_dinner_<?=$cat.$id?>" name="cnt_oi_dinner_<?=$cat?>[]" value="<?=$id?>">
                                                                                <input type="hidden" id="id_oi_dinner_<?=$cat.$id?>" name="id_oi_dinner_<?=$cat?>[]" value="<?=$mastermenuid?>">
                                                                                <input type="hidden" id="preimg_oi_dinner_<?=$cat.$id?>" name="preimg_oi_dinner_<?=$cat?>[]" value="<?=(isset($oi_dinner[$value][$i]))?$oi_dinner[$value][$i]['image']:""?>">
                                                                                <div class="upload-btn-wrapper" id="el_image_oi_dinner_<?=$cat.$id?>">
                                                                                    <button class="btn">
                                                                                        <img id="img_oi_dinner_<?=$cat.$id?>" src="<?=$imagesrc?>" class="uploaded-img">
                                                                                    </button>
                                                                                    <input type="file" name="image_oi_dinner_<?=$cat.$id?>" id="image_oi_dinner_<?=$cat.$id?>" onchange="checkfile($(this),'oi_dinner_<?=$cat?>')" accept=".jpg,.jpeg,.png,.gif"/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemname_oi_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input" name="itemname_oi_dinner_<?=$cat?>[]" id="itemname_oi_dinner_<?=$cat.$id?>" value="<?=$itemname?>" data-provide="itemname_oi_dinner_<?=$cat.$id?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemprice_oi_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input s-input" name="itemprice_oi_dinner_<?=$cat?>[]" id="itemprice_oi_dinner_<?=$cat.$id?>" value="<?=$itemprice?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group" id="el_itemqty_oi_dinner_<?=$cat.$id?>" style="margin-bottom: 0;">
                                                                                    <input type="text" class="menu-input s-input" name="itemqty_oi_dinner_<?=$cat?>[]" id="itemqty_oi_dinner_<?=$cat.$id?>" value="<?=$itemdetail?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="stock-radio">
                                                                                    <input type="checkbox" name="instock_oi_dinner_<?=$cat.$id?>" id="instock_oi_dinner_<?=$cat.$id?>" value="1" <?=$instock?>>
                                                                                    <label for="instock_oi_dinner_<?=$cat.$id?>">In stock</label>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a href="javascript:void(0)" class="add-menu-row addbtn_oi_dinner_<?=$cat?>" onclick="additem('oi_dinner_<?=$cat?>')" style="<?php if($id!=$dinnerlength){ echo 'display:none;'; } ?>""><img src="<?= KITCHEN_IMAGES_URL?>menu-plus.svg" alt=""></a>
                                                                                <a href="javascript:void(0)" class="rmbtn_oi_dinner_<?=$cat?>" onclick="removeitem('oi_dinner_<?=$cat.$id?>')" style="<?php if($id==$dinnerlength){ echo 'display:none;'; } ?>"><img src="<?= KITCHEN_IMAGES_URL?>trash.svg" alt=""></a>
                                                                            </td>
                                                                            <script>
                                                                                $(document).ready(function() { 
                                                                                    $("[data-provide='itemname_oi_dinner_<?=$cat.$id?>']").each(function () {
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
                                                                                });
                                                                            </script>
                                                                        </tr>
                                                                    <?php } ?>                                                
                                                                <?php //} ?>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="southIndiaFooterButton">
                                                    <button type="submit" onclick="savelunchordinnermenu('oi_dinner')">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> */ ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-8 -->
            </div>
        </div>
    
    </div>
    <script>
        function checkfile(obj,element){
            var val = obj.val();
            var id = obj.attr("id").match(/\d+/);
            var filename = obj.val().replace(/C:\\fakepath\\/i, '');
            
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpeg': case 'png':
                        
                    if (obj[0].files && obj[0].files[0]) {
                        var reader = new FileReader();
                        
                        reader.onload = function(e) {
                            $('#img_'+element+id).attr('src', e.target.result);
                        }
                        reader.readAsDataURL(obj[0].files[0]);
                    }
                break;
                default:
                $("#image_"+element+id).val("");
                $('#img_'+element+id).attr('src', KITCHEN_IMAGES_URL+"upload-icon.svg");
                notifyme.create({title:"Image",text:"Accept only image file !",type:"alert"});
                break;
            }
        }
    </script>
<?php }else{ ?>
    <div class="noMenuAddedSection">
        <h2>Master Menu</h2>
        <div class="noMenuTabSection">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="AllMenu" role="tabpanel">
                    <div class="noMenuBodySection">
                        <img src="<?= KITCHEN_IMAGES_URL?>cusine.svg" alt="">
                        <h2>No menu added yet</h2>
                        <p>Look's like you, haven't made your menu yet.</p>
                        <a href="<?=KITCHEN_URL?>menu/add-menu">Add Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>