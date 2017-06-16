<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    header('Location:login.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //sql get producatori
  $sql="SELECT * from brand ORDER BY brand";
  $result=$db->query($sql);
  $errors=array();

//editare
  if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id=(int)$_GET['edit'];
    $edit_id=sanitize($edit_id);
    $sql2="SELECT * from brand where id='$edit_id'";
    $edit_result=$db->query($sql2);
    $eBrand=mysqli_fetch_assoc($edit_result);

  }

  //stergere din baza de dare
  if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id=(int)$_GET['delete'];
    $delete_id=sanitize($delete_id);
    $sql="DELETE from brand Where id = '$delete_id'";
    $db->query($sql);
    header('Location: brands.php');
  }

  //verificam daca sumbit s-a executat
  if(isset($_POST['add_submit'])){
    $brand=sanitize($_POST['brand']);
    //verificam daca s-a introdus text
    if($_POST['brand']==''){
      $errors[] .='Trebuie sa introduceti un producator!';
    }
    //verificam daca exista in baza de date
    $sql="SELECT * FROm brand where brand='$brand'";
    if (isset($_GET['edit'])) {
      # code...
      $sql="SELECT * from brand WHERE brand='$brand' and id!='$edit_id'";
    }
    $result=$db->query($sql);
    $count=mysqli_num_rows($result);
    if($count>0){
      $errors[] .=$brand.' exista deja in baza de date, alegeti alt producator.';
    }
    //display errors
    if(!empty($errors)){
      echo display_errors($errors);
    }
    else{
      //adaugam in baza de date
      $sql="INSERT into brand (brand) VALUES('$brand')";
      if (isset($_GET['edit'])) {
        # code...
        $sql="UPDATE brand SET brand='$brand' Where id='$edit_id";
      }
      $db->query($sql);
      header('Location: brands.php');
    }
  }
  ?>

  <h2 class="text-center">Administrator Producatori</h2><hr>
  <!-- form producator-->
  <div class="text-center">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <div class="form-group">
        <?php
        $brand_value='';
        if(isset($_GET['edit'])){
          $brand_value=$eBrand['brand'];
        }
        else {
          if (isset($_POST['brand'])) {
            # code...
            $brand_value=sanitize($_POST['brand']);
          }
        }?>
        <label for="brand"><?=((isset($_GET['edit']))?'Editeaza':'Adauga');?> producatori</label>
        <input type="text" name="brand" id="brand" value="<?=$brand_value;?>" class="form-control">
        <?php if(isset($_GET['edit'])) : ?>
          <a href="brands.php" class="btn btn-default">Anuleaza</a>
        <?php endif;?>
        <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Editeaza':'Adauga');?> producatori" class="btn btn-success">
      </div>
    </form>
  </div><hr>

  <table class="table table-bordered table-striped table-auto table-condensed" style="  width:auto;margin:0 auto;">
    <thead>
      <th> </th>
      <th>Producator</th>
      <th> </th>
    </thead>
    <tbody>
      <?php while($brand=mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><a href="brands.php?edit=<?=$brand['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><?=$brand['brand']?></td>
        <td><a href="brands.php?delete=<?=$brand['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a> </td>
      </tr>
      <?php endwhile ;?>
    </tbody>
  </table>
  <?php include 'includes/footer.php'; ?>
