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

			    $orders = $project->show_admin_orders($status);
			    
			} else {
			   $orders = $project->show_admin_orders();
			}
		}


		if($action == "view_order"){
			if(!empty($_GET['id'])){


				$id = intval($_GET['id']);
				$order = $project->show_admin_order($id);

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

		if($action == "update"){
			if(!empty($_GET['id']) && !empty($_GET['status'])){

				$id 	= intval($_GET['id']);
				$status = $_GET['status'];

				$order = $project->update_admin_order($id, $status);
				
				$_SESSION['message'] 	= "Sipariş başarıyla güncellendi.";
				header("Location: orders.php?action=view_order&id=" . $id);
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
      	

      	<?php include("lib/left_admin.php"); ?>


        <div class="col-12 col-md-9 pt-5">
          
        <?php if(!empty($message)){?>
        <br>
        	<div class="alert alert-success" role="alert"><?php print $message; ?></div>

        <?php } ?>

          <?php if(!$action || $action == "view"){ ?>
          <div class="jumbotron">
            <h1>Siparişler!</h1>
            <p>Bu sayfada tüm siparişleri listeleme ve düzenleme işlemleri yapabilirsiniz!</p>
          </div>


            <table class="table table-bordered">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Sipariş</th>
			      <th>Müşteri</th>
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

					$user = $project->show_user($order['user']);

					$table = $project->show_table($order['table']);

			  		?>
			  			

					    <tr>
					      <th scope="row"><?php echo $order['id']; ?></th>
					      <td><?php echo $order['order_id']; ?></td>
					      <td><?php echo $user['name'] . " " . $user['surname']; ?></td>
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

			<div class="jumbotron">
	            <h1>Sipariş!</h1>
	            <p>Bu sayfada sipariş düzenleme işlemleri yapabilirsiniz!</p>
          	</div>

          	<h1>Sipariş bilgileri</h1>
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Sipariş</th>
			      <th>Müşteri</th>
			      <th>Masa</th>
			      <th>Tarih</th>
			      <th>Durum</th>
			      <th>Toplam</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php

			  	if($order) {


					$user = $project->show_user($order['user']);

					$table = $project->show_table($order['table']);

			  		?>
			  			

					    <tr>
					      <th scope="row"><?php echo $order['id']; ?></th>
					      <td><?php echo $order['order_id']; ?></td>
					      <td><?php echo $user['name'] . " " . $user['surname']; ?></td>
					      <td><?php echo $table['name']; ?></td>
					      <td><?php echo date("m.d.y H:i", $order['created']); ?></td>
					      <td><?php if($order['status'] == "0"){ print "<span class='badge badge-primary'>Yeni</span>"; } else if($order['status'] == "1"){ print "<span class='badge badge-secondary'>Hazırlanıyor</span>"; } else if($order['status'] == "2"){ print "<span class='badge badge-success'>Teslim edildi</span>"; } else { print "<span class='badge badge-danger'>İptal edildi</span>"; } ?></td>
					      <td><?php echo $order['total']; ?> TL</td>
					    </tr>

			  	<?php } ?>
			  
			  </tbody>
			</table>

			<?php if($order) {  ///////////// ?>
			<div class="row">
				<div class="col-md-6">
	                <div class="mb-auto">
	                  <div class="card mb-3">
	                    <div class="card-header">Sipariş güncelleme</div>
	                    <div class="card-body">
	                      <h5 class="card-text">

							<form method="GET" action="orders.php" class="py-auto form-row">
		                        <div class="form-group">
		                          <input type="hidden" name="action" value="update"/>
		                          <select class="form-control" id="status" name="status">
		                          	<option value="pending">Yeni</option>
									<option value="accepted">Hazırlanıyor</option>dd
									<option value="completed">Teslim edildi</option>
									<option value="declined">İptal edildi</option>
		                          </select>
		                          <input type="hidden" name="id" value="<?php echo $order['id']; ?>"/>
								  
		                        </div>
		                        <div class="form-group">
		                        	<button type="submit" class="btn btn-primary">Kaydet</button>
		                        </div>

	            			</form>
	                      </h5>
	                    </div>
	                  </div>
	                </div>
	            </div>
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









