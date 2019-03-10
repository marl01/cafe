<div class="col-6 col-md-3">

        	<h2>Siparişler</h2>
	        <div class="list-group">
	          <a href="orders.php?action=view&amp;status=pending" class="list-group-item list-group-item-action <?php if($page=="order_pending"){echo "active";} ?>">Yeni</a>
	          <a href="orders.php?action=view&amp;status=accepted" class="list-group-item list-group-item-action <?php if($page=="order_accepted"){echo "active";} ?>">Hazırlanıyor</a>
	          <a href="orders.php?action=view&amp;status=completed" class="list-group-item list-group-item-action <?php if($page=="order_completed"){echo "active";} ?>">Teslim edildi</a>
	          <a href="orders.php?action=view&amp;status=declined" class="list-group-item list-group-item-action <?php if($page=="order_declined"){echo "active";} ?>">İptal edildi</a>
	          <a href="orders.php" class="list-group-item list-group-item-action <?php if($page=="orders"){echo "active";} ?>">Tümü</a>
	        </div>
        	

        </div>