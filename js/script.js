//atunci cand dam scroll in jos, logo-ul ramane pana cand nu se mai vede deloc
  jQuery(window).scroll(function(){
    var vscroll=jQuery(this).scrollTop();
    jQuery('#logotext').css({
      "transform":"translate(0px,"+vscroll/2+"px)"})
  });
//trimitem catre detailsmodal.php id-ul produsului
  function detailsmodal(id){
    alert(id);
    var data={"id":id};
    jQuery.ajax({
      url:<?php echo BASEURL;?>+'includes/detailsmodal.php',
      method:"post",
      data: data,
      succes: function(){
        jQuery('body').append(data);
        jQuery('#details-modals').modal('toggle');
      },
      error: function(){}
    });
  }
