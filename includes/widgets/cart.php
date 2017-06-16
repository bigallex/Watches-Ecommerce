<head>
 <link href="../../css/main.css" rel="stylesheet">
 </head>

<h3 class="text-center"> Cos de cumparaturi</h3>
<div>
	<?php if(empty($cart_id)): ?>
		<p> Cosul tau de cumparaturi este gol! </p>
	<?php else : 
		$cartQ=$db->query("SELECT * from cart where id='{$cart_id}' ");
		$results=mysqli_fetch_assoc($cartQ);
		$items=json_decode($results['items'],true);
		$i=1;
		$sub_total=0;
	?>
	<table class="table table-condensed" id="cart_widget">
		<tbody>
			<?php foreach($items as $item):
				$productQ=$db->query("SELECT * from products where id='{$item['id']}'");
				$product=mysqli_fetch_assoc($productQ);
			?>
				<tr>
					<td><?=$item['quantity'];?></td>
					<td><?=substr($product['title'],0,15);?></td>
					<td><?=money($item['quantity'] * $product['price']);?></td>
				</tr> 

			<?php
			$sub_total+=($item['quantity'] * $product['price']);
			 endforeach;?>	
			 <tr>
			 	<td></td> 
			 	<td>Subtotal</td>
			 	<td><?=money($sub_total);?></td>
			 </tr>
		</tbody>
	</table>
	<a href="cart.php" class="btn btn-xs btn-primary pull-right">Vezi cosul</a>
	<div class="clearfix">
		
	</div>

	<?php endif;?>
</div>