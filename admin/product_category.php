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

$page = "product_category";

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

		if($_POST){

			if(!empty($_POST['product_category_name'])){



				$product_category_name		= $_POST['product_category_name'];


				$project = new project();


				$result = $project->add_product_category($product_category_name);

				if($result){

					$_SESSION['message']  = "Menu kategori olusturuldu!";

					header("Location: product_category.php");

				} else {

					$_SESSION['message']  = "Menu kategori olusturuken bir hata olustu";

					header("Location: product_category.php");

				}





			}


		}


	} elseif ($action == "edit") {

		

		if($_POST){

			if(!empty($_POST['product_category_id']) &&!empty($_POST['product_category_name']) ){


				$product_category_id			= $_POST['product_category_id'];
				$product_category_name			= $_POST['product_category_name'];


				$project = new project();


				$result = $project->edit_product_category($product_category_id, $product_category_name);

				if($result){

					$_SESSION['message'] = "Menu kategori duzenledi!";

					header("Location: product_category.php");


				} else {

					$_SESSION['message'] = "Menu kategori duzenledigi zaman bir hata olustu";

					header("Location: product_category.php");

				}





			}


		}



		if(!empty($_GET['id'])){

			$id = $_GET['id'];

			$project = new project();


			$product_category = $project->show_product_category($id);
		}



	} elseif ($action == "delete") {
		


		if(!empty($_GET['id'])){

			$id = $_GET['id'];

			$project = new project();


			
			$result = $project->delete_product_category($id);

			if($result){

				$_SESSION['message'] = "Menu kategori silindi!";

				header("Location: product_category.php");


			} else {

				$_SESSION['message'] = "Menu kategori silinirken bir hata olustu";

				header("Location: product_category.php");

			}




		}




	} else {

		// bir sey yok
	}

} else {


	$project = new project();


	$product_categories = $project->get_product_category();

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
            <h1>Menü kategorileri!</h1>
            <p>Bu sayfada tüm menü kategorileri listeleme, ekleme ve düzenleme işlemleri yapabilirsiniz</p>

          </div>

        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-success" role="alert"><?php print $message; ?></div>

        <?php } ?>

          <?php if(!$action){ ?>

          <a href="product_category.php?action=new" class="btn btn-success float-right">Yeni menü</a>
          <br><br>
            <table class="table table-bordered">
			  <thead>
			    <tr>
			      <th># No</th>
			      <th>Menü adı</th>
			      <th>Düzenle</th>
			      <th>Sil</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($product_categories) {

			  		foreach ($product_categories as $product_category) { ?>
			  			

					    <tr>
					      <th scope="row"><?php echo $product_category['id']; ?></th>
					      <td><?php echo $product_category['name']; ?></td>
					      <td><a href="product_category.php?action=edit&id=<?php echo $product_category['id']; ?>" class="btn btn-primary">Düzenle</a></td>
					      	<td><a href="product_category.php?action=delete&id=<?php echo $product_category['id']; ?>" onclick="return confirm('Silinsin mi?')" class="btn btn-danger">Sil</a></td>
					    </tr>

			  	<?php }
			  	} else { ?>

			  		<tr>
			  			<td>Menü kategorileri bulunamadı</td>
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
			    <label for="product_category_name">Menü kategori adı</label>
			    <input type="text" class="form-control" id="product_category_name" name="product_category_name" placeholder="Menü kategori adı">
			  </div>
			  <button type="submit" class="btn btn-success btn-block">Yeni menü kategori oluştur</button>
			</form>

			<?php } elseif ($action == "edit") {?>

			<form action="" method="post">
			  <div class="form-group">
			    <label for="product_category_name">Masa adı</label>
			    <input type="text" class="form-control" id="product_category_name" name="product_category_name" placeholder="Menü kategori adı" value="<?php echo $product_category['name']; ?>">
			  </div>
			  <input type="hidden" name="product_category_id" value="<?php echo $product_category['id']; ?>">
			  <button type="submit" class="btn btn-success btn-block">Menü kategori düzenle</button>
			</form>

			<?php } ?>


        </div><!--/span-->

 
      </div><!--/row-->

      <hr>

   

 <?php include("lib/footer.php"); ?>










