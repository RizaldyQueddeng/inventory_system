<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/databaseobject.php'); ?>
<?php require_once('includes/user.php'); ?>

<?php 

	if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
  	# code...
  }


 ?>