<?php

// Ana sayfa

// Guvenlik
define("rs", true);


set_include_path('../');


require ("lib/project.php");


session_start();




if(empty($_SESSION['id'])) {

	header("Location: login.php");

}

if($_SESSION['type'] == 1){

	header("Location: index.php");

}


$page = "tables";

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

			if(!empty($_POST['table_name']) && !empty($_POST['table_max_person'])){



				$table_name			= $_POST['table_name'];
				$table_max_person	= $_POST['table_max_person'];


				$project = new project();


				$result = $project->add_table($table_name, $table_max_person);

				if($result){

					$_SESSION['message']  = "Masa olusturuldu!";

					header("Location: tables.php");

				} else {

					$_SESSION['message']  = "Masa olusturuken bir hata olustu";

					header("Location: tables.php");

				}





			}


		}


	} elseif ($action == "edit") {

		

		if($_POST){

			if(!empty($_POST['table_id']) &&!empty($_POST['table_name']) && !empty($_POST['table_max_person'])){


				$table_id			= $_POST['table_id'];
				$table_name			= $_POST['table_name'];
				$table_max_person	= $_POST['table_max_person'];


				$project = new project();


				$result = $project->edit_table($table_id, $table_name, $table_max_person);

				if($result){

					$_SESSION['message'] = "Masa duzenledi!";

					header("Location: tables.php");


				} else {

					$_SESSION['message'] = "Masa duzenledigi zaman bir hata olustu";

					header("Location: tables.php");

				}





			}


		}



		if(!empty($_GET['id'])){

			$id = $_GET['id'];

			$project = new project();


			$table = $project->show_table($id);
		}



	} elseif ($action == "delete") {
		


		if(!empty($_GET['id'])){

			$id = $_GET['id'];

			$project = new project();


			
			$result = $project->delete_table($id);

			if($result){

				$_SESSION['message'] = "Masa silindi!";

				header("Location: tables.php");


			} else {

				$_SESSION['message'] = "Masa silinirken bir hata olustu";

				header("Location: tables.php");

			}




		}




	} else {

		// bir sey yok
	}

} else {


	$project = new project();


	$tables = $project->get_tables();

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
            <h1>Masalar!</h1>
            <p>Bu sayfada tüm masaları listeleme, ekleme ve düzenleme işlemleri yapabilirsiniz</p>

          </div>

        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-success" role="alert"><?php print $message; ?></div>

        <?php } ?>

          <?php if(!$action){ ?>

          <a href="tables.php?action=new" class="btn btn-success float-right">Yeni masa</a>
          <br><br>
            <table class="table table-bordered">
			  <thead>
			    <tr>
			      <th># No</th>
			      <th>Masa adı</th>
			      <th>Toplam kişi</th>
			      <th>Düzenle</th>
			      <th>Sil</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($tables) {

			  		foreach ($tables as $table) { ?>
			  			

					    <tr>
					      <th scope="row"><?php echo $table['id']; ?></th>
					      <td><?php echo $table['name']; ?></td>
					      <td><?php echo $table['max_person']; ?></td>
					      <td><a href="tables.php?action=edit&id=<?php echo $table['id']; ?>" class="btn btn-primary">Düzenle</a></td>
					      <td><a href="tables.php?action=delete&id=<?php echo $table['id']; ?>" onclick="return confirm('Silinsin mi?')"  class="btn btn-danger">Sil</a></td>
					    </tr>

			  	<?php }
			  	} else { ?>

			  		<tr>
			  			<td>Masalar bulunamadı</td>
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
			    <label for="table_name">Masa adı</label>
			    <input type="text" class="form-control" id="table_name" name="table_name" placeholder="Masa adı">
			  </div>
			  <div class="form-group">
			    <label for="table_max_person">Masa toplam kişi</label>
			    <input type="number" class="form-control" id="table_max_person" name="table_max_person" placeholder="Masa toplam kisi">
			  </div>
			  <button type="submit" class="btn btn-success btn-block">Yeni masayı oluştur</button>
			</form>

			<?php } elseif ($action == "edit") {?>

			<form action="" method="post">
			  <div class="form-group">
			    <label for="table_name">Masa adı</label>
			    <input type="text" class="form-control" id="table_name" name="table_name" placeholder="Masa adı" value="<?php echo $table['name']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="table_max_person">Masa toplam kişi</label>
			    <input type="number" class="form-control" id="table_max_person" name="table_max_person" placeholder="Masa toplam kisi" value="<?php echo $table['max_person']; ?>">
			  </div>
			  <input type="hidden" name="table_id" value="<?php echo $table['id']; ?>">
			  <button type="submit" class="btn btn-success btn-block">Masayı düzenle</button>
			</form>

			<?php } ?>


        </div><!--/span-->

 
      </div><!--/row-->

      <hr>

   

<?php include("lib/footer.php"); ?>










