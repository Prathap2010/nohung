<div class="dashbaordHeaderSection">
    <div class="dashboardHeaderLeftside">
        <div class="toggleButtons">
            <button id="MenuToggleButton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 19"><defs><style>.a{opacity:0.6;}.b{fill:#444341;}</style></defs><g class="a"><rect class="b" width="20" height="3" rx="1.5"/><rect class="b" width="15" height="3" rx="1.5" transform="translate(0 8)"/><rect class="b" width="25" height="3" rx="1.5" transform="translate(0 16)"/></g></svg>
            </button>
        </div>
        <!-- <div class="headerSearchBox">
            <form action="">
                <svg xmlns="http://www.w3.org/2000/svg" width="18.996" height="19" viewBox="0 0 18.996 19"><path class="a" d="M18.866,18.021l-4.614-4.614a8.1,8.1,0,1,0-.8.8l4.614,4.614a.572.572,0,0,0,.4.169.555.555,0,0,0,.4-.169.569.569,0,0,0,0-.8ZM1.186,8.1a6.959,6.959,0,1,1,6.96,6.964A6.959,6.959,0,0,1,1.186,8.1Z" transform="translate(-0.035 0.01)"/></svg>
                <input type="text" class="form-control" placeholder="type here to search...">
            </form>
        </div> -->
    </div>
    <div class="dashboardHeaderRightSide">
        <div class="headerAddMenuButton">
            <button onclick="window.location.href=SITE_URL+'menu/add-menu'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.329" height="17.9" viewBox="0 0 16.329 17.9"><defs><style>.a{fill:#fff;}</style></defs><path class="a" d="M93.941,107.837c-.989,0-1.7,1.4-1.7,2.749a2.3,2.3,0,0,0,1.232,2.268v5.588a.476.476,0,1,0,.936,0v-5.588a2.3,2.3,0,0,0,1.232-2.268C95.641,109.231,94.924,107.837,93.941,107.837Zm0,3.969c-.45,0-.764-.5-.764-1.221,0-.856.427-1.618.764-1.618s.764.762.764,1.618C94.705,111.3,94.391,111.806,93.941,111.806Z" transform="translate(-90.064 -104.472)"/><path class="a" d="M22.982,17.9H38.263a.524.524,0,0,0,.524-.524V.524A.524.524,0,0,0,38.263,0H33.081a2.981,2.981,0,0,0-2.458,1.3A2.981,2.981,0,0,0,28.165,0H22.982a.524.524,0,0,0-.524.524V17.375A.524.524,0,0,0,22.982,17.9Zm10.1-16.851h4.658v15.8H31.147V2.982A1.936,1.936,0,0,1,33.081,1.049Zm-9.574,0h4.658A1.936,1.936,0,0,1,30.1,2.982V16.851H23.507Z" transform="translate(-22.458)"/><path class="a" d="M301.468,105.74h3.075a.468.468,0,0,0,.468-.468V102.2a.468.468,0,0,0-.468-.468h-3.075a.468.468,0,0,0-.468.468v3.075A.468.468,0,0,0,301.468,105.74Zm.468-3.075h2.139V104.8h-2.139Z" transform="translate(-290.554 -98.044)"/><path class="a" d="M301.468,261.207h3.075a.468.468,0,1,0,0-.936h-3.075a.468.468,0,1,0,0,.936Z" transform="translate(-290.554 -251.111)"/><path class="a" d="M301.468,321.207h3.075a.468.468,0,0,0,0-.936h-3.075a.468.468,0,1,0,0,.936Z" transform="translate(-290.554 -308.999)"/><path class="a" d="M301.468,381.207h3.075a.468.468,0,0,0,0-.936h-3.075a.468.468,0,1,0,0,.936Z" transform="translate(-290.554 -366.888)"/></svg>
                <span>Add Menu</span>
            </button>
        </div>
        <!-- <div class="headerNotitications">
            <button>
                <span></span>
                <img src="<?= KITCHEN_IMAGES_URL?>notificationbell.svg" alt="">
            </button>
        </div> -->
        <div class="headerUserName dropdown">
            <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="userImgSection">
                    <?php if($this->session->userdata(base_url().'FRONTKITCHENPROFILEIMAGE')!="" && file_exists(USER_PROFILE_PATH.$this->session->userdata(base_url().'FRONTKITCHENPROFILEIMAGE'))) { ?>
                        <img src="<?=USER_PROFILE.$this->session->userdata(base_url().'FRONTKITCHENPROFILEIMAGE')?>" class="thumbwidth">
                    <?php } else{ ?>
                        <img src="<?= NOPROFILEIMAGE ?>" alt="">
                    <?php } ?>
                </div>
                <div class="userInformSection">
                    <h4><?=$this->session->userdata(base_url().'FRONTKITCHENNAME')?></h4>
                    <span><?=$this->session->userdata(base_url().'FRONTKITCHENADDRESS')?></span>
                </div>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 1.6rem;">
                <!-- <a class="dropdown-item" href="<?=KITCHEN_URL?>">Profile</a> -->
                <a class="dropdown-item" href="<?=KITCHEN_URL?>my-account">My Account</a>
                <a class="dropdown-item" href="<?=KITCHEN_URL?>logout">Logout</a>
            </div>
        </div>
    </div>
</div>