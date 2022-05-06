<style>
    .pac-container {
        background-color: #FFF;
        z-index: 20;
        position: fixed;
        display: inline-block;
        float: left;
    }

    .modal {
        z-index: 20;
        top: 72px;
    }

    .modal-backdrop {
        z-index: 10;
    }

    .myaccount-addresslist-container .btn-add-payment-plus {
        font-size: 18px;
        padding: 4px 15px;
    }

    .myaccount-addresslist-container .btn-add-payment-plus {
        display: inline;
        background-color: #FCC647;
        color: white;
        font-weight: 500;
        border-radius: 10px;
        border: 2px solid #FCC647;
    }

    .addpayment-model .payment-main input[type="text"] {
        margin-bottom: 0px;
        margin-top: 15px;
    }

    #addpayment .checkbox input[type="checkbox"] {
        opacity: 0;
        z-index: 1;
    }

    #addpayment .checkbox label {
        font-size: 14px;
        color: #2F3443;
        vertical-align: middle;
        display: inline-block;
        padding-left: 25px;
        position: relative;
    }

    #addpayment .checkbox label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: 0px;
        border: 1px solid #ccc;
        border-radius: 2px;
        background-color: #fff;
    }

    #addpayment .checkbox-success input[type="checkbox"]:checked+label::before {
        background-color: #5cb85c;
        border-color: #5cb85c;
    }

    #addpayment .checkbox label::after {
        content: "";
        display: inline-block;
        position: absolute;
        width: 16px;
        height: 16px;
        left: 0;
        top: 0;
        margin-left: 0px;
        padding-left: 3px;
        padding-top: 1px;
        font-size: 11px;
    }

    #addpayment .checkbox-success input[type="checkbox"]:checked+label::after {
        color: #fff;
    }

    #addpayment .checkbox input[type="checkbox"]:checked+label::after {
        font-family: "FontAwesome";
        content: "\f00c";
    }

    .cardbox {
        /* float: left; */
        padding: 15px !important;
    }

    .cardbox p {
        font-size: 13px;
        margin-bottom: 5px;
    }

    .default_card_cls {
        font-size: 13px;
    }

    .myaccount-addresslist-container .btn-container {
        text-align: right;
    }

    .myaccount-addresslist-container .btn-add-payment-plus {
        font-size: 32px;
        padding: 4px 15px;
    }

    .myaccount-addresslist-container .btn-add-payment-plus,
    .myaccount-addresslist-container .btn-add-payment-plus {
        display: inline;
        background-color: #FCC647;
        color: white;
        font-weight: 500;
        border-radius: 50%;
        border: 2px solid #FCC647;
    }

    .kitchen-information .myaccount-section .email-phone {
        max-width: 100%;
        margin: 40px 16px 90px 185px;
        word-break: break-all;
    }
    .kitchen-information .myaccount-section .my-wallet {
    font-size: 21px;
    color: #2F3443;
}

.kitchen-information .myaccount-section .myaccount-summery .img-container img {
    width: auto;
    height:auto;
}
.myaccount-section .activeorder-container .name-bill {
    display: flex;
    /* flex-wrap: wrap; */
    justify-content: space-between;
}
/* prathap edit */
.modal-content {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: .3rem;
    outline: 0;
    box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.2), 0 12px 20px 0 rgba(0, 0, 0, 0.19)
}

.HeaderSection .HeaderButtons ul li.dropdown button span {
    letter-spacing: 0px;
    color: #2F3443;
    margin-right: 15px;
    font-variant: all-small-caps;
    font-size:25px;
}

.modal-header {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    border-top-left-radius: .3rem;
    border-top-right-radius: .3rem;
}

.modal-body {
    position: relative;
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: .5rem;
}

.margin-left101 {
    margin-left: 19px;
}

