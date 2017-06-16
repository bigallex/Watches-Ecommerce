<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'./_webProject/core/init.php';
  if(!is_logged_in())
  {
    login_error_redirect();
  }
  include 'includes/head.php';
  $hashed=$user_data['password'];
  $user_id=$user_data['id'];
  $old_password=((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
  $old_password=(trim($old_password));
  $password=((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password=(trim($password));
  $confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $confirm=(trim($confirm));
  $new_hashed=password_hash($password, PASSWORD_DEFAULT);
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
        if (empty($_POST['password'])) {
          $errors[]='Trebuie sa introdceti noua parola!';
        }
        if (empty($_POST['confirm'])) {
          $errors[]='Trebuie sa confirmati parola!';
        }

      //parola este mai mare de 6 caractere

      if (strlen($password)<6) {
        $errors[]='Parola trebuie sa fie de minim 6 caractere';
      }

      //verificam daca noua parola o verifica pe cea confirm
      if(strcmp($password, $confirm)!=0)
      {
          $errors[]='Parolele nu se potrivesc!';

      }
        //verificam daca este la fel cu cea din baza de date;
        if(!password_verify($old_password, $hashed))
        {
          $errors[]='Parola actuala introdusa este incorecta!';
        }
        if (!empty($errors)) {
          echo display_errors($errors);
        }
        else{
          $db->query("UPDATE users SET password='$new_hashed' where id='$user_id'");

          $_SESSION['success_flash']='Parola a fost schimbata!';
          header('Location:index.php');
        }
      }
     ?>
  </div>
  <h2 class="text-center">Schimbare parola</h2><hr>
  <form action="change_password.php" method="post">
    <div class="form-group">
      <label for="old_password">Parola actuala:</label>
      <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
    </div>
    <div class="form-group">
      <label for="password">Parola noua:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>

    <div class="form-group">
      <label for="confirm">Confirma noua parola:</label>
      <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
    </div>
    <div class="form-group">
      <a href="index.php" class="btn-default btn">Anulare</a>
      <input type="submit" value="Schimba parola" class="btn btn-primary">
    </div>
  </form>
</div>


 <?php include 'includes/footer.php'; ?>

</div>
