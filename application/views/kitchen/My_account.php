<link rel="stylesheet" href="<?php echo KITCHEN_CSS_URL; ?>all.min.css" >
<style>
    .table td, .table th {
        padding: 15px;
    }
    .table td {
        border-top: 1px solid #dee2e6 !important;
        border-bottom: 0 !important;
    }
    .nk-account-detail-card {
        position: relative;
        width: 100%;
        border-radius: 5px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        background-color: #FFFFFF;
    }
    .nk-account-header-img img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px 5px 0 0;
    }
    .nk-account-header-logo img {
        width: 100px;
        height: 100px;
        margin-left: 20px;
        display: block;
        margin-top: -60px;
        object-fit: contain;
        object-position: center;
    }
    .nk-account-card-body {
        padding: 20px;
    }
    .nk-kitchen-title {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .nk-kitchen-description {
        color: #7EDABF;
    }
    .nk-rating-list {
        padding: 0;
        list-style: none;
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }
    .nk-rating-item {
        color: #D8D8D8;
        margin-left: 5px;
    }
    .nk-rating-item.active {
        color: #FDD303;
    }
    .nk-kitchen-details {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .nk-open-time {
        margin-bottom: 20px;
    }
    .nk-open-time span {
        color: #7EDABF;
    }
    .nk-kitchen-about {
        padding: 20px;
        border-radius: 10px;
        background-color: #F3F6FA;
        margin-bottom: 20px;
    }
    .nk-kitchen-info {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .nk-kitchen-info-card {
        background-color: #F3F6FA;
        padding: 15px 10px;
        width: calc(33.33% - 10px);
        text-align: center;
        border-radius: 10px;
        height: 100%;
    }
    .nk-kitchen-info-card:nth-child(2) {
        margin: 0 15px;
    }
    .nk-kitchen-info-img {
        height: 45px;
        margin-bottom: 20px;
    }
    .nk-kitchen-info-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }
    .nk-kitchen-info-title {
        text-transform: uppercase;
        font-size: 16px;
        font-weight: bold;
    }
    .nk-meals-type {
        background-color: #F3F6FA;
        padding: 20px;
        border-radius: 10px;
    }
    .nk-meals-type-title {
        color: #424755;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .nk-meals-type-list {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
    }
    .nk-meals-type-item {
        flex: 1;
        max-width: 20%;
        text-align: center;
    }
    .nk-meals-type-item img {
        display: block;
        width: 32px;
        height: 32px;
        margin: 0 auto 15px;
        object-fit: contain;
    }
    .nk-meals-type-item label {
        margin-bottom: 0;
        font-weight: bold;
        color: #2F3443;
    }
    .nk-all-kitchen-details {
        position: relative;
        width: 100%;
        border-radius: 5px;
        box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%);
        background-color: #FFFFFF;
        height: 100%;
        padding: 20px;
    }
    .nk-all-kitchen-detail-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 30px;
    }
    .nk-all-kitchen-detail__inner:not(:last-child) {
        margin-bottom: 30px;
    }
    .nk-all-kitchen-subtitle {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .custom-control {
        padding-left: 24px;
    }
    .custom-control-label::after,
    .custom-control-label::before {
        width: 16px;
        height: 16px;
    }
    .custom-control-label::before {
        background-color: transparent;
        border: 2px solid #98E1CC;
    }
    .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: transparent;
    }
    .custom-radio .custom-control-input:checked~.custom-control-label::after {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%2398E1CC'/%3E%3C/svg%3E");
    }
    .custom-checkbox .custom-control-label::before {
        border-radius: 5px;
    }
    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #98E1CC;
    }
    .nk-all-kitchen-detail-content .form-group label {
        color: #FFA451;
    }
    .nk-all-kitchen-detail-content select.form-control {
        height: auto !important;
        font-size: 16px;
        border-top: none;
        border-left: none;
        border-right: none;
    }
    .nk-all-kitchen-detail-content .custom-control {
        margin-bottom: 10px;
    }
    .btn-custom {
        background-color: #ffa451 !important;
        color: #fff;
    }
    .nk-all-kitchen-detail-btn {
        margin-top: 100px;
    }
    .nk-all-kitchen-detail-btn .btn {
        padding: 10px 30px;
        min-width: 50%;
        line-height: 1;
        font-size: 16px;
        font-weight: bold;
        margin: auto;
        display: block;
        border-radius: 6px;
    }
    .nk-account-setting-modal .modal-dialog {
        max-width: 30%;
    }
    .nk-account-setting-modal .modal-dialog .modal-content .modal-body {
        padding: 15px;
    }
    .nk-account-setting-modal .btn {
        min-width: 50%;
        line-height: 1;
        font-weight: bold;
        margin: auto;
        border-radius: 6px !important;
    }
    .nk-account-setting-modal .modal-header {
        border-bottom: 0;
    }
    .nk-account-title-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        justify-content: space-between;
    }
    .nk-account-title-header .nk-kitchen-title {
        margin-bottom: 0;
        margin-right: 10px;
    }
    .txtinput {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        background-color: #f1f1f1;
        padding: 10px 10px;
        border-radius: 5px;
        height: 45px;
        border: 0;
        transition: all 0.3s ease-in-out;
    }
    .custom-modal .modal-dialog .modal-content .modal-body .form-group textarea{
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        background-color: #f1f1f1;
        padding: 10px 20px;
        border-radius: 5px;
        height: 50px;
        border: 0;
        transition: all 0.3s ease-in-out;
    }    
