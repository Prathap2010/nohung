<?php if(!empty($archive_offers)){
    foreach($archive_offers as $offer){ ?>
        <div class="col-lg-4 col-md-6">
            <div class="managenmentOferContent">
                <div class="managenmentOferHeader">
                    <div class="getOfferSection">
                        <h4><?=$offer['title']?></h4>
                        <span><?=date('D', strtotime($offer['startdate']))?>, <?=date('d M y', strtotime($offer['startdate']))?> - <?=date('D', strtotime($offer['enddate']))?>, <?=date('d M y', strtotime($offer['enddate']))?></span>
                    </div>
                    <div class="offerCodeSection">
                        <p><?=$offer['offercode']?></p>
                    </div>
                </div>
                <div class="managementOfferBody">
                    <p style="cursor: pointer;" class="useAgainSection" onclick="get_offer_detail(<?=$offer['id']?>)">Use again</p>
                    <span><?=$offer['discount'].($offer['discounttype']==0?"%":"Rs");?> Off</span>
                </div>
            </div>
        </div>   
    <?php }
}else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="managenmentOferContent">
            <p style="color:#7e7f7f;">No archive offer available.</p>
        </div>
    </div> 
<?php } ?>