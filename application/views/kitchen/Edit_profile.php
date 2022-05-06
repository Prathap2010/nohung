<style>
    .form-group input, .form-group textarea {
        display: block;
        width: 100%;
        height: 50px;
        background: transparent;
        border: solid 1px #CFCFCF;
        padding: 0 15px;
        font-size: 18px;
        transition: all 0.5s ease;
    }
    .form-group label {
        position: absolute;
        cursor: text;
        z-index: 2;
        top: 13px;
        left: 10px;
        font-size: 14px;
        font-weight: 500;
        background: #fff;
        padding: 0 10px;
        color: #999;
        transition: all 0.5s ease;
    }
    .form-group input:valid + label, .form-group textarea:valid + label {
        font-size: 12px;
        top: -8px;
    }
    .form-group{
        position: relative;
        margin-bottom: 20px;
    }
    .p-xs {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    
    .manage-error .form-control,.manage-error .bootstrap-select button{
        border: 1px solid #fe0d0d !important;
    }
    .bootstrap-select button {
        border:1px solid #CFCFCF;
    }
    .filter-option {
        font-size: 15px;
        padding: 6px;
    }
    .bootstrap-select li span.text {
        font-size: 15px;
    }
    .custom-file-label {
        height: calc(2.25rem + 15px);
    }
    .custom-file-label::after {
        height: calc(calc(2.25rem + 15px) - 1px * 2);
        padding: 0.575rem 0.75rem;
    }
</style>
<div class="offerManagementWrap kitchen-payment">
    <div class="offermanageTopHeading">
        <h2>Edit Profile</h2>
    </div>
    <div class="row">
        <div class="wallet-history-table" style="margin-top: 0;">
            <form action="#" id="userform" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-row row">
                        <div class="col-lg-6 p-xs">
                            <div class="form-group" id="knelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" name="kitchenname" id="KitchenName" autocomplete="off" class="form-control" value="<?=$kitchendata['kitchenname']?>">
                                    <label for="KitchenName">Kitchen Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 p-xs">
                            <div class="form-group" id="addelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" name="address" id="KitchenAddress" autocomplete="off" class="form-control" value="<?=$kitchendata['address']?>">
                                    <label for="KitchenAddress">Kitchen Address</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row row">
                        <div class="col-lg-12 p-xs">
                            <div class="form-group" id="descelement">
                                <div class="col-lg-12 p-xs">
                                    <textarea rows="10" name="description" id="description" autocomplete="off" class="form-control"><?=$kitchendata['description']?></textarea>
                                    <label for="description">Kitchen Description</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row row">
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="stelement">
                                <div class="col-lg-12 p-xs">
                                    <select name="stateid" id="stateid" class="selectpicker form-control" data-size="8">
                                        <option value="0">Select State</option>
                                        <?php if(!empty($provincedata)){
                                            foreach($provincedata as $state){ ?>
                                                <option value="<?=$state['id']?>" <?=($kitchendata['stateid']==$state['id'] ? "selected" : "")?>><?=$state['name']?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="ctelement">
                                <div class="col-lg-12 p-xs">
                                    <select name="cityid" id="cityid" class="selectpicker form-control" data-size="8">
                                        <option value="0">Select City</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="pcelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="pincode" name="pincode" autocomplete="off" class="form-control" onkeypress="return isNumeric(event);" value="<?=$kitchendata['pincode']?>">
                                    <label for="pincode">Pincode</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="cnelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="contact-name" name="contactname" autocomplete="off" class="form-control" value="<?=$kitchendata['contactname']?>">
                                    <label for="contact-name">Contact Person's Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="rlelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="role" name="role" autocomplete="off" class="form-control" value="<?=$kitchendata['role']?>">
                                    <label for="role">Contact Person's Role</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="mnelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="mobile-number" name="mobilenumber" autocomplete="off" class="form-control" onkeypress="return isNumeric(event);" value="<?=$kitchendata['mobilenumber']?>">
                                    <label for="mobile-number">Mobile Number</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="kcnelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="kitchencontactnumber" name="kitchencontactnumber" autocomplete="off" class="form-control" onkeypress="return isNumeric(event);" value="<?=$kitchendata['kitchencontactnumber']?>">
                                    <label for="kitchencontactnumber">Kitchen's Contact Number</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="emailelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" name="email" id="email" autocomplete="off" class="form-control" value="<?=$kitchendata['email']?>">
                                    <label for="email">Email Id</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="fssaielement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="fssai" name="fssai" autocomplete="off" class="form-control" value="<?=$kitchendata['fssailicenceno']?>">
                                    <label for="fssai">FSSAI License No.</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="edelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="expiry-date" name="expirydate" autocomplete="off" class="form-control" value="<?=($kitchendata['expirydate']!="0000-00-00" ? $this->general_model->displaydate($kitchendata['expirydate']) : "")?>">
                                    <label for="expiry-date">Expiry Date</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="panelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="pan" name="panno" autocomplete="off" class="form-control" value="<?=$kitchendata['panno']?>">
                                    <label for="pan">PAN Card</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-xs">
                            <div class="form-group" id="gstelement">
                                <div class="col-lg-12 p-xs">
                                    <input type="text" id="gst" name="gstno" autocomplete="off" class="form-control" value="<?=$kitchendata['gstno']?>">
                                    <label for="gst">GST Registration No.</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-lg-6 p-xs">
                            <label class="control-label">Upload Documents</label>
                            <div class="custom-file mb-3">
                                <input type="hidden" name="documentid" id="documentid" value="<?=$kitchendata['documentid']?>">
                                <input type="hidden" name="olddocumentfile" id="olddocumentfile" value="<?=$kitchendata['documentfile']?>">
                                <input type="hidden" id="isvaliddocumentfile" value="<?=($kitchendata['documentfile']!="" ? 1 : 0)?>">
                                <input type="file" id="documentfile" name="documentfile" class="custom-file-input" accept=".jpg,.png,.gif,.pdf" onchange="check_file($(this),'documentfile')"/>
                                <label id="lbldocumentfile" class="custom-file-label" for="documentfile" style="overflow: hidden;"><?=($kitchendata['documentfile']!="" ? $kitchendata['documentfile'] : "Choose file")?></label>
                            </div>
                        </div>
                        <div class="col-lg-6 p-xs">
                            <label class="control-label">Upload Menu</label>
                            <div class="custom-file mb-3">
                                <input type="hidden" name="oldmenufile" id="oldmenufile" value="<?=$kitchendata['menufile']?>">
                                <input type="hidden" id="isvalidmenufile" value="<?=($kitchendata['menufile']!="" ? 1 : 0)?>">
                                <input type="file" id="menufile" name="menufile" class="custom-file-input" accept=".jpg,.png,.gif,.pdf" onchange="check_file($(this),'menufile')"/>
                                <label id="lblmenufile" class="custom-file-label" for="menufile" style="overflow: hidden;"><?=($kitchendata['menufile']!="" ? $kitchendata['menufile'] : "Choose file")?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-6 p-xs">
                            <label class="control-label">Upload Profile Image</label>
                            <div class="custom-file mb-3">
                                <input type="hidden" name="oldprofile_image" id="oldprofile_image" value="<?=$kitchendata['profile_image']?>">
                                <input type="hidden" id="isvalidprofile_image" value="<?=($kitchendata['profile_image']!="" ? 1 : 0)?>">
                                <input type="file" id="profile_image" name="profile_image" class="custom-file-input" accept=".jpg,.png,.gif,.pdf" onchange="check_image($(this),'profile_image')"/>
                                <label id="lblprofile_image" class="custom-file-label" for="profile_image" style="overflow: hidden;"><?=($kitchendata['profile_image']!="" ? $kitchendata['profile_image'] : "Choose file")?></label>
                            </div>
                        </div>
                    </div>
                    <div class="southIndiaFooterButton">
                        <button type="button" id="btn-save" onclick="save_details()">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
    
    $(document).ready(function() {
        
        getcity('<?=$kitchendata['stateid']?>');

        var CITY_ID = '<?=$kitchendata['cityid']?>';
        $('#cityid').val(CITY_ID).selectpicker('refresh');

        $('#stateid').on('change', function (e) {
            getcity(this.value);
        });
        $('#expiry-date').datepicker({
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayBtn:"linked"
        });
    });
    function check_file(obj, element){
        var val = obj.val();
        var id = obj.attr('id').match(/\d+/);
        var filename = obj.val().replace(/C:\\fakepath\\/i, '');
        var filesize = obj[0].files[0].size;
        
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': case 'pdf': 
                
                $("#isvalid"+element).val(1);
                $("#lbl"+element).html(filename);
                break;
            default:
                    
                $("#isvalid"+element).val(0);
                $("#lbl"+element).html("Choose file");
                if(element == 'documentfile'){
                    toastr.error('Accept documents only PDF & image format !');
                }else{
                    toastr.error('Accept menu file only PDF & image format !');
                }
                break;
        }
    }
    function check_image(obj, element){
        var val = obj.val();
        var id = obj.attr('id').match(/\d+/);
        var filename = obj.val().replace(/C:\\fakepath\\/i, '');
        var filesize = obj[0].files[0].size;
        
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': case 'pdf': 
                
                $("#isvalid"+element).val(1);
                $("#lbl"+element).html(filename);
                break;
            default:
                    
                $("#isvalid"+element).val(0);
                $("#lbl"+element).html("Choose file");
                if(element == 'profile_image'){
                    toastr.error('Accept profile only image format !');
                }
                break;
        }
    }
    function getcity(provinceid){

        $('#cityid')
            .find('option')
            .remove()
            .end()
            .append('<option value="0">Select City</option>')
        ;
        $('#cityid').val('0').selectpicker('refresh');
        
        if(provinceid!=0){
            
            $.ajax({
                url: SITE_URL+"process/getCityData",
                type: 'POST',
                data: {provinceid:provinceid},
                dataType: 'json',
                async: false,
                success: function(response){

                    for(var i = 0; i < response.length; i++) {
                        $('#cityid').append($('<option>', { 
                            value: response[i]['id'],
                            text : response[i]['name']
                        }));
                    }
                    
                },
                error: function(xhr) {
                    //alert(xhr.responseText);
                },
            });
        }
        $('.selectpicker').selectpicker('refresh');
    }
    function save_details(){

        var kitchenname = $("#KitchenName").val().trim();
        var description = $("#description").val().trim();
        var address = $("#KitchenAddress").val().trim();
        var email = $("#email").val().trim();
        var stateid = $("#stateid").val();
        var cityid = $("#cityid").val();
        var pincode = $("#pincode").val();
        var contactname = $("#contact-name").val();
        var role = $("#role").val();
        var mobilenumber = $("#mobile-number").val();
        var kitchencontactnumber = $("#kitchencontactnumber").val();
        var fssai = $("#fssai").val().trim();
        var expirydate = $("#expiry-date").val().trim();
        var pan = $("#pan").val().trim();
        var gst = $("#gst").val();
        var documents = $("#documents").val();
        var isvaliddocuments = $("#isvaliddocumentfile").val();
        var menufile = $("#menufile").val();
        var isvalidmenufile = $("#isvalidmenufile").val();
        var profile_image = $("#profile_image").val();
        var isvalidprofile_image = $("#isvalidprofile_image").val();

        var isvalid = 1;
        
        if(kitchenname == ''){
            $("#knelement").addClass("manage-error");
            toastr.error('Please enter kitchen name !');
            isvalid = 0;
        }else{
            $("#knelement").removeClass("manage-error");
        }
        if(description == ''){
            $("#descelement").addClass("manage-error");
            toastr.error('Please enter description !');
            isvalid = 0;
        }else{
            $("#descelement").removeClass("manage-error");
        }
        if(email == ''){
            $("#emailelement").addClass("manage-error");
            toastr.error('Please enter email !');
            isvalid = 0;
        }else if(email != '' && !checkEmail(email)){
            $("#emailelement").addClass("manage-error");
            toastr.error('Email address is not valid !');
            isvalid = 0;
        }else{
            $("#emailelement").removeClass("manage-error");
        }
        if(address == ''){
            $("#addelement").addClass("manage-error");
            toastr.error('Please enter kitchen address !');
            isvalid = 0;
        }else {
            $("#addelement").removeClass("manage-error");
        }
        if(stateid == 0){
            $("#stelement").addClass("manage-error");
            toastr.error('Please select state !');
            isvalid = 0;
        }else{
            $("#stelement").removeClass("manage-error");
        }
        if(cityid == 0){
            $("#ctelement").addClass("manage-error");
            toastr.error('Please select city !');
            isvalid = 0;
        }else{
            $("#ctelement").removeClass("manage-error");
        }
        if(pincode == ''){
            $("#pcelement").addClass("manage-error");
            toastr.error('Please enter pincode !');
            isvalid = 0;
        }else{
            $("#pcelement").removeClass("manage-error");
        }
        if(contactname == ''){
            $("#cnelement").addClass("manage-error");
            toastr.error('Please enter contact person\'s name !');
            isvalid = 0;
        }else{
            $("#cnelement").removeClass("manage-error");
        }
        if(role == ''){
            $("#rlelement").addClass("manage-error");
            toastr.error('Please enter contact person\'s role !');
            isvalid = 0;
        }else{
            $("#rlelement").removeClass("manage-error");
        }
        if(mobilenumber == ''){
            $("#mnelement").addClass("manage-error");
            toastr.error('Please enter mobile number !');
            isvalid = 0;
        }else if(mobilenumber.length != 10){
            $("#mnelement").addClass("manage-error");
            toastr.error('Mobile number required 10 digits !');
            isvalid = 0;
        }else{
            $("#mnelement").removeClass("manage-error");
        }
        if(kitchencontactnumber == ''){
            $("#kcnelement").addClass("manage-error");
            toastr.error('Please enter kitchen\'s contact number !');
            isvalid = 0;
        }else if(kitchencontactnumber.length != 10){
            $("#kcnelement").addClass("manage-error");
            toastr.error('Allow 10 digits number of kitchen\'s contact number');
            isvalid = 0;
        }else{
            $("#kcnelement").removeClass("manage-error");
        }
        if(fssai == ''){
            $("#fssaielement").addClass("manage-error");
            toastr.error('Please enter FSSAI license no. !');
            isvalid = 0;
        }else if(fssai != '' && fssai.length != "14"){
            $("#fssaielement").addClass("manage-error");
            toastr.error('FSSAI license no. required 14 digits !');
            isvalid = 0;
        }else{
            $("#fssaielement").removeClass("manage-error");
        }
        if(expirydate == ''){
            $("#edelement").addClass("manage-error");
            toastr.error('Please enter expiry date !');
            isvalid = 0;
        }else{
            $("#edelement").removeClass("manage-error");
        }
        if(pan == ''){
            $("#panelement").addClass("manage-error");
            toastr.error('Please enter PAN card !');
            isvalid = 0;
        }else{
            $("#panelement").removeClass("manage-error");
        }
        if(gst == ''){
            $("#gstelement").addClass("manage-error");
            toastr.error('Please enter GST registration no. !');
            isvalid = 0;
        }else{
            $("#gstelement").removeClass("manage-error");
        }
        if(documents == '' && isvaliddocuments == 0){
            toastr.error('Please upload documents !');
            isvalid = 0;
        }else if(documents != '' && isvaliddocuments == 0){
            toastr.error('Accept document file only PDF & image format !');
            isvalid = 0;
        } 
        if(menufile == '' && isvalidmenufile == 0){
            toastr.error('Please upload menu !');
            isvalid = 0;
        }else if(menufile != '' && isvalidmenufile == 0){
            toastr.error('Accept menu file only PDF & image format !');
            isvalid = 0;
        } 
        if(profile_image != '' && isvalidprofile_image == 0){
            toastr.error('Accept profile image only image format !');
            isvalid = 0;
        } 
        if(isvalid == 1){
            
            var formData = new FormData($('#userform')[0]);
            $.ajax({
                url: SITE_URL+"my-account/update-profile",
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#btn-save').css('opacity','0.3').prop("disabled",true);
                },
                success: function(response){
                    if(response==1){
                        toastr.success('Profile update successfully.');
                        setTimeout(function(){
                            window.location.href=SITE_URL+"my-account";
                        },2000);
                    }else if(response==2){
                        toastr.error('Email already register !');
                    }else if(response==0){
                        toastr.error('Profile not update !');
                    }else{
                        toastr.error(response);
                    }
                    $('#btn-save').css('opacity','1').prop("disabled",false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            
        }
    }
</script>