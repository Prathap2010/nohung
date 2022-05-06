<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    .highcharts-credits {
        display: none;
    }

    .outerSectionLayout .rightSideSection .dashboardOtherOptions .saleOverviewSection {
        max-height: 360px;
    }
</style>
<div class="dashbaordLayout">
    <div class="commonHeading">
        <h1>Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="dashboardCard acitveColorName">
                <div class="activeOrderSection">
                    <h3><?= $count_active_orders ?></h3>
                    <p>Active Orders</p>
                </div>
                <div class="orderImgSection">
                    <img src="<?= KITCHEN_IMAGES_URL ?>activeOrderIcon.svg" alt="">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="dashboardCard upcomingOrderName">
                <div class="activeOrderSection">
                    <h3><?= $count_upcoming_orders ?></h3>
                    <p>Upcoming Orders</p>
                </div>
                <div class="orderImgSection">
                    <img src="<?= KITCHEN_IMAGES_URL ?>UpcomingOrders.svg" alt="">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="dashboardCard penddingOrderName">
                <div class="activeOrderSection">
                    <h3><?= $count_pending_orders ?></h3>
                    <p>Pending Orders</p>
                </div>
                <div class="orderImgSection">
                    <img src="<?= KITCHEN_IMAGES_URL ?>PendingOrders.svg" alt="">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="dashboardCard CompletedOrdersName">
                <div class="activeOrderSection">
                    <h3><?= $count_completed_orders ?></h3>
                    <p>Completed Orders</p>
                </div>
                <div class="orderImgSection">
                    <img src="<?= KITCHEN_IMAGES_URL ?>CompletedOrders.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboardOtherOptions">
    <div class="row">
        <div class="col-xl-6">
            <div class="saleOverviewSection">
                <div class="saleOverviewHeader">
                    <h2>Sales Overview</h2>
                    <div class="saleOverveiwRightSide">
                        <p>Total Earnings <span id="total_earning">₹</span></p>
                        <select name="earning_year" id="earning_year">
                            <?php
                            for ($i = date('Y'); $i >= 2018; $i--) { ?>
                                <option value="<?= $i ?>" <?= ($i == date('Y') ? "selected" : "") ?>><?= $i ?></option>
                            <?php } ?>
                        </select>
                        <a href="<?= KITCHEN_URL ?>order/index/order-history">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                <defs>
                                    <style>
                                        .a {
                                            fill: #fff;
                                        }
                                    </style>
                                </defs>
                                <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="saleOverviewBody">
                    <div id="sales_overview_chart" style="height: 280px; width: 100%"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="saleOverviewSection">
                <div class="saleOverviewHeader">
                    <h2>Active Orders</h2>
                    <div class="saleOverveiwRightSide">
                        <a href="<?= KITCHEN_URL ?>order/index/active-orders">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                <defs>
                                    <style>
                                        .a {
                                            fill: #fff;
                                        }
                                    </style>
                                </defs>
                                <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="activeOrdertable">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>PATIENT</th>
                                <th>Pickup Time</th>
                                <th>Rider</th>
                            </tr>
                            <?php if (!empty($recent_active_orders)) {
                                foreach ($recent_active_orders as $row) { ?>
                                    <tr>
                                        <td>
                                            <div class="userNameImg">
                                                <img src="<?= KITCHEN_IMAGES_URL ?>userImg.png" alt="">
                                                <p><?= $row['customer_name'] ?> <span></span></p>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($row['delivery_fromtime'] != "00:00:00") { ?>
                                                <button class="timingButtons"><?= date("h:i A", strtotime($row['delivery_fromtime'])) ?></button>
                                            <?php } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <div class="riderNameSection">
                                                <p><?= $row['rider_name'] ?></p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16.329" height="17.9" viewBox="0 0 16.329 17.9">
                                                    <defs>
                                                        <style>
                                                            .a {
                                                                fill: #fff;
                                                            }
                                                        </style>
                                                    </defs>
                                                    <path class="a" d="M93.941,107.837c-.989,0-1.7,1.4-1.7,2.749a2.3,2.3,0,0,0,1.232,2.268v5.588a.476.476,0,1,0,.936,0v-5.588a2.3,2.3,0,0,0,1.232-2.268C95.641,109.231,94.924,107.837,93.941,107.837Zm0,3.969c-.45,0-.764-.5-.764-1.221,0-.856.427-1.618.764-1.618s.764.762.764,1.618C94.705,111.3,94.391,111.806,93.941,111.806Z" transform="translate(-90.064 -104.472)"></path>
                                                    <path class="a" d="M22.982,17.9H38.263a.524.524,0,0,0,.524-.524V.524A.524.524,0,0,0,38.263,0H33.081a2.981,2.981,0,0,0-2.458,1.3A2.981,2.981,0,0,0,28.165,0H22.982a.524.524,0,0,0-.524.524V17.375A.524.524,0,0,0,22.982,17.9Zm10.1-16.851h4.658v15.8H31.147V2.982A1.936,1.936,0,0,1,33.081,1.049Zm-9.574,0h4.658A1.936,1.936,0,0,1,30.1,2.982V16.851H23.507Z" transform="translate(-22.458)"></path>
                                                    <path class="a" d="M301.468,105.74h3.075a.468.468,0,0,0,.468-.468V102.2a.468.468,0,0,0-.468-.468h-3.075a.468.468,0,0,0-.468.468v3.075A.468.468,0,0,0,301.468,105.74Zm.468-3.075h2.139V104.8h-2.139Z" transform="translate(-290.554 -98.044)"></path>
                                                    <path class="a" d="M301.468,261.207h3.075a.468.468,0,1,0,0-.936h-3.075a.468.468,0,1,0,0,.936Z" transform="translate(-290.554 -251.111)"></path>
                                                    <path class="a" d="M301.468,321.207h3.075a.468.468,0,0,0,0-.936h-3.075a.468.468,0,1,0,0,.936Z" transform="translate(-290.554 -308.999)"></path>
                                                    <path class="a" d="M301.468,381.207h3.075a.468.468,0,0,0,0-.936h-3.075a.468.468,0,1,0,0,.936Z" transform="translate(-290.554 -366.888)"></path>
                                                </svg>
                                                <a href="tel:+91<?= $row['rider_mobileno'] ?>">
                                                    <img src="<?= KITCHEN_IMAGES_URL ?>callingButton.svg" alt="">
                                                    </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="text-center">No any orders available.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboardSecondSection">
        <div class="row">
            <div class="col-xl-6">
                <div class="saleOverviewSection">
                    <div class="saleOverviewHeader">
                        <h2>Earning Report</h2>
                        <div class="saleOverveiwRightSide">
                            <select name="earningyear" id="earningyear">
                                <?php
                                for ($i = date('Y'); $i >= 2018; $i--) { ?>
                                    <option value="<?= $i ?>" <?= ($i == date('Y') ? "selected" : "") ?>><?= $i ?></option>
                                <?php } ?>
                            </select>
                            <select name="earningmonth" id="earningmonth">
                                <option value="1" <?= (date('m') == "01" ? "selected" : "") ?>>January</option>
                                <option value="2" <?= (date('m') == "02" ? "selected" : "") ?>>February</option>
                                <option value="3" <?= (date('m') == "03" ? "selected" : "") ?>>March</option>
                                <option value="4" <?= (date('m') == "04" ? "selected" : "") ?>>April</option>
                                <option value="5" <?= (date('m') == "05" ? "selected" : "") ?>>May</option>
                                <option value="6" <?= (date('m') == "06" ? "selected" : "") ?>>June</option>
                                <option value="7" <?= (date('m') == "07" ? "selected" : "") ?>>July</option>
                                <option value="8" <?= (date('m') == "08" ? "selected" : "") ?>>August</option>
                                <option value="9" <?= (date('m') == "09" ? "selected" : "") ?>>September</option>
                                <option value="10" <?= (date('m') == "10" ? "selected" : "") ?>>October</option>
                                <option value="11" <?= (date('m') == "11" ? "selected" : "") ?>>November</option>
                                <option value="12" <?= (date('m') == "12" ? "selected" : "") ?>>December</option>
                            </select>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                    <defs>
                                        <style>
                                            .a {
                                                fill: #fff;
                                            }
                                        </style>
                                    </defs>
                                    <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="earningbodySection">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="earningContentSection">
                                    <div class="earningProfitSection">
                                        <img src="<?= KITCHEN_IMAGES_URL ?>earningImg01.svg" alt="">
                                        <div class="profiteCount">
                                            <h2>0%</h2>
                                            <span>Profite</span>
                                        </div>
                                    </div>
                                    <h4>₹0</h4>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="earningContentSection">
                                    <div class="earningProfitSection">
                                        <img src="<?= KITCHEN_IMAGES_URL ?>earningImg02.svg" alt="">
                                        <div class="profiteCount">
                                            <h2>0%</h2>
                                            <span>Loss</span>
                                        </div>
                                    </div>
                                    <h4>₹0</h4>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="earningWeekDetails" id="earningWeekDetails">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="saleOverviewSection">
                    <div class="saleOverviewHeader">
                        <h2>Order Status</h2>
                    </div>
                    <div class="statusOrderBody">
                        <p>Click on the labels below to view the respective orders and change their status</p>
                        <ul>
                            <li>
                                <p>Preparing</p>
                                <span><?= $count_preparing_orders ?> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                        <defs>
                                            <style>
                                                .a {
                                                    fill: #fff;
                                                }
                                            </style>
                                        </defs>
                                        <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                                    </svg></span>
                            </li>
                            <li>
                                <p>Ready to be picked</p>
                                <span><?= $count_ready_to_pick_orders ?> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                        <defs>
                                            <style>
                                                .a {
                                                    fill: #fff;
                                                }
                                            </style>
                                        </defs>
                                        <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                                    </svg></span>
                            </li>
                            <li>
                                <p>Out for delivery</p>
                                <span><?= $count_out_for_delivery_orders ?> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                        <defs>
                                            <style>
                                                .a {
                                                    fill: #fff;
                                                }
                                            </style>
                                        </defs>
                                        <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                                    </svg></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="saleOverviewSection ActiveDeliveriesBox">
                    <div class="saleOverviewHeader">
                        <h2>Active Deliveries</h2>
                        <div class="saleOverveiwRightSide">
                            <a href="<?= KITCHEN_URL ?>track-deliveries">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                    <defs>
                                        <style>
                                            .a {
                                                fill: #fff;
                                            }
                                        </style>
                                    </defs>
                                    <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="ActiveDeliveriesBody">
                        <p><?= $count_active_deliveries_orders ?></p>
                        <img src="<?= KITCHEN_IMAGES_URL ?>ActiveDeliveries.svg" alt="ActiveDeliveries">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>