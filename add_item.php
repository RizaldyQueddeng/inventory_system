<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
      $product_id = $_POST['product_id'];
      $units_purchase = $_POST['units_purchase'];

      // Check for required field
      if (!strlen($product_id) || !strlen($units_purchase)) {
        $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; All fields are required.";
      } else {
        // Check if is numeric
        if (!is_numeric($units_purchase)) {
          $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; Units purchase must be integer.";
        } else {
          $product = new Inventory();
          $product->product_id = $_POST['product_id'];
          $product->units_purchase = $units_purchase;
          $product->purchase_date = date("Y-m-d");
          if ($product->add_item()) {
            $session->message("Items for Product purchased succesfully.");
            redirect_to("add_item.php");
          } else {
            $message = "Purchase error!";
          }
        }
      }
  } else {
    $product_id = "";
    $units_purchase = "";
  }
 ?>

<?php include_once('includes/layouts/header.php'); ?>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span2">
        <div class="well sidebar-nav">
          <ul class="nav nav-tabs nav-stacked">
            <li><a href="home.php"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Home</a></li>
            <li class="active"><a href="inventory.php"><i class="icon-list icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
            <li><a href="products.php"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
            <li><a href="sales.php"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
            <li><a href="purchase_order.php"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Purchase Order</a></li>
            <li><a href="admin_users.php"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Users</a></li>
          </ul>
        </div><!--/.well -->
      </div><!--/span-->

      <div class="span10">
        <div class="row-fluid content-header">
          <h1>Inventory</h1>
          <ul class="breadcrumb">
            <li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Inventory</a></li>
          </ul>
        </div> <!-- end of content-header -->

        <div class="row-fluid content-main">

          <?php output_message($message); ?>
          
          <ul class="nav nav-tabs">
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li class="active"><a href="add_item.php">Add Items</a></li>
            <li><a href="items_sold.php">Items Sold</a></li>
            <li><a href="edit_price.php">Edit Price</a></li>
          </ul>

          <div class="tabb">
            <form action="add_item.php" method="post" class="form-horizontal add-item">
              <div class="box-header">
                <h5><i class="icon-plus-sign"></i><span class="break"></span> Add an Item to inventory</h5>
              </div>

              <div class="control-group">
                <label for="productName" class="control-label">Product Name</label>
                <div class="controls">
                  <select name="product_id" id="productName">
                    <?php 
                      $table_name = "products";
                      $for_select_input = Inventory::find_all_inventory($table_name);
                      foreach ($for_select_input as $field) {
                        echo "<option value='". $field->product_id ."'>". $field->product ."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div> <!-- end of control-group -->

              <div class="control-group">
                <label for="numberOfItem" class="control-label">Units Purchased</label>
                <div class="controls">
                  <input type="number" name="units_purchase" id="numberOfItem" value="<?php echo htmlentities($units_purchase); ?>">
                </div>
              </div> <!-- end of control-group -->

              <div class="control-group">
                <div class="controls">
                  <input type="submit" name="submit" class="btn btn-primary" value="Add">
                </div>
              </div>

            </form>
          </div> <!-- end of tab-pane -->

        </div> <!-- end of row-fluid -->
      </div><!-- span -->
    </div><!-- row -->

  </div><!-- fluid-container -->

    
<?php include_once('includes/layouts/footer.php'); ?>