</style>
<div class="offerManagementWrap kitchen-payment">
    <div class="offermanageTopHeading">
        <h2>My Account</h2>
        <!-- <a href="<?=KITCHEN_URL?>my-account/edit-profile">Edit Profile</a> -->
    </div>
    <div class="row">
        <div class="col col-12 col-md-5 col-lg-5">
            <div class="nk-account-detail">
                <div class="nk-account-detail-card">
                    <div class="nk-account-card-header">
                        <div class="nk-account-header-img">
                            <img src="<?php echo KITCHEN_IMAGES_URL; ?>kitchen-banner.png" class="img-fluid" alt="image"  />
                        </div>
                        <div class="nk-account-header-logo">
                            <?php if($kitchendata['profile_image']!="" && file_exists(USER_PROFILE_PATH.$kitchendata['profile_image'])) { ?>
                                <img src="<?=USER_PROFILE.$kitchendata['profile_image']?>" class="img-fluid" style="border-radius: 50%;border: 3px solid #FFF;outline: 2px solid #000;">
                            <?php } else{ ?>
                                <img src="<?= KITCHEN_IMAGES_URL?>logo-kitchen.png" alt="" class="img-fluid">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="nk-account-card-body">
                        <div class="nk-account-title-header">
                            <h1 class="nk-kitchen-title"><?=$kitchendata['kitchenname']?></h1>
                        </div>
                        <div class="nk-kitchen-details">
                            <div class"nk-kitchen-details__inner">
                                <?php if($kitchendata['foodtype']!=""){ ?>
                                <p class="nk-kitchen-description"><?=$kitchendata['foodtype']?></p>
                                <?php } ?>
                                <p class="nk-kitchen-description"><?=$kitchendata['address']?></p>
                            </div>
                            <ul class="nk-rating-list">
                                <li class="nk-rating-item <?=$kitchendata['averagerating'] >= 1 ? "active" : ""?>"><i class="fas fa-star"></i></li>
                                <li class="nk-rating-item <?=$kitchendata['averagerating'] >= 2 ? "active" : ""?>"><i class="fas fa-star"></i></li>
                                <li class="nk-rating-item <?=$kitchendata['averagerating'] >= 3 ? "active" : ""?>"><i class="fas fa-star"></i></li>
                                <li class="nk-rating-item <?=$kitchendata['averagerating'] >= 4 ? "active" : ""?>"><i class="fas fa-star"></i></li>
                                <li class="nk-rating-item <?=$kitchendata['averagerating'] >= 5 ? "active" : ""?>"><i class="fas fa-star"></i></li>
                            </ul>
                        </div>
                        <p class="nk-open-time"><span>
                            <?php if(date("H:i:s") > $kitchendata['fromtime'] && date("H:i:s") < $kitchendata['totime']){
                                echo '<span class="lightgreen opennow">Open Now</span>';
                            }else{
                                echo '<span class="lightgreen opennow">Closed</span>';
                            } ?> -</span> <?=date("h:i A",strtotime($kitchendata['fromtime']))?> to <?=date("h:i A",strtotime($kitchendata['totime']))?> (<?=$kitchendata['opendays']?>)</p>
                        
                        <?php if($kitchendata['description']!=""){ ?>
                        <div class="nk-kitchen-about">
                            <p class="nk-kitchen-about-text"><?=$kitchendata['description']?></p>
                        </div>
                        <?php } ?>
                        <div class="nk-kitchen-info">
                            <div class="nk-kitchen-info-card" onclick="window.location.href=SITE_URL+'package'" style="cursor: pointer;">
                                <div class="nk-kitchen-info-img">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>package.png" alt="package" class="img-fluid" />
                                </div>
                                <h3 class="nk-kitchen-info-title">Pakages</h3>
                            </div>
                            <div class="nk-kitchen-info-card" onclick="window.location.href=SITE_URL+'menu'" style="cursor: pointer;">
                                <div class="nk-kitchen-info-img">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>menu.png" alt="menu" class="img-fluid" />
                                </div>
                                <h3 class="nk-kitchen-info-title">Menu</h3>
                            </div>
                            <div class="nk-kitchen-info-card" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;">
                                <div class="nk-kitchen-info-img">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>info.png" alt="info" class="img-fluid" />
                                </div>
                                <h3 class="nk-kitchen-info-title">Other Info</h3>
                            </div>
                        </div>
                        
                        <div class="nk-meals-type">
                            <h3 class="nk-meals-type-title">Types of Meals</h3>
                            <?php if(!empty($kitchendata['mealtype'])){ ?>
                            <ul class="nk-meals-type-list">
                                <?php if(in_array("Breakfast", explode(",", $kitchendata['mealtype']))){ ?>
                                <li class="nk-meals-type-item">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>Breakfast.png" alt="Breakfast" class="img-fluid" />
                                    <label>Breakfast</label>
                                </li>
                                <?php } if(in_array("Lunch", explode(",", $kitchendata['mealtype']))){ ?>
                                <li class="nk-meals-type-item">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>Lunch.png" alt="Lunch" class="img-fluid" />
                                    <label>Lunch</label>
                                </li>
                                <?php } if(in_array("Dinner", explode(",", $kitchendata['mealtype']))){ ?>
                                <li class="nk-meals-type-item">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>Dinner.png" alt="Dinner" class="img-fluid" />
                                    <label>Dinner</label>
                                </li>
                                <?php } if(in_array("Veg", explode(",", $kitchendata['mealtype']))){ ?>
                                <li class="nk-meals-type-item">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>Veg.png" alt="Veg" class="img-fluid" />
                                    <label>Veg</label>
                                </li>
                                <?php } if(in_array("Non Veg", explode(",", $kitchendata['mealtype']))){ ?>
                                <li class="nk-meals-type-item">
                                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>Non-Veg.png" alt="Non-Veg" class="img-fluid" />
                                    <label>Non-veg</label>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php }else{ ?>
                                <p>Not found type of meals you.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-7 col-lg-7">
            <div class="nk-all-kitchen-details">
                <h2 class="nk-all-kitchen-detail-title">Kitchen Details</h2>
                <form action="#" id="kitchenform" class="form-horizontal">
                    <div class="nk-all-kitchen-detail__inner">
                        <h3 class="nk-all-kitchen-subtitle">Type of frim</h3>
                        <div class="nk-all-kitchen-detail-content">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="firmtype1" name="firmtype" class="custom-control-input" value="0" <?=($kitchendata['firmtype']=="0" ? "checked" : "checked")?>>
                                <label class="custom-control-label" for="firmtype1">Kitchen only for delivery</label>
                            </div>    
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="firmtype2" name="firmtype" class="custom-control-input" value="1" <?=($kitchendata['firmtype']=="1" ? "checked" : "")?>>
                                <label class="custom-control-label" for="firmtype2">Restaurants for delivery</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nk-all-kitchen-detail__inner">
                        <h3 class="nk-all-kitchen-subtitle">What type of food you provide?</h3>
                        <div class="nk-all-kitchen-detail-content">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="foodtype[]" id="foodtype1" value="North Indian Meals" <?=(in_array("North Indian Meals",explode(",",$kitchendata['foodtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="foodtype1">North Indian Meals</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="foodtype[]" id="foodtype2" value="South Indian Meals" <?=(in_array("South Indian Meals",explode(",",$kitchendata['foodtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="foodtype2">South Indian Meals</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="foodtype[]" id="foodtype3" value="Diet Meals" <?=(in_array("Diet Meals",explode(",",$kitchendata['foodtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="foodtype3">Diet Meals</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nk-all-kitchen-detail__inner">
                        <h3 class="nk-all-kitchen-subtitle">Oprational Timings of kitchen</h3>
                        <div class="nk-all-kitchen-detail-content">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fromtime">Time From</label>
                                        <input type="time" class="form-control txtinput" name="fromtime" id="fromtime" value="<?=($kitchendata['fromtime']!="00:00:00" ? $kitchendata['fromtime'] : "")?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="totime">Time To</label>
                                        <input type="time" class="form-control txtinput" name="totime" id="totime" value="<?=($kitchendata['totime']!="00:00:00" ? $kitchendata['totime'] : "")?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nk-all-kitchen-detail__inner">
                        <h3 class="nk-all-kitchen-subtitle">Open days & Respective Timings</h3>
                        <div class="nk-all-kitchen-detail-content">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays1" value="Sunday" <?=(in_array("Sunday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays1">Sunday</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays2" value="Monday" <?=(in_array("Monday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays2">Monday</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays3" value="Tuesday" <?=(in_array("Tuesday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays3">Tuesday</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays4" value="Wednesday" <?=(in_array("Wednesday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays4">Wednesday</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays5" value="Thursday" <?=(in_array("Thursday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays5">Thrusday</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays6" value="Friday" <?=(in_array("Friday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays6">Friday</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="opendays[]" id="opendays7" value="Saturday" <?=(in_array("Saturday",explode(",",$kitchendata['opendays'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="opendays7">Saturday</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nk-all-kitchen-detail__inner">
                        <h3 class="nk-all-kitchen-subtitle">Type of Meals you</h3>
                        <div class="nk-all-kitchen-detail-content">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="mealtype[]" id="mealtype1" value="Breakfast" <?=(in_array("Breakfast",explode(",",$kitchendata['mealtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="mealtype1">Breakfast</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="mealtype[]" id="mealtype2" value="Lunch" <?=(in_array("Lunch",explode(",",$kitchendata['mealtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="mealtype2">Lunch</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="mealtype[]" id="mealtype3" value="Dinner" <?=(in_array("Dinner",explode(",",$kitchendata['mealtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="mealtype3">Dinner</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="mealtype[]" id="mealtype4" value="Veg" <?=(in_array("Veg",explode(",",$kitchendata['mealtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="mealtype4">Veg</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="mealtype[]" id="mealtype5" value="Non Veg" <?=(in_array("Non Veg",explode(",",$kitchendata['mealtype'])) ? "checked" : "")?>>
                                <label class="custom-control-label" for="mealtype5">Non-veg</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nk-all-kitchen-detail-btn">
                        <button type="button" class="btn btn-custom" id="btn-save" onclick="save_details()">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal custom-modal fade nk-account-setting-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <img src="<?= KITCHEN_IMAGES_URL?>modal-close.svg">
            </button>
          </div>
          <div class="modal-body">
                <form action="#" id="settingform" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6 pr-0">
                            <div class="form-group mr-2">
                                <label for="kitchenname" class="top-lbl">Kitchen Name</label>
                                <input id="kitchenname" class="form-control" name="kitchenname" value="<?=$kitchendata['kitchenname']?>" type="text" tabindex="1">
                            </div>
                        </div>
                        <div class="col-md-6 pl-0">
                            <div class="form-group ml-2">
                                <label for="email" class="top-lbl">Email</label>
                                <input id="email" class="form-control" name="email" value="<?=$kitchendata['email']?>" type="email" tabindex="2">
                            </div>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label for="address" class="top-lbl">Location</label>
                        <input id="address" class="form-control" name="address" value="<?=$kitchendata['address']?>" type="text" tabindex="3">
                    </div>
                    <div class="form-group">
                        <label for="description" class="top-lbl">Description</label>
                        <textarea id="description" class="form-control" name="description" tabindex="4"><?=$kitchendata['description']?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 pr-0">
                            <div class="form-group mr-2">
                                <label for="mobilenumber" class="top-lbl">Mobile Number</label>
                                <input id="mobilenumber" class="form-control" name="mobilenumber" value="<?=$kitchendata['mobilenumber']?>" type="text" tabindex="4" maxlength="10" onkeypress="return isNumeric(event)">
                            </div>
                        </div>
                        <div class="col-md-6 pl-0">
                            <div class="form-group ml-2">
                                <label for="password" class="top-lbl">Password</label>
                                <input id="password" class="form-control" name="password" value="<?=$kitchendata['mobilenumber']?>" type="password" tabindex="5">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 pr-1">
                            <div class="form-group">
                                <label for="profile_image" class="top-lbl">Profile Image</label>
                                <div class="col-md-12 p-0">
                                    <input type="hidden" name="oldprofile_image" id="oldprofile_image" value="<?=$kitchendata['profile_image']?>">
                                    <input type="hidden" id="isvalidprofile_image" value="<?=($kitchendata['profile_image']!="" ? 1 : 0)?>">
                                    <input type="file" id="profile_image" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.gif" onchange="check_image($(this),'profile_image')"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <img id="profile_image_src" src="<?=($kitchendata['profile_image']!="" ? USER_PROFILE.$kitchendata['profile_image'] : NOPROFILEIMAGE)?>" class="img-thumbnail mb-2" style="height:83px;">
                        </div>
                    </div>
                    <div class="form-button">
                        <button type="button" class="btn btn-custom" id="btn-save-set" onclick="save_settings()">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>

    function check_image(obj, element){
        var val = obj.val();
        var id = obj.attr('id').match(/\d+/);
        var filename = obj.val().replace(/C:\\fakepath\\/i, '');
        var filesize = obj[0].files[0].size;
        
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp':
                
                $("#isvalid"+element).val(1);
            
                if (obj[0].files && obj[0].files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#'+element+"_src").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(obj[0].files[0]);
                }

                break;
            default:
                    
                $("#isvalid"+element).val(0);
                $('#'+element+"_src").attr('src', SITE_URL+"assets/image/noimage.jpg");
                toastr.error('Accept only (.jpg,.jpeg,.png,.gif) file !');
                break;
        }
    }

    function save_details(){

        var foodtype = $("input[name='foodtype[]']:checked").length;
        var fromtime = $("#fromtime").val().trim();
        var totime = $("#totime").val().trim();
        var opendays = $("input[name='opendays[]']:checked").length;
        var mealtype = $("input[name='mealtype[]']:checked").length;
        
        var isvalid = 1;
        
        if(foodtype==0){
            toastr.error('Please select atleast one type of food you provide !');
            isvalid = 0;
        }
        if(opendays==0){
            toastr.error('Please select atleast one open days & respective timings !');
            isvalid = 0;
        }
        if(mealtype==0){
            toastr.error('Please select atleast one type of meals !');
            isvalid = 0;
        }
        if(fromtime==""){
            toastr.error('Please select time from !');
            isvalid = 0;
        }
        if(totime==""){
            toastr.error('Please select time to !');
            isvalid = 0;
        }
        if(isvalid == 1){
            
            var formData = new FormData($('#kitchenform')[0]);
            $.ajax({
                url: SITE_URL+"my-account/update-account-detail",
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#btn-save').css('opacity','0.3').prop("disabled",true);
                },
                success: function(response){
                    if(response==1){
                        toastr.success('Account detail saved successfully.');
                        setTimeout(function(){
                            window.location.href=SITE_URL+"my-account";
                        },2000);
                    }else{
                        toastr.error('Account detail not saved !');
                    }
                    $('#btn-save').css('opacity','1').prop("disabled",false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            
        }
    }

    function save_settings() {

        var kitchenname = $("#kitchenname").val().trim();
        var address = $("#address").val().trim();
        var email = $("#email").val().trim();
        var mobilenumber = $("#mobilenumber").val().trim();
        var password = $("#password").val().trim();

        var isvalid = 1;

        if(kitchenname == ''){
            $("#kitchenname").parent("div").addClass("manage-error");
            toastr.error('Please enter kitchen name !');
            isvalid = 0;
        }else {
            $("#kitchenname").parent("div").removeClass("manage-error");
        }
        if(address == ''){
            $("#address").parent("div").addClass("manage-error");
            toastr.error('Please enter address !');
            isvalid = 0;
        }else {
            $("#address").parent("div").removeClass("manage-error");
        }
        if(email == ''){
            $("#email").parent("div").addClass("manage-error");
            toastr.error('Please enter email !');
            isvalid = 0;
        }else if(email != '' && !checkEmail(email)){
            $("#email").parent("div").addClass("manage-error");
            toastr.error('Email address is not valid !');
            isvalid = 0;
        }else {
            $("#email").parent("div").removeClass("manage-error");
        }
        if(mobilenumber == ''){
            $("#mobilenumber").parent("div").addClass("manage-error");
            toastr.error('Please enter mobile number !');
            isvalid = 0;
        }else if(mobilenumber.length != 10){
            $("#mobilenumber").parent("div").addClass("manage-error");
            toastr.error('Mobile number required 10 digits !');
            isvalid = 0;
        }else {
            $("#mobilenumber").parent("div").removeClass("manage-error");
        }
        if(password == ''){
            $("#password").parent("div").addClass("manage-error");
            toastr.error('Please enter password !');
            isvalid = 0;
        }else if(password.length < 6){
            $("#password").parent("div").addClass("manage-error");
            toastr.error('Password required minimum 6 digits !');
            isvalid = 0;
        }else {
            $("#password").parent("div").removeClass("manage-error");
        }
        if(description == ''){
            $("#description").parent("div").addClass("manage-error");
            toastr.error('Please enter description !');
            isvalid = 0;
        }else{
            $("#description").parent("div").removeClass("manage-error");
        }

        if(isvalid ==1){
        
            var formData = new FormData($('#settingform')[0]);
            $.ajax({
                url: SITE_URL+"my-account/update-account-setting",
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#btn-save-set').css('opacity','0.3').prop("disabled",true);
                },
                success: function(response){
                    if(response==1){
                        toastr.success('Account setting saved successfully.');
                        setTimeout(function(){
                            window.location.href=SITE_URL+"my-account";
                        },2000);
                    }else if(response==2){
                        toastr.error('Email already register !');
                    }else if(response==0){
                        toastr.error('Account setting not saved !');
                    }else{
                        toastr.error(response);
                    }
                    $('#btn-save-set').css('opacity','1').prop("disabled",false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            
        }
    }
</script>
