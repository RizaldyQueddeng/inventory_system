<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['addproduct_submit'])) {
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
              $product->save();


              // for success message
              $message = $product->message;
              redirect_to('home.php');
            }
          }
        }
      }

  } elseif (isset($_POST['additems_submit'])) {
    
  } elseif (isset($_POST['editprice_submit'])) {
      
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

            <div class="tabbable">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#inventory" data-toggle="tab">Inventory</a></li>
                <li><a href="#addproduct" data-toggle="tab">Add Product</a></li>
                <li><a href="#additem" data-toggle="tab">Add Items</a></li>
                <li><a href="#editprice" data-toggle="tab">Edit Price</a></li>
              </ul>
              <div class="tab-content">

                <div class="tab-pane active" id="inventory">
                  <table class="table table-striped table-bordered inventory-table">
                    <thead class="btn-success">
                      <th>Date</th>
                      <th>Item</th>
                      <th>Quantity left</th>
                      <th>Quantity Sold</th>
                      <th>Price</th>
                      <th>Sales</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                      <?php 
                        $item = Inventory::find_all_inventory();
                        foreach ($item as $field) {
                          echo "<tr><td>";
                          echo $field->product_date;
                          echo "</td><td>";
                          echo $field->product;
                          echo "</td><td>"; 
                          echo $field->quantity_left;
                          echo "</td><td>";
                          echo $field->quantity_sold;
                          echo "</td><td>";
                          echo formatMoney($field->price, true);
                          echo "</td><td>";
                          echo $field->sales;
                          echo "</td><td>";
                          echo "<a href='#' class='btn'><i class='icon-trash'></i></a>";
                          echo "</td></tr>";
                        }
                        
                       ?>
                    </tbody>
                  </table>
                </div> <!-- end of tab-pane -->

                <div class="tab-pane tabbable-with-border" id="addproduct">
                  <form action="home.php" method="post" class="form-horizontal add-item">
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
                        <input type="submit" name="addproduct_submit" class="btn btn-primary" value="Add">
                      </div>
                    </div>

                  </form>
                </div> <!-- end of tab pane -->

                <div class="tab-pane tabbable-with-border" id="additem">
                  <form action="#" method="post" class="form-horizontal add-item">
                    <div class="box-header">
                      <h5><i class="icon-plus-sign"></i><span class="break"></span> Add an Item to inventory</h5>
                    </div>

                    <div class="control-group">
                      <label for="productName" class="control-label">Product Name</label>
                      <div class="controls">
                        <select name="productname" id="productName">
                          <option value="#">IP Camera</option>
                          <option value="#">Analog Camera</option>
                        </select>
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="numberOfItem" class="control-label">Number of Item</label>
                      <div class="controls">
                        <input type="text" name="numberitem" id="numberOfItem">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <div class="controls">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add">
                      </div>
                    </div>

                  </form>
                </div> <!-- end of tab-pane -->

                <div class="tab-pane tabbable-with-border" id="editprice">
                  <div class="box-header">
                    <h5><i class="icon-pencil"></i><span class="break"></span> Edit Price</h5>
                  </div>

                  <form action="#" method="post" accept-charset="utf-8" class="form-horizontal">

                    <div class="control-group">
                      <label class="control-label" for="productName">Product Name</label>
                      <div class="controls">
                        <select name="productname" id="productName">
                          <option value="dp_1">DP IP 7309</option>
                          <option value="dp_2">DP IP 7310</option>
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
                  
                </div>
              </div>
            </div>

          </div>
          
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; DPoint Technologies Asia <?php echo date("Y", time()); ?></p>
      </footer>

    </div><!--/.fluid-container-->
    
<?php include_once('includes/footer.php'); ?>
