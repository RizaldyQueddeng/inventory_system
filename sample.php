<?php 

  require_once('includes/functions.php');
  require_once('includes/database.php');
  require_once('includes/databaseobject.php');
  require_once('includes/user.php');
  require_once('includes/inventory.php');


  include_once('includes/layouts/header.php');

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


  $sql = "SELECT id, product_id, SUM(units_sold) AS units_sold, sales_date, SUM(sales) AS sales ";
  $sql .= " FROM sales ";
  $sql .= " GROUP BY sales_date";

  $sales = Inventory::find_by_sql($sql);

 ?>

  <table class="table table-striped table-bordered table-hover inventory-table">
    <thead class="btn-success">
      <th>date</th>
      <th>Sales Order</th>
      <th>Sales</th>
      <th>Actions</th>
    </thead>
    <tbody>
      <?php 
        foreach ($sales as $product_sales) {
          echo "<tr><td>"; 
          echo $product_sales->sales_date;
          echo "</td><td>";
          echo $product_sales->units_sold;
          echo "</td><td>";
          echo formatMoney($product_sales->sales, true);
          echo "</td><td>";
          echo "<a href='delete_product.php?id=". $product_sales->product_id ."' class='btn tooltip_dialog' data-toggle='tooltip' data-placement='left' title='Delete Record' onclick='return confirmAction()'><i class='icon-trash'></i></a>";
          echo "</td></tr>";
        }

       ?>
    </tbody>
  </table>

 <?php include_once('includes/layouts/footer.php'); ?>