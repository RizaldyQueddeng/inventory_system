<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
      $product_id = $_POST['product_id'];
      $product_name = $_POST['product_name'];
      $units_purchase = $_POST['units_purchase'];

      // Check for required field
      if (!strlen($product_id) || !strlen($product_name) || !strlen($units_purchase)) {
        $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; All fields are required.";
      } else {
        // Check if is numeric
        if (is_numeric($units_purchase)) {
          $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; Units purchase must be integer.";
        } else {
          $product = new Inventory();
          $product->product_id = $product_id;
          $product->product = $product_name;
          $product->units_purchase = $units_purchase;
        }
      }
  } else {
    $product_name = "";
    $product_description = "";
    $price = "";
    $quantity = "";
  }
 ?>

<?php include_once('includes/header.php'); ?>
  <body>

    <div class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">DPoint Inventory System</a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li class="dropdowm">
                <a href="#user" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Account Settings&nbsp;&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><i class="icon-cog"></i>&nbsp;&nbsp;Profile</a></li>
                  <li><a href="logout.php"><i class="icon-off"></i>&nbsp;&nbsp;Logout</a></li>
                </ul>
              </li>
            </ul>
            <!-- <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul> -->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-tabs nav-stacked">
              <li class="active"><a href="#"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
              <li><a href="#"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
              <li><a href="#"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
              <li><a href="#"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Orders</a></li>
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

            <?php 
              if (!empty($message)) {
                $alert_message = "<div class='alert alert-error'><br>";
                $alert_message .= "<button class='close' data-dismiss='alert'>&times;</button>";
                $alert_message .= "{$message}";
                $alert_message .= "</div>";

                echo $alert_message;
              } 
             ?>

            <ul class="nav nav-tabs">
              <li><a href="inventory.php">Inventory</a></li>
              <li><a href="add_product.php">Add Product</a></li>
              <li class="active"><a href="#additem">Add Items</a></li>
              <li><a href="#editprice">Edit Price</a></li>
            </ul>

            <div class="tabb">
              <form action="add_item.php" method="post" class="form-horizontal add-item">
                <div class="box-header">
                  <h5><i class="icon-plus-sign"></i><span class="break"></span> Add an Item to inventory</h5>
                </div>

                <div class="control-group">
                  <label for="productName" class="control-label">Product Name</label>
                  <div class="controls">
                    <select name="product_name" id="productName">
                      <?php 
                        $for_select_input = Inventory::find_all_inventory();
                        foreach ($for_select_input as $field) {
                          echo "<option value='". $field->product ."'>". $field->product ."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div> <!-- end of control-group -->

                <input type="hidden" name="product_id" value="<?php echo $field->product_id; ?>">

                <div class="control-group">
                  <label for="numberOfItem" class="control-label">Units Purchase</label>
                  <div class="controls">
                    <input type="number" name="units_purchase" id="numberOfItem">
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

      <hr>

      <footer>
        <p>&copy; DPoint Technologies Asia <?php echo date("Y", time()); ?></p>
      </footer>

    </div><!--/.fluid-container-->
    
<?php include_once('includes/footer.php'); ?>
