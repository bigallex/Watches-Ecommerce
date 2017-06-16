<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <a href="/_webProject/admin/index.php" class="navbar-brand"> Tic Tac ADMIN</a>
      <ul class="nav navbar-nav">

        <li><a href="brands.php">Producatori</a></li>
        <li><a href="categories.php">Categorii</a></li>
        <li><a href="products.php">Produse</a></li>
        <li><a href="transactions.php">Istoric tranzactii</a></li>
        <li><a href="users.php">Users</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bine ati venit,  <?php echo $user_data['first']; ?>!<span class="caret"> </span</a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="change_password.php">Schimbare parola</a></li>
            <li><a href="../logout.php">Log out</a></li>


          </ul>

        </li>




          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">aaaaaaaa<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#">aaaaaaaa</a></li>
            </ul>
          </li> -->
      </ul>

    </div>
</nav>
