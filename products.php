<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
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
              <li><a href="home.php"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
              <li class="active"><a href="products.php"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
              <li><a href="#"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
              <li><a href="#"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Orders</a></li>
              <li><a href="admin_users.php"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Users</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
          <div class="row-fluid content-header">
            <h1>Products</h1>
            <ul class="breadcrumb">
              <li><a href="home.php">Home</a> <span class="divider">/</span></li>
              <li><a href="products.php">Products</a></li>
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

             <?php 
              $table_name = "products";
              $item = Inventory::inventory_join_image();
              $i = 1;

              foreach ($item as $field) {

                if ($i == 1) {
                  echo "<ul class='thumbnails product-thumbnails'>";
                }

                $product_img = Upload::find_by_product_id($field->product_id);

                echo "<li class='span3'>";
                echo "<div class='thumbnail'>";
                if ($product_img) {
                  echo "<a href='#" .$field->product_id. "' role='button' data-toggle='modal' data-toggle='tooltip' class='tooltip_dialog' data-placement='left' title='View Details'><img src='assets/img/". $field->filename ."' /></a>";
                } else {
                  echo "<a href='#" .$field->product_id. "' role='button' data-toggle='modal' data-toggle='tooltip' class='tooltip_dialog' data-placement='left' title='View Details'><img src='holder.js/215x160' /></a>";
                }
                
                echo "<h4><center>". $field->product ."</center></h4>";
                echo "<center><div class='btn-group'>";
                echo "<a href='product_upload.php?id=". $field->product_id ."' class='btn btn-success tooltip_dialog' data-toggle='tooltip' data-placement='bottom' title='Upload an Image to Product'>Upload Image</a>";
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

              if ($i < 3) { echo "</ul>"; }

            ?>

            <?php foreach($item as $field): ?>
              
              <div id="<?php echo $field->product_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="productName" aria-hidden="true">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h3 id ="productName"><?php echo $field->product; ?></h3>
                </div>
                <div class="modal-body">
                  <table>
                    <tr>
                      <td><div class="thumbnail"><img src="assets/img/<?php echo $field->filename; ?>"></div></td>
                      <td>
                        <p>"<?php echo $field->product_description ?>"</p><br>
                        <h4>Price: <span>Php <?php echo formatMoney($field->price, true); ?></span></h4>
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
    
<?php include_once('includes/footer.php'); ?>
