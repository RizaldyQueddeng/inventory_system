<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>

<?php 
    
  $id = $_GET['id'];

  $record = new Inventory();
  $record->product_id = $id;
  $message = $record->delete();

  header("location: home.php?message=$message")

 ?>