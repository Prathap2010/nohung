<style>
  .radio label {
      display: inline-block;
      vertical-align: middle;
      position: relative;
      padding-left: 10px;
      font-size: 19px;
      color: #2F3443;
  }
  .radio label::before {
      content: "";
      display: inline-block;
      position: absolute;
      width: 20px;
      height: 20px;
      left: 0;
      margin-left: -20px;
      border: 1px solid #cccccc;
      border-radius: 50%;
      background-color: #fff;
      -webkit-transition: border 0.15s ease-in-out;
      -o-transition: border 0.15s ease-in-out;
      transition: border 0.15s ease-in-out;
  }
  .radio label::after {
      display: inline-block;
      position: absolute;
      content: " ";
      width: 9px;
      height: 9px;
      left: 5px;
      top: 6px;
      margin-left: -20px;
      border-radius: 50%;
      background-color: #555555;
      -webkit-transform: scale(0, 0);
      -ms-transform: scale(0, 0);
      -o-transform: scale(0, 0);
      transform: scale(0, 0);
      -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
      -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
      -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
      transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  }
  .radio input[type="radio"] {
      opacity: 0;
      z-index: 1;
  }
  .radio input[type="radio"]:checked + label::before {
      border-color: #5cb85c;
  }
  .radio input[type="radio"]:checked + label::after {
      background-color: #5cb85c;
      -webkit-transform: scale(1, 1);
      -ms-transform: scale(1, 1);
      -o-transform: scale(1, 1);
      transform: scale(1, 1);
  }
  
  
  
   .radio1 label {
      display: inline-block;
      vertical-align: middle;
      position: relative;
      padding-left: 10px;
      font-size: 19px;
      color: #2F3443;
  }
  .radio1 label::before {
      content: "";
      display: inline-block;
      position: absolute;
      width: 20px;
      height: 20px;
      left: 0;
      margin-left: -20px;
      border: 1px solid #cccccc;
      border-radius: 50%;
      background-color: #fff;
      -webkit-transition: border 0.15s ease-in-out;
      -o-transition: border 0.15s ease-in-out;
      transition: border 0.15s ease-in-out;
  }
  .radio1 label::after {
      display: inline-block;
      position: absolute;
      content: " ";
      width: 9px;
      height: 9px;
      left: 5px;
      top: 6px;
      margin-left: -20px;
      border-radius: 50%;
      background-color: #555555;
      -webkit-transform: scale(0, 0);
      -ms-transform: scale(0, 0);
      -o-transform: scale(0, 0);
      transform: scale(0, 0);
      -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
      -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
      -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
      transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  }
  .radio1 input[type="radio"] {
      opacity: 0;
      z-index: 1;
  }
  .radio1 input[type="radio"]:checked + label::before {
      border-color: #5cb85c;
  }
  .radio1 input[type="radio"]:checked + label::after {
      background-color: #5cb85c;
      -webkit-transform: scale(1, 1);
      -ms-transform: scale(1, 1);
      -o-transform: scale(1, 1);
      transform: scale(1, 1);
  }
</style>
<script>
  var kitchen_address = '<?=$kitchendata['address']?>';
