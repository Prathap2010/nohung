<?php if(count($packagedata) > 0){ ?>
    <?php foreach($packagedata as $row){?>
        <div class="breakfast-monthly-content">
            <div class="left-part">
                <div class="headings">
                    <?php if($row['mealtype']==1){
                        $img = "NonVegFood_icon.png";
                    }else{
                        $img = "vegan.png";
                    }?>
                    <img src="<?= FRONT_IMAGES_URL.$img?>">
                    <p class="heading"><?=$row['packagename']?></p>
                </div>
                <p class="sub-heading"><?php 
                    if($row['cuisinetype']==0){
                        echo "South Indian";
                    }else if($row['cuisinetype']==1){
                        echo "North Indian";
                    }else if($row['cuisinetype']==2){
                        echo "Other Indian";
                    }
                ?></p>
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
            <div class="right-part">
                <p class="price">₹<?=($plantype=='weekly')?number_format($row['weeklyprice'],2,'.',','):number_format($row['monthlyprice'],2,'.',',')?></p> 
                <p class="weekend-include">
                    <?php if($row['including_saturday']==1 || $row['including_sunday']==1){ ?>
                    <span class="cementgray">Including</span> 
                    <?php } if($row['including_saturday']==1){
                        echo ($row['including_sunday']==1)?"Saturday, ":"Saturday";
                    }
                    if($row['including_sunday']==1){
                        echo "Sunday";
                    } ?></p>
                <p><a href="javascript:void(0)" name="view_details" class="view-details" data-toggle="modal" data-target="#packageModal" onclick="get_package_detail(<?=$row['id']?>,'<?=$plantype?>')">Proceed</a></p>
            </div>    
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="listOfFoodSection" style="border-radius: 8px !important;font-size: 15px;padding: 20px;">
            <?php echo "No any package available." ?>
        </div>
    </div>
<?php } ?>