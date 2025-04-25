<?php
session_start();
include "navbar.php";
include "User.php";

$id = $_SESSION['all']['id'] ?? 0;
$fetchData = new User($conn);
$products = $fetchData->fetchAllCart($id);

$totalProductPrice = 0;
$totalDiscount = 0;
$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container py-5">
    <h1 class="mb-5">Shopping Cart</h1>
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($products as $row):
                            $unitPrice = $row['price'] - $row['discount'];
                            $total = $unitPrice * $row['quantity'];
                            $totalProductPrice += $row['price'] * $row['quantity'];
                            $totalDiscount += $row['discount'] * $row['quantity'];
                            $totalAmount += $total;
                            $image = $row['image'] ?: 'upload/no_image_icon_23500.jpg';
                        ?>
                        <tr id="row-<?php echo $row['id']; ?>">
                            <td>
                                <img src="Products/<?php echo $image; ?>" width="100"><br>
                                <?php echo $row['name']; ?>
                            </td>
                            <td id="unitPrice_<?php echo $row['id']; ?>"><?php echo $unitPrice; ?></td>
                            <td>
                                <div class="input-group" id="cart_id_<?php echo $row['id']; ?>">
                                    <button class="btn btn-danger" onclick="updateQty(<?php echo $row['id']; ?>, 'decrement')">
                                        <?php echo ($row['quantity'] > 1) ? '-' : '<i class="fa fa-trash"></i>'; ?>
                                    </button>
                                    <input type="text" class="form-control text-center" id="quantity-item-<?php echo $row['id']; ?>" value="<?php echo $row['quantity']; ?>" readonly>
                                    <button class="btn btn-primary" onclick="updateQty(<?php echo $row['id']; ?>, 'increment')">+</button>
                                </div>
                            </td>
                            <td><?php echo $total; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card cart-summary">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?php echo $totalProductPrice; ?></span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Discount</span><span><?php echo $totalDiscount; ?></span></div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3"><strong>Total</strong><strong><?php echo $totalAmount; ?></strong></div>
                    <a href="checkout.php" class="btn btn-primary w-100 mb-2">Proceed to Checkout</a>
                    <a href="index.php" class="btn btn-outline-info w-100">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateQty(cartId, action) {
    $.ajax({
        url: 'update_cart.php',
        method: 'POST',
        data: {
            cart_id: cartId,
            action: action
        },
        success: function(response) {
            console.log("Server Response:", response);

            if (response === "deleted") {
                $("#row-" + cartId).remove();
            } else if (!isNaN(response)) {
                $("#quantity-item-" + cartId).val(response);
            } else {
                alert("Failed to update cart.");
            }

            // Reload to update totals
            location.reload();
        },
        error: function(err) {
            alert("Error updating cart");
            console.log(err);
        }
    });
}
</script>
</body>
</html>
