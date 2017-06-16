<?php
// stabilim o conexiunea la baza de date tictac, utilizatorul root si ip-ul localhost
$db=mysqli_connect('127.0.0.1','root','','tictac');
session_start();//sesiune.
//verificam daca a fost intampinata vreo eroare in conectarea la baza de date
if(mysqli_connect_errno())
{
  echo 'Conexiunea la baza de date a intampinat eroarea: '. mysqli_connect_errno();
  die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/config.php';
require_once BASEURL.'helpers/helpers.php';
//cart
$cart_id='';

if(isset($_COOKIE[CART_COOKIE]))
{
  $cart_id=sanitize($_COOKIE[CART_COOKIE]);
} 

if (isset($_SESSION['SBUser'])) {
  $user_id=$_SESSION['SBUser'];
  $query=$db->query("SELECT * from users where id='$user_id'");
  $user_data=mysqli_fetch_assoc($query);
  $fn=explode(' ', $user_data['full_name']);
  $user_data['first']=$fn[0];
  $user_data['last']=$fn[1];
}

if (isset($_SESSION['success_flash'])) {
  echo '<div class="bg-success"><p class="text-succes text-center">'.$_SESSION['success_flash'].'</p></div>';
  unset($_SESSION['success_flash']);
}

if (isset($_SESSION['error_flash'])) {
  echo '<div class="bg-danger"><p class="text-succes text-center">'.$_SESSION['error_flash'].'</p></div>';
  unset($_SESSION['error_flash']);
}
 ?>
