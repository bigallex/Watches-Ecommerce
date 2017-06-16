<?php

//pagina principala
//includem partea de conectare la baza de date
  require_once 'core/init.php';

  //partea de header cu toate includerile
  // BASEURL.'/_webProject/admin/login.php';
  if(has_permission('admin')){
    header('Location:admin/index.php');
  }

  include 'includes/head.php';
  //bara de navigatie
  include 'includes/navigation.php';
  //imaginea si logo
  include 'includes/headerfull.php';
  //bara din stanga
  include 'includes/leftbar.php';

  $sql="SELECT * from products where oferta=1";
  $oferta=$db->query($sql);
?>

          <!--continut principal oferte -->
<div class="col-md-8">
  <div class="row">
    <h2 class="text-center">Oferta Produse</h2>
    <!-- incarcam produsele din baza de date in mod dinamic, folosind while... produsele afisate sunt cele ce au flagul de oferta pus -->
    <?php while($item=mysqli_fetch_assoc($oferta)) : ?>
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
