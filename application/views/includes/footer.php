<footer>
    <div class="container">
        <div class="footerLogo" onclick="window.location.href='<?= FRONT_URL?>'">
                        <img src="<?= FRONT_IMAGES_URL ?>logo.svg" alt="logo" style="
    margin-top: -80px;
"></div>
        <div class="row">
            <div class="col-sm-12">
                <ul class="footerMenus">
                    <li>
                        <h4>COMPANY</h4>
                        <ul>
                            <?php if(!empty($company_section_content)){
                                foreach($company_section_content as $row){ ?>
                                    <li><a href="<?=FRONT_URL.'manage-content/'.$row['slug']?>"><?=strtoupper($row['title'])?></a></li>
                            <?php }
                            }?>
                        </ul>
                    </li>
                    <li>
                        <h4>FOR FOODIES</h4>
                        <ul>
                            <?php if(!empty($forfoodies_section_content)){
                                foreach($forfoodies_section_content as $row){ ?>
                                    <li><a href="<?=FRONT_URL.'manage-content/'.$row['slug']?>"><?=strtoupper($row['title'])?></a></li>
                            <?php }
                            }?>
                        </ul>
                    </li>
                    <li>
                        <h4>FOR KITCHENS</h4>
                        <ul>
                            <li><a href="<?=KITCHEN_URL.'register'?>">ADD KITCHEN</a></li>
                            <li><a href="<?=KITCHEN_URL?>">KITCHEN APP</a></li>
                            <?php if(!empty($forkitchen_section_content)){
                                foreach($forkitchen_section_content as $row){ ?>
                                    <li><a href="<?=FRONT_URL.'manage-content/'.$row['slug']?>"><?=strtoupper($row['title'])?></a></li>
                            <?php }
                            }?>
                        </ul>
                    </li>
                    <li>
                        <h4>FOR RIDERS</h4>
                        <ul>
                            <li><a href="<?=FRONT_URL?>">ADD RIDER</a></li>
                            <li><a href="<?=FRONT_URL?>">RIDER APP</a></li>
                            <?php if(!empty($forrider_section_content)){
                                foreach($forrider_section_content as $row){ ?>
                                    <li><a href="<?=FRONT_URL.'manage-content/'.$row['slug']?>"><?=strtoupper($row['title'])?></a></li>
                            <?php }
                            }?>
                        </ul>
                    </li>
                    <li>
                        <h4>FOR YOU</h4>
                        <ul>
                            <?php if(!empty($foryou_section_content)){
                                foreach($foryou_section_content as $row){ ?>
                                    <li><a href="<?= FRONT_URL.'manage-content/'.$row['slug']?>"><?=strtoupper($row['title'])?></a></li>
                            <?php }
                            }?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="MiniFooter">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="miniFooterContent">
                    <div class="footerLogo1" onclick="window.location.href='<?= FRONT_URL?>'">
                        <img src="<?= FRONT_IMAGES_URL ?>logo.svg" alt="logo">
                    </div>
                    <div class="copyRightSection">
                        <p>Copyrights <?=date("Y")?>. All Rights Reserved.</p>
                    </div>
                    <ul><?php 
                        if(TWITTER_LINK!=""){ ?>
                            <li><a href="<?=TWITTER_LINK?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <?php }else { ?>
                            <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
                        <?php } 
                        if(FACEBOOK_LINK!=""){ ?>
                            <li><a href="<?=FACEBOOK_LINK?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <?php }else { ?>
                            <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
                        <?php }
                        if(INSTAGRAM_LINK!=""){ ?>
                            <li><a href="<?=INSTAGRAM_LINK?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <?php }else { ?>
                            <li><a href="javascript:void(0)"><i class="fa fa-instagram"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>