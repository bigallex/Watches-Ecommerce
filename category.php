<?php

//pagina principala
//includem partea de conectare la baza de date
  require_once 'core/init.php';

  //partea de header cu toate includerile
  include 'includes/head.php';
  //bara de navigatie
  include 'includes/navigation.php';
  //imaginea si logo
  include 'includes/headerpartial.php';
  //bara din stanga
  include 'includes/leftbar.php';


  if (isset($_GET['cat'])) {
    $cat_id=sanitize($_GET['cat']);
  }
  else {
    $cat_id='';
  }
  $sql="SELECT * from products where categories='$cat_id'";
  $productQ=$db->query($sql);
  $category=get_category($cat_id);


?>

          <!--continut principal oferte -->
<div class="col-md-8">
  <div class="row">
    <h2 class="text-center"><?=$category['parent'].' '.$category['child'];?></h2>
    <!-- incarcam produsele din baza de date in mod dinamic, folosind while... produsele afisate sunt cele ce au flagul de oferta pus -->
    <?php while($item=mysqli_fetch_assoc($productQ)): ?>
    <div class="col-sm-3 text-center">
      <h4><?php echo $item['title']?></h4>
      <img src="<?php echo $item['image']?>" alt="<?php echo $item['title']?>" class="img-thumb"/>
      <p class="list-price text-danger">Pret initial:<s>$<?php echo $item['list_price']?></s></p>
      <p class="price">Pret redus: $<?php echo $item['price']?></p>
      <!-- apasand butonul de detalii se deschide o fereastra de tip modal, pe baza id-ului produsului, cu informatiile acestuia. vezi functia script detailsmodal(id) din footer, in care trimitem prin POST parametrul id -->
      <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $item['id']; ?>)">Detalii</button>
    </div>
  <?php endwhile; ?>
  </div>
</div>
<?php
//bara dreapta
  include 'includes/rightbar.php';
  //footer
  include 'includes/footer.php';
  ?>
