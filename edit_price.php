<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
      
  } else {
    $product_name = "";
    $product_description = "";
    $price = "";
    $quantity = "";
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
            <li><a href="add_item.php">Add Items</a></li>
            <li><a href="items_sold.php">Items Sold</a></li>
            <li class="active"><a href="edit_price.php">Edit Price</a></li>
          </ul>

          <div class="tabb">
            <div class="box-header">
              <h5><i class="icon-pencil"></i><span class="break"></span> Edit Price</h5>
            </div>

            <form action="#" method="post" accept-charset="utf-8" class="form-horizontal">

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
                  <input type="text" id="price" placeholder="price" name="price">
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
