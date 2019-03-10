<?php

// Ana sayfa

// Guvenlik
define("rs", true);


set_include_path('../');


require ("lib/project.php");


session_start();

if(empty($_SESSION['id'])) {

	header("Location: http://megam.cf/login.php");

}

if($_SESSION['type'] == 1){

	header("Location: http://megam.cf/index.php");

}
// Page update
$page = "products";

// Hata messaji
$message = "";

if(!empty($_SESSION['message'])){

	$message = $_SESSION['message'];

	unset($_SESSION['message']);

}

$action = false;


if(!empty($_GET['action'])){

	$action = $_GET['action'];


	if($action == "new"){

		$project = new project();

		if($_POST){

			if(!empty($_POST['product_name']) && !empty($_POST['product_image']) &&  !empty($_POST['product_desc']) && !empty($_POST['product_price']) && !empty($_POST['product_category_id']) ){



				$product_name				= $_POST['product_name'];
				$product_image				= $_POST['product_image'];
				$product_desc				= $_POST['product_desc'];
				$product_price				= $_POST['product_price'];
				$product_category_id		= $_POST['product_category_id'];

				


				$result = $project->add_product($product_name, $product_image, $product_desc, $product_price, $product_category_id);

				if($result){

					$_SESSION['message']  = "Menu ürünü olusturuldu!";

					header("Location: products.php");

				} else {

					$_SESSION['message']  = "Menu ürünü olusturuken bir hata olustu";

					header("Location: products.php");

				}


			}


		}

		$product_categories = $project->get_product_category();


	} elseif ($action == "edit") {

		

		if($_POST){

			if(!empty($_POST['product_id']) && !empty($_POST['product_name']) && !empty($_POST['product_image']) && !empty($_POST['product_desc']) && !empty($_POST['product_price']) && !empty($_POST['product_category_id'])){

				$product_id					= $_POST['product_id'];
				$product_name				= $_POST['product_name'];
				$product_image				= $_POST['product_image'];
				$product_desc				= $_POST['product_desc'];
				$product_price				= $_POST['product_price'];
				$product_category_id		= $_POST['product_category_id'];
				

				$project = new project();


				$result = $project->edit_product($product_id, $product_name, $product_image, $product_desc, $product_price, $product_category_id);

				if($result){

					$_SESSION['message'] = "Menu ürünü duzenledi!";

					header("Location: products.php");


				} else {

					$_SESSION['message'] = "Menu ürünü duzenledigi zaman bir hata olustu";

					header("Location: products.php");

				}

			}

		}

		if(!empty($_GET['id'])){

			$id = $_GET['id'];

			$project = new project();


			$product = $project->show_product($id);

			$product_categories = $project->get_product_category();
		}



	} elseif ($action == "delete") {
		


		if(!empty($_GET['id'])){

			$id = $_GET['id'];

			$project = new project();


			
			$result = $project->delete_product($id);

			if($result){

				$_SESSION['message'] = "Menu ürünü silindi!";

				header("Location: products.php");


			} else {

				$_SESSION['message'] = "Menu ürünü silinirken bir hata olustu";

				header("Location: products.php");
			}

		}

	} else {

		// bir sey yok
	}

} else {


	$project = new project();


	$products = $project->get_products();

}









?>


