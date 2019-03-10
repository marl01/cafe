        <div class="col-lg-3">

          <h1 class="my-4">
            
           <a href="index.php"><img class="card-img-top border border-primary" src="images/m1.jpg" ></a>

          </h1>
          <div class="list-group border border-primary">
            <?php if($product_categories) { foreach ($product_categories as $product_category) { ?>
              
            <a href="http://megam.cf/index.php?action=list&amp;product_category_id=<?php echo $product_category['id']; ?>" class="list-group-item list-group-item-action <?php if(!empty($action)){ if($action == "list"){ if($product_category['id'] == $product_category_id){ echo "active"; }  } } ?>" ><?php echo $product_category['name']; ?></a>
          <?php } } ?>
          </div>
          
        </div>
        <!-- /.col-lg-3 -->