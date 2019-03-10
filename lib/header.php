<!DOCTYPE html>
<html lang="tr">
  <head>
    <title>Megam</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
  </head>
  <body>
   
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
          
              <a class="navbar-brand" href="http://megam.cf/index.php">Megam</a>
              
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item <?php if($page=="main"){echo "active";} ?>">
                    <a class="nav-link" href="http://megam.cf/index.php">Ana sayfa</a>
                  </li>
                <?php if(empty($_SESSION['id'])) {?> 
                  <li class="nav-item <?php if($page=="registration"){echo "active";} ?>">
                    <a class="nav-link" href="http://megam.cf/registration.php">Kayıt ol</a>
                  </li>
                  <li class="nav-item <?php if($page=="login"){echo "active";} ?>">
                    <a class="nav-link" href="http://megam.cf/login.php">Giriş yap</a>
                  </li>
                  <li class="nav-item <?php if($page=="cart"){echo "active";} ?>">
                    <a class="nav-link" href="http://megam.cf/cart.php">Sepet</a>
                  </li>
                <?php } else { ?>
                <?php if($_SESSION['type'] == 2){?>
                  <li class="nav-item">
                    <a class="nav-link" href="http://megam.cf/admin/orders.php?action=view&amp;status=pending">Admin</a>
                  </li>
                <?php  } ?>
                <li class="nav-item">
                  <a class="nav-link" href="http://megam.cf/orders.php?action=view&amp;status=pending">Siparişler</a>
                </li>
                <li class="nav-item <?php if($page=="cart"){echo "active";} ?>">
                  <a class="nav-link" href="http://megam.cf/cart.php">Sepet</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="http://megam.cf/logout.php">Çıkış yap</a>
                </li>

              <?php } ?>
                  
                </ul>

              <form class="form-inline" action="index.php" method="get">
                <input type="hidden" name="action" value="search">
                <input class="form-control mr-sm-2" name="query" type="text" placeholder="Arama Kelimesi" aria-label="Search" required>

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ara</button>
              </form>


              </div>
      </div>
    </nav>

    </div> <!-- /container -->


    <div class="container">