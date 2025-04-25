<?php
session_start();

  //  $userId= $_SESSION['all']['id'];
//  echo $product_id = $_GET['user_id'];

//  echo  $_SESSION['id'];
// die();
include('user_function.php');
  $product_id = $_POST['product_id'];
$onerecord = new User($conn);
$row = $onerecord->fetchOneProduct($product_id);
// print_r(($row));

$price = $row['price'];
 $discount = $row['discount'];
$totalPrice = $price - $discount;
$quantity = $row['quantity'];
// $image = $row['image'] ?: 'no_image_icon_23500.jpg';

// $created_at = date("Y-m-d H:i:s");
// die();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //  $product_id = $_POST['product_id'];
     $newprice = $price;
     $quantity = $_POST['quantity'];
     $discount = $discount;

    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
    $session_id = isset($_SESSION['session_id']) ? $session_id : null;
// die();
    //  $session_id = session_id();

	$res=$onerecord->insertCart($user_id, $session_id, $product_id,$quantity, $price, $discount);
	
    if ($res) {
		$total=$onerecord->fetchAllCartRecord($id,$user_id,$session_id);
		 $number=count($total);
		echo $number;

    } else {
        echo false;
    }
}
?>
