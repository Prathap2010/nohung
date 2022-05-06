<?php if(count($trialmealdata) > 0){ ?>
    <?php foreach($trialmealdata as $row){
        $cart_count ='';
        if(!empty($cart_items_array)){ 
            foreach($cart_items_array as $_cart){
                if($_cart['typeid'] == $row['id'])
                {
                    $cart_count = $_cart['quantity'];
                }
            }
        }
        ?>
        <div class="breakfast-menu-item">
            <div class="left-part">
                <div class="img-container floatleft">
                    <?php 
                        if($row['image']!='' && file_exists(MENU_PATH.$row['image'])){
                            $img_src = MENU.$row['image'];  
                        }else{
                            $img_src = NOIMAGE;
                        }
                    ?>
                    <img src="<?=$img_src?>" alt="" class="img-fluid" style="width:120px;height:120px;margin-bottom:30px;margin-left:25px;">
                </div>
                <div class="breakfast-name floatright">
                    <p class="heading"><?=$row['itemname']?>
                        <input type="hidden" id="tm_itemname<?=$row['id']?>" value="<?=$row['itemname']?>">
                        <input type="hidden" id="tm_itemprice<?=$row['id']?>" value="<?=number_format($row['itemprice'],2,'.',',')?>">
                    </p>
                    <p class="breakfast-type"><?php 
                        if($row['cuisinetype']==0){
                            echo "South Indian";
                        }else if($row['cuisinetype']==1){
                            echo "North Indian";
                        }else if($row['cuisinetype']==2){
                            echo "Other Indian";
                        }
                    ?></p>
                    <p class="price">₹<?=number_format($row['itemprice'],2,'.',',')?></p>
                    <!-- <div class="rating"> 
                        <ul id='stars'>
                        <li class='star' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        </ul>
                    </div> -->
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="right-part">
                <?php /* if(empty($this->session->userdata(base_url().'FOODIESUSERID'))) {
                    $disabled = "disabled";
                    $reditect_to_login = "window.location.href='".FRONT_URL."login'";
                }else{ */
                    $disabled = "";
                    $reditect_to_login = ''; ?>
                <?php /*} */ ?>    

               <div class="btn-container init-add-meal" id="btn-container<?=$row['id']?>" onclick="<?=$reditect_to_login?>" style="<?=$cart_count!='' ?'background-color:#FCC647':'';?>">
                    <button class="remove-meal" id="removemeal<?=$row['id']?>" style="<?=$cart_count=='' ?'display:none':'';?>" <?=$disabled?>>-</button>
                     <input style="<?=$cart_count!='' ?'font-weight:bold':'';?>" type="button" value="<?=$cart_count=='' ?'Add':$cart_count; ?>" class="mealcount" id="mealcount<?=$row['id']?>" onkeypress="return isNumeric(event)" <?=$disabled?>>
                     <button class="add-meal" id="addmeal<?=$row['id']?>" <?=$disabled?>> +</button>
                </div>
            </div>
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="listOfFoodSection" style="border-radius: 8px !important;font-size: 15px;padding: 0px;text-align:center;">
            <?php echo "No any item available." ?>
        </div>
    </div>
<?php } ?>