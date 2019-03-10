<?php

// Ana sayfa
// Guvenlik
define("rs", true);

session_start();

require ("lib/project.php");

$page = "main";

$project = new project();

$product_categories = $project->get_product_category();


$action = "";
// Get kontrol et
if($_GET){
  // Urunleri goster
  if($_GET['action'] == "list" && $_GET['product_category_id']){

    $action = "list";

    $product_category_id = $_GET['product_category_id'];

    $products = $project->get_products_by_category($product_category_id);

  }

  if($_GET['action'] == "show" && !empty($_GET['product_id'])){

    $action = "show";

    $product_id = $_GET['product_id'];

    $product_one = $project->show_product($product_id);
  
  }


  if($_GET['action'] == "search" && !empty($_GET['query'])){

    $action = "search";

    $query = $_GET['query'];

    $products = $project->search_product($query);

  }

} else {

  $action = "list";

  $products = $project->get_products();

}


// Hata messaji
$message = "";

if(!empty($_SESSION['message'])){

  $message = $_SESSION['message'];

  unset($_SESSION['message']);

}


?>

<?php include("lib/header.php"); ?>

      <div class="row">

        <?php include("lib/left_user.php"); ?>

        <div class="col-lg-9">
        
        <?php if(!empty($message)){?>
        <br>
          <div class="alert alert-success" role="alert"><?php print $message; ?></div>

        <?php } ?>
        <?php if($action == "list" || $action == "search"){
          if(!empty($products)) { ?>
          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img class="d-block img-fluid" src="images/bigstock.jpg" >
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="images/kofem.jpg" >
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="images/thinkstock.jpg" >
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="row">

            <?php

            foreach ($products as $product) {

              $product_category = $project->show_product_category($product['product_category_id']);

             ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card border-primary h-100">
                <a href="http://megam.cf/index.php?action=show&amp;product_id=<?php echo $product['id']; ?>"><img class="card-img-top" src="<?php echo $product['image']; ?>" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title text-center">
                    <a class="text-info" href="http://megam.cf/index.php?action=show&amp;product_id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                  </h4>
                  <h5 class="text-center"><span><?php echo $product['price']; ?> TL</span></h5>
                </div>
                <div class="card-footer bg-transparent "><a href="cart.php?action=add&amp;product_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block">Sepete Ekle</a></div>
              </div>
            </div>

            <?php } } else { ?>

            <div class="pt-4"><div class="alert alert-danger">Maalesef aradığınız ürünler bulunamadı şimdilik. Gelecekte olma ihtimali yüksektir belkide.</div></div>

            <?php } } ?>



            <?php if($action == "show") {
              if(!empty($product_one)) { ?>


            <div class="row pt-4">
              <div class="col-md-6">
                <img class="img-fluid" src="<?php echo $product_one['image']; ?>" alt="">
              </div>

              <div class="col-md-6">

                <div class="card mb-3" style="max-width: 20rem;">

                <div class="card-body">
                  <h4 class="card-title text-center"><?php echo $product_one['name']; ?></h4>
                  <p class="card-text"><h2 class="text-center text-danger"><?php echo $product_one['price']; ?> TL</h2></p>
                </div>
                <div class="card-footer bg-transparent "><a href="cart.php?action=add&amp;product_id=<?php echo $product_one['id']; ?>" class="btn btn-primary btn-block">Sepete Ekle</a></div>
              </div>
                
              </div>
              <div class="col pt-3">
                <div class="card">
                  <div class="card-header">
                    Açıklama
                  </div>
                  <div class="card-body">
                    <blockquote class="blockquote mb-0">
                      <p><?php echo $product_one['description']; ?></p>
                    </blockquote>
                  </div>
                </div>
              </div>

            </div>
            <!-- /.row -->



            <?php } } ?>

          </div>
          <!-- /.row -->


        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

<?php include("lib/footer.php"); ?>










