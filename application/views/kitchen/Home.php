<section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-info">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6">
                            <h1>
                                Let's explore tables at all your favourite restaurants
                            </h1>
                            <!-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est ducimus quod beatae mollitia eius atque aliquid labore ipsam tempora debitis, odio eos corrupti explicabo laudantium voluptas velit libero provident amet!</p> -->
                            <p><a href="<?=FRONT_URL?>get-started" style="color: #fff;font-size: 20px;">Fill in more info here</a></p>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-6">
                            <form action="" class="ban-frm">
                                <h3 class="text-center ">Reservations</h3>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Guest</label>
                                            <span class="down"><i class="fas fa-angle-down"></i></span>
                                            <select class="selectpicker" name="people" id="people">
                                                <option>Select People</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
                                                <option>10</option>
                                                <option>11</option>
                                                <option>12</option>
                                                <option>13</option>
                                                <option>14</option>
                                                <option>15</option>
                                                <option>16</option>
                                                <option>17</option>
                                                <option>18</option>
                                                <option>19</option>
                                                <option>20</option>
                                                <option>21</option>
                                                <option>22</option>
                                                <option>23</option>
                                                <option>24</option>
                                                <option>25</option>
                                                <option>26</option>
                                                <option>27</option>
                                                <option>28</option>
                                                <option>29</option>
                                                <option>30</option>
                                                <option>31</option>
                                                <option>32</option>
                                                <option>33</option>
                                                <option>34</option>
                                                <option>35</option>
                                                <option>36</option>
                                                <option>37</option>
                                                <option>38</option>
                                                <option>39</option>
                                                <option>40</option>
                                                <option>41</option>
                                                <option>42</option>
                                                <option>43</option>
                                                <option>44</option>
                                                <option>45</option>
                                                <option>46</option>
                                                <option>47</option>
                                                <option>48</option>
                                                <option>49</option>
                                                <option>50</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date</label>
                                            <span class="down"><i class="fas fa-angle-down"></i></span>
                                            <input type="text" class="form-control" name="date" id="date" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Time</label>
                                            <span class="down"><i class="fas fa-angle-down"></i></span>
                                            <div class='input-group date' id='timepicker'>
                                                <input type="text" class="form-control" name="time" id="time" value="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Location</label>
                                            <span class="down"><i class="fas fa-angle-down"></i></span>
                                            <input type="text" class="form-control" name="location" id="location" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <a href="#" class="login-btn ban-frmbtn">
                                        Let's Go
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(!empty($recommendedrestaurants)){ ?>
<section class="recommend">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Recommended Restaurants</h2>
            </div>
        </div>
        <div class="hotels-info">
            <div class="row">
                <?php foreach($recommendedrestaurants as $rr){ ?>
                <div class="col-lg-3 col-sm-3 col-md-3">
                    <div class="hotel-img">
                        <a href="javascript:void(0)">
                            <img src="<?=($rr['image']!="" && file_exists(RESTAURANT_PATH.$rr['image'])?RESTAURANT.$rr['image']:FRONT_URL."assets/images/r-img.png")?>" class="w-100" alt="">
                            <div class="overlay">
                                <h5><?=$rr['restaurantname']?>
                                    <span class="float-right"><i class="fas fa-star"></i> 4.7</span>
                                </h5>
                                <p>
                                    <img src="<?=FRONT_URL?>assets/images/map-m.svg" alt=""> <?=$rr['restaurantcity']?>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php } ?>
                <!-- <div class="col-lg-3 col-sm-3 col-md-3">
                    <div class="hotel-img">
                        <a href="#">
                            <img src="<?=FRONT_URL?>assets/images/r-img.png" class="w-100" alt="">
                            <div class="overlay">
                                <h5>Seasons Tea Lounge
                                    <span class="float-right"><i class="fas fa-star"></i> 4.7</span>
                                </h5>
                                <p>
                                    <img src="<?=FRONT_URL?>assets/images/map-m.svg" alt=""> Abu Dhabi
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3">
                    <div class="hotel-img">
                        <a href="#">
                            <img src="<?=FRONT_URL?>assets/images/r-img.png" class="w-100" alt="">
                            <div class="overlay">
                                <h5>Seasons Tea Lounge
                                    <span class="float-right"><i class="fas fa-star"></i> 4.7</span>
                                </h5>
                                <p>
                                    <img src="<?=FRONT_URL?>assets/images/map-m.svg" alt=""> Abu Dhabi
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3">
                    <div class="hotel-img">
                        <a href="#">
                            <img src="<?=FRONT_URL?>assets/images/r-img.png" class="w-100" alt="">
                            <div class="overlay">
                                <h5>Seasons Tea Lounge
                                    <span class="float-right"><i class="fas fa-star"></i> 4.7</span>
                                </h5>
                                <p>
                                    <img src="<?=FRONT_URL?>assets/images/map-m.svg" alt=""> Abu Dhabi
                                </p>
                            </div>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<?php } ?>

<section class="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>Customer Review</h3>
                <div class="testimonial-slider">
                    <div class="owl-carousel testi-slider owl-theme owl-loaded">
                        <div class="owl-stage-outer">
                            <div class="owl-stage">
                                <div class="owl-item">
                                    <div class="testi-box">
                                        <div class="star">

                                            <img src="<?=FRONT_URL?>assets/images/star.svg" alt="">
                                        </div>
                                        <div class="testi-title">
                                            <div class="float-left">
                                                <i class="fas fa-quote-left"></i>
                                            </div>
                                            <div class="float-right">
                                                <h6>Smart Guide</h6>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="testi-info">
                                            <p>Excellent service, can't wait to come again!</p>
                                        </div>
                                        <div class="arrow-down"></div>
                                    </div>
                                    <div class="testi-user">
                                        <div class="user-info">
                                            <div class="user-img">
                                                <img src="<?=FRONT_URL?>assets/images/user.png" alt="">
                                            </div>
                                            <div class="user-title">
                                                <h5>Alex Velvin</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item">
                                    <div class="testi-box">
                                        <div class="star">

                                            <img src="<?=FRONT_URL?>assets/images/star.svg" alt="">
                                        </div>
                                        <div class="testi-title">
                                            <div class="float-left">
                                                <i class="fas fa-quote-left"></i>
                                            </div>
                                            <div class="float-right">
                                                <h6>Smart Guide</h6>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="testi-info">
                                            <p>Amazing food, thank you!</p>
                                        </div>
                                        <div class="arrow-down"></div>
                                    </div>
                                    <div class="testi-user">
                                        <div class="user-info">
                                            <div class="user-img">
                                                <img src="<?=FRONT_URL?>assets/images/user.png" alt="">
                                            </div>
                                            <div class="user-title">
                                                <h5>Tom McGreal</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item">
                                    <div class="testi-box">
                                        <div class="star">

                                            <img src="<?=FRONT_URL?>assets/images/star.svg" alt="">
                                        </div>
                                        <div class="testi-title">
                                            <div class="float-left">
                                                <i class="fas fa-quote-left"></i>
                                            </div>
                                            <div class="float-right">
                                                <h6>Smart Guide</h6>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="testi-info">
                                            <p>Lovely food and better people!</p>
                                        </div>
                                        <div class="arrow-down"></div>
                                    </div>
                                    <div class="testi-user">
                                        <div class="user-info">
                                            <div class="user-img">
                                                <img src="<?=FRONT_URL?>assets/images/user.png" alt="">
                                            </div>
                                            <div class="user-title">
                                                <h5>Emily Gallagher</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</section>