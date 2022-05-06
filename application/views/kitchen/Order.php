<script>
    var PER_PAGE_ORDER = '<?= PER_PAGE_ORDER ?>';
</script>
<div class="offerManagementWrap">
    <div class="offermanageTopHeading">
        <h2>Orders Management</h2>
        <!-- <a href=""> <img src="assets/images/OfferManagement_icons.svg" alt=""> Add Offer</a> -->
    </div>
</div>

<div class="managementTabSection">
    <div class="tabContentManagement">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?= ($opentab == "" ? "active" : "") ?>" data-toggle="tab" href="#OrderRequests" role="tab">Order Requests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($opentab == "active-orders" ? "active" : "") ?>" data-toggle="tab" href="#ActiveOrders" role="tab">Active Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#UpcomingOrders" role="tab">Upcoming Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($opentab == "order-history" ? "active" : "") ?>" data-toggle="tab" href="#OrderHistory" role="tab">Order History</a>
            </li>
        </ul>
        <div class="managementFilterSection">
            <button><img src="<?php echo KITCHEN_IMAGES_URL ?>filter.svg" alt=""></button>
            <form action="" id="search_order_form">
                <img src="<?php echo KITCHEN_IMAGES_URL ?>search-inner.svg">
                <input id="search" type="text" placeholder="search...">
            </form>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane <?= ($opentab == "" ? "active" : "") ?>" id="OrderRequests" role="tabpanel">
            <div class="orderManagementCotents">
                <div class="row" id="orlist"></div>
                <div class="or load_more_btn" style="display:none;">
                    <a href="javascript:void(0)" onclick="load_order_requests()">load more</a>
                </div>
            </div>
        </div>
        <div class="tab-pane <?= ($opentab == "active-orders" ? "active" : "") ?>" id="ActiveOrders" role="tabpanel">
            <div class="orderManagementCotents">
                <div class="row" id="aolist"></div>
                <div class="ao load_more_btn" style="display:none;">
                    <a href="javascript:void(0)" onclick="load_active_orders()">load more</a>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="UpcomingOrders" role="tabpanel">
            <div class="orderManagementCotents">
                <div class="row" id="uolist"></div>
                <div class="uo load_more_btn" style="display:none;">
                    <a href="javascript:void(0)" onclick="load_upcoming_orders()">load more</a>
                </div>
            </div>
        </div>
        <div class="tab-pane <?= ($opentab == "order-history" ? "active" : "") ?>" id="OrderHistory" role="tabpanel">
            <div class="orderManagementCotents">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="salesSummarySection">
                            <img src="<?php echo KITCHEN_IMAGES_URL ?>kitchen.svg" alt="">
                            <div class="summaryContent">
                                <span>Sales Summary</span>
                                <h3>Today, <?= date('d M\'Y', strtotime(date("Y-m-d"))) ?> <img src="<?php echo KITCHEN_IMAGES_URL ?>calendar_icons.svg" alt=""> </h3>
                            </div>
                            <ul>
                                <li>
                                    <p><?= $count_pending_orders ?></p>
                                    <span>Booked</span>
                                </li>
                                <li>
                                    <p><?= $count_active_orders ?></p>
                                    <span>Paid</span>
                                </li>
                                <li>
                                    <p><?= $count_cancelled_orders ?></p>
                                    <span>Cancelled</span>
                                </li>
                            </ul>
                            <div class="totalsalesSection">
                                <img src="<?php echo KITCHEN_IMAGES_URL ?>delivery-money-bag-food-hamburger-payment.svg" alt="">
                                <div class="salesTotalcontent">
                                    <h4>Total Sales</h4>
                                    <span><?= number_format($total_sales, 2, '.', ',') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="ProjectedTomorrowSection">
                            <div class="TomorrowProjectContent">
                                <span><?= number_format($projected_sales_tomorrow, 2, '.', ',') ?></span>
                                <p>Projected Sales for Tomorrow</p>
                            </div>
                            <img src="<?php echo KITCHEN_IMAGES_URL ?>Flat.svg" alt="">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="orderManagementCotents orderHistorySection">
                            <div class="row" id="ohlist"></div>
                            <div class="oh load_more_btn" style="display:none;">
                                <a href="javascript:void(0)" onclick="load_order_history()">load more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>