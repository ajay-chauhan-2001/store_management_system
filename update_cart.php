<?php
session_start();
include('config.php');
include('user_function.php');

$onerecord = new User($conn);
$cart_id = $_POST['cart_id'] ?? null;
$action = $_POST['action'] ?? null;
$user_id = $_SESSION['all']['id'] ?? null;
$session_id = session_id();

if (!$cart_id || !$action) {
    echo 'error';
    exit;
}

$cartItems = $onerecord->fetchAllCartRecord(null, $user_id, $session_id);

foreach ($cartItems as $row) {
    if ($row['id'] == $cart_id) {
        $quantity = $row['quantity'];

        if ($action === 'increment') {
            $quantity++;
            $onerecord->updateCartQuantity($cart_id, $quantity, $user_id, $session_id);
            echo $quantity;
            exit;
        } elseif ($action === 'decrement') {
            if ($quantity > 1) {
                $quantity--;
                $onerecord->updateCartQuantity($cart_id, $quantity, $user_id, $session_id);
                echo $quantity;
                exit;
            } else {
                $onerecord->deleteCartItem($cart_id, $user_id, $session_id);
                echo 'deleted';
                exit;
            }
        }
    }
}

echo 'error';
