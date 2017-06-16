<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'./_webProject/core/init.php';
  include 'includes/head.php';

  $email=((isset($_POST['email']))?sanitize($_POST['email']):'');
  $email=(trim($email));
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
    $password=(trim($password));
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
        if(empty($_POST['email']))
        {
          $errors[]='Trebuie sa introdceti emailul!';
        }
        if (empty($_POST['password'])) {
          $errors[]='Trebuie sa introdceti parola!';
        }
        //validare email
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors[]='Trebuie sa introduci o adresa de email valida!';
      }

      //parola este mai mare de 6 caractere

      if (strlen($password)<6) {
        $errors[]='Parola trebuie sa fie de minim 6 caractere';
      }


        //verificam daca exista in baza de database
        $query=$db->query("SELECT * from users where email='$email'");
        $user=mysqli_fetch_assoc($query);
        $userCount=mysqli_num_rows($query);
        if($userCount<1){
          $errors[]='Acest utilizator nu exista in baza de date!';
        }
        //verificam daca este la fel cu cea din baza de date;
        if(!password_verify($password, $user['password']))
        {
          $errors[]='Parola nu se potriveste!';
        }



        if (!empty($errors)) {
          echo display_errors($errors);
        }
        else{
          //acept
          $user_id=$user['id'];
          login($user_id);
        }
      }

      //sa fac functia de reset...
     ?>
  </div>
  <h2 class="text-center">Login</h2><hr>
  <form action="login.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <div class="form-group">
      <label for="password">Parola:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="form-group">
     <input type="button" value="Reset" class="btn btn-primary">
      <input type="submit" value="Login" class="btn btn-primary">
    </div>
  </form>
  <p class="text-right"><a href="/_webProject/index.php" alt="home">Viziteaza-ne!</a></p>
</div>


 <?php include 'includes/footer.php'; ?>

</div>
