<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Menu_model","Menu");
    }

    public function index() {

        $title = "Menu";

        $this->viewData['page'] = "Menu";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Menu";

        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $this->viewData['menudata'] = $this->Menu->getUserMasterMenu($USERID);
        $this->viewData['menucount'] = $this->Menu->getCountUserMasterMenu($USERID);
        
        $this->kitchen_headerlib->add_plugin("form-select2","form-select2/select2.css");
        $this->kitchen_headerlib->add_javascript_plugins("form-select2","form-select2/select2.min.js");
        $this->kitchen_headerlib->add_javascript("add_menu","add_menu.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }

    public function add_menu() {
        $title = "Add Menu";

        $this->viewData['page'] = "Add_menu";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Add_menu";

        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $this->viewData['menudata'] = $this->Menu->getUserMasterMenu($USERID); 
        // echo "<pre>"; print_r($this->viewData['menudata']);exit;

        $this->kitchen_headerlib->add_plugin("form-select2","form-select2/select2.css");
        $this->kitchen_headerlib->add_javascript_plugins("form-select2","form-select2/select2.min.js");
        
        $this->kitchen_headerlib->add_javascript("add_menu","add_menu.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }

    public function searchitem()
    {
        $USERID = $this->session->userdata(base_url().'FRONTUSERID');

        $Menudata = array();
        if(isset($_REQUEST["term"]) && trim($_REQUEST['term'])!==''){
            $Menudata = $this->Menu->searchitem(1,$_REQUEST["term"],$USERID);
        }else if(isset($_REQUEST["id"]) && trim($_REQUEST['id'])!==''){
            $Menudata = $this->Menu->searchitem(0,$_REQUEST["id"],$USERID);
        }
        
        echo json_encode($Menudata);
    }

    public function savebreakfast() {
        $PostData = $this->input->post();
        // print_r($_FILES); print_r($PostData); exit;
        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        $element = $PostData['elementname'];
        $cuisinetype = $PostData['cuisinetype'];
        $menutype = $PostData['menutype'];
        $itemtype = $PostData['itemtype'];

        $cntarray = $PostData['cnt_'.$element];
        $idarray = $PostData['id_'.$element];
        $itemnamearray = $PostData['itemname_'.$element];
        $preimgarray = $PostData['preimg_'.$element];
        $itempricearray = $PostData['itemprice_'.$element];
        $itemqtyarray = $PostData['itemqty_'.$element];

        if(!is_dir(MENU_PATH)){
            @mkdir(MENU_PATH);
        }
        
        $insertdata = $updatedata = $updatedID = array();
        if(!empty($cntarray)){
            foreach($cntarray as $k=>$count){

                $id = !empty($idarray[$k])?$idarray[$k]:"";
                $instock = isset($PostData['instock_'.$element.$count])?1:0;
                $image = "";
                $category = ($itemtype==0) ? "Veg" : "Non Veg";
                
                if($itemnamearray[$k]!="" && $itempricearray[$k]!=""){
                    if($_FILES['image_'.$element.$count]['name'] != ''){
                        if($preimgarray[$k]==""){
                            $image = uploadfile('image_'.$element.$count, 'image', MENU_PATH, "jpeg|png|jpg|gif|JPEG|PNG|JPG");
                        }else{
                            $image = reuploadfile('image_'.$element.$count, 'image', $preimgarray[$k], MENU_PATH, "jpeg|png|jpg|gif|JPEG|PNG|JPG");
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

    public function savelunchordinner() {
        $PostData = $this->input->post();
        // print_r($_FILES); print_r($PostData); exit;
        $USERID = $this->session->userdata(base_url().'FRONTUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        $element = $PostData['elementname'];
        $cuisinetype = $PostData['cuisinetype'];
        // $menutype = $PostData['menutype'];

        $itemtype = $PostData['itemtype'];
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
                $menutype = $PostData['menutype_'.$EL_ID];

                if(!empty($cntarray)){
                    foreach($cntarray as $k=>$count){
        
                        $id = !empty($idarray[$k])?$idarray[$k]:"";
                        $instock = isset($PostData['instock_'.$EL_ID.$count])?1:0;
                        $image = "";
                        
                        if($itemnamearray[$k]!="" && $itempricearray[$k]!=""){

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
                                                "menutype"=>$menutype[$k],
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
                                                "menutype" => $menutype[$k],
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
        
        $where = array("userid"=>$USERID,"cuisinetype"=>$cuisinetype, "(menutype=1 OR menutype=2 OR menutype=3)"=>null,"itemtype"=>$itemtype);
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
}