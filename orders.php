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
$page = "orders";

// user id
$user = $_SESSION['id'];

// Hata messaji
$message = "";

if(!empty($_SESSION['message'])){

	$message = $_SESSION['message'];

	unset($_SESSION['message']);

}

$action = false;


$project = new project();

if($_GET){
	if(!empty($_GET['action'])){

		$action = $_GET['action'];

		if($action == "view"){
			if(!empty($_GET['status'])){

			   	$status = $_GET['status'];

			   	if($status == "pending"){
					$page = "order_pending";
				} else if($status == "accepted"){
					$page = "order_accepted";
				} else if($status == "completed"){
					$page = "order_completed";
				} else if($status == "declined"){
					$page = "order_declined";
				} else {
					$status = 0;
				}

			    $orders = $project->show_user_orders($user, $status);
			    
			} else {
			   $orders = $project->show_user_orders($user);
			}
		}


		if($action == "view_order"){
			if(!empty($_GET['id'])){


				$id = intval($_GET['id']);
				$order = $project->show_user_order($user, $id);

				if($order){

					$order_products = $project->show_products_order($order['order_id']);

				} else {
					$_SESSION['message'] = "Boyle bir siparis mevcut degil";
					header("Location: orders.php");
				}

			} else {
				$_SESSION['message'] = "Boyle bir siparis mevcut degil";
				header("Location: orders.php");
			}
		}

	}

} else {

  $orders = $project->show_admin_orders();

}

?>


<?php include("lib/header.php"); ?>

    <div class="container pt-2">

      <div class="row">
      	

      	<?php include("lib/left_user_panel.php"); ?>


        <div class="col-12 col-md-9 pt-5">
          
        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-success" role="alert"><?php print $message; ?></div>

        <?php } ?>

          <?php if(!$action || $action == "view"){ ?>

            <table class="table table-bordered">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Sipariş</th>
			      <th>Masa</th>
			      <th>Tarih</th>
			      <th>Durum</th>
			      <th>Geçen süre</th>
			      <th>Toplam</th>
			      <th>Göster</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($orders) {

			  		foreach ($orders as $order) {

					$table = $project->show_table($order['table']);

			  		?>
			  			

					    <tr>
					      <th scope="row"><?php echo $order['id']; ?></th>
					      <td><?php echo $order['order_id']; ?></td>
					      <td><?php echo $table['name']; ?></td>
					      <td><?php echo date("m.d.y H:i", $order['created']); ?></td>
					      <td><?php if($order['status'] == "0"){ print "<span class='badge badge-primary'>Yeni</span>"; } else if($order['status'] == "1"){ print "<span class='badge badge-secondary'>Hazırlanıyor</span>"; } else if($order['status'] == "2"){ print "<span class='badge badge-success'>Teslim edildi</span>"; } else { print "<span class='badge badge-danger'>İptal edildi</span>"; } ?></td>
					      <td><?php
					      if($order['status'] == "1"){
					      	$time = (time() - $order['start']) / 60;
					      } else if($order['status'] == "2"){
					      	$time = ($order['end'] - $order['start']) / 60;
					      } else {
					      	$time = 0;
					      }
					      echo number_format((float)$time, 2, '.', ''); ?> dk</td>
					      <td><?php echo $order['total']; ?> TL</td>
					      <td><a href="orders.php?action=view_order&amp;id=<?php echo $order['id']; ?>" class="btn btn-primary">Göster</a></td>
					    </tr>

			  	<?php }
			  	} else { ?>

			  		<tr>
			  			<td colspan="9">Siparişler bulunamadı</td>
			  		</tr>

			  	<?php }

			  	?>
			  
			  </tbody>
			</table>

			<?php }
			if ($action == "view_order") { ?>

          	<h1>Sipariş bilgileri</h1>
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Sipariş</th>
			      <th>Masa</th>
			      <th>Tarih</th>
			      <th>Durum</th>
			      <th>Toplam</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($order) {

					$table = $project->show_table($order['table']);

			  		?>
					    <tr>
					      <th scope="row"><?php echo $order['id']; ?></th>
					      <td><?php echo $order['order_id']; ?></td>
					      <td><?php echo $table['name']; ?></td>
					      <td><?php echo date("m.d.y H:i", $order['created']); ?></td>
					      <td><?php if($order['status'] == "0"){ print "<span class='badge badge-primary'>Yeni</span>"; } else if($order['status'] == "1"){ print "<span class='badge badge-secondary'>Hazırlanıyor</span>"; } else if($order['status'] == "2"){ print "<span class='badge badge-success'>Teslim edildi</span>"; } else { print "<span class='badge badge-danger'>İptal edildi</span>"; } ?></td>
					      <td><?php echo $order['total']; ?> TL</td>
					    </tr>

			  	<?php } ?>
			  
			  </tbody>
			</table>

			<?php if($order) {  ?>
			<div class="row">
		        <div class="col-md-6">
		            <div class="mb-auto">
		                <div class="card mb-3">
		                <div class="card-header">Geçen süre</div>
		                  <div class="card-body">
		                     <h4 class="card-text">Toplam  <span class="text-info"><?php if($order['status'] == "1"){ $time = (time() - $order['start']) / 60; } else if($order['status'] == "2"){ $time = ($order['end'] - $order['start']) / 60; } else { $time = 0; } echo number_format((float)$time, 2, '.', ''); ?></span> dakika<br><br></h4>
		                   </div>
		                 </div>
		            </div>
	           	</div>
	           	<div class="col-md-6">
		            <div class="mb-auto">
		                <div class="card mb-3">
		                <div class="card-header">Toplam</div>
		                  <div class="card-body">
		                     <h4 class="card-text">Ödenecek tutar  <span class="text-info"><?php echo $order['total']; ?></span> TL<br><br></h4>
		                   </div>
		                 </div>
		            </div>
	           	</div>
            </div>
            <?php } ?>





			<h1>Sipariş verilen ürünler</h1>
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Ürün adı</th>
			      <th>Ürün miktari</th>
			      <th>Toplam</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($order_products) {


			  		foreach ($order_products as $product) {

					$product_info = $project->show_product($product['product_id']);

			  		?>
			  		
					    <tr>
					      <th scope="row"><?php echo $product['id']; ?></th>
					      <td><?php echo $product_info['name']; ?></td>
					      <td><?php echo $product['product_quantity']; ?></td>
					      <td><?php $total = $product_info['price'] * $product['product_quantity']; echo $total; ?> TL</td>
					    </tr>

			  	<?php }
			  	} else { ?>

			  		<tr>
			  			<td colspan="4">Siparişler bulunamadı</td>
			  		</tr>

			  	<?php }

			  	?>
			  
			  </tbody>
			</table>


			<?php } ?>


        </div><!--/span-->

 
      </div><!--/row-->

      <hr>

   

<?php include("lib/footer.php"); ?>









