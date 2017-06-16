<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/core/init.php';
	$name=sanitize($_POST['full_name']);
	$email=sanitize($_POST['email']);
	$street=sanitize($_POST['street']);
	$street2=sanitize($_POST['street2']);
	$city=sanitize($_POST['city']);
	$state=sanitize($_POST['state']);
	$zip_code=sanitize($_POST['zip_code']);
	$country=sanitize($_POST['country']);



	if($cart_id!=''){ 
		$cartQ=$db->query("SELECT * from cart where id='{$cart_id}'");
		$result=mysqli_fetch_assoc($cartQ);
		$items=json_decode($result['items'],true);
		$i=1;
		$sub_total=0;
		$item_count=0;
	}
	foreach($items as $item){
		$item_id=$item['id'];

		
//adjust inventory


		$product_id=$item['id'];
		$productQ=$db->query("SELECT * FROM products where id='{$product_id}'");
		$product=mysqli_fetch_assoc($productQ);
		$dif=$product['qty'] - $item['quantity'];
		$db->query("UPDATE products SET qty='{$dif}' where id='{$product_id}'");



		$i++;
		$item_count+=$item['quantity'];
		$sub_total+=$item['quantity'] * $product['price'];

	}
	$tax=TAXRATE * $sub_total;
	$tax=number_format($tax,2);
	$grand_total=$tax+$sub_total;
	



	//update cart
	$db->query("UPDATE cart SET paid=1 where id='{$cart_id}'");
	$db->query("INSERT into transactions (cart_id,full_name,	email,	street,	street2,	city,	state,	zip_code,	country,	sub_total,	tax,	grand_total) VALUES( '$cart_id', '$name', '$email', '$street','$street2', '$city','$state', '$zip_code', '$country','$sub_total','$tax','$grand_total' )");
	$domain=false;
	setcookie(CART_COOKIE, '', 1,"/",$domain,false);

	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerpartial.php';

?>

<h1 class="text-center text-success"> Va multumim! </h1>
<p> Ati reusit sa platiti cu succes <?=money($grand_total);?> produsele. Va mai asteptam pe la noi! </p>

<?php
	include 'includes/footer.php';

 ?>