// $(window).scroll(function(){
//     var sticky = $('.sticky'),
//         scroll = $(window).scrollTop();

//     if (scroll >= 100) sticky.addClass('fixedHeader');
//     else sticky.removeClass('fixedHeader');
//   });

//   $(document).ready(function (){
//       $(".toggleButton").click(function (){
//           $(".mobile_menus ul").toggleClass("mobile_menusToggle")
//       });
//   });

//   $(document).ready(function (){
//     $("#closedMenes").click(function (){
//         $(".mobile_menus ul").toggleClass("mobile_menusToggle")
//     });
// });

$(document).ready(function() {
    $("#MenuToggleButton").click(function() {
        $("body").toggleClass("collapseMenu");
    })
    notifyme.config({
        showtime: 4000,
        position:"topright" // topleft, bottomleft, bottmright
    });
});
// $(window).resize(function() {
//     $("body").toggleClass("collapseMenu");
// });
jQuery(document).ready(function() {
    if (jQuery(window).width() < 991) {
        $("body").toggleClass("collapseMenu");
    }
    toastr.options = {
        // "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        // "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
      
});
$(".myButton1").click(function () {
    $('.myDiv1').toggle("'slide', {direction: 'right' }, 1000");
});
$("#hide").click(function () {
    $('.myDiv1').toggle("'slide', {direction: 'left' }, 1000");
});
$('.next').click(function(){
    // $(this).parent().parent().hide().next().show();//hide parent and show next
 });
 
 $('.back').click(function(){
    $(this).parent().parent().hide().prev().show();//hide parent and show previous
 });
 /* $('.nextnew').click(function(){
    $(this).parent().parent().hide().next().show();//hide parent and show next
 });
 
 $('.backnew').click(function(){
    $(this).parent().parent().hide().prev().show();//hide parent and show previous
 });
 $(document).ready(function(){
    $('[data-toggle="popover"]').popover();
  }); */
// jQuery(window).resize(function() {
//     if (jQuery(window).width() < 900) {
//         $("body").toggleClass("collapseMenu");
//     }
// });
function checkEmail(email){  
    var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (pattern.test(email)) {  
      return true;
    }else{
        return false;  
    }  
} 
function isNumeric(event) {
    event = (event) ? event : window.event;
    var charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
}
