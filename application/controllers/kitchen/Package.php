<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Package_model","Package");
    }

    public function index() {

        $title = "Packages";

        $this->viewData['page'] = "Packages";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Package";

        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        
        $Postdata['kitchenid'] = $USERID;
        $this->viewData['count_packages'] = $this->Package->getKitchenPackages(0,0,$Postdata,1);

        $this->kitchen_headerlib->add_plugin("bootstrap-datepickercss","bootstrap-datepicker/css/bootstrap-datepicker.min.css");
        $this->kitchen_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/js/bootstrap-datepicker.js");
        $this->kitchen_headerlib->add_javascript("package","package.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    public function load_packages() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;

        $this->viewData['packagesdata'] = $this->Package->getKitchenPackages(PER_PAGE_PACKAGE, $offset, $PostData);

        $return['totalrows'] = $this->Package->getKitchenPackages(PER_PAGE_PACKAGE, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'package-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    public function edit_package($id) {

        $title = "Edit Package";

        $this->viewData['page'] = "Edit_package";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Edit_package";

        $this->viewData['packagedata'] = $this->Package->getPackageDataById($id);
        if(empty($this->viewData['packagedata'])){
            redirect("pagenotfound");
        }
        $this->viewData['menudata'] = $this->Package->getMenuByPackage($id);
        $this->viewData['weeklypackagedata'] = $this->Package->getWeeklyPackageData($id);
        // echo "<pre>"; print_r($this->viewData['menudata']); exit;
        $this->kitchen_headerlib->add_javascript_plugins("bootstrap-touchspin","bootstrap-touchspin/jquery.bootstrap-touchspin.js");
        $this->kitchen_headerlib->add_plugin("jquery-bootstrap-touchspin","bootstrap-touchspin/jquery.bootstrap-touchspin.min.css");
        $this->kitchen_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/js/bootstrap-datepicker.js");
        $this->kitchen_headerlib->add_javascript("edit-package","edit_package.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    public function delete_package() {
        $PostData = $this->input->post();

        $this->Package->_table = "weeklypackagemenu";
        $this->Package->Delete("weeklypackageid IN (SELECT id FROM weeklypackage WHERE packageid='" . $PostData['id'] . "')");

        $this->Package->_table = "weeklypackage";
        $this->Package->Delete(array("packageid"=>$PostData['id']));

        $this->Package->_table = "packages";
        $this->Package->Delete(array("id"=>$PostData['id']));
        echo 1;
    }
    public function add_package() {
        $PostData = $this->input->post();
        
        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        $packageid = $PostData['packageid'];
        $packagename = $PostData['packagename'];
        $cuisinetype = $PostData['cuisinetype'];
        $mealtype = $PostData['mealtype'];
        $mealfor = $PostData['mealfor'];
        $startdate = $this->general_model->convertdate($PostData['startdate']);
        $weeklyplantype = isset($PostData['weeklyplantype'])?1:0;
        $monthlyplantype = isset($PostData['monthlyplantype'])?1:0;
        $including_saturday = isset($PostData['including_saturday'])?1:0;
        $including_sunday = isset($PostData['including_sunday'])?1:0;
        
        $CheckPackage = $this->Package->CheckPackageAvailable($packagename,$packageid);
        
        if ($CheckPackage != 0) {
            if($packageid==""){
                $insertdata = array("userid"=>$USERID,
                                    "packagename"=>$packagename,                    
                                    "cuisinetype"=>$cuisinetype,
                                    "mealtype"=>$mealtype,
                                    "mealfor"=>$mealfor,
                                    "weeklyplantype"=>$weeklyplantype,
                                    "monthlyplantype"=>$monthlyplantype,
                                    "startdate"=>$startdate,
                                    "including_saturday"=>$including_saturday,
                                    "including_sunday"=>$including_sunday,
                                    "createddate"=>$createddate,
                                    "modifieddate"=>$createddate
                                );
                $PackageID = $this->Package->Add($insertdata);

            }else{

                $this->Package->_table = "packages";
                $packagedata = $this->Package->getPackageDataById($packageid);

                $insertdata = array("packagename"=>$packagename,                    
                                    "cuisinetype"=>$cuisinetype,
                                    "mealtype"=>$mealtype,
                                    "mealfor"=>$mealfor,
                                    "weeklyplantype"=>$weeklyplantype,
                                    "monthlyplantype"=>$monthlyplantype,
                                    "startdate"=>$startdate,
                                    "including_saturday"=>$including_saturday,
                                    "including_sunday"=>$including_sunday,
                                    "modifieddate"=>$createddate
                                );
                $this->Package->_where = array("id"=>$packageid);   
                $this->Package->Edit($insertdata);
                $PackageID = $packageid;

                if($including_saturday == 0 && $packagedata['including_saturday'] == 1){
                    $this->Package->_table = "weeklypackagemenu";
                    $this->Package->Delete("weeklypackageid IN (SELECT id FROM weeklypackage WHERE packageid='" . $packageid . "' AND days='6')");
                    
                    $this->Package->_table = "weeklypackage";
                    $this->Package->Delete(array("packageid" => $packageid, "days"=>'6'));
                }

                if ($including_sunday == 0 && $packagedata['including_sunday'] == 1) {
                    $this->Package->_table = "weeklypackagemenu";
                    $this->Package->Delete("weeklypackageid IN (SELECT id FROM weeklypackage WHERE packageid='" . $packageid . "' AND days='7')");
                    
                    $this->Package->_table = "weeklypackage";
                    $this->Package->Delete(array("packageid" => $packageid, "days" => '7'));
                }
                
                /* $this->Package->_table = "weeklypackage";
                if ($including_saturday == 1 && $packagedata['including_saturday'] == 0) {
                    $this->Package->Add(array("packageid" => $packageid, "days" => '6'));
                }

                if ($including_sunday == 1 && $packagedata['including_sunday'] == 0) {
                    $this->Package->Add(array("packageid" => $packageid, "days" => '7'));
                } */
            }

            if ($PackageID) {
                echo $PackageID;
            } else {
                echo 0;
            }
        }else{
            echo -2;
        }
    }

    public function savelunchordinner() {
        $PostData = $this->input->post();
        // print_r($_FILES); print_r($PostData); exit;
        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        $element = $PostData['elementname'];
        $cuisinetype = $PostData['cuisinetype'];
        $menutype = $PostData['menutype'];
        $itemtype = $PostData['itemtype'];

        if(!is_dir(MENU_PATH)){
            @mkdir(MENU_PATH);
        }
        $insertdata = $updatedata = $updatedID = array();

        $categoryarray = $PostData['category_'.$element];
        if(!empty($categoryarray)){
            foreach($categoryarray as $category){

                $cat = str_replace(" ","_",strtolower($category));

                $EL_ID = $element."_".$cat;
                $cntarray = $PostData['cnt_'.$EL_ID];
                $idarray = $PostData['id_'.$EL_ID];
                $itemnamearray = $PostData['itemname_'.$EL_ID];
                $preimgarray = $PostData['preimg_'.$EL_ID];
                $itempricearray = $PostData['itemprice_'.$EL_ID];
                $itemqtyarray = $PostData['itemqty_'.$EL_ID];
                
                if(!empty($cntarray)){
                    foreach($cntarray as $k=>$count){
        
                        $id = !empty($idarray[$k])?$idarray[$k]:"";
                        $instock = isset($PostData['instock_'.$EL_ID.$count])?1:0;
                        $image = "";
                        
                        if($itemnamearray[$k]!="" && $itempricearray[$k]!="" && $itemqtyarray[$k]!=""){

                            if($_FILES['image_'.$EL_ID.$count]['name'] != ''){
                                if($preimgarray[$k]==""){
                                    $image = uploadfile('image_'.$EL_ID.$count, 'image', MENU_PATH, "jpeg|png|jpg|gif|JPEG|PNG|JPG");
                                }else{
                                    $image = reuploadfile('image_'.$EL_ID.$count, 'image', $preimgarray[$k], MENU_PATH, "jpeg|png|jpg|gif|JPEG|PNG|JPG");
                                }
                                if($image === 0 || $image === 2){	
                                    $image = "";
                                }
                            }else{
                                $image = $preimgarray[$k];
                            }
                            if($id==""){
            
                                $insertdata[] = array("userid"=>$USERID,
                                                "cuisinetype"=>$cuisinetype,
                                                "menutype"=>$menutype,
                                                "itemname"=>$itemnamearray[$k],
                                                "itemprice"=>$itempricearray[$k],
                                                "itemdetail"=>$itemqtyarray[$k],
                                                "instock"=>$instock,
                                                "image"=>$image,
                                                "category"=>$category,
                                                "itemtype"=>$itemtype,
                                                "createddate"=>$createddate,
                                                "modifieddate"=>$createddate
                                            ); 
                            }else{
                                $updatedata[] = array("id"=>$id,
                                                "itemname"=>$itemnamearray[$k],
                                                "itemprice"=>$itempricearray[$k],
                                                "itemdetail"=>$itemqtyarray[$k],
                                                "instock"=>$instock,
                                                "image"=>$image,
                                                "category"=>$category,
                                                "modifieddate"=>$createddate
                                            ); 
            
                                $updatedID[] = $id;
                            }
                        }
                    }
                }
            }
        }
        
        $where = array("userid"=>$USERID,"cuisinetype"=>$cuisinetype,"menutype"=>$menutype,"itemtype"=>$itemtype);
        $data = $this->Menu->getMasterMenu($where);
        $preidsarray = array_column($data, "id");
        $diff = array_diff($preidsarray,$updatedID);

        if(!empty($diff)){
            $this->Menu->Delete("userid=".$USERID." AND id IN (".implode(",", $diff).")");
        }
        if(!empty($insertdata)){
            $this->Menu->add_batch($insertdata);
        }
        if(!empty($updatedata)){
            $this->Menu->edit_batch($updatedata,"id");
        }
        echo 1;
    }

    public function create_package() {
        $PostData = $this->input->post();
        // print_r($PostData); exit;
        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        
        $packageid = $PostData['packageid'];
        $weeklyprice = $PostData['weeklyprice'];
        $monthlyprice = $PostData['monthlyprice'];
        $cntdaysarr = $PostData['cnt'];

        $updatedata = array("weeklyprice"=>$weeklyprice,                    
                            "monthlyprice"=>$monthlyprice,
                            "modifieddate"=>$createddate
                        );
        $this->Package->_where = array("id"=>$packageid);   
        $update = $this->Package->Edit($updatedata);
        if($update){
            if(!empty($cntdaysarr)){
                if(!is_dir(PACKAGE_PATH)){
                    @mkdir(PACKAGE_PATH);
                }
                
                foreach($cntdaysarr as $k=>$cnt){
                    $weeklypackageid = $PostData['weeklypackageid'][$k];
                    $preimg = $PostData['preimg'][$k];
                    // $menuid = $PostData['menuid'][$k];
                    $defailtdishitem = $PostData['defailtdishitem'][$k];
                    $totalprice = $PostData['totalprice'][$k];

                    if($totalprice > 0){

                        if($_FILES['image'.$cnt]['name'] != ''){
                            if($preimg==""){
                                $image = uploadfile('image'.$cnt, 'image', PACKAGE_PATH, "jpeg|png|jpg|gif|JPEG|PNG|JPG");
                            }else{
                                $image = reuploadfile('image'.$cnt, 'image', $preimg, PACKAGE_PATH, "jpeg|png|jpg|gif|JPEG|PNG|JPG");
                            }
                            if($image === 0 || $image === 2){	
                                $image = "";
                            }
                        }else{
                            $image = $preimg;
                        }

                        if($weeklypackageid!=""){
                            $updatedata = array("days"=>$cnt,
                                                /* "menu"=>$menuid, */
                                                "defailtdishitem"=>$defailtdishitem,
                                                "price"=>$totalprice,
                                                "image"=>$image,
                                            );
                                            
                            $this->Package->_table = 'weeklypackage';        
                            $this->Package->_where = array("id"=>$weeklypackageid);   
                            $this->Package->Edit($updatedata);

                            $menudetailarray = json_decode($PostData['menuid'][$k],true);
                            if(!empty($menudetailarray)){
                                $editmenuitemdetail = array();
                                foreach($menudetailarray as $menudetail){
                                    $weeklypackagemenuid = $menudetail['id'];

                                    if(!empty($weeklypackagemenuid)){
                                        $updatemenus = array("weeklypackageid"=>$weeklypackageid,
                                            "menuid"=>$menudetail['menuid'],
                                            "itemname"=>$menudetail['itemname'],
                                            "qty"=>$menudetail['qty'],
                                            "price"=>$menudetail['price']
                                        );
    
                                        $this->Package->_table = 'weeklypackagemenu'; 
                                        $this->Package->_where = array("id"=>$weeklypackagemenuid);          
                                        $this->Package->Edit($updatemenus);

                                        $editmenuitemdetail[] = $weeklypackagemenuid;
                                    }else{
                                        $insertmenus = array("weeklypackageid"=>$weeklypackageid,
                                            "menuid"=>$menudetail['menuid'],
                                            "itemname"=>$menudetail['itemname'],
                                            "qty"=>$menudetail['qty'],
                                            "price"=>$menudetail['price']
                                        );
    
                                        $this->Package->_table = 'weeklypackagemenu';        
                                        $weeklypackagemenuinsertid = $this->Package->Add($insertmenus);

                                        $editmenuitemdetail[] = $weeklypackagemenuinsertid;
                                    }
                                }
                                if(!empty($editmenuitemdetail)){
                                    $this->Package->_table = 'weeklypackagemenu'; 
                                    $this->Package->_where = array("id"=>$weeklypackagemenuid);          
                                    $this->Package->Delete(array("weeklypackageid"=>$weeklypackageid,"id NOT IN (".implode(",",$editmenuitemdetail).")"=>null));
                                }
                            }
                        }else{
                            $insertdata = array("packageid"=>$packageid,
                                                "days"=>$cnt,
                                                // "menu"=>$menuid,
                                                "defailtdishitem"=>$defailtdishitem,
                                                "price"=>$totalprice,
                                                "image"=>$image,
                                            );

                            $this->Package->_table = 'weeklypackage';        
                            $insertid = $this->Package->Add($insertdata);

                            $menudetailarray = json_decode($PostData['menuid'][$k],true);
                            if(!empty($menudetailarray)){
                                foreach($menudetailarray as $menudetail){

                                    $insertmenus = array("weeklypackageid"=>$insertid,
                                        "menuid"=>$menudetail['menuid'],
                                        "itemname"=>$menudetail['itemname'],
                                        "qty"=>$menudetail['qty'],
                                        "price"=>$menudetail['price']
                                    );

                                    $this->Package->_table = 'weeklypackagemenu';        
                                    $this->Package->Add($insertmenus);
                                }
                            }
                        }
                    }
                }
            }
            echo 1;
        }else{
            echo 0;
        }
    }
}