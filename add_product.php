<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
      $product_name = $_POST['product_name'];
      $product_description = $_POST['product_description'];
      $price = $_POST['price'];
      $quantity = $_POST['quantity'];

      // check for empty fields
      if (!strlen($product_name) || !strlen($product_description) || !strlen($price) || !strlen($quantity)) {
        $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; All fields are required.";
      } else {
        // check if description exceeds maximum length of 255 characters
        if (strlen($product_description)>255) {
          $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; Description has to be 255 characters only.";
        } else {
          // Check for valid price format and if is numeric
          $valid_price_format = "/^-?[0-9]+(?:\.[0-9]{1,2})?$/";
          if (!preg_match($valid_price_format, $price) && is_numeric($price)) {
            $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; Invalid format for price.";
          } else {
            // Check if quantity is numeric
            if (!is_numeric($quantity)) {
              $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp; Quantity must be an integer.";
            } else {

              // Check if record exist'
              $table_name = "products";
              if (Inventory::find_if_exist($product_name, $table_name)) {
                $message = "<strong>Add Product Failed!</strong>&nbsp;&nbsp;&nbsp;  Record Exist.";
              } else {
                $product = new Inventory();
                $product->product = $_POST['product_name'];
                $product->quantity_left = $_POST['quantity'];
                $product->quantity_sold = 0;
                $product->price = $_POST['price'];
                $product->sales = 0;
                $product->product_description = $_POST['product_description'];
                $product->product_date = date("Y-m-d");

                $product->units_purchase = $product->quantity_left;
                $product->purchase_date = date("Y-m-d");
                if ($product->save()) {
                  $session->message("Product added successfully.");
                  redirect_to("add_product.php");
                } else {
                  $message = "Product was not saved!";
                }
              }
            }
          }
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
    
    <div class="wrapper">
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
                <li class="active"><a href="home.php"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
                <li><a href="products.php"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
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

              <?php output_message($message); ?>
              
              <ul class="nav nav-tabs">
                <li><a href="home.php">Inventory</a></li>
                <li class="active"><a href="add_product.php">Add Product</a></li>
                <li><a href="add_item.php">Add Items</a></li>
                <li><a href="items_sold.php">Items Sold</a></li>
                <li><a href="edit_price.php">Edit Price</a></li>
              </ul>

             <div class="tabb">
              <form action="add_product.php" method="post" class="form-horizontal add-item">
                <div class="box-header">
                  <h5><i class="icon-plus-sign"></i><span class="break"></span> Add Product to inventory</h5>
                </div>
   
                <div class="control-group">
                  <label for="productName" class="control-label">Product Name</label>
                  <div class="controls">
                    <input type="text" name="product_name" id="productName" placeholder="name" value="<?php echo htmlentities($product_name); ?>" />
                  </div>
                </div> <!-- end of control-group -->
   
                <div class="control-group">
                  <label for="description" class="control-label">Description</label>
                    <div class="controls">
                      <textarea class="input-xxlarge" name="product_description" id="description" rows="7" placeholder="description...."><?php echo htmlentities($product_description); ?></textarea>
                  </div>
                </div> <!-- end of control-group -->
   
                <div class="control-group">
                  <label for="price" class="control-label">Price</label>
                  <div class="controls">
                    <input type="number" name="price" id="price" placeholder="price" value="<?php echo htmlentities($price); ?>">
                  </div>
                </div> <!-- end of control-group -->
   
                <div class="control-group">
                  <label for="quantity" class="control-label">Quantity</label>
                  <div class="controls">
                    <input type="number" name="quantity" id="quantity" placeholder="quantity" value="<?php echo htmlentities($quantity); ?>">
                  </div>
                </div> <!-- end of control-group -->
   
                <div class="control-group">
                  <div class="controls">
                    <input type="submit" name="submit" class="btn btn-primary" value="Add">
                  </div>
                </div>
   
              </form>
            </div> <!-- end of tabb -->

            </div> <!-- end row-fluid -->
          
          </div><!-- span -->
        </div><!-- row -->

      </div><!--/.fluid-container-->
      <div class="push"></div>
    </div>
    
<?php include_once('includes/footer.php'); ?>