<?php include("lib/header.php"); ?>

    <div class="container pt-2">

      <div class="row">
      	

      	<?php include("lib/left_admin.php"); ?>


        <div class="col-12 col-md-9 pt-5">
          <p class="float-right d-md-none">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <h1>Menü ürünleri!</h1>
            <p>Bu sayfada tüm menü ürünleri listeleme, ekleme ve düzenleme işlemleri yababilirsinizk</p>

          </div>

        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-success" role="alert"><?php print $message; ?></div>

        <?php } ?>

          <?php if(!$action){ ?>

          <a href="products.php?action=new" class="btn btn-success float-right">Yeni menü ürünü</a>
          <br><br>
            <table class="table table-bordered">
			  <thead>
			    <tr>
			      <th># No</th>
			      <th>Ürün adı</th>
			      <th>Ürün fıyat</th>
			      <th>Ürün kategorisi</th>
			      <th>Düzenle</th>
			      <th>Sil</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($products) {

			  		foreach ($products as $product) {




					$product_category = $project->show_product_category($product['product_category_id']);


			  		 ?>
			  			

					    <tr>
					      <th scope="row"><?php echo $product['id']; ?></th>
					      <td><?php echo $product['name']; ?></td>
					      <td><?php echo $product['price']; ?> tl</td>
					      <td><?php echo $product_category['name']; ?></td>
					      <td><a href="products.php?action=edit&id=<?php echo $product['id']; ?>" class="btn btn-primary">Düzenle</a></td>
					      	<td><a href="products.php?action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Silinsin mi?')" class="btn btn-danger">Sil</a></td>
					    </tr>

			  	<?php }
			  	} else { ?>

			  		<tr>
			  			<td>Menü ürünleri bulunamadı</td>
			  			<td></td>
			  			<td></td>
			  			<td></td>
			  		</tr>

			  	<?php }

			  	?>
			  
			  </tbody>
			</table>

			<?php } elseif ($action == "new") { ?>


			<form action="" method="post">
			  <div class="form-group">
			    <label for="product_name">Ürün adı</label>
			    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Ürün adı">
			  </div>
			  <div class="form-group">
			    <label for="product_image">Ürün resmi</label>
			    <input type="text" class="form-control" id="product_image" name="product_image" placeholder="Ürün resmi">
			  </div>
			  <div class="form-group">
			    <label for="product_desc">Ürün bilgi</label>
			    <textarea class="form-control" id="product_desc" name="product_desc" rows="3"></textarea>
			  </div>
			  <div class="form-group">
			    <label for="product_price">Ürün fiyat</label>
			    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Ürün fiyatı">
			  </div>

			 <div class="form-group">
			    <label for="product_category_id">Ürün kategori</label>
			    <select class="form-control" id="product_category_id" name="product_category_id">
			    <?php 

			    if($product_categories){

			    	foreach ($product_categories as $product_category) { ?>

			    	<option value="<?php echo $product_category['id']; ?> "><?php echo $product_category['name']; ?> </option>

			    	<?php
			    	}

			    }

			    ?>
			    </select>
			  </div>
			  <button type="submit" class="btn btn-success btn-block">Yeni ürün oluştur</button>
			</form>

			<?php } elseif ($action == "edit") {?>

			<form action="" method="post">
			  <div class="form-group">
			    <label for="product_name">Ürün adı</label>
			    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Ürün adı" value="<?php echo $product['name']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="product_image">Ürün resmi</label>
			    <input type="text" class="form-control" id="product_image" name="product_image" placeholder="Ürün resmi"  value="<?php echo $product['image']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="product_desc">Ürün bilgi</label>
			    <textarea class="form-control" id="product_desc" name="product_desc" rows="3"><?php echo $product['description'];?></textarea>
			  </div>
			  <div class="form-group">
			    <label for="product_price">Ürün fiyat</label>
			    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Ürün fiyatı" value="<?php echo $product['price']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="product_category_id">Ürün kategori</label>
			    <select class="form-control" id="product_category_id" name="product_category_id">
			    <?php 

			    if($product_categories){

			    	foreach ($product_categories as $product_category) { ?>

			    	<option value="<?php echo $product_category['id']; ?> "><?php echo $product_category['name']; ?> </option>

			    	<?php
			    	}

			    }

			    ?>
			    </select>
			  </div>
			  <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
			  <button type="submit" class="btn btn-success btn-block">Ürünü düzenle</button>
			</form>

			<?php } ?>


        </div><!--/span-->

 
      </div><!--/row-->

      <hr>

   

<?php include("lib/footer.php"); ?>









