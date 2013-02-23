<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/session.php'); ?>

<?php 

  $session->logout();
  session_destroy();
  
  redirect_to("index.php");


 ?>