<?php if(!empty($addresses)){ 
    foreach($addresses as $i=>$address){ ?>
        <div class="myaccount-addresslist-content">
            <div class="left-part">
                <div class="symbol-container">
                    <img src="<?=FRONT_IMAGES_URL?>Component1319.png" alt="" class="img-fluid">
                </div>
                <div class="address">
                    <p class="address-title">Address <?=++$offset?> :</p>
                    <input type="hidden" id="txt_lat_<?=$address['id']?>" value="<?=$address['latitude']?>">
                    <input type="hidden" id="txt_long_<?=$address['id']?>" value="<?=$address['longitude']?>">
                    <input type="hidden" id="txt_is_delivery_<?=$address['id']?>" value="<?=$address['is_delivery']?>">
                    <p class="address-desc" id="txt_address_<?=$address['id']?>"><?php echo $address['address']; ?></p>
                    <p style="color:#4bb64b;" id="default_address_id_<?=$address['id']?>" class="address-desc default_address_cls"><?=($address['is_delivery']=='y' ? '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>&nbsp;Default Address' : "")?></p>
                </div> 
            </div>
            <div class="right-part">
                <a href="javascript:void(0)" onclick="edit_address('<?=$address['id']?>')" data-toggle="modal" data-target="#addaddress" title="Edit Address"><img src="<?=FRONT_IMAGES_URL?>pencil.png" alt="" class="img-fluid"></a>
            </div>
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="myaccount-addresslist-content">
        <p class="trxt-center">No any address available.</p>
    </div>
<?php } ?>