<?php 
	require_once 'core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerpartial.php';

	$user_id=$user_data['id'];
  	$resource=$db->query("SELECT * from users where id='{$user_id}'");
  	$res=mysqli_fetch_assoc($resource);
	$emaill=$res['email'];


	if($cart_id!=''){
		$cartQ=$db->query("SELECT * from cart where id='{$cart_id}'");
		$result=mysqli_fetch_assoc($cartQ);
		$items=json_decode($result['items'],true);
		$i=1;
		$sub_total=0;
		$item_count=0;

	}
?>
<!--form-->

<div class="col-md-12">
	<div class="row">
		<h2 class="text-center">
			Cosul meu de cumparaturi
		</h2><hr>
		<?php if($cart_id==''):?>
			<div class="bg-danger">
				<p class="text-center text-danger">
					Cosul tau de cumparaturi este gol! Nu iti plac produsele noastre? &#9785
				</p>
			</div>
		<?php else :?>
			<table class="table table-bordered table-condensed table striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Produs</th>
						<th>Pret</th>
						<th>Cantitate</th>
						<th>Subtotal</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					 foreach($items as $item){
					 	$product_id=$item['id'];
					 	$productQ=$db->query("SELECT * FROM products where id='{$product_id}'");
					 	$product=mysqli_fetch_assoc($productQ);


						?>
						<tr>
							<td><?=$i;?></td>
							<td><?=$product['title'];?></td>
							<td><?=money($product['price']);?></td>
							<td>
							<button type="button" onclick= "update_cart('removeone','<?=$product['id'];?>')" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-minus"></span></button>
							<?=$item['quantity'];?>
							<?php if($item['quantity']<$product['qty']):?>
							<button type="button" onclick= "update_cart('addone','<?=$product['id'];?>')" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span></button>

						<?php else: ?>
							<span class="text-danger"> maxim disponibile</span>


								<?php endif;?>
							</td>
							<td><?=money($item['quantity'] * $product['price']);?></td>
						</tr>

						<?php 
						$i++;
						$item_count+=$item['quantity'];
						$sub_total+=$item['quantity'] * $product['price'];

					}

					$tax=TAXRATE * $sub_total;
					$tax=number_format($tax,2);
					$grand_total=$tax+$sub_total;

						?>
				</tbody>
			</table>
		
			<table class="table table-bordered table-condensed text-right">
				<legend>TOTAL</legend>
				<thead class="totals-table-header">
					<tr>
						<th>Numar total de produse</th>
						<th>Subtotal</th>
						<th>Taxe</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$item_count;?></td>
						<td><?=money($sub_total);?></td>
						<td><?=money(TAXRATE);?></td>
						<td class="bg-success"><?=money($grand_total);?></td>
					</tr>
				</tbody>
			</table>

			<!--verificare cos modal-->
			<?php if(is_logged_in()):?>
			<button type="button" class="pull-right btn btn-primary btn-lg" data-toggle="modal" data-target="#checkoutModal"><span class="glyphicon glyphicon-shopping-cart"></span> Pasul urmator >></button>
			<?php else:?>
				<a href="login.php" class="pull-right btn btn-primary btn-lg">Trebuie sa te loghezi pentru a cumpara!</a>
			<?php endif?>



			<div class="modal fade" id="checkoutModal" aria-labelledby="checkoutModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content ">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="checkoutModalLabel">Adresa de livrare</h4>
				      </div>
				     	<div class="modal-body">
					      <div class="row">
					        <form action="thankYou.php" method="post"  id="payment-form">
					        	<span class="bg-danger" id="payment-errors"></span>
					        	<div id="step1" style="display:block;">
					        		<div class="form-group col-md-6">
					        		 	<label for="full_name">Nume intreg:</label>
					        		 	<input name="full_name" id="full_name" type="text" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="email">Email:</label>
					        		 	<input name="email" id="email" type="email" readonly value="<?=$emaill;?>" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="street">Adresa :</label>
					        		 	<input name="street" id="street" type="text" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="street2">Numar:</label>
					        		 	<input name="street2" id="street2" type="text" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="city">Oras:</label>
					        		 	<input name="city" id="city" type="text" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="state">Judet:</label>
					        		 	<input name="state" id="state" type="text" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="country">Tara:</label>
					        		 	<input name="country" id="country" type="text" class="form-control">
					        		 </div>

					        		 <div class="form-group col-md-6">
					        		 	<label for="zip_code">ZIP Code:</label>
					        		 	<input name="zip_code" id="zip_code" type="text" class="form-control">
					        		 </div>

					        		
					        	</div>
					        	<div id="step2" style="display:none;">
					        		 <div class="form-group col-md-3">
						        		 <label for="name">Numele de pe card:</label>
						        		 <input type="text" id="name" class="form-control">
					        		 </div>
					        		 <div class="form-group col-md-3">
						        		 <label for="number">Numarul Cardului:</label>
						        		 <input type="text" id="number" class="form-control">
					        		 </div>
					        		 <div class="form-group col-md-2">
						        		 <label for="cvc">CVC</label>
						        		 <input type="text" id="cvc" class="form-control">
					        		 </div>
					        		 <div class="form-group col-md-2">
						        		 <label for="expire">Luna expirarii</label>
						        		<select id="exp-month"  class="form-control">
						        			<option value=""></option>
						        			<?php for($i=1;$i<13;$i++):?>
						        				<option  value="<?=$i;?>"><?=$i;?></option>

						        				<?php endfor;?>
						        			
						        		</select>
					        		 </div>

					        		 <div class="form-group col-md-2">
						        		 <label for="expire">Anul expirarii</label>
						        		<select id="exp-month"  class="form-control">
						        			<option value=""></option>
						        			<?php $yr=date("Y");?>
						        			<?php for($i=0;$i<10;$i++):?>
						        				<option  value="<?=$yr+$i;?>"><?=$yr+$i;?></option>

						        				<?php endfor;?>
						        			
						        		</select>
					        		 </div>
					        	</div>

					        
				      	 </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        
				        <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Pasul urmator >></button>
				        <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display:none;">  << Inapoi </button>
				        <button type="submit" class="btn btn-primary"  id="checkout_button" style="display:none;">Finalizeaza>></button>
				        </form> 
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
		<?php endif;?>	

	</div>


