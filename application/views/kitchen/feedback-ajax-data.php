<?php if(!empty($reviews)){ ?>
    <?php foreach($reviews as $row){ ?>
        <div class="nk-review-card">
            <div class="nk-review-card-img">
                <?php if($row['customerimage']!="" && file_exists(USER_PROFILE_PATH.$row['customerimage'])) {
                    $src = USER_PROFILE.$row['customerimage'];
                }else{
                    $src = NOPROFILEIMAGE;
                }?>
                <img src="<?php echo $src; ?>" alt="Profile Image" class="img-fluid" />
            </div>
            <div class="nk-review-card-content">
                <div class="nk-review-card-header">
                    <div class="nk-review-user-detail">
                        <label class="nk-review-user-name"><?=$row['customername']?></label>
                        <ul class="nk-rating-list">
                            <li class="nk-rating-item <?=($row['rating']>=1 ? "active" : "")?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?=($row['rating']>=2 ? "active" : "")?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?=($row['rating']>=3 ? "active" : "")?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?=($row['rating']>=4 ? "active" : "")?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?=($row['rating']>=5 ? "active" : "")?>"><i class="fas fa-star"></i></li>
                        </ul>
                    </div>
                    <span class="nk-review-time"><?=(string)$this->general_model->time_Ago(strtotime($row['createddate']))?></span>
                </div>
                <div class="nk-review-card-body">
                    <p class="nk-review-description"><?=$row['message']?></p>
                    <ul class="nk-rating-type-list">
                        <li class="nk-rating-type-item">
                            <label>Food Quality</label>
                            <?php if($row['foodquality']=="1"){ ?>
                                <img src="<?php echo FRONT_URL ?>assets/images/like.png" alt="Good" class="img-fluid" />
                            <?php }else{ ?>
                                <img src="<?php echo FRONT_URL ?>assets/images/like1.png" alt="Bad" class="img-fluid" />
                            <?php } ?>
                        </li>
                        <li class="nk-rating-type-item">
                            <label>Taste</label>
                            <?php if($row['taste']=="1"){ ?>
                                <img src="<?php echo FRONT_URL ?>assets/images/like.png" alt="Good" class="img-fluid" />
                            <?php }else{ ?>
                                <img src="<?php echo FRONT_URL ?>assets/images/like1.png" alt="Bad" class="img-fluid" />
                            <?php } ?>
                        </li>
                        <li class="nk-rating-type-item">
                            <label>Quantity</label>
                            <?php if($row['quantity']=="1"){ ?>
                                <img src="<?php echo FRONT_URL ?>assets/images/like.png" alt="Good" class="img-fluid" />
                            <?php }else{ ?>
                                <img src="<?php echo FRONT_URL ?>assets/images/like1.png" alt="Bad" class="img-fluid" />
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } ?>
<?php 
}else{ ?>
    <div class="nk-review-card">
        <p>No reviews found.</p>
    </div>
<?php } ?>