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
  $per_page = 10;

  // 3. total record count ($total_count)
  $total_count = Inventory::count_all();

  // Use pagination to find images
  $pagination = new Pagination($page, $per_page, $total_count);

  // Instead of finding all records, just find the records for this page

  $query = "SELECT * FROM products ";
  $query .= "LIMIT {$per_page} ";
  $query .= "OFFSET {$pagination->offset()}";
  $products = Inventory::find_by_sql($query);

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
          
            <?php 
              if (isset($_GET['message'])) {
                $message = $_GET['message'];
              }
              if (!empty($message)) {
                $alert_message = "<div class='alert alert-error'><br>";
                $alert_message .= "<button class='close' data-dismiss='alert'>&times;</button>";
                $alert_message .= "{$message}";
                $alert_message .= "</div>";

                echo $alert_message;
              } 
             ?>

            <ul class="nav nav-tabs navigation">
              <li class="active"><a href="home.php">Inventory</a></li>
              <li><a href="add_product.php">Add Product</a></li>
              <li><a href="add_item.php">Add Items</a></li>
              <li><a href="items_sold.php">Items Sold</a></li>
              <li><a href="edit_price.php">Edit Price</a></li>
            </ul>

            <table class="table table-striped table-bordered table-hover inventory-table">
              <thead class="btn-success">
                <th>ID</th>
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
                  foreach ($products as $product) {
                    echo "<tr><td>";
                    echo $product->product_id;
                    echo "</td><td>";
                    echo $product->product_date;
                    echo "</td><td>";
                    echo $product->product;
                    echo "</td><td>"; 
                    echo $product->quantity_left;
                    echo "</td><td>";
                    echo $product->quantity_sold;
                    echo "</td><td>";
                    echo formatMoney($product->price, true);
                    echo "</td><td>";
                    echo formatMoney($product->sales, true);
                    echo "</td><td>";
                    echo "<a href='delete.php?id=". $product->product_id ."' class='btn tooltip_dialog' data-toggle='tooltip' data-placement='left' title='Delete Record' onclick='return confirmAction()'><i class='icon-trash'></i></a>";
                    echo "</td></tr>";
                  }
                  
                 ?>
              </tbody>
            </table>

            <div class="pagination pagination-right">
              <ul>
                <?php 
                  if ($pagination->total_pages() > 1) {
                    
                    if ($pagination->has_previous_page()) {
                      echo "<li><a href=\"home.php?page=";
                      echo $pagination->previous_page();
                      echo "\">Previous</a></li>";
                    }

                    for ($i=1; $i <= $pagination->total_pages(); $i++) { 
                      if ($i == $page) {
                        echo "<li class='active'><span>{$i}</span></li>";
                      } else {
                        echo "<li><a href=\"home.php?page={$i}\">{$i}</a></li>";
                      }
                    }

                    if ($pagination->has_next_page()) {
                      echo "<li><a href=\"home.php?page=";
                      echo $pagination->next_page();
                      echo "\">Next</a></li>";
                    }
                  }
                 ?>
              </ul>
            </div>

          </div> <!-- end of row-container-fluid -->
        
        </div><!-- span -->
      </div><!-- row -->
      
    </div><!--/.fluid-container-->
    
<?php include_once('includes/footer.php'); ?>
