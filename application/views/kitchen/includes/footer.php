<footer class="footer-block">
    <div class="container">
        <div class="footer-inner mb-3">
            <div class="row">
                <div class="col-lg-10 col-md-10 centerdiv text-center ">
                    <div class="newsletter">
                        <div class="newsletter-title">
                            <h3>Newsletters</h3>
                            <h6>Be the first to hear about our amazing offers</h6>
                            <form method="post" class="newfrm" id="newsletterfrm">
                                <div class="form-group input-group">
                                    <input type="text" name="newsletteremail" id="newsletteremail" class="form-control" placeholder="Enter Email Address">
                                    <div class="input-group-append">
                                        <button class="btn login-btn" type="submit">Subscribe Now</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <span class="col-md-12 text-left" id="newslettererror" style="color: red;"></span>
                                </div>
                            </form>
                        </div>
                                </div>
                            </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 ">
                    <div class="info">
                        <div class="footer-title">
                            <h5 class="mb-3">About Us</h5>
                        </div>
                        <div class="footer-content">
                            <p><?=substr(strip_tags($aboutuscontent['description']),0,300)?></p>
                        </div>
                        <ul class="ftr-social-link">
                            <li><a href="https://www.facebook.com/notioninfosoft"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://g.page/notion-infosoft?gm"><i class="fab fa-google"></i></a></li>
                            <li><a href="https://linkedin.com/company/notion-infosoft"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 push-lg-4">
                    <div class="footer-links">
                        <div class="footer-title">
                            <h5 class="mb-3">Quick LInks</h5>
                        </div>
                        <ul class="ftr-list">
                            <li><a href="<?=FRONT_URL?>">Home</a></li>
                            <li><a href="<?=FRONT_URL?>about-us">About</a></li>
                            <li><a href="<?=FRONT_URL?>">Service</a></li>
                            <li><a href="<?=FRONT_URL?>contact-us">Contact</a></li>
                            <li><a href="<?=FRONT_URL?>privacy-policy">Privacy Policy</a></li>
                            <li><a href="<?=FRONT_URL?>terms-of-use">Terms & Condition</a></li>
                            <li><a href="<?=FRONT_URL?>faqs">FAQs</a></li>
                            <li><a href="<?=FRONT_URL?>get-started">Get Started</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="footer-showcase">
                        <div class="footer-title">
                            <h5 class="mb-3">Gallery</h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6  pr-0">
                                <div class="footer-photo mb-2">
                                    <a href="#">
                                        <img src="<?=FRONT_URL?>assets/images/foot-img.png" class="w-100" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 pr-0 col-md-6">
                                <div class="footer-photo">
                                    <a href="#">
                                        <img src="<?=FRONT_URL?>assets/images/foot-img.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 pr-0 col-md-6">
                                <div class="footer-photo">
                                    <a href="#">
                                        <img src="<?=FRONT_URL?>assets/images/foot-img.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 pr-0 col-md-6">
                                <div class="footer-photo">
                                    <a href="#">
                                        <img src="<?=FRONT_URL?>assets/images/foot-img.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 pr-0 col-md-6">
                                <div class="footer-photo">
                                    <a href="#">
                                        <img src="<?=FRONT_URL?>assets/images/foot-img.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 pr-0 col-md-6">
                                <div class="footer-photo">
                                    <a href="#">
                                        <img src="<?=FRONT_URL?>assets/images/foot-img.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="copyright text-center">
                    <p>&copy; <?=date('Y')?> <?=SITE_NAME?> all rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>