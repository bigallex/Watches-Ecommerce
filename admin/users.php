<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/core/init.php';
  if(!is_logged_in()){
    header('Location:login.php');
  }
  if (!has_permission('admin')) {
    permission_error_redirect('index.php');
  }


  include 'includes/head.php';
  include 'includes/navigation.php';

	if (isset($_GET['delete'])) {
		$delete_id=sanitize($_GET['delete']);
		$db->query("DELETE from users where id='$delete_id'");
		$_SESSION['succes_flash']='Userul a fost sters';
		header('Location:users.php');
	}
	if (isset($_GET['add'])) {
		$name=((isset($_POST['name']))?sanitize($_POST['name']):'');
		$email=((isset($_POST['email']))?sanitize($_POST['email']):'');
		$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
		$confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
		$adresa=((isset($_POST['adresa']))?sanitize($_POST['adresa']):'');
		$telefon=((isset($_POST['telefon']))?sanitize($_POST['telefon']):'');
		$permissions=((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');

		$errors=array();
		if ($_POST) {

			$emailQuery=$db->query("SELECT * from users where email='$email'");
			$emailCount=mysqli_num_rows($emailQuery);

			if($emailCount!=0){
				$errors[]='Acest email exista deja in baza de date!';
			}
			$required=array('name','email','adresa','telefon','password','confirm','permissions');
			foreach ($required as $f) {
				if (empty($_POST[$f])) {
					$errors[]='Trebuie sa completati toate campurile!';
					break;
				}
			}
			if(strlen($password)<6)
			{
				$errors[]='Parola aleasa trebuie sa fie de minim 6 caractere!';
			}
			if($password!=$confirm)
			{
				$errors[]='Parolele nu coincid!';
			}
			if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
				$errors[]='Trebuie sa introduceti un email valid!';
			}
			if(!empty($errors))
			{
				echo display_errors($errors);
			}
			else{
				//add user_data
				$hashed=password_hash($password,PASSWORD_DEFAULT);
				$db->query("INSERT into users (full_name,email, telefon, adresa, password,permissions) values('$name','$email','$telefon','$adresa','$hashed','$permissions') ");

				$_SESSION['succes_flash']='Utilizatorul a fost aduagat cu succes!';
				header('Location:users.php');
			}
		}



		?>
			<h2 class="text-center">Adauga un user nou</h2<hr>
			<form class="" action="users.php?add=1" method="post">
				<div class="form-group  col-md-6">
					<label for="name">Nume complet:</label>
					<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
				</div>
				<div class="form-group col-md-6">
					<label for="email">Email:</label>
					<input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
				</div>
				<div class="form-group col-md-6 ">
					<label for="password">Parola:</label>
					<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
				</div>
				<div class="form-group  col-md-6">
					<label for="confirm">Confirma parola:</label>
					<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
				</div>
				<div class="form-group col-md-6 ">
					<label for="telefon">Telefon:</label>
					<input type="text" name="telefon" id="telefon" class="form-control" value="<?=$telefon;?>">
				</div>
				<div class="form-group col-md-6 ">
					<label for="adresa">Adresa:</label>
					<input type="text" name="adresa" id="adresa" class="form-control" value="<?=$adresa;?>">
				</div>
				<div class="form-group col-md-6 ">
					<label for="permisiuni">Permisiuni:</label>
					<select class="form-control" name="permissions">
						<option value="user"<?=(($permissions=='')?'selected':'user');?>>User</option>
						<option value="editor"<?=(($permissions=='editor')?'selected':'');?>>Editor</option>
						<option value="admin, editor"<?=(($permissions=='')?'selected':'admin,editor');?>>Administrator</option>
					</select>
				</div>
				<div class="form-group col-md-6 text-right" style="margin-top:25px;">
					<a href="users.php" class="btn btn-default">Anulare</a>
					<input type="submit" name="" value="Adauga user" class="btn btn-primary">

				</div>




			</form>


		<?php
	}else {

	$userQuery=$db->query("SELECT * from users order by full_name");
  ?>

  <h2>Users</h2>
	<a href="users.php?add=1" class="pull-right btn btn-success" id="add_product_btn">Adauga un user nou</a>
	<br>
	<hr>

	<table class="table table-bordered table-striped table-condensed">
		<thead>
			<th></th>
			<th>Nume</th>
			<th>Email</th>
			<th>Telefon</th>
			<th>Adresa</th>
			<th>Data inregistrarii</th>
			<th>Last login</th>
			<th>Permissions</th>
		</thead>
		<tbody>
			<?php while($user=mysqli_fetch_assoc($userQuery)): ?>
				<tr>
					<td>
						<?php if($user['id']!=$user_data['id']): ?>
							<a href="users.php?delete=<?=$user['id']?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
						<?php endif ; ?>
					</td>
					<td><?=$user['full_name'];?></td>
					<td><?=$user['email'];?></td>
					<td><?=$user['telefon'];?></td>
					<td><?=$user['adresa'];?></td>
					<td><?=pretty_date($user['join_date']);?></td>
					<td><?=(($user['last_login']=='0000-00-00 00:00')?'NEVER':pretty_date($user['last_login']));?></td>
					<td><?=$user['permissions'];?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
  <?php }include 'includes/footer.php'; ?>