</div>

<script>


function back_address(){
	jQuery('#payment-errors').html("");
	jQuery("#step1").css("display","block");
	jQuery("#step2").css("display","none");
	jQuery("#next_button").css("display","inline-block");
	jQuery("#back_button").css("display","none");
	jQuery("#checkout_button").css("display","none");
	jQuery('#checkoutModalLabel').html("Adresa de livrare");
}


	function check_address(){
		var data={
			'full_name': jQuery('#full_name').val(),
			'email': jQuery('#email').val(),
			'street': jQuery('#street').val(),
			'street2': jQuery('#street2').val(),
			'city': jQuery('#city').val(),
			'state': jQuery('#state').val(),
			'country': jQuery('#country').val(),
			'zip_code': jQuery('#zip_code').val()
				};
				jQuery.ajax({
					url: '/_webProject/admin/parser/check_adress.php',
					method: "post",
					data:data,
					success:function(data){

						if(data.trim()=='passed')
						{

							
							jQuery("#step1").css("display","none");
							jQuery("#step2").css("display","block");
							jQuery("#next_button").css("display","none");
							jQuery("#back_button").css("display","inline-block");
							jQuery("#checkout_button").css("display","inline-block");
							jQuery('#checkoutModalLabel').html("Introduceti informatiile cardului");

						}
						if (data.trim() !='passed') {
							jQuery('#payment-errors').html(data);
					
						}
					},
					error:function(){alert("Ceva a mers prost...")}
				});

	};


	$( "#payment-form").submit(function( event ) {

		var data={
			'full_name': jQuery('#full_name').val(),
			'email': jQuery('#email').val(),
			'street': jQuery('#street').val(),
			'street2': jQuery('#street2').val(),
			'city': jQuery('#city').val(),
			'state': jQuery('#state').val(),
			'country': jQuery('#country').val(),
			'zip_code': jQuery('#zip_code').val()
				};
				jQuery.ajax({
					url: '/_webProject/thankYou.php',
					method: "post",
					data:data,
					success:function(){

					},
					error:function(){alert("Ceva a mers prost...")}
				});

});

</script>




<?php include 'includes/footer.php';
	

 ?>