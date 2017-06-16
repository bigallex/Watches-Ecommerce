<?php

// incarcam in mod dinamic din baza de date itemii, respectiv categoriile si subcategoriile
$sql="SELECT * FROM categories Where parent=0";
$parentQ=$db->query($sql);
?>
<!-- incarcam bara de meniu -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <a href="index.php" class="navbar-brand"> Tic Tac Shop</a>
      <ul class="nav navbar-nav">
        <!-- aici in primul while incarcam categoriile, categoriile parinte -->
        <?php while($parent=mysqli_fetch_assoc($parentQ)) : ?>
          <?php
          $parent_id=$parent['id'];
          $sql2="select * from categories where parent='$parent_id'";
          $childQ=$db->query($sql2);
          ?>
          <!--Itemi meniu -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">

              <!-- pentru fiecare categorie  afisata mai sus, in bucla while afisam subcategoriile -->
              <?php while($child=mysqli_fetch_assoc($childQ)) : ?>
                <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category'] ?></a></li>
              <?php endwhile;?>
            </ul>
          </li>
        <?php endwhile; ?>
        <li >
          <a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>Cos de cumparaturi</a>
        </li>


        <?php if(!is_logged_in()): ?>
           <li><a href="login.php">Log in</a></li>
           <li><a href="new.php">Cont nou</a></li>
        <?php else:?>
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bine ati venit,  <?php echo $user_data['first']; ?>!<span class="caret"> </span</a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="change_detail.php">Modificare profil</a></li>
            <li><a href="change_password.php">Modificare parola</a></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </li>
      <?php endif;?>



      </ul>




    </div>
</nav>
