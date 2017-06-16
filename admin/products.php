<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/core/init.php';

	if(!is_logged_in()){
	 header('Location:login.php');
	}
	include 'includes/head.php';
	include 'includes/navigation.php';

	if (isset($_GET['delete'])) {
		$id=sanitize($_GET['delete']);
		$db->query("UPDATE products SET deleted=1 where id='$id'");
		header('Location:products.php');
	}


	if(isset($_GET['add']) || isset($_GET['edit'])) {
		$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
		$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");

		$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']) : '');
		$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']) : '');
		$category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']) : '');
		$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']) : '');
		$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']) : '');
		$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']) : '');
		$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']) : '');
		$qty = ((isset($_POST['qty']) && $_POST['qty'] != '')?sanitize($_POST['qty']) : '');

		if(isset($_GET['edit'])) {
			$edit_id = (int)$_GET['edit'];
			$productResults = $db->query("SELECT * FROM products WHERE id = '{$edit_id}'");
			$product = mysqli_fetch_assoc($productResults);

			$qty = ((isset($_POST['qty']) && !empty($_POST['qty']))?sanitize($_POST['qty']) : $product['qty']);
			$title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']) : $product['title']);
			$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']) : $product['brand']);
			$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']) : $product['categories']);
			$price = ((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']) : $product['price']);
			$list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']) : $product['list_price']);
			$description = ((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']) : $product['description']);

			$parentQ = $db->query("SELECT * FROM categories WHERE id = '{$category}'");
			$parentResult = mysqli_fetch_assoc($parentQ);
			$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']) : $parentResult['parent']);
		}

		if($_POST) {
			//$title = sanitize($_POST['title']);
			//$brand = sanitize($_POST['brand']);
			$categories = sanitize($_POST['child']);
			$price = sanitize($_POST['price']);
			$list_price = sanitize($_POST['list_price']);
			$qty=$_POST['qty'];
			$description = sanitize($_POST['description']);

			$errors = array();

			$required = array('title', 'brand', 'price', 'parent', 'child', 'qty');
			foreach($required as $field) {
				if($_POST[$field] == '') {
					$errors[] = 'Toate campurile cu * sunt necesare!';
					break;
				}
			}

			if(!empty($_FILES)) {
				var_dump($_FILES);
				$photo = $_FILES['photo'];
				$name = $photo['name'];
				$nameArray = explode('.', $name);
				$fileName = $nameArray[0];
				$fileExt = $nameArray[1];
				$mime = explode('/', $photo['type']);
				$mimeType = $mime[0];
				$mimeExt = $mime[1];
				$tmpLoc = $photo['tmp_name'];
				$fileSize = $photo['size'];

				$allowed = array('png', 'jpg', 'jpeg', 'gif');
				$uploadName = md5(microtime()).'.'.$fileExt;
				$uploadPath = BASEURL.'images/'.$uploadName;
				$dbpath = '/_webProject/images/'.$uploadName;
				if($mimeType != 'image') {
					$errors[] .= 'Trebuie sa fie o imagine.';
				}
				if(!in_array($fileExt, $allowed)) {
					$errors[] .= 'Extensia trebuie sa fie png, jpg, jpeg, sau gif.';
				}
				if($fileSize > 15000000) {
					$errors[] .= 'Dimensiunea imaginii trebuie sa fie sub 15 MB.';
				}
				if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
					$errors[] .= 'Extensia nu se potriveste.';
				}
			}

			if(!empty($errors)) {
				echo display_errors($errors);
			} else {
				/* Upload file and insert into database. */
				if (!emtpy($_FILES)) {
					move_uploaded_file($tmpLoc, $uploadPath);
				}
				
				$insertSql = "INSERT INTO products (`title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `qty`) VALUES ('{$title}', '{$price}', '{$list_price}', '{$brand}', '{$categories}', '{$dbpath}', '{$description}', '{$qty}')";
				$db->query($insertSql);
				header("Location: products.php");
			}
		}
?>


<!-- Form -->
<h2 class="text-center"><?php echo ((isset($_GET['edit']))?'Editeaza' : 'Adauga'); ?> produs</h2>
<hr>

<form class="form" action="products.php?<?php echo ((isset($_GET['edit']))?'edit='.$edit_id : 'add=1'); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group col-md-3">
		<label for="title">Titlu*:</label>
		<input class="form-control" type="text" name="title" id="title" value="<?php echo $title; ?>">
	</div>
	<div class="form-group col-md-3">
		<label for="brand">Brand*:</label>
		<select class="form-control" name="brand" id="brand">
			<option value=""<?php echo (($brand == '')?' selected' : ''); ?>></option>
			<?php while($b = mysqli_fetch_assoc($brandQuery)) : ?>
			<option value="<?php echo $b['id']; ?>"<?php echo (($brand == $b['id'])?' selected' : ''); ?>><?php echo $b['brand']; ?></option>
			<?php endwhile; ?>
		</select>
	</div>
  <div class="form-group col-md-3">
			<label for="parent">Categorie:*</label>
			<select class="form-control" id="parent" name="parent">
				<option value=""></option>
				<?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
					<option value="<?php echo $parent['id']; ?>"><?php echo $parent['category']; ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="child">Subcatgorie:*</label>
			<select id="child" name="child" class="form-control">
			</select>
		</div>
	<div class="form-group col-md-3">
		<label for="price">Pret*:</label>
		<input class="form-control" type="text" name="price" id="price" value="<?php echo $price?>">
	</div>
	<div class="form-group col-md-3">
		<label for="list_price">Pret oficial:</label>
		<input class="form-control" type="text" name="list_price" id="list_price" value="<?php echo $list_price?>">
	</div>
	<div class="form-group col-md-3">
		<label for="qty">Cantitate</label>
		<input id="qty" type="number" name="qty" min="0" class="form-control"  value="<?php echo $qty ?>">
	</div>
	<div class="form-group col-md-6">
		<label for="photo">Fotografie produs:</label>
		<input class="form-control" type="file" name="photo" id="photo">
	</div>
	<div class="form-group col-md-6">
		<label for="description">Description</label>
		<textarea class="form-control" name="description" id="description" rows="6"><?php echo $description ?></textarea>
	</div>
	<div class="form-group pull-right clearfix">
		<a class="btn btn-default" href="products.php">Cancel</a>
		<input class="btn btn-success" type="submit" value="<?php echo ((isset($_GET['edit']))?'Editeaza' : 'Adauga'); ?> produs">
	</div>
	<div class="clearfix"></div>
</form>


<!-- Modal -->
</div>
<?php
	} else {

	$presults = $db->query("SELECT * FROM products WHERE deleted = 0");
	if(isset($_GET['oferta'])) {
		$id = (int)$_GET['id'];
		$oferta = (int)$_GET['oferta'];
		$db->query("UPDATE products SET oferta = '{$oferta}' WHERE id = '{$id}'");
		header("Location: products.php");
	}
?>


<!-- Table -->
<h2 class="text-center">Produse</h2>
<a class="btn btn-success pull-right" id="add_product_btn" href="products.php?add=1">Adauga produs</a>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th></th>
		<th>Produse</th>
		<th>Pret</th>
		<th>Categorie</th>
		<th>Stoc</th>
		<th>Oferta</th>
    <th>Vandut</th>
	</thead>
	<tbody>
		<?php while($product = mysqli_fetch_assoc($presults)) :
			$childID = $product['categories'];
			$result = $db->query("SELECT * FROM categories WHERE id = '{$childID}'");
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$presult = $db->query("SELECT * FROM categories WHERE id = '$parentID'");
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].' ~ '.$child['category'];
		?>
		<tr>
			<td>
				<a class="btn btn-xs btn-default" href="products.php?edit=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-xs btn-default" href="products.php?delete=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
			</td>
			<td><?php echo $product['title']; ?></td>
			<td><?php echo money($product['price']); ?></td>
			<td><?php echo $category; ?></td>
      <td><?php echo $product['qty']; ?></td>
			<td>
				<a class="btn btn-xs btn-default" href="products.php?oferta=<?php echo (($product['oferta'] == 0)?'1' : '0'); ?>&id=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-<?php echo (($product['oferta'] == 1)?'minus': 'plus'); ?>"></span></a>&nbsp; <?php echo (($product['oferta'] == 1)?'Produs la oferta' : ''); ?>
			</td>
			<td>0</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>


<?php
	}
	include 'includes/footer.php';?>
