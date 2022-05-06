<style>
    .package-main .package-body .package-card{
        margin-right: 20px;
        min-width: 31.3%;
    }
    .package-main .package-body{
        justify-content: normal;
    }
</style>
<script>
    var PER_PAGE_PACKAGE = '<?=PER_PAGE_PACKAGE?>';
    var packages = '<?=$count_packages?>';
</script>
<?php if($count_packages > 0){ ?>
    <div class="package-main">
        <div class="package-header">
            <h2>Packages</h2>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#packageModal" onclick="openpopup()">
                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 512 512" width="512" height="512"><path d="M420.614,130.293a5.818,5.818,0,0,0-5.98-5.293H348V102.41C348,52.009,306.589,11,256,11s-92,41-92,91.4V125H97.366a5.818,5.818,0,0,0-5.98,5.293L64.949,451.329A45.914,45.914,0,0,0,110.794,501H401.206a45.99,45.99,0,0,0,45.845-49.67ZM176,102.4C176,58.623,212.028,23,256,23s80,35.621,80,79.406V125H176ZM102.892,137H164v44.4a6,6,0,0,0,12,0V137H336v44.41a6,6,0,0,0,12,0V137h61.108l23.429,284H318V331.72a37.817,37.817,0,0,0,22-34.7V260.34A37.032,37.032,0,0,0,302.681,223h0A37.3,37.3,0,0,0,265,260.341v36.684a37.124,37.124,0,0,0,23,34.7V421H225V350.2a29.171,29.171,0,0,1,10.251-21.9A37.936,37.936,0,0,0,248,300.012V233.455a6,6,0,0,0-12,0V294H217V232.755a6,6,0,0,0-12,0V294H184V233.455a6,6,0,0,0-12,0v66.611a37.732,37.732,0,0,0,13.151,28.29A28.1,28.1,0,0,1,195,349.407V421H79.463ZM302.527,323A25.815,25.815,0,0,1,277,297.025V260.34a25.5,25.5,0,1,1,51,0v36.684A25.769,25.769,0,0,1,302.527,323ZM306,334.713V421h-6V334.713c1,.08,1.977.132,3,.132S305,334.793,306,334.713Zm-112.88-15.3A26.438,26.438,0,0,1,184.914,306h50.3a26.072,26.072,0,0,1-7.961,13.409A40.726,40.726,0,0,0,213,350.149V421h-6V349.355A39.678,39.678,0,0,0,193.12,319.414ZM426.214,478.032A33.641,33.641,0,0,1,401.206,489H110.794a34.015,34.015,0,0,1-33.885-36.884L78.475,433h355.05l1.566,19.116A33.843,33.843,0,0,1,426.214,478.032Z"/><path d="M112.846,453h-4.825a6,6,0,1,0,0,12h4.825a6,6,0,0,0,0-12Z"/><path d="M201.617,453H135.908a6,6,0,0,0,0,12h65.709a6,6,0,0,0,0-12Z"/></svg>
                New Package
            </a>
        </div>
        <div class="package-body" id="packagelist">
             
        </div>
        <div class="load_more_btn" style="display:none;">
            <a href="javascript:void(0)" onclick="load_packages()">load more</a>
        </div>
    </div>
<?php }else{ ?>
    <div class="noMenuAddedSection">
        <h2>Packages</h2>
        <div class="noMenuTabSection">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="AllPackages" role="tabpanel">
                    <div class="noMenuBodySection">
                        <img src="<?= KITCHEN_IMAGES_URL?>noPackage_icon.svg" alt="">
                        <h2>No packages added yet</h2>
                        <p>Look's like you, haven't made your package yet.</p>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#packageModal">Create Package</a>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
<?php } ?>
<div class="modal custom-modal" id="packageModal">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create Package</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <img src="<?= KITCHEN_IMAGES_URL?>modal-close.svg">
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="packageform" class="form-horizontal">
                    <input type="hidden" id="packageid" name="packageid">
                    <div class="form-row">
                        <div class="form-group" id="pnelement">
                            <label class="top-lbl">Package Name</label>
                            <input type="text" id="packagename" name="packagename">
                        </div>
                        <div class="form-group">
                            <label class="top-lbl">Cuisine Type</label>
                            <div class="package-radio three-flex">
                                <input type="radio" id="northindian" name="cuisinetype" value="1" checked>
                                <label for="northindian">North Indian</label>

                                <input type="radio" id="southindian" name="cuisinetype" value="0">
                                <label for="southindian">South Indian</label>

                                <input type="radio" id="othercuisine" name="cuisinetype" value="2">
                                <label for="othercuisine">Other Cuisines</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="top-lbl">Meal Type</label>
                            <div class="package-radio">
                                <input type="radio" id="veg" name="mealtype" value="0" checked>
                                <label for="veg" class="nv-radio">
                                    <span></span>
                                    Veg
                                </label>

                                <input type="radio" id="nonveg" name="mealtype" value="1">
                                <label for="nonveg" class="nv-radio2">
                                    <span></span>
                                    Non-Veg
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="top-lbl">Meal For</label>
                            <div class="package-radio three-flex">
                                <input type="radio" id="breakfast" name="mealfor" value="0" checked>
                                <label for="breakfast">Breakfast</label>

                                <input type="radio" id="lunch" name="mealfor" value="1">
                                <label for="lunch">Lunch</label>

                                <input type="radio" id="dinner" name="mealfor" value="2">
                                <label for="dinner">Dinner</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group calendar-custom" id="sdelement">
                            <label class="top-lbl">Start Date</label>
                            <input type="text" id="startdate" name="startdate" autocomplete="off">
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
                        <div class="form-group">
                            <label class="top-lbl">Plan Type</label>
                            <div class="package-checkbox">
                                <input type="checkbox" id="weekly" name="weeklyplantype" value="0" class="plantype" checked>
                                <label for="weekly">Weekly</label>

                                <input type="checkbox" id="monthly" name="monthlyplantype" value="1" class="plantype">
                                <label for="monthly">Monthly</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row toggles">
                        <div class="form-group">
                            <div class="toggle-title">Including Saturday</div>
                            <label class="switch">
                                <input type="checkbox" id="including_saturday" name="including_saturday" value="1" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <div class="toggle-title">Including Sunday</div>
                            <label class="switch">
                                <input type="checkbox" id="including_sunday" name="including_sunday" value="1" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-button">
                        <button type="button" onclick="addpackage()">
                            Set Menu
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.903" height="14" viewBox="0 0 16.903 14"><defs><style>.a{fill:#ffa451;}</style></defs><path class="a" d="M16.572,138.2h0l-5.9-5.871a1.129,1.129,0,0,0-1.593,1.6l3.961,3.942H1.129a1.129,1.129,0,1,0,0,2.258H13.04l-3.961,3.942a1.129,1.129,0,0,0,1.593,1.6l5.9-5.871h0A1.13,1.13,0,0,0,16.572,138.2Z" transform="translate(0 -132)"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
