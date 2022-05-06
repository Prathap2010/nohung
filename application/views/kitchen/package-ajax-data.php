<?php if(!empty($packagesdata)){ ?>
    <?php foreach($packagesdata as $package){ ?>
        <div class="package-card" id="package<?=$package['id']?>">
            <div class="package-card-header">
                <h3>
                    <?php if($package['mealtype']==0){ ?>
                        <img src="<?= KITCHEN_IMAGES_URL?>vegan.svg">
                    <?php }else{ ?>
                        <img src="<?= KITCHEN_IMAGES_URL?>chicken-leg.svg">
                    <?php } 
                    echo $package['packagename'];
                    ?>
                </h3>
                <div class="package-edit">
                    <input type="hidden" id="packagename<?=$package['id']?>" value="<?=$package['packagename']?>">
                    <input type="hidden" id="cuisinetype<?=$package['id']?>" value="<?=$package['cuisinetype']?>">
                    <input type="hidden" id="mealtype<?=$package['id']?>" value="<?=$package['mealtype']?>">
                    <input type="hidden" id="mealfor<?=$package['id']?>" value="<?=$package['mealfor']?>">
                    <input type="hidden" id="weeklyplantype<?=$package['id']?>" value="<?=$package['weeklyplantype']?>">
                    <input type="hidden" id="monthlyplantype<?=$package['id']?>" value="<?=$package['monthlyplantype']?>">
                    <input type="hidden" id="startdate<?=$package['id']?>" value="<?=$this->general_model->displaydate($package['startdate'])?>">
                    <input type="hidden" id="including_saturday<?=$package['id']?>" value="<?=$package['including_saturday']?>">
                    <input type="hidden" id="including_sunday<?=$package['id']?>" value="<?=$package['including_sunday']?>">

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#packageModal" onclick="openpopup(<?=$package['id']?>)"><img src="<?= KITCHEN_IMAGES_URL?>edit.svg"></a>
                    <a href="javascript:void(0)" onclick="deletepackage(<?=$package['id']?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.874" height="22" viewBox="0 0 17.874 22"><defs><style>.a{fill:#CE543D;}</style></defs><path class="a" d="M49.716,2.75H53.5V2.063A2.065,2.065,0,0,1,55.563,0h2.75a2.065,2.065,0,0,1,2.063,2.063v.688h3.782a1.716,1.716,0,0,1,1.716,1.716V6.875a.688.688,0,0,1-.688.688H64.81l-.594,12.473A2.061,2.061,0,0,1,62.155,22H51.717a2.061,2.061,0,0,1-2.061-1.964L49.063,7.563h-.376A.688.688,0,0,1,48,6.875V4.468A1.716,1.716,0,0,1,49.716,2.75ZM59,2.062a.688.688,0,0,0-.688-.688H55.563a.688.688,0,0,0-.688.688V2.75H59Zm5.5,2.406a.345.345,0,0,0-.343-.343H49.716a.345.345,0,0,0-.343.343V6.184H64.5Zm-13.465,15.5a.686.686,0,0,0,.686.66h10.44a.686.686,0,0,0,.686-.66l.591-12.408h-13Z" transform="translate(-48)"/><path class="a" d="M240.688,218.314a.688.688,0,0,1-.688-.688v-8.938a.688.688,0,1,1,1.376,0v8.938A.688.688,0,0,1,240.688,218.314Z" transform="translate(-231.75 -199.062)"/><path class="a" d="M320.688,218.314a.688.688,0,0,1-.688-.688v-8.938a.688.688,0,1,1,1.375,0v8.938A.688.688,0,0,1,320.688,218.314Z" transform="translate(-315.187 -199.062)"/><path class="a" d="M160.688,218.314a.688.688,0,0,1-.688-.688v-8.938a.688.688,0,1,1,1.376,0v8.938A.688.688,0,0,1,160.688,218.314Z" transform="translate(-148.312 -199.062)"/></svg>
                    </a>
                </div>
            </div>
            <div class="package-subrow">
                <div class="package-start-date"><?=date('M d, Y', strtotime($package['startdate']))?></div>
                <div class="package-weekend">
                <?php if($package['including_saturday']==1){
                    echo ($package['including_sunday']==1)?"Sat, ":"Sat";
                }
                if($package['including_sunday']==1){
                    echo "Sun";
                } ?></div>
            </div>
            <div class="package-body-row">
                <div class="meal-type">
                    
                    <?php 
                    if($package['mealfor']==0){
                        echo '<img src="'. KITCHEN_IMAGES_URL.'Breakfast_icons.svg"> Breakfast';
                    }else if($package['mealfor']==1){
                        echo '<img src="'. KITCHEN_IMAGES_URL. 'indian-food.svg"> Lunch';
                    }else if($package['mealfor']==2){
                        echo '<img src="'. KITCHEN_IMAGES_URL.'indian-food.svg"> Dinner';
                    }
                    ?>
                    <a href="javascript:void(0)"><img src="<?= KITCHEN_IMAGES_URL?>right-arrow.svg"></a>
                </div>
                <div class="cuising-type">
                <?php 
                    if($package['cuisinetype']==0){
                        echo 'South Indian';
                    }else if($package['cuisinetype']==1){
                        echo 'North Indian';
                    }else if($package['cuisinetype']==2){
                        echo 'Other Cuisine';
                    }
                ?>
                </div>
            </div>
            <div class="package-footer-row">
                <div class="weekly-package">
                    <?php if($package['weeklyplantype']==1){ ?>
                        ₹<?=number_format($package['weeklyprice'],2,'.',',')?> <span>Weekly Package</span>    
                    <?php } ?>
                </div>
                <div class="monthly-package">
                    <?php if($package['monthlyplantype']==1){ ?>
                        ₹<?=number_format($package['monthlyprice'],2,'.',',')?> <span>Monthly Package</span>    
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php 
}else{ ?>
    <div class="single-item item">
        <div class="info" style="border-radius: 8px !important;font-size: 15px;">
        <?php echo "Package not available."; ?>
        </div>
    </div>
<?php } ?>