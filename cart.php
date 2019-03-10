<?php

// Ana sayfa
// Guvenlik
define("rs", true);

session_start();

require ("lib/project.php");

$page = "cart";

$project = new project();

$product_categories = $project->get_product_category();

$tables = $project->get_tables();


// Hata messaji
$message = "";

if(!empty($_SESSION['message'])){

  $message = $_SESSION['message'];

  unset($_SESSION['message']);

}


// Cart array
if(!isset($_SESSION['cart'])){
  $_SESSION['cart'] = array();
}



$action = "";

if($_GET){

    // Add to cart
    if($_GET['action'] == "add" && !empty($_GET['product_id'])){

      $action = "add";

      $product_id = intval($_GET['product_id']);
      
      $product_one = $project->show_product($product_id);

      if(!empty($_SESSION['cart'][$product_one['id']])){
        // test
        $_SESSION['cart'][$product_one['id']]['quantity']++;
        $message = "Ürün sepete başarıyla eklendi";

      } else {

        $_SESSION['cart'][$product_one['id']]['info'] = $product_one;
        $_SESSION['cart'][$product_one['id']]['quantity'] = 1;
        $message = "Ürün sepete başarıyla eklendi";
      }

    }

    // Add to cart
    if($_GET['action'] == "update" && !empty($_GET['product_id']) && !empty($_GET['product_quantity'])){

      $action = "add";

      $product_id = intval($_GET['product_id']);

      $product_quantity = intval($_GET['product_quantity']);
      
      $product_one = $project->show_product($product_id);

      if(isset($_SESSION['cart'][$product_one['id']])){
        // product quantity check
        if($product_quantity <= 0){
          unset($_SESSION['cart'][$product_id]);
        } else {
          $_SESSION['cart'][$product_one['id']]['quantity'] = $product_quantity;
          $message = "Ürün sepete başarıyla eklendi";
        }
        

      } else {

        $_SESSION['cart'][$product_one['id']]['info'] = $product_one;

        $message = "Ürün sepete başarıyla eklendi";
      }

    }

    // Remove from cart
    if ($_GET['action'] == "remove" && !empty($_GET['product_id'])) {

      $action = "remove";

      $product_id = intval($_GET['product_id']);

      unset($_SESSION['cart'][$product_id]);

      $message = "Ürün sepetten başarıyla silindi.";

    }

    if($_GET['action'] == "view"){
      $action = "view";
    }

} else {
  $action = "view";
}

// Cart products here
$cart = $_SESSION['cart'];

if($_POST){

  if(!empty($_POST['order']) && !empty($_POST['table']) ){

    $action = "view";

    // table
    $table = intval($_POST['table']);

    // random order id
    $order_id = mt_rand(1000, 999999);

    // user id
    $user_id = $_SESSION['id'];

    // total
    $total = 0;

    // calculate total price
    if(!empty($cart)){
      foreach ($cart as $product) {
        $total = $total + $product['info']['price'] * $product['quantity'];
      }
    }

    // if less than 0
    if($total <= 0){

      $_SESSION['message'] = "Sepette ürün yok veya toplam ürün fiyatı 0 TL'den az.";
      header("Location: cart.php?action=view");

    } else {

      $action = "complete";

      // current timestamp
      $created = time();

      // create order
      $order = $project->add_order ($order_id, $table, $user_id, $total, $created);

      // add products to order
      if(!empty($cart)){
        foreach ($cart as $product) {
          $ordered_products = $project->add_order_product ($order_id, $product['info']['id'], $product['quantity']);
        }
      }

      unset($_SESSION['cart']);
    }

  } else {
    $action = "view";
  }

}




?>

