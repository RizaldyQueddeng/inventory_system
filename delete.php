<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/inventory.php'); ?>

<?php 
    
  if (!isset($_GET['id'])) {
    redirect_to("home.php");
  } else {
    $id = $_GET['id'];

    $record = new Inventory();
    $record->product_id = $id;
    if ($record->delete()) {
      $session->message("Record succesfully deleted.");
      redirect_to("home.php");
    } else {
      $session->message("Record was not deleted!");
    }
  }

  


 ?>