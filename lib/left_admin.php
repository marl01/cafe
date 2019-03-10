		<div class="col-6 col-md-3">

        	<h2>Sipariş</h2>
	        <div class="list-group">
	          <a href="orders.php?action=view&amp;status=pending" class="list-group-item list-group-item-action <?php if($page=="order_pending"){echo "active";} ?>">Yeni</a>
	          <a href="orders.php?action=view&amp;status=accepted" class="list-group-item list-group-item-action <?php if($page=="order_accepted"){echo "active";} ?>">Hazırlanıyor</a>
	          <a href="orders.php?action=view&amp;status=completed" class="list-group-item list-group-item-action <?php if($page=="order_completed"){echo "active";} ?>">Teslim edildi</a>
	          <a href="orders.php?action=view&amp;status=declined" class="list-group-item list-group-item-action <?php if($page=="order_declined"){echo "active";} ?>">İptal edildi</a>
	          <a href="orders.php" class="list-group-item list-group-item-action <?php if($page=="orders"){echo "active";} ?>">Tümü</a>
	        </div>
        	
        	<div class="pt-2">
	        	<h2>Ürünler</h2>
		        <div class="list-group">
		          <a href="tables.php" class="list-group-item list-group-item-action <?php if($page=="tables"){echo "active";} ?>">Masalar</a>
		          <a href="product_category.php" class="list-group-item list-group-item-action <?php if($page=="product_category"){echo "active";} ?>">Menü kategori</a>
		          <a href="products.php" class="list-group-item list-group-item-action <?php if($page=="products"){echo "active";} ?>">Menü ürünler</a>
		        </div>
	    	</div>

        </div>