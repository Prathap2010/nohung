<style>
    .set-menu-content .menu-items .menu-sec {
        display: contents;
    }
</style>
<div class="offerManagementWrap">
    <div class="offermanageTopHeading">
        <h2><?=$packagedata['packagename']?></h2>
        <!-- <a href=""> <img src="assets/images/OfferManagement_icons.svg" alt=""> Add Offer</a> -->
    </div>
    <form action="#" id="packageform" class="form-horizontal">
        <input type="hidden" name="packageid" id="packageid" value="<?=$packagedata['id']?>">
        <input type="hidden" name="startday" id="startday" value="<?=date("d",strtotime($packagedata['startdate']))?>">
        <input type="hidden" name="startdate" id="startdate" value="<?=$packagedata['startdate']?>">
        <div class="row">
            <div class="col-lg-8">
                <div class="packageLunchSection">
                    <div class="lunchHeadingSection">
                        <h2><?php if($packagedata['mealfor']==0){ echo "Breakfast"; }else if($packagedata['mealfor']==1){ echo "Lunch"; }else if($packagedata['mealfor']==2){ echo "Dinner"; } ?></h2>
                        <div class="foodNameSeciton">
                            <?php if($packagedata['mealtype']==0){ ?>
                                <p><img src="<?=KITCHEN_IMAGES_URL?>vegan.svg" alt="">Veg</p>
                            <?php }else if($packagedata['mealtype']==1){ ?>
                                <p><img src="<?= KITCHEN_IMAGES_URL?>chicken-leg.svg" alt="">Non-veg</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="foodsTableSection">
                        <table class="table">
                        <?php $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
                        for($i=1; $i<=7; $i++) {
                            if (in_array($i, array(1,2,3,4,5)) || ($packagedata['including_saturday'] == 1 && $i == 6) || ($packagedata['including_sunday'] == 1 && $i == 7)) {
                                
                                $weeklypackageid = $image = $menuid = $price = $defailtdishitem = $menuitem = "";
                                $img_src = KITCHEN_IMAGES_URL.'upload-icon.svg';
                                if(!empty($weeklypackagedata)){
                                    $key = array_search($i, array_column($weeklypackagedata, "days"));
                                    if(trim($key)!="" && isset($weeklypackagedata[$key])){
                                        $weeklypackageid = $weeklypackagedata[$key]['id'];
                                        $image = $weeklypackagedata[$key]['image'];
                                        if(!empty($image)){
                                            $img_src = MENU.$image;
                                        }
                                        $menuid = str_replace('"','&quot;',json_encode($weeklypackagedata[$key]['menuitemdetail']));
                                        $price = $weeklypackagedata[$key]['price'];
                                        
                                        $menuitem = implode(", ", array_column($weeklypackagedata[$key]['menuitemdetail'], "item_name"));
                                        $defailtdishitem = $weeklypackagedata[$key]['defailtdishitem'];
                                    }
                                } ?>
                                <tr>
                                    <td width="15%">
                                        <div class="foodsDayName">
                                            <p><?=$days[$i]?></p>
                                            <input type="hidden" id="weeklypackageid<?=$i?>" name="weeklypackageid[]" value="<?=$weeklypackageid?>">
                                            <input type="hidden" id="cnt<?=$i?>" name="cnt[]" value="<?=$i?>">
                                            <input type="hidden" id="preimg<?=$i?>" name="preimg[]" value="<?=$image?>">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn">
                                                    <img id="img<?=$i?>" src="<?=$img_src?>" class="uploaded-img">
                                                </button>
                                                <input type="file" name="image<?=$i?>" id="image<?=$i?>"  onchange="checkfile($(this))" accept=".jpg,.jpeg,.png,.gif"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="46%">
                                        <p id="textmenuid<?=$i?>"><?=$menuitem?></p>
                                        <input type="hidden" id="menuid<?=$i?>" name="menuid[]" value="<?=$menuid?>">
                                        <input type="hidden" id="defailtdishitem<?=$i?>" name="defailtdishitem[]" value="<?=$defailtdishitem?>">
                                    </td>
                                    <td width="15%">
                                        <p class="text-center" id="texttotalprice<?=$i?>"><?=($price>0?"₹".$price:"")?></p>
                                        <input type="hidden" class="totalprice" id="totalprice<?=$i?>" name="totalprice[]" value="<?=$price?>">
                                    </td>
                                    <td>
                                        <a id="button" class="myButton1" onclick="openrightbar(<?=$i?>)"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><defs><style>.a{fill:#fff;}</style></defs><path class="a" d="M6,0,4.909,1.091l4.13,4.13H0V6.779H9.039l-4.13,4.13L6,12l6-6Z"/></svg></a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                        </table>
                    </div>
                    <div class="foodsFooterImg">
                        <img src="<?= KITCHEN_IMAGES_URL?>LunchFooter.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="LunchTypeSection">
                    <div class="typeLunchContent">
                        <p><img src="<?= KITCHEN_IMAGES_URL?>LunchType.svg" style="height: 22px;" alt=""> <?php if($packagedata['mealfor']==0){ echo "Breakfast"; }else if($packagedata['mealfor']==1){ echo "Lunch"; }else if($packagedata['mealfor']==2){ echo "Dinner"; } ?></p>
                        <p><img src="<?= KITCHEN_IMAGES_URL?>SouthIndian.svg" alt=""> <?php if($packagedata['cuisinetype']==0){ echo "South Indian"; }else if($packagedata['cuisinetype']==1){ echo "North Indian"; }else if($packagedata['cuisinetype']==2){ echo "Other Cuisine"; }?></p>
                    </div>
                    <div class="LunchDateSection">
                        <p><img src="<?= KITCHEN_IMAGES_URL?>calendar_icons.svg" alt=""> <?=date("d-m-y", strtotime($packagedata['startdate']))?></p>
                        <p>
                            <?php if($packagedata['weeklyplantype']==1){
                                echo ($packagedata['monthlyplantype']==1)?"Weekly , ":"Weekly";
                            }
                            if($packagedata['monthlyplantype']==1){
                                echo "Monthly";
                            } ?>
                        </p>
                    </div>
                </div>

                <div class="CreatePackageSection">
                    <ul>
                        <li>
                            <div class="weeklyPackage">
                                <input type="hidden" name="inputweeklyactualprice" id="inputweeklyactualprice" value="4425">
                                <p id="weeklyactualprice">₹0</p>
                                <span>Actual Total price<br />
                                    <b>Weekly Package</b></span>
                            </div>
                            <div class="weeklyPackage text-right">
                                <input type="hidden" name="inputmonthlyactualprice" id="inputmonthlyactualprice" value="6425">
                                <p id="monthlyactualprice">₹0</p>
                                <span>Actual Total price<br />
                                    <b>Monthly Package</b></span>
                            </div>
                        </li>
                        <li>
                            <div class="weeklyPricingSection" id="wpelement">
                                <h3>Set Your Price (Weekly)</h3>
                                <input type="text" class="form-control" name="weeklyprice" id="weeklyprice" value="<?=($packagedata['weeklyprice']>0)?$packagedata['weeklyprice']:""?>" placeholder="">
                            </div>
                            <div class="weeklyVariationSection">
                                <span>Variation</span>
                                <h3 class="text-right" id="weeklypricevariayion">0%</h3>
                            </div>
                        </li>
                        <li>
                            <div class="weeklyPricingSection" id="mpelement">
                                <h3>Set Your Price (Monthly)</h3>
                                <input type="text" class="form-control" name="monthlyprice" id="monthlyprice" value="<?=($packagedata['monthlyprice']>0)?$packagedata['monthlyprice']:""?>" placeholder="">
                            </div>
                            <div class="weeklyVariationSection">
                                <span>Variation</span>
                                <h3 class="text-right" id="monthlypricevariayion">0%</h3>
                            </div>
                        </li>
                        <li style="margin-bottom: -20px;">
                            <img src="<?= KITCHEN_IMAGES_URL?>shopGetway.svg" alt="">
                            <a href="javascript:void(0)" onclick="createpackage()">Create Package</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="myDiv1" class="myDiv1">
    <div class="set-menu-content">
        <h3>
            Select Menu
            <button type="button" class="close" id="hide">
                <img src="<?= KITCHEN_IMAGES_URL?>modal-close.svg">
            </button>
        </h3>
        <div class="set-menu-body">
            <div class="menu-items">
                <div id="menu1error" class="col-md-12" style="color:red;margin-bottom:15px;padding:0;"></div>
                <input type="hidden" value="" id="selecteddays">
                <?php if(!empty($menudata)){ 
                foreach($menudata as $menu) { 
                    $menu['category'] = ($packagedata['mealfor']==0)?($packagedata['mealtype']==0?"Veg":"Non Veg"):$menu['category'];
                    $cat = str_replace(" ","_",strtolower($menu['category'])); ?>
                    <div class="menu-sec category_item col-md-12" id="<?=$cat?>">
                        <h4 style="margin-top: 20px;"><?=$menu['category']?></h4>
                        <?php if(!empty($menu['menuitems'])){ 
                            foreach($menu['menuitems'] as $menuitems) { ?>
                                <div class="col-md-12" style="padding: 0;">
                                    <div class="col-md-12" style="padding: 0;    float: left;">
                                        <div class="col-md-8" style="padding: 0;float: left;">
                                            <input class="styled-checkbox chkitem" id="chk<?=$menuitems['id']?>" type="checkbox" value="1" data-itemname="<?=$menuitems['itemname']?>" data-itemprice="<?=$menuitems['itemprice']?>" data-cat="<?=$cat?>" data-catcap="<?=$menu['category']?>">
                                            <label for="chk<?=$menuitems['id']?>"><?=$menuitems['itemname']?></label>
                                            <input id="meniitemdetailid<?=$menuitems['id']?>" type="hidden" value="">
                                        </div>
                                    <?php //if($cat=="bread"){ ?>
                                        <div class="col-md-4" style="padding: 0;float: left; margin-bottom: 5px;">
                                            <input id="qty<?=$menuitems['id']?>" class="qty" type="text" style="width:50px;font-size:15px;" value="1">
                                        </div>
                                        <?php //} ?>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                <?php }
                }else{
                    echo '<div class="col-md-12" style="color:red;margin-bottom:15px;padding:0;font-size: 16px;">You need to add items in master menu !</div>';
                } ?>
            </div>
            <div class="menu-footer">
                <?php if(!empty($menudata)){ ?>
                <button type="button" class="next" onclick="setdefaultitem()">
                    Set Default<img src="<?= KITCHEN_IMAGES_URL?>right-arrow (7).svg">
                </button>
                <?php } ?>
            </div>
        </div>
        <div class="set-menu-body-2" style="display:none;">
            <div class="set-default-body">
                <div class="set-default-text">
                    <h5>
                        Selected Items
                        <span>Select any of the below to make it as a default dish for the day.</span>
                    </h5>
                </div>
                <div id="defaultitemdata"></div>
                <!-- <div class="set-default-menu">
                    <div class="default-title">Non Veg</div>
                    <div class="default-menu-items">
                        <input type="radio" id="r1" name="radio-group2" class="selecteditem" checked>
                        <label for="r1">Mutton Handi</label>

                        <input type="radio" id="r2" name="radio-group2" class="selecteditem">
                        <label for="r2">Chicken Masala</label>

                        <input type="radio" id="r3" name="radio-group2" class="selecteditem">
                        <label for="r3">Chicken Tikka</label>
                    </div>
                </div>
                <div class="set-default-menu">
                    <div class="default-title">Dal</div>
                    <div class="default-menu-items">
                        <input type="radio" id="r4" name="radio-group3" class="selecteditem" checked>
                        <label for="r4">Dal Fry</label>

                        <input type="radio" id="r5" name="radio-group3" class="selecteditem">
                        <label for="r5">Dal Tadka</label>

                        <input type="radio" id="r6" name="radio-group3" class="selecteditem">
                        <label for="r6">Dal Makhani</label>
                    </div>
                </div> -->
            </div>
            <div class="default-menu-footer">
                <a class="back">Back</a>
                <button type="button" class="next" onclick="addmeal()">
                    <img src="<?= KITCHEN_IMAGES_URL?>plus.png"> Add Meal
                </button>
            </div>
            </div>
    </div>
</div>

<script>
    function checkfile(obj){
        var val = obj.val();
        var id = obj.attr("id").match(/\d+/);
        var filename = obj.val().replace(/C:\\fakepath\\/i, '');
        
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'gif': case 'jpg': case 'jpeg': case 'png':
                    
            if (obj[0].files && obj[0].files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#img'+id).attr('src', e.target.result);
                }
                reader.readAsDataURL(obj[0].files[0]);
            }
            break;
            default:
            $("#image"+id).val("");
            $('#img'+id).attr('src', KITCHEN_IMAGES_URL+"upload-icon.svg");
            notifyme.create({title:"Image",text:"Accept only image file !",type:"alert"});
            break;
        }
    }
</script>