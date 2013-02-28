<?php 

  require_once('includes/functions.php');
  require_once('includes/database.php');
  require_once('includes/databaseobject.php');
  require_once('includes/user.php');
  require_once('includes/inventory.php');



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

  // $product = new Inventory();
  // $product->product = "Dome Camera";
  // $product->quantity_left = 30;
  // $product->quantity_sold = 0;
  // $product->price = 20000;
  // $product->sales = 0;
  // $product->product_description = "Cctv camera for indoor security";

  // $product->units_purchase = $product->quantity_left;
  // $product->date = date("Y-m-d");
  // $product->save();

  // $table_name = "products";
  // $for_select_input = Inventory::find_all_inventory($table_name);
  // foreach ($for_select_input as $field) {
  //   echo $field->product_id ." ". $field->product . "<br />";
  // }
  
  // echo "<br />";


  if (isset($_POST{'submit'})) {
    echo $_POST['product_id'];
  }


 ?>