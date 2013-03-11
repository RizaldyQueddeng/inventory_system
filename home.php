<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }
 ?>

<?php include_once('includes/layouts/home_header.php'); ?>
  <div class="container home">
    <br>
    <!-- Main hero unit for a primary marketing message or call to action -->
    <div class="hero-unit">
      <p>Welcome! Admin <?php echo ucfirst($_SESSION['first_name']); ?> to Dpoint's</p>
      <h1>Inventory Management System</h1>
      <br>
      <p>Helps manage company's products such as CCTV units and systems, 
        with realtime product purchase and sales monitoring that ensures 
        the inventory is accurate and valid.</p>
    </div>

    <ul class="thumbnails">
      <li class="span3">
        <div class="thumbnail">
          <a href="inventory.php"><img src="assets/img/inventory.jpg" alt="inventory"></a>
          <h2>Inventory</h2>
          <p>Monitor inventory sales and orders</p>
          <p><a class="btn" href="inventory.php">View details &raquo;</a></p>
        </div>
      </li>
      <li class="span3">
        <div class="thumbnail">
          <a href="products.php"><img src="assets/img/banner1.png" alt="products"></a>
          <h2>Products</h2>
          <p>Manage and upload image to Products</p>
          <p><a class="btn" href="products.php">View details &raquo;</a></p>
        </div>
      </li>
      <li class="span3">
        <div class="thumbnail">
          <a href="#"><img src="assets/img/sales.jpg" alt="sales"></a>
          <h2>Sales</h2>
          <p>Get realtime statistics on sales from range of months and dates</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </li>
      <li class="span3">
        <div class="thumbnail">
          <a href="#"><img src="assets/img/purchase.png" alt="purchase"></a>
          <h2>Purchase</h2>
          <p>Monitor Purchased products via statistical graph</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </li>
    </ul>

  </div> <!-- end of container -->

<?php include_once('includes/layouts/home_footer.php'); ?>