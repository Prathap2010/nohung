<div class="leftSideSection">
    <div class="dashboardLogoSection">
        <img src="<?= KITCHEN_IMAGES_URL ?>logo.svg" alt="logo" class="mainLogo">
        <img src="<?= KITCHEN_IMAGES_URL ?>cookCap.png" alt="cookCap" class="CookCap">
    </div>
    <div class="dashbaordMenu">
        <ul>
            <li>
                <a href="<?= KITCHEN_URL ?>" class="<?= (isset($page) && $page == "Dasboard" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>dasboard_icons.svg" alt="">
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>track-deliveries" class="<?= (isset($page) && $page == "Track_deliveries" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>TrackDeliveries_icon.svg" alt="">
                    <span>Track Deliveries</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>offer" class="<?= (isset($page) && $page == "Offer" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>OfferManagement_icons.svg" alt="">
                    <span>Offer Management</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>feedback" class="<?= (isset($page) && $page == "Feedback" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>FeedbackReviews_icons.svg" alt="">
                    <span>Feedback/Reviews</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>menu" class="<?= (isset($page) && $page == "Menu" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>Menu_icons.svg" alt="">
                    <span>Menu</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>package" class="<?= (isset($page) && $page == "Packages" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>Menu_icons.svg" alt="">
                    <span>Package</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>order" class="<?= (isset($page) && $page == "Order" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>Orders_icons.svg" alt="">
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="<?= KITCHEN_URL ?>payment" class="<?= (isset($page) && $page == "Payment" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>Payment_icons.svg" alt="">
                    <span>Payment</span>
                </a>
            </li>
            <!-- <li>
                <a href="<?= KITCHEN_URL ?>customer-chat" class="<?= (isset($page) && $page == "Customer_chat" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>CustomerChat_icons.svg" alt="">
                    <span>Customer Chat</span>
                </a>
            </li> -->
            <li>
                <a href="<?= KITCHEN_URL ?>admin-chat" class="<?= (isset($page) && $page == "Admin_chat" ? "active" : "") ?>">
                    <img src="<?= KITCHEN_IMAGES_URL ?>CustomerChat_icons.svg" alt="">
                    <span>Admin Chat</span>
                    <span class="badge badge-success" style="float: right;margin: 0px 10px;padding: 4px 8px;font-size: 12px;" id="count_sidebar_admin_msg"><?= (!empty($count_unread_admin_messages) ? $count_unread_admin_messages : "")?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="logoutSection">
        <a href="<?= KITCHEN_URL ?>logout">
            <img src="<?= KITCHEN_IMAGES_URL ?>logout.svg" alt="">
            <span>Logout</span>
        </a>
    </div>
</div>