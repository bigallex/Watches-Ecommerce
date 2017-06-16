<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'./_webProject/core/init.php';
  if(!is_logged_in())
  {
    login_error_redirect();
  }
  include 'includes/head.php';
  $hashed=$user_data['password'];
  $user_id=$user_data['id'];
  $resource=$db->query("SELECT * from users where id='{$user_id}'");
  $res=mysqli_fetch_assoc($resource);
  $emaill=$res['email'];

  $old_password=((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
  $name=((isset($_POST['name']))?sanitize($_POST['name']):$res['full_name']);
  $adresa=((isset($_POST['adresa']))?sanitize($_POST['adresa']):$res['adresa']);
  $telefon=((isset($_POST['telefon']))?sanitize($_POST['telefon']):$res['telefon']);

  $old_password=(trim($old_password));
 
  $errors=array();

  ?>
  <!--partea de css este comuna.. asa ca am preferat ca aceste elemente de stil fiind necesare doar aici, sa le scriu aici -->
  <head>
  <style>
  body{
    background-image: url("/_webProject/images/ceasbuz.jpg");
    background-size: 100vw 100vh;
    background-attachment: fixed;
  }
</style>
</head>
<div class="" id="login-form">
  <div >
    <?php
      if($_POST){
        //form validare
        if(empty($_POST['old_password']))
        {
          $errors[]='Trebuie sa introdceti parola actuala';
        }
       
        if(!password_verify($old_password, $hashed))
        {
          $errors[]='Parola actuala introdusa este incorecta!';
        }
        if (!empty($errors)) {
          echo display_errors($errors);
        }
        else{
          $db->query("UPDATE users SET full_name='$name', adresa='$adresa', telefon='$telefon' where id='$user_id'");

          $_SESSION['success_flash']='Profilul a fost modificat!';
          header('Location:index.php');
        }
      }
     ?>
  </div>
  <h2 class="text-center">Modificare profil</h2><hr>
  <form action="change_detail.php" method="post">
      <div class="form-group">
      <label for="name">Nume intreg:</label>
      <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
    </div>
    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" name="email" id="email" class="form-control" readonly value="<?=$res['email'];?>">
    </div>
    <div class="form-group">
      <label for="adresa">Adresa:</label>
      <input type="text" name="adresa" id="adresa" class="form-control" value="<?=$adresa;?>">
    </div>
    <div class="form-group">
      <label for="telefon">Telefon:</label>
      <input type="text" name="telefon" id="telefon" class="form-control" value="<?=$telefon;?>">
    </div>
        <div class="form-group">
      <label for="old_password">Parola actuala:</label>
      <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
    </div>
    
    <div class="form-group">
      <a href="index.php" class="btn-default btn">Anulare</a>
      <input type="submit" value="Modifica profil" class="btn btn-primary">
    </div>
  </form>
</div>


 <?php include 'includes/footer.php'; ?>

</div>
