<?php
//o functie de formatare a textului in vederea afisarilor de erori
//se primeste eroarea ca parametru si se afiseaza sub forma de bulleti intr-un chenar rosu
function display_errors($errors){
  $display='<ul class="bg-danger">';
  foreach($errors as $error)
  {
    $display.='<li class="text-danger">'.$error.'<br></li>';
  }
  $display.='</ul>';
  return $display;
}
//functie de verificare a caracaterelor din input impotriva sql-injection
function sanitize($text){
  return htmlentities($text,ENT_QUOTES,"UTF-8");
}

//returneaza suma de bani cu $ in fata
function money($number){
  return '$'.number_format($number,2);
}

function login($user_id)
{
  $_SESSION['SBUser']=$user_id;
  global $db;
  $date=date("Y-m-d H:i:s");
  $db->query("UPDATE users SET last_login='$date' where id='$user_id'");
  $_SESSION['success_flash']='Acum esti logat!';

  if(has_permission('admin') || has_permission('edit')){
    header('Location:admin/index.php');
  }
  else
  {
    header('Location:index.php');
  }

}
function is_logged_in(){
  if (isset($_SESSION['SBUser']) && $_SESSION['SBUser']>0) {
    return true;
  }
  else {
    return false;
  }
}
function loggin_error_redirect($url='login.php'){
  $_SESSION['error_flash']='Trebuie sa fii logat sa accesezi acea pagina';
  header('Location:'.$url);
}
function permission_error_redirect($url='login.php'){
  $_SESSION['error_flash']='Nu ai acces aici...';
  header('Location:'.$url);
}
//session_destroy();
function has_permission($permission='admin'){
  global $user_data;
  $permissions= explode(',',$user_data['permissions']);
  if (in_array($permission, $permissions, true)) {
    return true;
  }
  else
  return false;
}
 function pretty_date($date){
   return date("M d, Y h:i A", strtotime($date));
 }
function get_category($child_id){
  global $db;
  $id=sanitize($child_id);
  $sql="SELECT p.id as 'pid', p.category as 'parent', c.id as 'cid', c.category as 'child' 
        FROM categories c
        INNER JOIN categories p
        ON c.parent=p.id
        where c.id='$id'";
  $query=$db->query($sql);
  $category=mysqli_fetch_assoc($query);
  return $category;
}

 ?>
