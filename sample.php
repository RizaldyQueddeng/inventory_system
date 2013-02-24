<?php 

  require_once('includes/functions.php');
  require_once('includes/database.php');
  require_once('includes/databaseobject.php');
  require_once('includes/user.php');


  $user = User::find_by_id(1);
  echo $user->full_name() . "<br />";

  echo "<hr />";

  $users = User::find_all(); 
  foreach ($users as $user) {
    echo "Username: " . $user->username . "<br>";
    echo "Full Name: " . $user->full_name() . "<br><br>";
  }

  // $user = new User();
  // $user->username = "yoga";
  // $user->password = "jsonmanz";
  // $user->first_name = "jayson";
  // $user->last_name = "mandani";
  // $user->save();

  // $user = USER::find_by_id(11);
  // $user->password = "certifiedyogamaster";
  // $user->save();

  // $user = User::find_by_id(12);
  // $user->delete();
  // echo $user->username;

 ?>