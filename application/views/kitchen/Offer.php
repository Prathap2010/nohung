<script>
    var PER_PAGE_OFFER = '<?=PER_PAGE_OFFER?>';
</script>
<div class="offerManagementWrap">
    <div class="offermanageTopHeading">
        <h2>Offer Management</h2>
        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="reset_form_modal()"> <img src="<?= KITCHEN_IMAGES_URL?>OfferManagement_icons.svg" alt=""> Add Offer</a>
    </div>
</div>

<div class="managementTabSection">
    <div class="tabContentManagement">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#LiveOffers" role="tab" id="livetabs">Live Offers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#ArchivedOffer" role="tab">Archive Offers</a>
            </li>
        </ul>
        <div class="managementFilterSection">
            <button><img src="<?= KITCHEN_IMAGES_URL?>filter.svg" alt=""></button>
            <form action="#" id="searchofferform">
                <svg xmlns="http://www.w3.org/2000/svg" width="18.996" height="19" viewBox="0 0 18.996 19">
                    <path class="a" d="M18.866,18.021l-4.614-4.614a8.1,8.1,0,1,0-.8.8l4.614,4.614a.572.572,0,0,0,.4.169.555.555,0,0,0,.4-.169.569.569,0,0,0,0-.8ZM1.186,8.1a6.959,6.959,0,1,1,6.96,6.964A6.959,6.959,0,0,1,1.186,8.1Z" transform="translate(-0.035 0.01)"></path>
                </svg>
                <input type="text" id="searchoffer" name="searchoffer" placeholder="search..." value="" autocomplete="off">
                <input type="hidden" name="searchofferid" id="searchofferid">
            </form>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="LiveOffers" role="tabpanel">
            <div class="managementOffersTabs">
                <div class="row" id="lolist">
                </div>
                <div class="lo load_more_btn" style="display:none;">
                    <a href="javascript:void(0)" onclick="get_live_offers()">load more</a>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ArchivedOffer" role="tabpanel">
            <div class="managementOffersTabs">
                <div class="row" id="aolist">
                </div>
                <div class="ao load_more_btn" style="display:none;">
                    <a href="javascript:void(0)" onclick="get_archive_offers()">load more</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal custom-modal offermodal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add an Offer</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <img src="<?= KITCHEN_IMAGES_URL?>modal-close.svg">
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="offerform" class="form-horizontal">
                    <input type="hidden" name="offerid" id="offerid">
                    <div class="form-row">
                        <div class="form-group" id="titleelement">
                            <label for="title" class="top-lbl">Offer Title *</label>
                            <input id="title" class="form-control" name="title" value="" type="text" tabindex="1">
                        </div>
                        <div class="form-group" id="ocelement">
                            <label for="offercode" class="top-lbl">Discount Code *</label>
                            <input id="offercode" class="form-control" name="offercode" value="" type="text" tabindex="1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-sub-row">
                            <div class="form-group" id="dtelement">
                                <label class="top-lbl">Discount Type</label>
                                <div class="custom-select-disc">
                                    <select id="discounttype" name="discounttype">
                                        <option value="0">Percentage</option>
                                        <option value="1">Rupees</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="diselement">
                                <label class="top-lbl">Discount Value *</label>
                                <input id="discount" class="form-control" name="discount" value="" type="text" tabindex="1">
                                <span class="disc-val">%</span>
                            </div>
                        </div>
                        
                        <div class="form-group coupon-apply">
                            <label class="top-lbl">Applies To</label>
                            <div class="package-radio three-flex">
                                <input type="radio" id="r5" name="appliesto" value="1" checked>
                                <label for="r5">Breakfast</label>

                                <input type="radio" id="r6" name="appliesto" value="2">
                                <label for="r6">Lunch</label>

                                <input type="radio" id="r7" name="appliesto" value="3">
                                <label for="r7">Dinner</label>

                                <input type="radio" id="r-all" name="appliesto" value="0">
                                <label for="r-all">All</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="top-lbl">Minimum Requirement</label>
                            <div class="package-radio three-flex">
                                <input type="radio" id="r11" name="minrequirement" value="0" checked>
                                <label for="r11">None</label>

                                <input type="radio" id="r12" name="minrequirement" value="1">
                                <label for="r12">Min. Amount</label>

                                <input type="radio" id="r13" name="minrequirement" value="2">
                                <label for="r13">Min. Items</label>
                            </div>
                        </div>
                        <div class="form-group" id="uslimitelement">
                            <label for="usagelimit" class="top-lbl">Usage Limit</label>
                            <div class="usage-limit">
                                <div class="usage-check">
                                    <input class="styled-checkbox" id="chk1" type="checkbox" value="value2" checked>
                                    <label for="chk1"><span>Limit the number of times this discount code can be used</span></label>
                                </div>
                                <input id="usagelimit" class="form-control" name="usagelimit" value="" type="text" tabindex="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-sub-row">
                            <div class="form-group calendar-custom" id="sdelement">
                                <label for="startdate" class="top-lbl">Start Date *</label>
                                    <input id="startdate" name="startdate" type="text" class="form-control" readonly>            							    
                                <span>
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M492,352c11.046,0,20-8.954,20-20V120c0-44.112-35.888-80-80-80h-26V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20
                                            v20h-91V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v20h-90V20c0-11.046-8.954-20-20-20s-20,8.954-20,20v20H80
                                            C35.888,40,0,75.888,0,120v312c0,44.112,35.888,80,80,80h352c44.112,0,80-35.888,80-80c0-11.046-8.954-20-20-20
                                            c-11.046,0-20,8.954-20,20c0,22.056-17.944,40-40,40H80c-22.056,0-40-17.944-40-40V120c0-22.056,17.944-40,40-40h25v20
                                            c0,11.046,8.954,20,20,20s20-8.954,20-20V80h90v20c0,11.046,8.954,20,20,20s20-8.954,20-20V80h91v20c0,11.046,8.954,20,20,20
                                            c11.046,0,20-8.954,20-20V80h26c22.056,0,40,17.944,40,40v212C472,343.046,480.954,352,492,352z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="125" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="299" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="386" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="125" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="125" cy="384" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="212" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="212" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="212" cy="384" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="299" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="386" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="299" cy="384" r="20"/>
                                    </g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                </svg>
                                </span>
                            </div>
                            <div class="form-group calendar-custom" id="edelement">
                                <label class="top-lbl">End Date *</label>
                                    <input id="enddate" name="enddate" type="text" class="form-control" readonly>            							    
                                <span>
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M492,352c11.046,0,20-8.954,20-20V120c0-44.112-35.888-80-80-80h-26V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20
                                            v20h-91V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v20h-90V20c0-11.046-8.954-20-20-20s-20,8.954-20,20v20H80
                                            C35.888,40,0,75.888,0,120v312c0,44.112,35.888,80,80,80h352c44.112,0,80-35.888,80-80c0-11.046-8.954-20-20-20
                                            c-11.046,0-20,8.954-20,20c0,22.056-17.944,40-40,40H80c-22.056,0-40-17.944-40-40V120c0-22.056,17.944-40,40-40h25v20
                                            c0,11.046,8.954,20,20,20s20-8.954,20-20V80h90v20c0,11.046,8.954,20,20,20s20-8.954,20-20V80h91v20c0,11.046,8.954,20,20,20
                                            c11.046,0,20-8.954,20-20V80h26c22.056,0,40,17.944,40,40v212C472,343.046,480.954,352,492,352z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="125" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="299" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="386" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="125" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="125" cy="384" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="212" cy="210" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="212" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="212" cy="384" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="299" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="386" cy="297" r="20"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <circle cx="299" cy="384" r="20"/>
                                    </g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                </svg>
                                </span>
                            </div>
                        </div>
                        <div class="form-sub-row">
                            <div class="form-group calendar-custom" id="stelement">
                                <label for="starttime" class="top-lbl">Start Time *</label>
                                <input id="starttime" name="starttime" type="time" class="form-control">            							    
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                        <path id="Path_643" data-name="Path 643" d="M2.484,2.456a7.263,7.263,0,0,1,5.6-2.4,7.263,7.263,0,0,1,5.6,2.4,7.263,7.263,0,0,1,2.4,5.6,7.263,7.263,0,0,1-2.4,5.6,7.263,7.263,0,0,1-5.6,2.4,7.263,7.263,0,0,1-5.6-2.4,7.984,7.984,0,0,1-2.4-5.6A7.263,7.263,0,0,1,2.484,2.456ZM11.6,11.6l.933-.933L9.2,7.333,8.261,3.159,8,2H6.667V8a1.21,1.21,0,0,0,.4.933.466.466,0,0,0,.267.133Z" transform="translate(0.416 0.444)" fill="none" stroke="#cfcfcf" stroke-width="1"/>
                                    </svg>                              
                                </span>
                            </div>
                            <div class="form-group calendar-custom" id="etelement">
                                <label for="endtime" class="top-lbl">End Time *</label>
                                <input id="endtime" name="endtime" type="time" class="form-control">            							    
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                        <path id="Path_643" data-name="Path 643" d="M2.484,2.456a7.263,7.263,0,0,1,5.6-2.4,7.263,7.263,0,0,1,5.6,2.4,7.263,7.263,0,0,1,2.4,5.6,7.263,7.263,0,0,1-2.4,5.6,7.263,7.263,0,0,1-5.6,2.4,7.263,7.263,0,0,1-5.6-2.4,7.984,7.984,0,0,1-2.4-5.6A7.263,7.263,0,0,1,2.484,2.456ZM11.6,11.6l.933-.933L9.2,7.333,8.261,3.159,8,2H6.667V8a1.21,1.21,0,0,0,.4.933.466.466,0,0,0,.267.133Z" transform="translate(0.416 0.444)" fill="none" stroke="#cfcfcf" stroke-width="1"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-button">
                        <button id="btn_addoffer" onclick="addoffer()" type="button">Create Offer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>