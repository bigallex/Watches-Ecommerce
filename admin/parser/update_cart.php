<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/core/init.php';
	$mode=sanitize($_POST['mode']);
	$edit_id=sanitize($_POST['edit_id']);

	$cartQ=$db->query("SELECT * from cart where id='{$cart_id}'");
	$result=mysqli_fetch_assoc($cartQ);
	$items=json_decode($result['items'],true);
	$updated_items=array();
	$domain=false;
	if ($mode=='removeone') {
		foreach($items as $item)
		{
			if ($item['id']==$edit_id) {
				$item['quantity']--;
			}
			if($item['quantity']>0)
			{
				$updated_items[]=$item;
			}
		}
	}
	if ($mode=='addone') {
		foreach($items as $item)
		{
			if ($item['id']==$edit_id) {
				$item['quantity']++;
			}

			$updated_items[]=$item;
			
		}
	}
	if (!empty($updated_items)) {
		$json_updated=json_encode($updated_items);
		$db->query("UPDATE cart set items='{$json_updated}' where id='{$cart_id}'");
		$_SESSION['success_flash']='Cosul de cumparaturi a fost actualizat';
	}
	if(empty($updated_items)){
		$db->query("DELETE from cart where id='{$cart_id}'");
		setcookie(CART_COOKIE,'',1,"/",$domain, false);
	}

 ?>