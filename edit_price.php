<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $updated_price = $_POST['updated_price'];

    // Check for required field
    if (!strlen($product_id) || !strlen($updated_price)) {
      $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; All fields are required.";
    } else {
      // Check if is numeric
      if (!is_numeric($updated_price)) {
        $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; Units purchase must be integer.";
      } else {
        $product_price = new Inventory();
        $product_price->product_id = $product_id;
        $product_price->updated_price = $updated_price;
        $product_price->upprice_date = date("Y-m-d");
        if ($product_price->update_price()) {
          $session->message("Price successfully updated.");
          redirect_to("edit_price.php");
        } else {
          $message = "Purchase error!";
        }
      }
    }
  } else {
    $product_id = "";
    $updated_price = "";
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
            <li><a href="home.php">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Inventory</a></li>
          </ul>
        </div> <!-- end of content-header -->

        <div class="row-fluid content-main">

          <?php output_message($message); ?>

          <ul class="nav nav-tabs">
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="add_item.php">Add Items</a></li>
            <li><a href="items_sold.php">Items Sold</a></li>
            <li class="active"><a href="edit_price.php">Edit Price</a></li>
          </ul>

          <div class="tabb">
            <div class="box-header">
              <h5><i class="icon-pencil"></i><span class="break"></span> Edit Price</h5>
            </div>

            <form action="edit_price.php" method="post" accept-charset="utf-8" class="form-horizontal">

              <div class="control-group">
                <label class="control-label" for="productName">Product Name</label>
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
              </div>

              <div class="control-group">
                <label class="control-label" for="price">Price</label>
                <div class="controls">
                  <input type="text" name="updated_price" id="price" placeholder="price" name="price">
                </div>
              </div>

              <div class="control-group">
                <div class="controls">
                  <input type="submit" name="submit" value="Update" class="btn btn-primary">
                </div>
              </div>

            </form>
            
          </div> <!-- end of tab pane -->

        </div> <!-- end of row-fluid -->
      
      </div><!-- span -->
    </div><!-- row -->

  </div><!--/.fluid-container-->
    
<?php include_once('includes/layouts/footer.php'); ?>
