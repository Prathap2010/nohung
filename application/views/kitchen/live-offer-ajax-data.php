<?php if (!empty($live_offers)) {
    foreach ($live_offers as $offer) { ?>
        <div class="col-lg-4 col-md-6" id="offer<?= $offer['id'] ?>">
            <div class="managenmentOferContent">
                <div class="managenmentOferHeader">
                    <div class="getOfferSection">
                        <h4><?= $offer['title'] ?></h4>
                        <span><?= date('D', strtotime($offer['startdate'])) ?>, <?= date('d M y', strtotime($offer['startdate'])) ?> - <?= date('D', strtotime($offer['enddate'])) ?>, <?= date('d M y', strtotime($offer['enddate'])) ?></span>
                    </div>
                    <div class="offerCodeSection" style="margin-right: 17px;margin-top: -28px;">
                        <p><?= $offer['offercode'] ?></p>
                    </div>
                    <a href="javascript:void(0)" onclick="deleteoffer(<?= $offer['id'] ?>)" style="position: absolute;right: -5px;top: -5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.874" height="22" viewBox="0 0 17.874 22">
                            <defs>
                                <style>
                                    .a {
                                        fill: #CE543D;
                                    }
                                </style>
                            </defs>
                            <path class="a" d="M49.716,2.75H53.5V2.063A2.065,2.065,0,0,1,55.563,0h2.75a2.065,2.065,0,0,1,2.063,2.063v.688h3.782a1.716,1.716,0,0,1,1.716,1.716V6.875a.688.688,0,0,1-.688.688H64.81l-.594,12.473A2.061,2.061,0,0,1,62.155,22H51.717a2.061,2.061,0,0,1-2.061-1.964L49.063,7.563h-.376A.688.688,0,0,1,48,6.875V4.468A1.716,1.716,0,0,1,49.716,2.75ZM59,2.062a.688.688,0,0,0-.688-.688H55.563a.688.688,0,0,0-.688.688V2.75H59Zm5.5,2.406a.345.345,0,0,0-.343-.343H49.716a.345.345,0,0,0-.343.343V6.184H64.5Zm-13.465,15.5a.686.686,0,0,0,.686.66h10.44a.686.686,0,0,0,.686-.66l.591-12.408h-13Z" transform="translate(-48)" />
                            <path class="a" d="M240.688,218.314a.688.688,0,0,1-.688-.688v-8.938a.688.688,0,1,1,1.376,0v8.938A.688.688,0,0,1,240.688,218.314Z" transform="translate(-231.75 -199.062)" />
                            <path class="a" d="M320.688,218.314a.688.688,0,0,1-.688-.688v-8.938a.688.688,0,1,1,1.375,0v8.938A.688.688,0,0,1,320.688,218.314Z" transform="translate(-315.187 -199.062)" />
                            <path class="a" d="M160.688,218.314a.688.688,0,0,1-.688-.688v-8.938a.688.688,0,1,1,1.376,0v8.938A.688.688,0,0,1,160.688,218.314Z" transform="translate(-148.312 -199.062)" />
                        </svg>
                    </a>
                </div>
                <div class="managementOfferBody">
                    <p>LIVE</p>
                    <span><?= $offer['discount'] . ($offer['discounttype'] == 0 ? "%" : "Rs"); ?> Off</span>
                </div>
            </div>
        </div>
    <?php }
} else { ?>
    <div class="col-lg-12 col-md-12">
        <div class="managenmentOferContent">
            <p style="color:#7e7f7f;">No live offer available.</p>
        </div>
    </div>
<?php } ?>