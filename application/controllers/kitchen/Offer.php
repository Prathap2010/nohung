<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Offer_model","Offer");
    }

    public function index() {

        $title = "Offer Management";

        $this->viewData['page'] = "Offer";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Offer";

        $this->kitchen_headerlib->add_plugin("bootstrap-datepickercss","bootstrap-datepicker/css/bootstrap-datepicker.min.css");
        $this->kitchen_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/js/bootstrap-datepicker.js");
        $this->kitchen_headerlib->add_javascript("typeahead","typeahead.min.js");
        $this->kitchen_headerlib->add_bottom_javascripts("offer","offer.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    public function get_live_offers() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;
        $PostData['type'] = "live";
        
        $this->viewData['live_offers'] = $this->Offer->getKitchenOffers(PER_PAGE_OFFER, $offset, $PostData);

        $return['totalrows'] = $this->Offer->getKitchenOffers(PER_PAGE_OFFER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'live-offer-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    public function get_archive_offers() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;
        $PostData['type'] = "archive";

        $this->viewData['archive_offers'] = $this->Offer->getKitchenOffers(PER_PAGE_OFFER, $offset, $PostData);

        $return['totalrows'] = $this->Offer->getKitchenOffers(PER_PAGE_OFFER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'archive-offer-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }

    public function filterOffers(){
        $searchoffer = $this->input->post('searchoffer');
        $userid = $this->session->userdata(base_url().'FRONTUSERID');

        $where = array();
        if(!empty($searchoffer)){
            $where = " AND userid=".$userid." AND (title LIKE '%".$searchoffer."%' OR offercode LIKE '%".$searchoffer."%')";
        }
        $liveOffers = $this->Offer->getOffers("live",$where);
        $archiveOffers = $this->Offer->getOffers("archive",$where);
        // print_r($liveOffers); exit;
        $liveOffersdata = $archiveOffersdata = "";
        if(!empty($liveOffers)){
            foreach($liveOffers as $k=>$offer){

                $liveOffersdata .= '<div class="col-lg-4 col-md-6">
                                    <div class="managenmentOferContent">
                                        <div class="managenmentOferHeader">
                                            <div class="getOfferSection">
                                                <h4>'.$offer['title'].'</h4>
                                                <span>'.date("D", strtotime($offer['startdate'])).', '.date("d M y", strtotime($offer['startdate'])).' - '.date("D", strtotime($offer['enddate'])).', '.date("d M y", strtotime($offer['enddate'])).'</span>
                                            </div>
                                            <div class="offerCodeSection">
                                                <p>'.$offer['offercode'].'</p>
                                            </div>
                                        </div>
                                        <div class="managementOfferBody">
                                            <p>LIVE</p>
                                            <span>'.$offer['discount'].($offer['discounttype']==0?"%":"Rs").' Off</span>
                                        </div>
                                    </div>
                                </div> ';
            }
        }else{
            $liveOffersdata .= '<div class="col-lg-12 col-md-12">
                                <div class="managenmentOferContent">
                                    <p style="color:#7e7f7f;">No live offer available.</p>
                                </div>
                            </div>'; 
        }
        if(!empty($archiveOffers)){
            foreach($archiveOffers as $k=>$offer){

                $archiveOffersdata .= '<div class="col-lg-4 col-md-6">
                                    <div class="managenmentOferContent">
                                        <div class="managenmentOferHeader">
                                            <div class="getOfferSection">
                                                <h4>'.$offer['title'].'</h4>
                                                <span>'.date("D", strtotime($offer['startdate'])).', '.date("d M y", strtotime($offer['startdate'])).' - '.date("D", strtotime($offer['enddate'])).', '.date("d M y", strtotime($offer['enddate'])).'</span>
                                            </div>
                                            <div class="offerCodeSection">
                                                <p>'.$offer['offercode'].'</p>
                                            </div>
                                        </div>
                                        <div class="managementOfferBody">
                                            <p class="useAgainSection">Use again</p>
                                            <span>'.$offer['discount'].($offer['discounttype']==0?"%":"Rs").' Off</span>
                                        </div>
                                    </div>
                                </div> ';
            }
        }else{
            $archiveOffersdata .= '<div class="col-lg-12 col-md-12">
                                <div class="managenmentOferContent">
                                    <p style="color:#7e7f7f;">No archive offer available.</p>
                                </div>
                            </div>'; 
        }
        $Offersdata['live'] = $liveOffersdata;
        $Offersdata['archive'] = $archiveOffersdata;

        echo json_encode($Offersdata);
    }

    public function add_offer() {

        $PostData = $this->input->post();

        $title = trim($PostData['title']);
        $offercode = trim($PostData['offercode']);
        // $description = trim($PostData['description']);
        $discounttype = trim($PostData['discounttype']);
        $discount = trim($PostData['discount']);
        $startdate = trim($PostData['startdate']);
        $enddate = trim($PostData['enddate']);
        $starttime = trim(date("H:i:s",strtotime($PostData['starttime'])));
        $endtime = trim(date("H:i:s",strtotime($PostData['endtime'])));
        $appliesto = trim($PostData['appliesto']);
        $minrequirement = trim($PostData['minrequirement']);
        $usagelimit = trim($PostData['usagelimit']);
        $createddate = $this->general_model->getCurrentDateTime();

        $CheckOffer = $this->Offer->CheckOfferAvailable($offercode);
        
        if ($CheckOffer != 0) {

            $insertdata = array(
                "userid"=>$this->session->userdata(base_url().'FRONTUSERID'),
                "title" => $title,
                "offercode" => $offercode,
                // "description" => $description,
                "discounttype" => $discounttype,
                "discount" => $discount,
                "appliesto" => $appliesto,
                "minrequirement" => $minrequirement,
                "usagelimit" => $usagelimit,
                "startdate" => $this->general_model->convertdate($startdate),
                "enddate" => $this->general_model->convertdate($enddate),
                "starttime" => $starttime,
                "endtime" => $endtime,
                "usertype" => 1,
                "addedby" => $this->session->userdata(base_url().'FRONTUSERID'),
                "createddate" => $createddate,
                "modifieddate" => $createddate);
            
            $OfferID = $this->Offer->Add($insertdata);

            if ($OfferID) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }
    public function update_offer() {

        $PostData = $this->input->post();

        $offerid = trim($PostData['offerid']);
        $title = trim($PostData['title']);
        $offercode = trim($PostData['offercode']);
        $discounttype = trim($PostData['discounttype']);
        $discount = trim($PostData['discount']);
        $startdate = trim($PostData['startdate']);
        $enddate = trim($PostData['enddate']);
        $starttime = trim(date("H:i:s",strtotime($PostData['starttime'])));
        $endtime = trim(date("H:i:s",strtotime($PostData['endtime'])));
        $appliesto = trim($PostData['appliesto']);
        $minrequirement = trim($PostData['minrequirement']);
        $usagelimit = trim($PostData['usagelimit']);
        $modifieddate = $this->general_model->getCurrentDateTime();

        $CheckOffer = $this->Offer->CheckOfferAvailable($offercode,$offerid);
        
        if ($CheckOffer != 0) {

            $updatedata = array(
                "title" => $title,
                "offercode" => $offercode,
                "discounttype" => $discounttype,
                "discount" => $discount,
                "appliesto" => $appliesto,
                "minrequirement" => $minrequirement,
                "usagelimit" => $usagelimit,
                "startdate" => $this->general_model->convertdate($startdate),
                "enddate" => $this->general_model->convertdate($enddate),
                "starttime" => $starttime,
                "endtime" => $endtime,
                "modifieddate" => $modifieddate
            );
            
            $this->Offer->_where = array("id"=>$offerid);
            $Edit = $this->Offer->Edit($updatedata);

            if ($Edit) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }

    public function get_offer_detail(){
        $PostData = $this->input->post();

        $offerid = trim($PostData['offerid']);   
        $res = $this->Offer->getOfferDataByID($offerid);

        echo json_encode($res);
    }

    public function delete_offer()
    {
        $PostData = $this->input->post();

        $this->Offer->Delete(array("id" => $PostData['id']));

        echo 1;
    }
}