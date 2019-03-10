<?php

// Kayit sayfasi

// Guvenlik
define("rs", true);

require ("lib/project.php");

$page = "registration";

session_start();

// Hata messaji
$message = "";

if($_POST){

	if(!empty($_POST['verification'])){

		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];

		$project = new project();


		$result = $project->registration($email, $password, $name, $surname);


		if($result){
			
		
			// Mesaj goster
			$_SESSION['message'] = "Kayit basarili. Giris yapabilirsiniz simdi!";

			// Yonlendir
			header("Location: index.php");


		} else {
			
			// Hata goster
			$message = "Kayit olmadiniz. Tekrar deneyiniz!";


		}


	}




}

?>


<?php include("lib/header.php"); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h3 class="display-4">Kayit ol</h3>
        

        <div class="col-5">

        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-danger" role="alert"><?php print $message; ?></div>

        <?php } ?>


			<form action="registration.php" method="POST">
			  <div class="form-group">
			    <label for="email">Email</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="Eposta" required>
			  </div>
			  <div class="form-group">
			    <label for="password">Şifre:</label>
			    <input type="password" class="form-control" id="password" name="password" placeholder="Şifre" required>
			  </div>
			  <div class="form-group">
			    <label for="name">Ad:</label>
			    <input type="text" class="form-control" id="name" name="name" placeholder="Ad" required>
			  </div>
			  <div class="form-group">
			    <label for="psurname">Soyad:</label>
			    <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad" required>
			  </div>
			  <input type="hidden" name="verification" value="1">
			  <button type="submit" class="btn btn-primary">Kayit ol</button>
			</form>
		</div>

      </div>
    </div>



<?php include("lib/footer.php"); ?>