<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/inventory.php'); ?>

<?php 

  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  header("Content-type: application/json");

  $sql = "SELECT id, product_id, SUM(units_sold) AS units_sold, sales_date, SUM(sales) AS sales ";
  $sql .= " FROM sales ";
  $sql .= " GROUP BY sales_date";

  $sales = Inventory::find_by_sql($sql);
  foreach ($sales as $product_sales) {
    $date = $product_sales->sales_date;
    $quantity = $product_sales->units_sold;
    $item_sales = formatMoney($product_sales->sales, true);
    $sales_array[] = array("date" => $date, "quantity" => $quantity, "sales" => $item_sales);
  }
   echo json_encode($sales_array);

  ?>


 ?> 