</script>
<div class="kitchen-information">
    <div class="container-fluid1">
        <div class="checkout-cart-section">
            <?php if(!empty($cart_items_array)){ ?>
            <form id="checkout_form">
              <input type="hidden" name="wallet_balance_amount" id="wallet_balance_amount" value="<?=number_format($foodiesdata['wallet'],2,'.','')?>">
              <input type="hidden" name="kitchen_latitude" id="kitchen_latitude" value="<?=!empty($kitchendata)?$kitchendata['latitude']:""?>">
              <input type="hidden" name="kitchen_longitude" id="kitchen_longitude" value="<?=!empty($kitchendata)?$kitchendata['longitude']:""?>">
              <input type="hidden" id="distance_between_kitchen_to_customer" value="">
              
              <input type="hidden" id="customer_id" value="<?=$this->session->userdata(base_url().'FOODIESUSERID')?>">
              <input type="hidden" id="customer_name" value="<?=$this->session->userdata(base_url().'FOODIESFULLNAME')?>">
              <input type="hidden" id="customer_mobileno" value="<?=$this->session->userdata(base_url().'FOODIESMOBILENO')?>">
              <input type="hidden" id="customer_email" value="<?=$this->session->userdata(base_url().'FOODIESEMAIL')?>">
              
              <div class="checkout-cart-section-container">
                  <div class="bank-payment-information">
                      <div class="left-part">
                          <div class="img-container">
                              <img src="<?=FRONT_IMAGES_URL?>Group10635.png" alt="" class="img-fluid">
                          </div>
                           <p class="heading"><?=$this->session->userdata(base_url().'FOODIESFULLNAME')?> (<?=$this->session->userdata(base_url().'FOODIESEMAIL')?>)</p>
                          <p class="sub-heading">You are securely logged in</p>

                          <!--<div class="select-payment-mathod-container">-->
                          <!--    <p class="payment-method-heading">Select Payment Method</p>-->
                          <!--    <div class="accordion" id="paymentmethod">-->
                          <!--      <div class="card">-->
                          <!--        <div class="card-header" id="wallets">-->
                          <!--          <h2 class="mb-0">-->
                          <!--            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseWallets" aria-expanded="true" aria-controls="collapseWallets">-->
                          <!--              <div class="checkbox">-->
                          <!--                <input type="checkbox" name="wallet_payment_method" id="wallet_payment_method" value="by_wallet">-->
                          <!--                <label for="wallet_payment_method">  -->
                          <!--                Wallets-->
                          <!--                </label>-->
                          <!--              </div>-->
                          <!--            </button>-->
                                      
                          <!--          </h2>-->

                          <!--        </div>-->
                                  <!-- <div id="collapseWallets" class="collapse show" aria-labelledby="wallets" data-parent="#paymentmethod">
                                    
                          <!--        </div> -->
                          <!--      </div>-->

                          <!--      <div class="card">-->
                          <!--        <div class="card-header" id="netbanking">-->
                          <!--          <h2 class="mb-0">-->
                          <!--            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseNetbanking" aria-expanded="false" aria-controls="collapseNetbanking">-->
                          <!--              <div class="radio">-->
                          <!--                <input type="radio" name="payment_method" id="payumoney_payment_method" value="1">-->
                          <!--                <label for="payumoney_payment_method">  -->
                          <!--                  PayUmoney-->
                          <!--                </label>    -->
                          <!--              </div>-->
                          <!--            </button>-->
                          <!--          </h2>-->
                          <!--        </div>-->
                                  <!-- <div id="collapseNetbanking" class="collapse" aria-labelledby="netbanking" data-parent="#paymentmethod">
                          <!--          <div class="card-body">-->
                          <!--          Netbanking-->
                          <!--          </div>-->
                          <!--        </div> -->
                          <!--      </div>-->

                                <!-- <div class="card">
                          <!--        <div class="card-header" id="pay-upi">-->
                          <!--          <h2 class="mb-0">-->
                          <!--            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapsePayupi" aria-expanded="false" aria-controls="collapsePayupi">-->
                          <!--              <div class="radio">-->
                          <!--                <input type="radio" name="payment_method" id="upi_payment_method" value="by_upi">-->
                          <!--                <label for="upi_payment_method">  -->
                          <!--                  Pay via UPI-->
                          <!--                </label>      -->
                          <!--              </div>-->
                          <!--            </button>-->
                          <!--          </h2>-->
                          <!--        </div>-->
                          <!--      </div> -->
                          <!--    </div>                            -->
                          <!--</div>-->
                          <!--<div class="btn-container">-->
                          <!--  <a href="javascript:void(0)" class="btn-checkout" id="btn-checkout" onclick="checkout()">Checkout</a> -->
                          <!--</div>-->
                      </div>
                      <div class="right-part1">
                        <!--<div class="img-container">-->
                        <!--      <img src="<?=FRONT_IMAGES_URL?>Group10635.png" alt="" class="img-fluid">-->
                        <!--  </div>-->
                          
                          <p class="heading"><?=$this->session->userdata(base_url().'FOODIESFULLNAME')?> (<?=$this->session->userdata(base_url().'FOODIESEMAIL')?>)</p>
                          <p class="sub-heading">You are securely logged in</p>

                          <div class="select-payment-mathod-container">
                              <p class="payment-method-heading">Select Payment Method</p>
                              <div class="accordion" id="paymentmethod">
                                <div class="card">
                                  <div class="card-header" id="wallets">
                                    <h2 class="mb-0">
                                      <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseWallets" aria-expanded="true" aria-controls="collapseWallets">
                                        <div class="radio">
                                          <input type="radio" name="wallet_payment_method" id="wallet_payment_method" value="1">
                                          <label for="wallet_payment_method">  
                                          Wallets
                                          </label>
                                        </div>
                                      </button>
                                      
                                    </h2>

                                  </div>
                                  <!-- <div id="collapseWallets" class="collapse show" aria-labelledby="wallets" data-parent="#paymentmethod">
                                    
                                  </div> -->
                                </div>

                                <div class="card">
                                  <div class="card-header" id="netbanking">
                                    <h2 class="mb-0">
                                      <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseNetbanking" aria-expanded="true" aria-controls="collapseNetbanking">
                                        <div class="radio1">
                                            <form>
                                    <input type="radio" name="payment_method" id="payumoney_payment_method" value="1">
                                          <label for="payumoney_payment_method">  
                                            PayUmoney
                                          </label>    
                                        </div>
                                      </button>
                                    </h2>
                                  </div>
                                  <!-- <div id="collapseNetbanking" class="collapse" aria-labelledby="netbanking" data-parent="#paymentmethod">
                                    <div class="card-body">
                                    Netbanking
                                    </div>
                                  </div> -->
                                </div>

                                <!-- <div class="card">
                                  <div class="card-header" id="pay-upi">
                                    <h2 class="mb-0">
                                      <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapsePayupi" aria-expanded="false" aria-controls="collapsePayupi">
                                        <div class="radio">
                                          <input type="radio" name="payment_method" id="upi_payment_method" value="by_upi">
                                          <label for="upi_payment_method">  
                                            Pay via UPI
                                          </label>      
                                        </div>
                                      </button>
                                    </h2>
                                  </div>
                                </div> -->
                               
                              </div>                            
                          </div>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                  <div class="product-pay-information">
                      <div class="location">
                          <p class="yourlocation">Your Delivery Point</p>
                          <a href="javascript:void(0)" onclick="$('#delivery_address').prop('readonly', false)" class="btn-change">Change</a>
                          <div class="clearfix"></div>
                      </div>
                      <input class="address" name="deliveryaddress" id="delivery_address" type="text" style="border-top: 0;border-right: 0;border-left: 0;width: 100%;" value="" readonly>
                      
                      <input type="hidden" name="deliverylatitude" id="deliverylatitude">
                      <input type="hidden" name="deliverylongitude" id="deliverylongitude">
                      
                       <!--<p class="address">To 89 Palmspring Way Roseville, CA 39847</p> -->
                      <div class="location">
                          <p class="yourlocation">Ordering for</p>
                          <a href="javascript:void(0)" class="btn-change" onclick="show_ordering_for_popup()">Change</a>
                          <div class="clearfix"></div>
                      </div>
                      <p class="name-phone" id="txt_ord_for"><?=$this->session->userdata(base_url().'FOODIESFULLNAME')?>, &nbsp;&nbsp;&nbsp;<?=$this->session->userdata(base_url().'FOODIESMOBILENO')?></p>
                      
                      <input type="hidden" name="orderingforname" id="orderingforname" value="<?=$this->session->userdata(base_url().'FOODIESFULLNAME')?>">
                      <input type="hidden" name="orderingformobileno" id="orderingformobileno" value="<?=$this->session->userdata(base_url().'FOODIESMOBILENO')?>">
                      
                      <p class="service-heading">Your oder</p>
                      <?php if(!empty($cart_items_array)){ 
                        foreach($cart_items_array as $_cart){
                          if($_cart['type']==2){ ?>
                            <div class="product-information class_cart_items noofcartitems" id="id_cart_items<?=$_cart['typeid']?>">
                              <div class="left-part-side">
                                <div class="img-container">
                                    <img src="<?=MENU.$_cart['menuimage']?>" alt="<?=$_cart['menuimage']?>" class="img-fluid">
                                </div>
                                <div class="name-price">
                                    <p class="product-name"><?=$_cart['name']?></p>
                                    <p class="meal-type"><?php 
                                          if($_cart['cuisinetype']==0){
                                              echo "South Indian";
                                          }else if($_cart['cuisinetype']==1){
                                              echo "North Indian";
                                          }else if($_cart['cuisinetype']==2){
                                              echo "Other Indian";
                                          } ?>
                                    </p>
                                    <p class="product-cost">₹<?=$_cart['price']?></p>
                                    <p class="date-time"><?=$this->general_model->convertdate($_cart['createddate'], 'd M Y h:i A')?></p>
                                </div>
                                <div class="clearfix"></div> 
                              </div>
                              <div class="right-part-side">
                                  <div class="btn-container1">
                                      <button type="button" class="remove-meal" id="removemeal<?=$_cart['typeid']?>" style="<?=($_cart['quantity']<=0)?"display:none;":""?>">-</button>
                                      <input type="button" name="quantity[]" value="<?=$_cart['quantity']?>" class="mealcount" id="mealcount<?=$_cart['typeid']?>" onkeypress="return isNumeric(event)">
                                      <button type="button" class="add-meal" id="addmeal<?=$_cart['typeid']?>">+</button>
                                  </div>
                                  <p class="total-cost" id="txt_total_menu_price<?=$_cart['typeid']?>">₹<?=number_format(($_cart['quantity']*$_cart['price']),2,'.',',')?></p>
                                  
                                  <input type="hidden" id="cart_id<?=$_cart['typeid']?>" value="<?=$_cart['id']?>">
                                  <input type="hidden" name="kitchen_id[]" id="kitchen_id<?=$_cart['typeid']?>" value="<?=$_cart['kitchen_id']?>">
                                  <input type="hidden" name="mealplan[]" value="<?=$_cart['type']?>">
                                  <input type="hidden" name="reference_id[]" value="<?=$_cart['typeid']?>">
                                  <input type="hidden" name="cuisinetype[]" value="<?=$_cart['cuisinetype']?>">
                                  
                                  <input type="hidden" name="item_name[]" id="tm_itemname<?=$_cart['typeid']?>" value="<?=$_cart['name']?>">
                                  <input type="hidden" name="item_price[]" id="tm_itemprice<?=$_cart['typeid']?>" value="<?=$_cart['price']?>">
                                  
                                  <input type="hidden" name="delivery_startdate[]" value="">
                                  <input type="hidden" name="delivery_enddate[]" value="">
                                  <input type="hidden" name="delivery_fromtime[]" value="">
                                  <input type="hidden" name="delivery_totime[]" value="">
                                  
                                  <input type="hidden" name="total_amount[]" class="total_menu_price" id="total_menu_price<?=$_cart['typeid']?>" value="<?=($_cart['quantity']*$_cart['price'])?>">
                              </div>
                            </div>
                          <?php }else{ ?>
                            <div class="noofcartitems">
                              <input type="hidden" name="kitchen_id[]" id="kitchen_id<?=$_cart['typeid']?>" value="<?=$_cart['kitchen_id']?>">
                              <input type="hidden" name="mealplan[]" value="<?=$_cart['type']?>">
                              <input type="hidden" name="reference_id[]" value="<?=$_cart['typeid']?>">
                              <input type="hidden" name="cuisinetype[]" value="<?=$_cart['cuisinetype']?>">
                              <input type="hidden" name="item_name[]" id="pkg_name<?=$_cart['typeid']?>" value="<?=$_cart['name']?>">
                              <input type="hidden" name="item_price[]" id="pkg_price<?=$_cart['typeid']?>" value="<?=$_cart['price']?>">
                              <input type="hidden" class="total_menu_price" name="total_amount[]" id="pkg_amount<?=$_cart['typeid']?>" value="<?=$_cart['price']?>">

                              <input type="hidden" name="delivery_startdate[]" value="<?=$_cart['fromdate']?>">
                              <input type="hidden" name="delivery_enddate[]" value="<?=$_cart['todate']?>">
                              <input type="hidden" name="delivery_fromtime[]" value="<?=$_cart['delivery_fromtime']?>">
                              <input type="hidden" name="delivery_totime[]" value="<?=$_cart['delivery_totime']?>">

                              <div class="package-name-cost">
                                  <div class="package-name-section">
                                      <div class="img-container">
                                          <img src="" alt="" class="img-fluid">
                                      </div>
                                      <p class="package-heading"><?=$_cart['name']?></p>
                                  </div>
                                  <p class="package-cost">₹<?=number_format($_cart['price'],2,'.',',')?></p>
                                  <div class="clearfix"></div>
                              </div>
                              <p class="meal-type2"><?php 
                                if($_cart['cuisinetype']==0){
                                    echo "South Indian";
                                }else if($_cart['cuisinetype']==1){
                                    echo "North Indian";
                                }else if($_cart['cuisinetype']==2){
                                    echo "Other Indian";
                                } ?>
                              </p>

                              <?php if($_cart['including_saturday']==1 || $_cart['including_sunday']==1){ ?>
                                <p class="weekend"><span class="cementgray">Including</span> 
                                  <?php if($_cart['including_saturday']==1){
                                      echo ($_cart['including_sunday']==1)?"Saturday, ":"Saturday";
                                  }
                                  if($_cart['including_sunday']==1){
                                      echo "Sunday";
                                  } ?>
                                </p>
                              <?php } ?>
                              <p class="package-days">
                                  <?php if($_cart['fromdate'] == $_cart['todate']){
                                    echo date("d M", strtotime($_cart['fromdate']));
                                  }else{
                                    echo date("d M", strtotime($_cart['fromdate'])).' to '.date("d M Y", strtotime($_cart['todate']));   
                                  } ?> at <?=date("h:i A", strtotime($_cart['delivery_fromtime']))?></p>
                            </div>
                          <?php }
                        }
                      } ?>
                        
                      <br><br>
                      
                       
                      <div class="discount-section">
                          <!---->
                          <div class="inputLabel form-group">
                    <input type="text" class="off" id="offercode" name="offercode" placeholder="Enter Offer Code" style="border-top: 0;border-left: 0;border-right: 0;">
                    <a href="javascript:void(0)" class="btn-apply" onclick="check_offer_code(<?=$kitchendata['id']?>)">APPLY</a>
                    </div>
                    
                          <div class="clearfix"></div>
                      </div>
                      <div class="taxes-section">
                          <p class="taxes">Taxes</p>
                          <p class="tax-ammount" id="txt_tax_amount">₹0</p>
                          <div class="clearfix"></div>
                      </div>
                      <div class="delivery-section">
                          <p class="delivery-charges-heading">Delivery Charges</p>
                          <p class="delivery-charge" id="txt_delivery_charge">₹<?=DELIVERY_CHARGE_PER_KM?></p>
                          <div class="clearfix"></div>
                      </div>
                      <div class="coupon-section">
                          <p class="coupon-heading">Coupon</p>
                          <p class="coupon-ammount" id="txt_coupon_ammount">₹0</p>
                          <div class="clearfix"></div>
                      </div>
                      <div class="total-amount-section">
                          <p class="amount-heading">Total</p>
                          <p class="total-amount" id="txt_sub_total">₹40</p>

                          <input type="hidden" name="tax" id="tax" value="<?=TAX_ON_ORDER?>">
                          <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                          <input type="hidden" id="delivery_charge_per_km" value="<?=DELIVERY_CHARGE_PER_KM?>">
                          <input type="hidden" name="delivery_charge" id="delivery_charge" value="<?=DELIVERY_CHARGE_PER_KM?>">
                          <input type="hidden" name="coupon_ammount" id="coupon_ammount" value="0">
                          <input type="hidden" name="sub_total" id="sub_total" value="">
                      </div>
                      <div class="border-dashed-bottom border-color-yellow margin-top35"></div>
                      
                      <!-- Prathap Edit button-->
                      <div class="right-part">
                          <!--<div class="img-container">-->
                          <!--    <img src="<?=FRONT_IMAGES_URL?>Group10635.png" alt="" class="img-fluid">-->
                          <!--</div>-->
                          <div class="btn-container">
                            <a href="javascript:void(0)" class="btn-checkout" id="btn-checkout" onclick="checkout()">Checkout</a> 
                          </div>
                      </div>
                      
                      <!-- Prathap Edited button-->
                      
                  </div>
              </div>
            </form>
            <form id="payment_form" action="<?=FRONT_URL?>checkout/payment" method="post" style="display: none;">
            </form>
            <?php }else{ ?>
              <div class="checkout-cart-section-container">
                <div style="background-color: white;padding: 130px;width: 100%;">
                  No any items available in cart. 
                </div>
              </div>
            <?php } ?>
        </div>
    </div>  
