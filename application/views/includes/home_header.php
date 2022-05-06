<div class="topHeaderSection" id="myHeader">
    <div class="logoSection">
        <a href="<?= FRONT_URL ?>">
            <img src="<?= FRONT_URL ?>assets/images/logo.svg" alt="logo">
        </a>
    </div>
    <div class="HeaderButtons">
        <ul>
            <li>
                <a href="<?= FRONT_URL ?>checkout" class="ShopingCart">
                    <img src="<?= FRONT_URL ?>assets/images/picnic.svg" alt="picnic">
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
<style>
    
    .sticky {
  position: fixed;
  top: 0;
  width: 100%;
  background-color:#fff;
}
</style>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>