<link rel="stylesheet" href="<?php echo KITCHEN_CSS_URL; ?>all.min.css">
<style>
    .star-rating .fa-star {
        color: #ff9f00;
    }

    .nk-all-review-card {
        width: 100%;
        border-radius: 5px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        background-color: #FFFFFF;
        padding: 20px 20px 0;
    }

    .nk-all-review-card-title {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .nk-all-review-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #EDEEF2;
    }

    .nk-all-review-rating {
        text-align: right;
    }

    .nk-all-review-rate {
        font-size: 20px;
        font-weight: bold;
        color: #FDD303;
        margin-bottom: 5px;
    }

    .nk-rating-list {
        padding-left: 0;
        margin-bottom: 5px;
        list-style: none;
        display: flex;
        align-items: center;
    }

    .nk-all-review-rating .nk-rating-list {
        justify-content: flex-end;
    }

    .nk-rating-item {
        color: #EBEBEB;
        margin-left: 5px;
    }

    .nk-rating-item.active {
        color: #FDD303;
    }

    .nk-rating-label {
        margin-bottom: 0;
        color: #C1C2C7;
    }

    .nk-all-review-bar-item {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .nk-all-review-bar-item:not(:last-child) {
        margin-bottom: 10px;
    }

    .nk-all-review-bar-label {
        font-weight: 500;
        width: 40%;
        margin-bottom: 0;
    }

    .nk-all-review-bar {
        width: 60%;
    }

    .progress {
        height: 12px;
        background-color: #DCDCE4;
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .progress-bar.bg-success {
        background-color: #7EDABF !important;
    }

    .progress-bar.bg-warning {
        background-color: #FDD303 !important;
    }

    .progress-bar.bg-info {
        background-color: #BEE8FF !important;
    }

    .progress-bar.bg-danger {
        background-color: #FCA896 !important;
    }

    .nk-all-review-bar-content {
        margin-bottom: 100px;
    }

    .nk-review-card {
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
    }

    .nk-review-card:not(:last-child) {
        margin-bottom: 30px;
    }

    .nk-review-user-name {
        font-weight: bold;
        font-size: 16px;
    }

    .nk-review-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .nk-review-card {
        display: flex;
        flex-wrap: wrap;
    }

    .nk-review-card-img {
        padding-right: 20px;
    }

    .nk-review-card-img img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
    }

    .nk-review-card-content {
        width: calc(100% - 80px);
    }

    .nk-review-time {
        font-size: 12px;
    }

    .nk-review-description {
        color: #A7A8BC;
    }

    .nk-rating-type-list {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        display: flex;
        align-items: center;
    }

    .nk-rating-type-item {
        margin-right: 30px;
        display: flex;
        align-items: center;
    }

    .nk-rating-type-item label {
        color: #717171;
        font-weight: bold;
        margin-bottom: 0;
        margin-right: 10px;
    }

    .nk-review-img img {
        width: 100%;
    }
</style>
<script>
    var PER_PAGE_FEEDBACK = '<?= PER_PAGE_FEEDBACK ?>';
</script>
<div class="offerManagementWrap kitchen-payment">
    <div class="offermanageTopHeading">
        <h2>Feedback / Reviews</h2>
        <!-- <a href=""> <img src="assets/images/OfferManagement_icons.svg" alt=""> Add Offer</a> -->
    </div>
    <div class="row">
        <div class="col col-12 col-md-5 col-lg-5">
            <div class="nk-all-review-card">
                <div class="nk-all-review-card-header">
                    <h1 class="nk-all-review-card-title">Overall Rating</h1>
                    <div class="nk-all-review-rating">
                        <h2 class="nk-all-review-rate"><?= number_format($rating_data['overall_rating'], 1, '.', '') ?></h2>
                        <ul class="nk-rating-list">
                            <li class="nk-rating-item <?= ($rating_data['overall_rating'] >= 1 ? "active" : "") ?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?= ($rating_data['overall_rating'] >= 2 ? "active" : "") ?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?= ($rating_data['overall_rating'] >= 3 ? "active" : "") ?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?= ($rating_data['overall_rating'] >= 4 ? "active" : "") ?>"><i class="fas fa-star"></i></li>
                            <li class="nk-rating-item <?= ($rating_data['overall_rating'] >= 5 ? "active" : "") ?>"><i class="fas fa-star"></i></li>
                        </ul>
                        <label class="nk-rating-label">Based on <?= $rating_data['total_review'] ?> reviews</label>
                    </div>
                </div>
                <div class="nk-all-review-bar-content">
                    <div class="nk-all-review-bar-list">
                        <div class="nk-all-review-bar-item">
                            <label class="nk-all-review-bar-label">Exellent (<?= $rating_data['excellent'] ?>)</label>
                            <div class="nk-all-review-bar">
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= ($rating_data['total_review'] > 0 ? ($rating_data['excellent'] * 100 / $rating_data['total_review']) : "0") ?>%" aria-valuenow="<?= ($rating_data['total_review'] > 0 ? ($rating_data['excellent'] * 100 / $rating_data['total_review']) : "0") ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-all-review-bar-item">
                            <label class="nk-all-review-bar-label">Very Good (<?= $rating_data['verygood'] ?>)</label>
                            <div class="nk-all-review-bar">
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= ($rating_data['total_review'] > 0 ? ($rating_data['verygood'] * 100 / $rating_data['total_review']) : "0") ?>%" aria-valuenow="<?= ($rating_data['total_review'] > 0 ? ($rating_data['verygood'] * 100 / $rating_data['total_review']) : "0") ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-all-review-bar-item">
                            <label class="nk-all-review-bar-label">Good (<?= $rating_data['good'] ?>)</label>
                            <div class="nk-all-review-bar">
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?= ($rating_data['total_review'] > 0 ? ($rating_data['good'] * 100 / $rating_data['total_review']) : "0") ?>%" aria-valuenow="<?= ($rating_data['total_review'] > 0 ? ($rating_data['good'] * 100 / $rating_data['total_review']) : "0") ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-all-review-bar-item">
                            <label class="nk-all-review-bar-label">Fair (<?= $rating_data['fair'] ?>)</label>
                            <div class="nk-all-review-bar">
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($rating_data['total_review'] > 0 ? ($rating_data['fair'] * 100 / $rating_data['total_review']) : "0") ?>%" aria-valuenow="<?= ($rating_data['total_review'] > 0 ? ($rating_data['fair'] * 100 / $rating_data['total_review']) : "0") ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-all-review-bar-item">
                            <label class="nk-all-review-bar-label">Poor (<?= $rating_data['poor'] ?>)</label>
                            <div class="nk-all-review-bar">
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($rating_data['total_review'] > 0 ? ($rating_data['poor'] * 100 / $rating_data['total_review']) : "0") ?>%" aria-valuenow="<?= ($rating_data['total_review'] > 0 ? ($rating_data['poor'] * 100 / $rating_data['total_review']) : "0") ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-review-img">
                    <img src="<?php echo KITCHEN_IMAGES_URL; ?>review-img.png" alt="review" class="img-fluid" />
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-7 col-lg-7">
            <div class="nk-review-content" id="list">
            </div>
            <div class="load_more_btn" style="display:none;">
                <a href="javascript:void(0)" onclick="get_reviews()">load more</a>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">