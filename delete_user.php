<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/user.php'); ?>

<?php 
    
  if (!isset($_GET['id'])) {
    redirect_to("admin_users.php");
  } else {
    $id = $_GET['id'];

    $record = new User();
    $record->id = $id;
    if ($record->delete()) {
      $session->message("Record succesfully deleted.");
      redirect_to("admin_users.php");
    } else {
      $session->message("Record was not deleted!");
    }
  }

  


 ?>