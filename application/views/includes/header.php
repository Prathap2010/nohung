<div class="HeaderSection <?php if (isset($headerclass)) {
                                    echo $headerclass;
                                } ?>">
    
    <div class="logoSection">
        <a href="<?= FRONT_URL ?>">
            <img src="<?= FRONT_IMAGES_URL ?>logo.svg" alt="logo" class="img-fluid">
        </a>
    </div>
    <div class="HeaderButtons">
        <ul>
            <li>
                <!-- <span class="lightbrown bold">Manish Nagar, Be...</span> -->
                <p class="text-ellipsis"><img src="<?= FRONT_IMAGES_URL ?>locationMarker.jpg" alt=""> <span class="lightbrown bold" id="foodieslocation"></span></p>
                <input type="hidden" id="cust_latitude" value="">
                <input type="hidden" id="cust_longitude" value="">
            </li>
             <li>
                <form id="search-form" method="post">
                    <span class="cementgray bold search-kitchen"><input type="text" id="search_kitchen_meals" placeholder="Search for Kitchens, Meals, etc" class="cementgray bold" style="border: 0;" autocomplete="off" value="<?= isset($search_text) ? urldecode($search_text) : "" ?>"></span>
                </form>
            </li>
            <li>
                <a href="<?= FRONT_URL ?>checkout" class="ShopingCart">
                    <img src="<?= FRONT_IMAGES_URL ?>picnic.svg" alt="picnic" class="img-fluid">
                    <span id="cart_count_header" class="<?= (!empty($cart_items_array) ? "base-count" : "") ?>"><?= (!empty($cart_items_array) ? count($cart_items_array) : "") ?></span>
                </a>
            </li>
            <?php if (empty($this->session->userdata(base_url() . 'FOODIESUSERID'))) { ?>
                <li><a href="<?= FRONT_URL ?>login" class="loginButton">Login</a></li>
                <li><a href="<?= FRONT_URL ?>register" class="signupButton">sign Up</a></li>
            <?php } else { ?>
                <li class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><?= $this->session->userdata(base_url() . 'FOODIESFULLNAME') ?></span>
                        <?php if ($this->session->userdata(base_url() . 'FOODIESPROFILEIMAGE') != "" && file_exists(USER_PROFILE_PATH . $this->session->userdata(base_url() . 'FOODIESPROFILEIMAGE'))) {
                            $src = USER_PROFILE . $this->session->userdata(base_url() . 'FOODIESPROFILEIMAGE');
                        } else {
                            $src = NOPROFILEIMAGE;
                        } ?>
                        <img src="<?= $src ?>" alt="">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?= FRONT_URL ?>my-account">My Account</a>
                        <a class="dropdown-item" href="<?= FRONT_URL ?>logout">Logout</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>