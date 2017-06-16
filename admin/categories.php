<?php


require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/core/init.php';
if(!is_logged_in()){
  header('Location:login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM categories WHERE parent = 0";
$result = $db->query($sql);
$errors = array();
$category='';
$post_parent='';
//editare categorii

if (isset($_GET['edit'])&& !empty($_GET['edit']))
 {
   $edit_id=(int)$_GET['edit'];
   $edit_id=sanitize($_GET['edit']);
   $esql="SELECT * from categories where id='$edit_id'";
   $edit_result=$db->query($esql);
   $edit_category=mysqli_fetch_assoc($edit_result);

}


//delete categorie
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
  $delete_id=(int)$_GET['delete'];
  $delete_id=sanitize($_GET['delete']);
  $sql="SELECT * from categories Where id='$delete_id'";
  $result=$db->query($sql);
  $category=mysqli_fetch_assoc($result);
  if ($category['parent']==0) {
    $sql="DELETE From categories where parent='$delete_id'";
    $db->query($sql);
  }
  $dsql="DELETE from categories where id='$delete_id'";
  $db->query($dsql);
  header('Location: categories.php');
}

// cand este apelat formul
if(isset($_POST) && !empty($_POST)){

 $post_parent = sanitize($_POST['parent']);
 $category = sanitize($_POST['category']);

 $sqlform = "SELECT * FROM categories WHERE category ='$category' AND parent = '$post_parent'";
if (isset($_GET['edit'])) {
  $id=$edit_category['id'];
  $sqlform="SELECT * from categories where category='$category' and parent='$post_parent' and id!='$id'";
}

 $fresult = $db->query($sqlform);
 $count = mysqli_num_rows($fresult);
 //testam daca categoria introdusa este goala
 if($category == ''){
  $errors[] .= 'Categoria nu poate fi lasata goala';

 }

 //testam daca exista categoria introdusa in baza de date
 if($count > 0){
  $errors[] .= $category.'Exista deja aceasta categorie';
 }
 //afisam erorile aparute pe parcursul completarii datelor
 if(!empty($errors)){
 $display = display_errors($errors);?>
 <script>
    jQuery('document').ready(function(){
  jQuery ('#errors').html('<?php echo $display;?>');

    });

 </script>


<?php } else{
 //inserare si update
 $updatesql = "INSERT INTO categories(category,parent)VALUES ('$category','$parent')";
 if (isset($_GET['edit'])) {
   $updatesql="UPDATE categories SET category='$category', parent='$post_parent' where id='$edit_id'";
 }
 $db->query($updatesql);
 header('location:categories.php');
}
}

$category_value='';
$parent_value=0;

if (isset($_GET['edit'])) {
  $category_value=$edit_category['category'];
  $parent_value=$edit_category['parent'];
}else{
  if (isset($_POST)) {
    $category_value=$category;
    $parent_value=$post_parent;

  }
}

?>
<h2 class="text-center">Categorii</h2><hr>


<div class="row">

<!-- form -->

<div class="col-md-6">
<form class="form"action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:' ');?>" method="post">
<legend><?=((isset($_GET['edit']))?'Editare':'Adauga');?> categorie</legend>
<div id="errors"></div>
<div class="form-group">
 <label for="parent">Parinte</label>
<select class="form-control" name="parent" id="parent">
<option value="0"><?=(($parent_value==0)?'Parent':'');?></option>
<?php while ($parent = mysqli_fetch_assoc($result)):?>
<option value= "<?php echo $parent['id'];?>"<?=(($parent_value==$parent['id'])?' selected="selected"':'');?>><?php echo $parent['category'];?></option>
<?php endwhile; ?>
</select>
</div>
<div class="form-group">
 <label for="category">Categorie</label>
<input type="text" class="form-control" id="category" name="category" value="<?=$category_value;?>">
</div>

<div class="form-group">
<input type="submit" class="btn btn-success"  value="<?=((isset($_GET['edit']))?'Editare':'Adauga');?> categorie">
</div>

 </form>
</div>


<!--tabelul de categorii-->
<div  class="col-md-6">
<table class="table table-bordered">
<thead>
    <th>Categorii</th><th>Parinte</th><th></th>
</thead>

<tbody>
<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$result = $db-> query($sql);
while($parent = mysqli_fetch_assoc($result)):
$parent_id = (int)$parent['id'];
$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
$cresult = $db->query($sql2);
?>

<tr class="bg-primary">
<td> <?php echo $parent['category'];?> </td>
<td>Parinte</td>
<td>
         <a href="categories.php?edit=<?php echo $parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
      <a href="categories.php?delete=<?php echo $parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>

</td>
</tr>
<?php while($child = mysqli_fetch_assoc($cresult)):?>
<tr class="bg-info">
<td> <?php echo $child['category'];?> </td>
<td><?php echo $parent['category'];?> </td>
<td>
         <a href="categories.php?edit=<?php echo $child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
      <a href="categories.php?delete=<?php echo $child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>

</td>
</tr>
<?php endwhile;?>
<?php endwhile;?>
</tbody>
</table>
</div>
</div>

 <?php include 'includes/footer.php'; ?>﻿
