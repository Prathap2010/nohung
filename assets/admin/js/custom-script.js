$('form').on('reset', function(e){
    setTimeout(function() {resetdata();});
});
function isValidWebsite(url) {
  var urlregex = new RegExp(
      "^(http:\/\/www.|http:\/\/[0-9A-Za-z].|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
  return urlregex.test(url);
  //return /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}
function validateYouTubeUrl(url) {

  if (url != undefined || url != '') {
    var regExp = /^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/;
    var match = url.match(regExp);
    if (match && match[1].length == 11) {
        // Do anything for being valid
        // if need to change the url to embed url then use below line
        return match[1];
      }
      else {
        // Do anything for not being valid
      }
    }
}
function isUrlValid(url) {
  return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

function float_validation(event, value, len=5, lastdigitslen=2){
  var present=0;
  var count=0;
  
  if((event.which < 45 || event.which > 58 || event.which == 47) && (event.which!=8 && event.which!=0)) {
    return false;
      event.preventDefault();
  
  } // prevent if not number/dot

  if(event.which == 46 && value.indexOf('.') != -1) {
      return false;
      event.preventDefault();
  } // prevent if already dot

  if(event.which == 45 && value.indexOf('-') != -1) {
          return false;
      event.preventDefault();
  } // prevent if already dot

  if(event.which == 45 && value.length>0) {
      event.preventDefault();
  } // prevent if already -
  if(value.length==len && (event.which!=8 && event.which!=0)){
    if(event.keyCode != 46)
    return false;
  }
  do{
    present=value.indexOf(".",present);

    if(present!=-1)
    {
      count++;
      present++;
      }
    }while(present!=-1);
    
  if(count==1 && (event.which!=8 && event.which!=0)) {
    var lastdigits=value.substring(value.indexOf(".")+1,value.length);
    if(lastdigits.length>=lastdigitslen){
      //alert("Two decimal places only allowed");
      event.keyCode=0;
      return false;
    }
  }
  return true;
};
var pattern = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
var validemail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
/*  ==========================================================================
Functions
========================================================================== */
function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}
function isPhonecode(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=43) {
   return false;
 }
 return true;
}
function ValidateEmail(mail){  
  //var res = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  var res = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (res.test(mail)) {  
    return true;
  }  
  return false;  
} 
function CheckPassword(inputtxt) { 
  // var passw = /^(?=.*[!@#$%_''""/=(){}\^\&*-.\?])[a-zA-Z0-9!@#$%_''""/=(){}\^\&*-.\?]{6,20}$/;
  var passw = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%_''""/=(){}\^\&*-.`\?]).{6,20}$/;
  if(inputtxt.match(passw)){ 
    return true;
  }else{ 
    return false;
  }
}
function alphanumeric(e){ 
  var regex = new RegExp("^[a-zA-Z0-9]+$");
  var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (regex.test(str)) {
      return true;
  }

  e.preventDefault();
  return false;
}
function onlyAlphabets(evt) {
  evt = (evt) ? evt : window.event;
  var inputValue = evt.charCode;
  
  if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)){
      evt.preventDefault();
  }
}
/*==========================================================================
Here is a function provides you more options to set min of special chars, min of upper chars, min of lower chars and min of number (min = 0)
========================================================================== */
function randomPassword(len = 8, minUpper = 1, minLower = 1, minNumber = 1, minSpecial = 1) {
    let chars = String.fromCharCode(...Array(127).keys()).slice(33),//chars
        A2Z = String.fromCharCode(...Array(91).keys()).slice(65),//A-Z
        a2z = String.fromCharCode(...Array(123).keys()).slice(97),//a-z
        zero2nine = String.fromCharCode(...Array(58).keys()).slice(48),//0-9
        specials = chars.replace(/\w/g, '')
    if (minSpecial < 0) chars = zero2nine + A2Z + a2z
    if (minNumber < 0) chars = chars.replace(zero2nine, '')
    let minRequired = minSpecial + minUpper + minLower + minNumber
    let rs = [].concat(
        Array.from({length: minSpecial ? minSpecial : 0}, () => specials[Math.floor(Math.random() * specials.length)]),
        Array.from({length: minUpper ? minUpper : 0}, () => A2Z[Math.floor(Math.random() * A2Z.length)]),
        Array.from({length: minLower ? minLower : 0}, () => a2z[Math.floor(Math.random() * a2z.length)]),
        Array.from({length: minNumber ? minNumber : 0}, () => zero2nine[Math.floor(Math.random() * zero2nine.length)]),
        Array.from({length: Math.max(len, minRequired) - (minRequired ? minRequired : 0)}, () => chars[Math.floor(Math.random() * chars.length)]),
    )
    return rs.sort(() => Math.random() > Math.random()).join('')
} 
/*  ==========================================================================
Multiple Delete
========================================================================== */
var currentdids = [];
var position = 0;
var inputs = $("input[type='checkbox']");


function deleterow(id,deleteurl){

  currentdids = id;
  swal({    title: "Are you sure want to delete?",
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Yes, delete it!",   
    closeOnConfirm: false }, 
    function(isConfirm){   
      if (isConfirm) {   
        multipledelete(deleteurl);
      }else{
        if($('#deletecheckall').prop('checked') == true){
          $('#deletecheckall').prop('checked', false);
        }
        for(var i=1;i<inputs.length;i++){
          if($('#'+inputs[i].id).prop('checked') == true){
            $('#'+inputs[i].id).prop('checked', false);
          }
        }
        currentdids = [];
        position = 0;
      }
  });
}

function multipledelete(url){ 
  var datastr = 'ids='+currentdids;
  var baseurl = url;
  $.ajax({
    url: baseurl,
    type: 'POST',
    data: datastr,
    success: function(data){
      location.reload();
    }
  });
}
     
function enabledisable(val,id,uurl,title,disable_class,enable_class,disable_title,enable_title,disable_test,enable_text){
  if(val==0){
    swal({    title: 'Are you sure want to '+title+'?',
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Yes, "+title+" it!",
      timer: 2000,   
      closeOnConfirm: false }, 
      function(isConfirm){
        if (isConfirm) {   
          enabledisableconfirm(val,id,uurl,title,disable_class,enable_class,disable_title,enable_title,disable_test,enable_text);
          
        }
      });
  }else{
    swal({    title: 'Are you sure want to '+title+'?',
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Yes, "+title+" it!",
      timer: 2000,   
      closeOnConfirm: false }, 
      function(isConfirm){
        if (isConfirm) {   
          enabledisableconfirm(val,id,uurl,title,disable_class,enable_class,disable_title,enable_title,disable_test,enable_text);
        }
      });
  }
}
function enabledisableconfirm(val,id,uurl,title,disable_class,enable_class,disable_title,enable_title,disable_text,enable_text)
{
  var datastr = 'id='+id+'&val='+val;
  $.ajax({
    url: uurl,
    type: 'POST',
    data: datastr,
    beforeSend: function(){
      $('.mask').show();
      $('#loader').show();
      },
    success: function (data) {
      if(data == id){

        var enablehtml = "<a href='#' class='btn-floating btn-flat waves-effect waves-light white-text "+disable_class+"' onclick=\"enabledisable(0,"+id+",'"+uurl+"','"+disable_title+"','"+disable_class+"','"+enable_class+"','"+disable_title+"','"+enable_title+"','"+disable_text.replace(/'/g, "\\'")+"','"+enable_text.replace(/'/g, "\\'")+"')\" title='"+disable_title+"'>"+disable_text+"</a>";
        var disablehtml = "<a href='#' class='btn-floating btn-flat waves-effect waves-light white-text "+enable_class+"' onclick=\"enabledisable(1,"+id+",'"+uurl+"','"+enable_title+"','"+disable_class+"','"+enable_class+"','"+disable_title+"','"+enable_title+"','"+disable_text.replace(/'/g, "\\'")+"','"+enable_text.replace(/'/g, "\\'")+"')\" title='"+enable_title+"'>"+enable_text+"</a>";
        swal.close();
        if(val == 0){
          $("#span"+id).html(disablehtml);
        }else{
          $("#span"+id).html(enablehtml);
        }
      }else if(data==0 && uurl == SITE_URL+"sms-gateway/sms-gateway-enable-disable"){
        swal("Failed", "Another SMS Gateway was Enabled !", "error");
      }
    },
    complete: function(){
      $('.mask').hide();
      $('#loader').hide();
    },
  });
}
function readURL(input,name) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#'+name).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
  
}   

function setsidebarcollapsed(){

  var sessionclass = "";
  if ($("body").hasClass("sidebar-collapsed")) {
    sessionclass = "sidebar-scroll";
  }else{
    sessionclass = "sidebar-collapsed";
  }
  $.ajax({
    url: SITE_URL+"process/setsidebarcollapsed",
    type: 'POST',
    data: {sessionclass: String(sessionclass)},
    success: function(response){
      if ($("body").hasClass("sidebar-collapsed")) {
        $("body").removeClass("sidebar-scroll");
        $(".static-sidebar").removeClass("scroll-pane has-scrollbar");
        $(".sidebar").removeClass("scroll-content");
      }else{
        $("body").addClass("sidebar-scroll");
        $(".static-sidebar").addClass("scroll-pane has-scrollbar");
        $(".sidebar").addClass("scroll-content");
      }
    },
    error: function(xhr) {
      //alert(xhr.responseText);
    },
  });
}
function formatBytes(bytes) {
  if(bytes < 1024) return bytes + "Bytes";
  else if(bytes < 1048576) return parseInt(bytes / 1024) + "KB";
  else if(bytes < 1073741824) return parseInt(bytes / 1048576) + "MB";
  else return parseInt(bytes / 1073741824) + "GB";
}