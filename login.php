<?php

// Giris sayfasi

// Guvenlik
define("rs", true);

require ("lib/project.php");

$page = "login";

session_start();

// Hata messaji
$message = "";

if($_POST){

	if(!empty($_POST['verification'])){

		
		$email = $_POST['email'];
		$password = $_POST['password'];



		$project = new project();


		$result = $project->login($email, $password);

		if($result){
			


			$_SESSION['name'] 	= $result['name'];
			$_SESSION['surname']= $result['surname'];
			$_SESSION['email']	= $result['email'];
			$_SESSION['type']	= $result['type'];
			$_SESSION['id']		= $result['id'];

			// Mesaj goster
			$_SESSION['message'] = "Giriş basarılı";

			// Ana sayfayi yonlendir
			header("Location: index.php");


		} else {
			
			// Hata goster
			$message = "Kullanici girişi hatalı. Tekrar deneyiniz!";

		}


	}




}



?>


<?php include("lib/header.php"); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h3 class="display-4">Giris yap</h3>
        

        <div class="col-5">

        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-danger" role="alert"><?php print $message; ?></div>

        <?php } ?>


			<form action="login.php" method="POST">
			  <div class="form-group">
			    <label for="email">Email</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="Eposta" required>
			  </div>
			  <div class="form-group">
			    <label for="password">Şifre:</label>
			    <input type="password" class="form-control" id="password" name="password" placeholder="Şifre" required>
			  </div>
			  <input type="hidden" name="verification" value="1">
			  <button type="submit" class="btn btn-primary">Giris yap</button>
			</form>
		</div>

      </div>
    </div>


<?php include("lib/footer.php"); ?>




