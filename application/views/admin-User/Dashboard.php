<div class="page-content">
  <div class="page-heading">            
    <h1>Dashboard</h1>    
    <small>
      <ol class="breadcrumb">                        
        <li class="active">Dashboard</li>
      </ol>
    </small>                
  </div>

  <div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-green" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-users"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>No. of Kitchens</span></div>
                    <div class="tile-body "><span><?=$totalkitchens?></span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-orange" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-users"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>No. of Foodies</span></div>
                    <div class="tile-body "><span><?=$totalfoodies?></span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-blue" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-users"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>No. of Riders</span></div>
                    <div class="tile-body "><span><?=$totalriders?></span></div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-purple" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>Total Orders</span></div>
                    <div class="tile-body "><span><?=$totalorders?></span></div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-info" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>Total Active Orders</span></div>
                    <div class="tile-body "><span><?=$totalactiveorders?></span></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-success" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>Total Completed Orders</span></div>
                    <div class="tile-body "><span><?=$totalcompleteorders?></span></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-danger" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>Total Cancel Orders</span></div>
                    <div class="tile-body "><span><?=$totalcancelorders?></span></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-tile info-tile-alt tile-danger" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="stats">
                    <div class="tile-content">
                        <!-- <span class="material-icons tile-icon">monetization_on</span> -->
                        <span class="tile-icon" style="padding: 10px;"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
                <div class="info">
                    <div class="tile-heading"><span>Total Rejected Orders</span></div>
                    <div class="tile-body "><span><?=$totalrejectorders?></span></div>
                </div>
            </div>
        </div>
        
    </div>
                    
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->