</div>

<!-- Booking Confirm Dialog Box --->
<div class="booking-confirm-modal modal fade" id="booking-confirm-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn-close-container">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"><img src="<?=FRONT_IMAGES_URL?>Group3314.png" alt="" class="img-fluid"></span>
                    </button>
                </div>    
            </div>
            <div class="modal-body">
                <div class="rate-experience-container">
                    <div class="rate-experience-content">
                        <p class="heading">Please rate your experience with NOHUNG</p>
                        <p class="sub-heading">Order ID 123456 | Ameya Reddy</p>
                        <div class="rating">
                            <input type="radio" name="star" id="star1"><label for="star1"><img src="<?=FRONT_IMAGES_URL?>sad1.png" alt="" class="img-fluid"></label>
                            <input type="radio" name="star" id="star2"><label for="star2"><img src="<?=FRONT_IMAGES_URL?>sad2.png" alt="" class="img-fluid"></label>
                            <input type="radio" name="star" id="star3"><label for="star3"><img src="<?=FRONT_IMAGES_URL?>smile.png" alt="" class="img-fluid"></label>
                            <input type="radio" name="star" id="star4"><label for="star4"><img src="<?=FRONT_IMAGES_URL?>happy.png" alt="" class="img-fluid"></label>
                            <input type="radio" name="star" id="star5" checked><label for="star5"><img src="<?=FRONT_IMAGES_URL?>Group10548.png" alt="" class="img-fluid"></label>
                         </div>
                        <p class="tellus">Tell us more so we can improve</p>
                        <textarea class="tellus-text"></textarea>
                        <div class="recommend-other">
                            <div class="left-part-side">
                                <p class="heading">Recommend to others</p>
                                <div class="yesno-btn">
                                    <div class="btn-container">
                                        <input type="radio" name="yesno" id="yes" checked><label for="yes"><img src="<?=FRONT_IMAGES_URL?>positivevote.png" alt="" class="img-fluid"><span>Yes</span></label>
                                    </div>
                                    <div class="btn-container">
                                        <input type="radio" name="yesno" id="no"><label for="no"><img src="<?=FRONT_IMAGES_URL?>negativevote.png" alt="" class="img-fluid" alt=""><span>No</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="right-part-side">
                               <div class="btn-container">
                                   <a href="#" class="btn-submit">Submit</a>
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
<div id="ordering-for-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5>Ordering For Detail</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6" style="padding-right: 5px;">
            <div class="form-group row">
              <div class="col-md-12">
                <label for="modal_ord_for_name">Name</label>
                <input type="text" id="modal_ord_for_name" class="form-control">
                <span id="modal_ord_for_name_error" style="color: red;font-size: 12px;"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6" style="padding-left: 5px;">
            <div class="form-group row">
              <div class="col-md-12">
                <label for="modal_ord_for_mobile">Mobile No.</label>
                <input type="text" id="modal_ord_for_mobile" class="form-control" onkeypress="return isNumeric(event)">
                <span id="modal_ord_for_mobile_error" style="color: red;font-size: 12px;"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="check_order_for_detail()">Save Changes</button>
      </div>
    </div>

  </div>
</div>