/* prathap edit end */
</style>
<script>
    var customer_id = '<?= $userdata['id'] ?>';
    var PER_PAGE_ORDER = '<?= PER_PAGE_ORDER ?>';
    var PER_PAGE_ADDRESS = '<?= PER_PAGE_ADDRESS ?>';
</script>
<div class="kitchen-information">
    <div class="container-fluid1">
        <div class="myaccount-section">
            <div class="heading-section">
                <p class="main-heading">My Account</p>
            </div>
            <div class="myaccount-section-container">
                <div class="myaccount-summery">
                    <div class="img-container">
                        <img src="<?= FRONT_IMAGES_URL ?>indiandhalspicycurry.png" alt="" class="img-fluid">
                    </div>
                    <div class="myaccount-symbol-container" style="position: relative;">
                        <?php if ($userdata['profile_image'] != "" && file_exists(USER_PROFILE_PATH . $userdata['profile_image'])) {
                            $src = USER_PROFILE . $userdata['profile_image'];
                        } else {
                            $src = NOPROFILEIMAGE;
                        } ?>
                        <img src=" <?= $src ?>" alt="" class="img-fluid" style="border-radius: 50%;height: 150px;width: 150px;border: 2px solid #fccc5b;">
                        <button type="button" class="btn btn-active" style="position: absolute;right: 5px;top: 85px;" data-toggle="modal" data-target="#editprofileModal" title="Edit Profile"><i class="fa fa-edit"></i> Edit</button>
                    </div>
                    <input type="hidden" id="foodie_profile_image" vale="<?= $userdata['profile_image'] ?>">
                    <p class="myaccount-heading"><?= $userdata['kitchenname'] ?></p>
                  <div class="wallet" style="float:left;">  
                    <p class="my-wallet"><img src="<?= FRONT_IMAGES_URL ?>walletfilledmoneytool.png" alt="" class="img-fluid"><span class="margin-left5">My Wallet</span></p>
                    <p class="myaccount-pay">₹<?= number_format($userdata['wallet'], 2, '.', ',') ?></p>
                    <a class="btn btn-active" href="javascript:void(0)" onclick="open_deposit_popup()" data-toggle="modal" data-target="#adddeposit" title="Add Deposit">Deposit</a>
                    </div>
                    <div class="email-phone">
                        <?php if ($userdata['email'] != "") { ?>
                            <p class="myemail"><img src="<?= FRONT_IMAGES_URL ?>Path7043.png" alt="" class="img-fluid"><span class="margin-left101"><?= $userdata['email'] ?></span></p>
                        <?php } ?>
                        <p class="myphone"><img src="<?= FRONT_IMAGES_URL ?>Path7044.png" alt="" class="img-fluid"> <span class="margin-left10">+91<?= $userdata['mobilenumber'] ?></span></p>
                    </div>

                    <a href="<?= FRONT_URL ?>logout" class="btn-account-logout"><img src="<?= FRONT_IMAGES_URL ?>XMLID15.png" alt="" class="img-fluid"><span class="margin-left10">Logout</span></a>
                </div>
                <div class="myaccount-detail-info">
                    <div class="myaccount-detail-info-container">
                        <div class="myaccount-details-content">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-orders-tab" data-toggle="pill" href="#pills-orders" role="tab" aria-controls="pills-orders" aria-selected="true">Orders</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-addresslist-tab" data-toggle="pill" href="#pills-addresslist" role="tab" aria-controls="pills-addresslist" aria-selected="false">Address List</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-managepayments-tab" data-toggle="pill" href="#pills-managepayments" role="tab" aria-controls="pills-managepayments" aria-selected="false">Manage Payments</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab">
                                    <div class="myaccount-orders-container">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="pills-activeorders-tab" data-toggle="pill" href="#pills-activeorders" role="tab" aria-controls="pills-activeorders" aria-selected="true">Active Orders</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-favoriteorders-tab" data-toggle="pill" href="#pills-favoriteorders" role="tab" aria-controls="pills-favoriteorders" aria-selected="false">Favorite Orders</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-orderhistory-tab" data-toggle="pill" href="#pills-orderhistory" role="tab" aria-controls="pills-orderhistory" aria-selected="false">Order History</a>
                                            </li>
                                            
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-favoriteorders-tab" data-toggle="pill" href="#pills-favoritekitchen" role="tab" aria-controls="pills-favoritekitchen" aria-selected="false">Favorite kitchen</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-activeorders" role="tabpanel" aria-labelledby="pills-activeorders-tab">
                                                <div class="activeorder-container" id="aolist"></div>
                                                <div class="ao load_more_btn" style="display:none;">
                                                    <a href="javascript:void(0)" onclick="load_active_orders()">load more</a>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-favoriteorders" role="tabpanel" aria-labelledby="pills-favoriteorders-tab">
                                                <div class="activeorder-container">
                                                    <?php if (!empty($favorite_orderdata)) {
                                                        foreach ($favorite_orderdata as $row) { ?>
                                                            <div class="order-active-content">
                                                                <div class="name-bill">
                                                                    <div class="left-part">
                                                                        <p class="kitchen-name"><?= $row['kitchenname'] ?></p>
                                                                        <p class="order-date"><?= $row['orderid'] ?> | Order from <?= date("d M, Y", strtotime($row['orderdate'])) ?></p>
                                                                        <p class="rate"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star cementgray"></i></p>
                                                                    </div>
                                                                    <div class="right-part">
                                                                        <p class="total-bill">Total Bill: ₹<?= number_format($row['netamount'], 2, '.', ',') ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="btn-container">
                                                                    <!-- <div class="left-part"><a href="#" class="btn-active">Active</a></div> -->
                                                                    <div class="right-part"><a href="javascript:void(0)" class="btn-view-details">View Details</a></div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <div class="order-active-content">
                                                            <p class="text-center">No any favorite order available.</p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-orderhistory" role="tabpanel" aria-labelledby="pills-orderhistory-tab">
                                                <div class="activeorder-container" id="ohlist"></div>
                                                <div class="oh load_more_btn" style="display:none;">
                                                    <a href="javascript:void(0)" onclick="load_order_history()">load more</a>
                                                </div>
                                            </div>
                                            
                                            <div class="tab-pane fade" id="pills-orderhistory" role="tabpanel" aria-labelledby="pills-orderhistory-tab">
                                                <div class="activeorder-container" id="ohlist"></div>
                                                <div class="oh load_more_btn" style="display:none;">
                                                    <a href="javascript:void(0)" onclick="load_order_history()">load more</a>
                                                </div>
                                            </div>
                                            
                                             <div class="tab-pane fade" id="pills-favoritekitchen" role="tabpanel" aria-labelledby="pills-favoritekitchen-tab">
                                                <div class="activeorder-container">
                                                    <?php if (!empty($favorite_kitchen)) {
                                                        foreach ($favorite_kitchen as $row) { ?>
                                                            <div class="order-active-content">
                                                                <div class="name-bill">
                                                                    <div class="left-part">
                                                                        <p class="kitchen-name"><?= $row['kitchenid'] ?></p>
                                                                        <p class="order-date"><?= $row['kitchenid'] ?> | Order from <?= date("d M, Y", strtotime($row['kitchenid'])) ?></p>
                                                                        <p class="rate"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star cementgray"></i></p>
                                                                    </div>
                                                                    <!--<div class="right-part">-->
                                                                    <!--    <p class="total-bill">Total Bill: ₹<?= number_format($row['netamount'], 2, '.', ',') ?></p>-->
                                                                    <!--</div>-->
                                                                </div>
                                                                <div class="btn-container">
                                                                    <!-- <div class="left-part"><a href="#" class="btn-active">Active</a></div> -->
                                                                    <div class="right-part"><a href="javascript:void(0)" class="btn-view-details">View Details</a></div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <div class="order-active-content">
                                                            <p class="text-center">No any favorite kitchen available.</p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-addresslist" role="tabpanel" aria-labelledby="pills-addresslist-tab">
                                    <div class="myaccount-addresslist-container">
                                        <div id="adlist"></div>
                                        <div class="ad load_more_btn" style="display:none;">
                                            <a href="javascript:void(0)" onclick="get_address()">load more</a>
                                        </div>
                                        <div class="btn-container">
                                            <a href="javascript:void(0)" onclick="add_address_popup()" class="btn-add-payment-plus" data-toggle="modal" data-target="#addaddress" title="Add New Address">+</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-managepayments" role="tabpanel" aria-labelledby="pills-managepayments-tab">
                                    <div class="myaccount-manage-payment-container">
                                        <div class="manage-payment-content">
                                            <div id="manage_card_section">
                                                <p class="heading">No Payment Method Added</p>
                                                <div class="img-container">
                                                    <img src="<?= FRONT_IMAGES_URL ?>Group10491.png" alt="" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="btn-container">
                                                <a href="javascript:void(0)" onclick="add_card_popup()" class="btn-add-payment-plus" data-toggle="modal" data-target="#addpayment">+</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Payment Dialog Box --->
<div id="addpayment" class="addpayment-model modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Credit, Debit & ATM Cards</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <form id="card_form" method="post">
                    <div class="payment-main">
                        <div class="payments-img-container">
                            <img src="<?= FRONT_IMAGES_URL ?>visa.svg" alt="" class="img-fluid">
                            <img src="<?= FRONT_IMAGES_URL ?>mastercard.svg" alt="" class="img-fluid">
                            <img src="<?= FRONT_IMAGES_URL ?>rupay.svg" alt="" class="img-fluid">
                            <img src="<?= FRONT_IMAGES_URL ?>paymentopt4.svg" alt="" class="img-fluid">
                        </div>
                        <p class="card-detail">Type your card details</p>

                        <span id="error_card_form"></span>

                        <input type="hidden" name="card_id" id="card_id">

                        <input type="text" placeholder="Card Name" name="card_name" id="card_name">
                        <span id="error_card_name" style="color: red;font-size: 13px;"></span>

                        <input type="text" placeholder="Card Number" name="card_number" id="card_number" maxlength="22">
                        <span id="error_card_number" style="color: red;font-size: 13px;"></span>

                        <input type="text" placeholder="Cardholder Name" pattern="\S.*" name="cardholder_name" id="cardholder_name">
                        <span id="error_cardholder_name" style="color: red;font-size: 13px;"></span>

                        <input type="text" placeholder="Valid Thru (MM / YY)" name="validthru" id="validthru" maxlength="7">
                        <span id="error_validthru" style="color: red;font-size: 13px;"></span>

                        <div class="custom-file mb-3">
                            <input type="hidden" name="oldcardimg" id="oldcardimg" value="">
                            <input type="hidden" id="isvalidcardimg" value="0">
                            <input type="file" id="cardimg" name="cardimg" class="custom-file-input" accept=".jpg,.jpeg,.png,.gif,.bmp" onchange="check_image($(this),'cardimg')" />
                            <label id="lblcardimg" class="custom-file-label" for="cardimg" style="overflow: hidden;">Choose file</label>
                            <span id="error_cardimg" style="color: red;font-size: 13px;"></span>
                        </div>

                        <div class="checkbox checkbox-success">
                            <input id="default-payment-card" class="styled" type="checkbox" name="default-payment-card" value="default-payment-card">
                            <label for="default-payment-card">Mark card as a default for all payments</label>
                        </div>
                        <span id="error_defaultcard" style="color: red;font-size: 13px;"></span>

                    </div>
                    <button type="button" name="add_card" id="add_card" class="btn-add-card" onclick="add_card_popup('add')">Add Card</button>
                </form>
            </div>

        </div>

    </div>
</div>

<div id="addaddress" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Add Address</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <form id="address_form" method="post">
                    <span id="error_address_form"></span>

                    <input type="hidden" name="address_id" id="address_id">

                    <label for="address">Address : </label>
                    <input class="address" name="address" id="address" type="text" style="border-top: 0;border-right: 0;border-left: 0;width: 100%;" value="" placeholder="Enter Address" autocomplete="off">
                    <input type="hidden" name="address_latitude" id="address_latitude">
                    <input type="hidden" name="address_longitude" id="address_longitude">
                    <br>
                    <span id="error_address" style="color: red;font-size: 13px;"></span>
                    <br>
                    <div class="checkbox">
                        <input id="default-address" type="checkbox" name="default-address" value="default-address">
                        <label for="default-address">Mark address as a default</label>
                    </div>
                    <p id="error_defaultaddress" style="color: red;font-size: 13px;"></p>

                    <button type="button" name="add_address" id="add_address" class="btn btn-active" onclick="add_address_popup('add')">Add Address</button>
                </form>
            </div>

        </div>

    </div>
</div>

<div id="adddeposit" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Add Deposit to Your Wallet</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <form id="deposit_form" method="post">
                    <span id="error_deposit_form"></span>

                    <label for="depositamount">Amount : </label>
                    <input name="depositamount" id="depositamount" type="text" style="border-top: 0;border-right: 0;border-left: 0;width: 100%;" value="" placeholder="Enter Amount" autocomplete="off" onkeypress="return isNumeric(event)" 
                     maxlength="5">
                    <br>
                    <span id="error_depositamount" style="color: red;font-size: 13px;display:block;"></span>
                    <br>

                    <button type="button" name="add_deposit" id="add_deposit" class="btn btn-active" onclick="add_deposit_amount()">Add Deposit</button>
                </form>
            </div>

        </div>

    </div>
</div>

<div id="editprofileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Edit Profile</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <form id="user_form" method="post">
                    <span id="error_user_form"></span>

                    <label for="user_name">Name : </label>
                    <input name="user_name" id="user_name" type="text" style="border-top: 0;border-right: 0;border-left: 0;width: 100%;" value="<?= $userdata['kitchenname'] ?>" placeholder="Enter Name">
                    <br>
                    <span id="error_user_name" style="color: red;font-size: 13px;display:block;"></span>
                    <br>

                    <label for="user_email">Email : </label>
                    <input name="user_email" id="user_email" type="text" style="border-top: 0;border-right: 0;border-left: 0;width: 100%;" value="<?= $userdata['email'] ?>" placeholder="Enter Email">
                    <br>
                    <span id="error_user_email" style="color: red;font-size: 13px;display:block;"></span>
                    <br>

                    <label for="">Profile Image : </label>
                    <div class="custom-file mb-1">
                        <input type="hidden" name="oldprofileimage" id="oldprofileimage" value="<?= $userdata['profile_image'] ?>">
                        <input type="hidden" id="isvalidprofile_image" value="<?= ($userdata['profile_image'] != "" ? 1 : 0) ?>">
                        <input type="file" id="profile_image" name="profile_image" class="custom-file-input" accept=".jpg,.jpeg,.png,.gif,.bmp" onchange="check_image($(this),'profile_image')" />
                        <label id="lblprofile_image" class="custom-file-label" for="profile_image" style="overflow: hidden;"><?= ($userdata['profile_image'] != "" ? $userdata['profile_image'] : "Choose file") ?></label>
                        <span id="error_profile_image" style="color: red;font-size: 13px;"></span>
                    </div>
                    <div class="mb-1">
                        <img id="img_profile_image" src="<?= $src ?>" class="img-thumbnail" style="height: 100px;">
                    </div>
                    <div class="text-right">
                        <button type="button" id="update_profile" class="btn btn-active" onclick="update_account()">Update Profile</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>