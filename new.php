<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'./_webProject/core/init.php';
  include 'includes/head.php';

    $name=((isset($_POST['name']))?sanitize($_POST['name']):'');
    $email=((isset($_POST['email']))?sanitize($_POST['email']):'');
    $password=((isset($_POST['password']))?sanitize($_POST['password']):'');
    $confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $adresa=((isset($_POST['adresa']))?sanitize($_POST['adresa']):'');
    $telefon=((isset($_POST['telefon']))?sanitize($_POST['telefon']):'');

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
        $emailQuery=$db->query("SELECT * from users where email='$email'");
      $emailCount=mysqli_num_rows($emailQuery);

      if($emailCount!=0){
        $errors[]='Acest email exista deja in baza de date!';
      }
      $required=array('name','email','adresa','telefon','password','confirm');
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
        $db->query("INSERT into users (full_name,email, telefon, adresa, password,permissions) values('$name','$email','$telefon','$adresa','$hashed','user') ");

        $_SESSION['succes_flash']='Contul a fost creat cu succes!';
        header('Location:login.php');
      }
      }

      //sa fac functia de reset...
     ?>
  </div>
      <h2 class="text-center">Adauga un user nou</h2<hr>
      <form class="text-center" style="margin-top:15px;" action="new.php" method="post">
        <div class="form-group">
  <div class="row">
        <div class="form-group  col-md-5">
          <label for="name">Nume complet:</label>
          <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
        </div>
        <div class="form-group col-md-5">
          <label for="email">Email:</label>
          <input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
        </div>
        <div class="form-group col-md-5">
          <label for="password">Parola:</label>
          <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group  col-md-5">
          <label for="confirm">Confirma parola:</label>
          <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
        </div>
        <div class="form-group col-md-5 ">
          <label for="telefon">Telefon:</label>
          <input type="text" name="telefon" id="telefon" class="form-control" value="<?=$telefon;?>">
        </div>
        <div class="form-group col-md-5 ">
          <label for="adresa">Adresa:</label>
          <input type="text" name="adresa" id="adresa" class="form-control" value="<?=$adresa;?>">
        </div>
        <div class="form-group col-md-5 text-right" style="margin-top:10px;">
          <a href="users.php" class="btn btn-default">Anulare</a>
          <input type="submit" name="" value="Adauga user" class="btn btn-primary">

        </div>


</div></div>

      </form>
  <p class="text-right"><a href="/_webProject/index.php" alt="home">Viziteaza-ne!</a></p>
</div>


 <?php include 'includes/footer.php'; ?>

</div>
