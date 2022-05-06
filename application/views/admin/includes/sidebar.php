<div class="static-sidebar">
	<div class="sidebar">
		<div class="widget" id="widget-profileinfo">
			<div class="widget-body">
				<div class="userinfo">
					<div class="avatar">
						<?php if ($this->session->userdata[base_url() . 'USERPROFILE'] != '') { ?>
							<img src="<?php echo PROFILE . $this->session->userdata[base_url() . 'USERPROFILE']; ?>" alt="" class="img-responsive img-circle logo">
						<?php } else { ?>
							<img src="<?php echo PROFILE ?>noimage.png" alt="" class="img-responsive img-circle logo">
						<?php } ?>
					</div>
					<div class="info">
						<span class="username"><?= ucwords($this->session->userdata[base_url() . 'USERNAME']); ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="widget stay-on-collapse" id="widget-sidebar">
			<nav role="navigation" class="widget-body">
				<ul class="acc-menu">
					<li class="<?php if ($page == "Dashboard") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "dashboard"; ?>" title="Dashboard" class="withripple">
							<span class="icon">
								<i class="fa fa-home"></i>
							</span>
							<span>Dashboard</span>
						</a>
					</li>

					<li class="<?php if ($page == "Order") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "order"; ?>" title="Order" class="withripple">
							<span class="icon">
								<i class="fa fa-shopping-cart"></i>
							</span>
							<span>Order</span>
						</a>
					</li>

					<li class="<?php if ($page == "Withdraw_payment") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "withdraw-payment"; ?>" title="Rider Withdraw Payment" class="withripple">
							<span class="icon">
								<i class="fa fa-money"></i>
							</span>
							<span>Rider Withdraw Payment</span>
						</a>
					</li>
					<li class="<?php if ($page == "Kitchen_withdraw_payment") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "Kitchen-withdraw-payment"; ?>" title="Kitchen Withdraw Payment" class="withripple">
							<span class="icon">
								<i class="fa fa-money"></i>
							</span>
							<span>Kitchen Withdraw Payment</span>
						</a>
					</li>

					<li class="<?php if ($page == "Offer_management") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "offer"; ?>" title="Offer Management" class="withripple">
							<span class="icon">
								<i class="fa fa-gift"></i>
							</span>
							<span>Offer Management</span>
						</a>
					</li>

					<li class="<?php if ($page == "User" || $page == "Foodie" || $page == "Rider") {
									echo 'active open';
								} ?>">
						<a class="withripple">
							<span class="icon">
								<i class="fa fa-user"></i>
							</span>
							<span>User Management</span>
						</a>
						<ul class="acc-menu" style="display:<?php if ($page == "User" || $page == "Foodie" || $page == "Rider") {
																echo 'block';
															} else {
																echo 'none';
															} ?>">
							<li class="<?php if ($page == "User") {
											echo 'active';
										} ?>">
								<a class="withripple" href="<?php echo base_url() . ADMINFOLDER . "user"; ?>" title="Manage Kitchen">

									<span class="icon">
										<i class="fa fa-caret-right"></i>
									</span>
									<span class="ml-sm">Manage Kitchen</span>
								</a>
							</li>
							<li class="<?php if ($page == "Foodie") {
											echo 'active';
										} ?>">
								<a class="withripple" href="<?php echo base_url() . ADMINFOLDER . "foodie"; ?>" title="Manage Foodie">
									<span class="icon">
										<i class="fa fa-caret-right"></i>
									</span>
									<span class="ml-sm">Manage Foodie</span>
								</a>
							</li>
							<li class="<?php if ($page == "Rider") {
											echo 'active';
										} ?>">
								<a class="withripple" href="<?php echo base_url() . ADMINFOLDER . "rider"; ?>" title="Manage Rider">
									<span class="icon">
										<i class="fa fa-caret-right"></i>
									</span>
									<span class="ml-sm">Manage Rider</span>
								</a>
							</li>
						</ul>
					</li>

					<li class="<?php if ($page == "Feedback") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "feedback"; ?>" title="Feedback / Reviews" class="withripple">
							<span class="icon">
								<i class="fa fa-comment"></i>
							</span>
							<span>Feedback / Reviews</span>
						</a>
					</li>

					<li class="<?php if ($page == "Rider_chat") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "rider-chat"; ?>" title="Rider Chat" class="withripple">
							<span class="icon">
								<i class="fa fa-comments-o"></i>
							</span>
							<span>Rider Chat</span>
							<span class="badge badge-success pull-right mt-sm" style="background-color: #8bc34a !important;" id="count_sidebar_rider_msg"><?= (!empty($count_unread_rider_messages) ? $count_unread_rider_messages : "") ?></span>
						</a>
					</li>
					<li class="<?php if ($page == "Kitchen_chat") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "kitchen-chat"; ?>" title="Kitchen Chat" class="withripple">
							<span class="icon">
								<i class="fa fa-comments-o"></i>
							</span>
							<span>Kitchen Chat</span>
							<span class="badge badge-success pull-right mt-sm" style="background-color: #8bc34a !important;" id="count_sidebar_kitchen_msg"><?= (!empty($count_unread_kitchen_messages) ? $count_unread_kitchen_messages : "") ?></span>
						</a>
					</li>
					<li class="<?php if ($page == "Manage_content") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "manage-content"; ?>" title="Manage Content" class="withripple">
							<span class="icon">
								<i class="fa fa-file-text-o"></i>
							</span>
							<span>Manage Content</span>
						</a>
					</li>
					<li class="<?php if ($page == "Email_template") {
									echo 'active';
								} ?>">
						<a href="<?php echo base_url() . ADMINFOLDER . "email-template"; ?>" title="Email Template" class="withripple">
							<span class="icon">
								<i class="fa fa-envelope"></i>
							</span>
							<span>Email Template</span>
						</a>
					</li>
					<li class="<?php if ($page == "State" || $page == "City") {
									echo 'active open';
								} ?>">
						<a class="withripple">
							<span class="icon">
								<i class="fa fa-map-marker"></i>
							</span>
							<span>Region / Area</span>
						</a>
						<ul class="acc-menu" style="display:<?php if ($page == "State") {
																echo 'block';
															} else {
																echo 'none';
															} ?>">
							<li class="<?php if ($page == "State") {
											echo 'active';
										} ?>">
								<a class="withripple" href="<?php echo base_url() . ADMINFOLDER . "state"; ?>" title="State">
									<span class="icon">
										<i class="fa fa-caret-right"></i>
									</span>
									<span class="ml-sm">State</span>
								</a>
							</li>
							<li class="<?php if ($page == "City") {
											echo 'active';
										} ?>">
								<a class="withripple" href="<?php echo base_url() . ADMINFOLDER . "city"; ?>" title="City">
									<span class="icon">
										<i class="fa fa-caret-right"></i>
									</span>
									<span class="ml-sm">City</span>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</div>