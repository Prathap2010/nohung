<?php if (count($transaction_history) > 0) { ?>
    <?php foreach ($transaction_history as $row) { ?>
        <div class="col-lg-6 col-md-6">
            <div class="contentOrderManagement">
                <div class="OrderManagementHeader">
                    <div class="orderImages">
                        <?php if ($row['customerimage'] != "" && file_exists(USER_PROFILE_PATH . $row['customerimage'])) {
                            $src = USER_PROFILE . $row['customerimage'];
                        } else {
                            $src = NOPROFILEIMAGE;
                        } ?>
                        <img src="<?php echo $src; ?>" alt="Customer">
                        <div class="userNameOrdermanagement">
                            <h4><?= $row['customer_name'] ?></h4>
                            <span><?= $row['order_number'] ?> <b><?= date("F dS, Y", strtotime($row['createddate'])) ?></b></span>
                        </div>
                    </div>
                    <p>₹<?= number_format($row['amount'], 2, '.', ',') ?></p>
                </div>
                <div class="orderBodyManagement">
                    <?php
                    if ($row['ordertype'] == "package") {

                        if (($row['packagetype'] == "weekly" || $row['packagetype'] == "both") && $row['weekly_plan'] != "") {
                            $pkg_arr = explode(",", $row['weekly_plan']);
                    ?>
                            <div class="weeklyPlanFood">
                                <span>Weekly Plan</span>
                                <?php foreach ($pkg_arr as $val) { ?>
                                    <div class="weeklyPlanbreakFast">
                                        <img src="<?php echo KITCHEN_IMAGES_URL; ?>Breakfast_icons.svg" alt="">
                                        <h5><?= $val ?></h5>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }

                        if (($row['packagetype'] == "monthly" || $row['packagetype'] == "both") && $row['monthly_plan'] != "") {
                            $pkg_arr = explode(",", $row['monthly_plan']);
                        ?>
                            <div class="weeklyPlanFood">
                                <span>Monthly Plan</span>
                                <?php foreach ($pkg_arr as $val) { ?>
                                    <div class="weeklyPlanbreakFast">
                                        <img src="<?php echo KITCHEN_IMAGES_URL; ?>Breakfast_icons.svg" alt="">
                                        <h5><?= $val ?></h5>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }
                    } else if ($row['ordertype'] == "trial") { ?>
                        <div class="weeklyPlanFood">
                            <span>Trial Orders</span>
                            <div class="weeklyPlanbreakFast">
                                <img src="<?php echo KITCHEN_IMAGES_URL; ?>Breakfast_icons.svg" alt="">
                                <h5><?= $row['trial_orders'] ?></h5>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="t-card-footer">
                    <span class="t-price">₹<?= number_format($row['amount'], 2, '.', ',') ?></span>
                    <span class="t-status"><?php if ($row['transaction_status'] == "pending") {
                                                echo "Pending";
                                            } else if ($row['transaction_status'] == "success") {
                                                echo "Success";
                                            } else if ($row['transaction_status'] == "failed") {
                                                echo "Failed";
                                            } ?></span>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="col-lg-12 col-md-12">
        <div class="contentOrderManagement" style="border-radius: 8px !important;font-size: 15px;padding: 20px;">
            <?php echo "No any transaction available." ?>
        </div>
    </div>
<?php } ?>