<?php include("lib/header.php"); ?>

      <div class="row">

        <?php include("lib/left_user.php"); ?>

        <div class="col-lg-9 pb-5">
        
        <?php if(!empty($message)){?>
        <br>
        <div class="alert alert-info alert-dismissible fade show pt-3" role="alert" ><?php echo $message; ?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>

        <?php } ?>
        <?php if($action == "add" || $action == "remove" || $action == "view") {?>
            <div class="container">
              <div class="row pt-4">
                <h1>Sepet</h1>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Ürün adı</th>
                      <th scope="col">Ürün miktarı</th>
                      <th scope="col">Ürün fiyat</th>
                      <th scope="col">Sil</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $total = 0;
                    if(!empty($cart)){

                    foreach ($cart as $product) {


                      $total = $total + $product['info']['price'] * $product['quantity'];

                    ?>
                    <tr>
                      <td><?php echo $product['info']['name']; ?></td>
                      <td>
                        <form method="GET" action="cart.php">
                          <input type="hidden" name="action" value="update">
                          <input type="hidden" name="product_id" value="<?php echo $product['info']['id']; ?>"/>
                          <div class="row">
                            <div class="col-4">
                              <input class="form-control form-control-sm" type="number" name="product_quantity" min="1" max="10" value="<?php echo $product['quantity']; ?>">
                            </div>
                            <div class="col-8">
                              <button type="submit" class="btn btn-primary btn-sm">Güncelle</button>
                            </div>
                          </div>
                          
                        </form>
                      </td>
                      <td><b><?php echo $product['info']['price']; ?> TL</b></td>
                      <td><a href="cart.php?action=remove&amp;product_id=<?php echo $product['info']['id']; ?>" class="btn btn-danger">Sil</a></td>
                    </tr>
                    <?php } } else {?>
                    <tr>
                      <td colspan=5 class="text-center">Sepette hiç bir şey yok</td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.row -->
            <form method="post" class="py-auto" action="cart.php?action=complete">
              
              <div class="form-group">
                <div class="mb-auto">
                  <div class="card mb-3">
                    <div class="card-header">Masa seçimi</div>
                    <div class="card-body">
                      <h5 class="card-text">

                        <div class="form-group">
                          <label for="table">Sipariş vermek istediğiniz masayı seçiniz</label>
                          <select class="form-control" id="table" name="table">
                          <?php 
                          if(!empty($tables)){

                            foreach ($tables as $table) { ?>

                            <option value="<?php echo $table['id']; ?>"><?php echo $table['name']; ?> </option>

                            <?php
                            }
                          } else { ?>

                            <option value="1">Standart masa</option>

                          <?php
                          }

                          ?>
                          </select>
                        </div>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="mb-auto">
                  <div class="card mb-3">
                    <div class="card-header">Sepet Özeti</div>
                    <div class="card-body">
                      <h4 class="card-text">Toplam <span class="text-info"><?php print $total; ?></span> TL</h4>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
              <?php
              // Check if user has been logged in
              if(!empty($_SESSION['id'])) {?>
                <input type="hidden" name="order" value="1"/>
                <button type="submit" class="btn btn-primary btn-lg btn-block float-right">Sipariş oluştur</button>
                <?php } else { ?>
                <div class="alert alert-danger" role="alert">Sipariş vermek için giriş yapınız veya kayıt olunuz.</div>
                <?php } ?>
              </div>
            </form>
        <?php }

        if($action == "complete"){ ?>
        <div class="pt-4">
          <div class="card">
            <h4 class="card-header">Sipariş</h4>
              <div class="card-body">
                <h4 class="card-title">Siparişiniz alındı</h4>
              <h4 class="card-text">
                Sipariş no <?php echo $order_id; ?><br><br>
                En kisa zamaninda siparişiniz masanıza gelecektir.<br><br>
                Lütfen masadan ayrılmayınız ve paranızı hazırlayınız.<br><br>

                Toplam ödenecek <?php print $total; ?> TL</h4>
            </div>
          </div>
          <br>
          <a href="orders.php?action=view&amp;status=pending" class="btn btn-primary btn-lg btn-block float-right pt-2">Sipariş takibi</a>
        </div>

        <?php } ?>


            

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

<?php include("lib/footer.php"); ?>










