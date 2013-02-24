<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/session.php'); ?>

<?php 

  $session->logout();
  
  redirect_to("index.php");


 ?>