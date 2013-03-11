<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  // 1. the current page number ($current_page)
  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

  // 2. records per page ($per_page)
  $per_page = 8;

  
  if (isset($_POST['submit'])) {

    $keyword = $_POST['keyword'];

    // 3. total record count ($total_count)
    $total_count = Inventory::count_search($keyword);

    // Use pagination to find images
    $pagination = new Pagination($page, $per_page, $total_count);

    $query = "SELECT products.product_id, products.product, products.price, products.product_description, product_image.filename ";
    $query .= "FROM products LEFT JOIN product_image ";
    $query .= "ON products.product_id=product_image.product_id ";
    $query .= "WHERE product LIKE '%" .$keyword. "%' ";
    $query .= "LIMIT {$per_page} ";
    $query .= "OFFSET {$pagination->offset()}";

    $products = Inventory::find_by_sql($query);
    if (!$products) {
      $message = "No records found";
    }

  } else {

    // 3. total record count ($total_count)
    $total_count = Inventory::count_all();

    // Use pagination to find images
    $pagination = new Pagination($page, $per_page, $total_count);

    // Instead of finding all records, just find the records for this page

    $query = "SELECT products.product_id, products.product, products.price, products.product_description, product_image.filename ";
    $query .= "FROM products LEFT JOIN product_image ";
    $query .= "ON products.product_id=product_image.product_id ";
    $query .= "LIMIT {$per_page} ";
    $query .= "OFFSET {$pagination->offset()}";
    $products = Inventory::find_by_sql($query);
      
  }

  

  

  // Need to add ?page=$page to all links we want to
  // maintain the current page (or store $page in $session)

 ?>

<?php include_once('includes/layouts/header.php'); ?>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span2">
        <div class="well sidebar-nav">
          <ul class="nav nav-tabs nav-stacked">
            <li><a href="home.php"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Home</a></li>
            <li><a href="inventory.php"><i class="icon-list icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
            <li class="active"><a href="products.php"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
            <li><a href="#"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
            <li><a href="#"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Orders</a></li>
            <li><a href="admin_users.php"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Users</a></li>
          </ul>
        </div><!--/.well -->
      </div><!--/span-->

      <div class="span10">
        <div class="row-fluid content-header">
          <h1 class="left">Products</h1>
          
          <form action="products.php" method="post" class="form-search right product-search">
            <div class="input-append">
              <input type="text" name="keyword" class="input-medium search-query">
              <input type="submit" name="submit" class="btn btn-primary" value="Search">
            </div>
          </form>

          <ul class="breadcrumb both">
            <li><a href="home.php">Home</a> <span class="divider">/</span></li>
            <li><a href="products.php">Products</a></li>
          </ul>
        </div> <!-- end of content-header -->

        <div class="row-fluid content-main">
        
          <?php output_message($message); ?>

         
          
          <?php 
            $table_name = "products";
            $i = 1;

            foreach ($products as $product) {

              if ($i == 1) {
                echo "<ul class='thumbnails product-thumbnails'>";
              }

              $product_img = Upload::find_by_product_id($product->product_id);

              echo "<li class='span3'>";
              echo "<div class='thumbnail'>";
              if ($product_img) {
                echo "<a href='#" .$product->product_id. "' role='button' data-toggle='modal' data-toggle='tooltip' class='tooltip_dialog' data-placement='left' title='View Details'><img src='assets/img/". $product->filename ."' /></a>";
              } else {
                echo "<a href='#" .$product->product_id. "' role='button' data-toggle='modal' data-toggle='tooltip' class='tooltip_dialog' data-placement='left' title='View Details'><img src='holder.js/215x160' /></a>";
              }
              
              echo "<h4><center>". $product->product ."</center></h4>";
              echo "<center><div class='btn-group'>";
              echo "<a href='product_upload.php?id=". $product->product_id ."' class='btn btn-success tooltip_dialog' data-toggle='tooltip' data-placement='bottom' title='Upload an Image to Product'>Upload Image</a>";
              echo "</div></center>";
              echo "</div>";
              echo "</li>";

              if ($i == 4) {
                $i = 1;
                echo "</ul>";
              } else {
                $i++;
              }
            }

            echo "</ul>";
            // if ($i < 4) { echo "</ul>"; }
          ?>

          <a href="products.php" class="btn btn-large left tooltip_dialog" data-toggle="tooltip" data-placement="right" title="Refresh Products List"><i class="icon-refresh"></i></a>

          <div class="pagination pagination-right">
            <ul>
              <?php 
                if ($pagination->total_pages() > 1) {
                  
                  if ($pagination->has_previous_page()) {
                    echo "<li><a href=\"products.php?page=";
                    echo $pagination->previous_page();
                    echo "\">Previous</a></li>";
                  }

                  for ($i=1; $i <= $pagination->total_pages(); $i++) { 
                    if ($i == $page) {
                      echo "<li class='active'><span>{$i}</span></li>";
                    } else {
                      echo "<li><a href=\"products.php?page={$i}\">{$i}</a></li>";
                    }
                  }

                  if ($pagination->has_next_page()) {
                    echo "<li><a href=\"products.php?page=";
                    echo $pagination->next_page();
                    echo "\">Next</a></li>";
                  }
                }
               ?>
            </ul>
          </div>

          <?php foreach($products as $product): ?>
            
            <div id="<?php echo $product->product_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="productName" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id ="productName"><?php echo $product->product; ?></h3>
              </div>

              <div class="modal-body">
                <table>
                  <tr>
                    <td><div class="thumbnail"><img src="assets/img/<?php echo $product->filename; ?>"></div></td>
                    <td>
                      <p>"<?php echo $product->product_description ?>"</p><br>
                      <h4>Price: <span>Php <?php echo formatMoney($product->price); ?></span></h4>
                    </td>
                  </tr>
                </table>
              </div>

              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
              </div>
            </div>

          <?php endforeach; ?>
    
        </div> <!-- end of row-container-fluid -->
      
      </div><!-- span -->
    </div><!-- row -->

  </div><!--/.fluid-container-->
    
<?php include_once('includes/layouts/footer.php'); ?>
