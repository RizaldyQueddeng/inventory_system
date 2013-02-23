<?php 

  require_once('includes/functions.php');
  require_once('includes/database.php');
  require_once('includes/user.php');


  $user = User::find_by_id(1);
  echo $user->full_name() . "<br />";

  echo "<hr />";

  $users = User::find_all(); 
  foreach ($users as $user) {
    echo "Username: " . $user->username . "<br>";
    echo "Full Name: " . $user->full_name() . "<br><br>";
  }


 ?>