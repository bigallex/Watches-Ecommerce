

</div><br><br>
<!--footer=-->
<footer class="col-md-12 text-center" id="footer">&copy; Copyright 2017 Tic Tac Shop by Alexander<br>
<br>
<a href="contact.php" class="btn btn-primary"><span class="glyphicon glyphicon-phone"></span>Contacteaza-ne!</a></footer>
<script>
//cu ajutorul acestei functii, logoul gliseaza pe imaginea din headerfull pana cand nu se mai vede
jQuery(window).scroll(function(){
  var vscroll=jQuery(this).scrollTop();
  jQuery('#logotext').css({
    "transform":"translate(0px,"+vscroll/2+"px)"})
});
//trimitem catre detailsmodal.php id-ul produsului
function detailsmodal(id){
  //data ce urmeaza a fi trimisa, respectiv id-ul..
  var data={"id" : id };
  jQuery.ajax({
    url:'/_webProject/includes/detailsmodal.php',
    method:"post",
    data: data,
    success: function(data){
      //in caz de succes, adaugam la pagina initiala bucata urmatoare de cod html cu id-ul #details-modal
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
    error: function(){
      alert("Ceva a mers prost... ");
    }
  });
};

function update_cart(mode,edit_id){
  var data={"mode": mode, "edit_id":edit_id};
  jQuery.ajax({
    url: '/_webProject/admin/parser/update_cart.php',
    method:"post",
    data:data,
    success:function(){
      location.reload();
    },
    error: function(){alert("Ceva a mers prost...");}
  });


}




function add_to_cart(id,available){
  jQuery('#modal_error').html("");
  var quantity=jQuery('#quantity').val();
  var product_id=id;
  var error='';
 if(quantity==''||quantity==0){
  error+='<p class="text-danger text-center">Trebuie sa introduci o cantitate!</p>';
  jQuery('#modal_errors').html(error);
  return;
  }   else if(quantity>available){
    error+='<p class="text-danger text-center">Trebuie sa introduci o cantitate mai mica decat cea din stoc!</p>';
     jQuery('#modal_errors').html(error);
     return;
   }
   else{
    jQuery.ajax({
      url: '/_webProject/admin/parser/add_cart.php',
      method: 'post',
      data:{'product_id': id, 'quantity':quantity, 'available':available },
      success: function(){
        location.reload();
      },
      error: function(){
        alert("ceva a mers prost////");
      }

    });
   }
};



</script>
       </body>
   </html>
