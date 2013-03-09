<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $max_file_size = 1048576; // expressed in bytes
                              //    10240 = 10kb
                              //   102400 = 100kb
                              //  1048576 = 1mb
                              // 10485760 = 10mb
    
    if (isset($_POST['submit'])) {
      $image = new Upload();
      $image->product_id = $id;
      $image->attach_file($_FILES['file_upload']);
      if ($image->save()) {
        // Success
        $session->message("Image uploaded succesfully.");
        redirect_to("products.php");
      } else {
        // Failure
        $message = join("<br />", $image->errors);
      }
    }
  } else {
    redirect_to("products.php");
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
              <li><a href="products.php">Products</a> <span class="divider">/</span></li>
              <li><a href="#">Upload</a></li>
            </ul>
          </div> <!-- end of content-header -->

          <?php output_message($message); ?>

          <div class="row-fluid content-main">
          
           <div class="tabb">
             <form action="product_upload.php?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post" class="form-horizontal">
                <div class="box-header">
                  <h5><i class="icon-upload"></i><span class="break"></span> Upload an Image to product</h5>
                </div>
                
                <div class="upload-controls">
                  <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                  <input type="file" name="file_upload" id="lefile">
                  <div class="input-append">
                    <input type="text" id="photoCover" class="input-large">
                    <a href="#" class="btn" onclick="$('input[id=lefile]').click();">Browse</a>
                  </div>
                  <br><br>
                  <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                </div>

              </form>
           </div>
      
          </div> <!-- end of row-container-fluid -->
        
        </div><!-- span -->
      </div><!-- row -->

      <hr>

    </div><!--/.fluid-container-->
    
<?php include_once('includes/footer.php'); ?>
