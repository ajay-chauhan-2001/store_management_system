$(document).ready(function() {

    function updateQty(id, action) {
        var input = jQuery("#quantity-item-" + id);
        var currentVal = parseInt(input.val());
        var proTotal = $("#unitPrice_" + id).text();
        var cartId = $("#cart_id_" + id).text();
     
        var price = $("#mainPrice").text();
        var discount = $("#discount").text();
        if (!validateQuantity(cartId)) return;
        if (action === "increase") {
            input.val(currentVal + 1);
        } else if (action === "decrease" && currentVal > 1) {
            input.val(currentVal - 1);
        }
    }
    
        $.ajax({
            url: "update_cart.php",
            method: "POST",
            data: {
                cart_id: cartId,
                action: action
            },
            success: function(response) {
                console.log(response);
                // return false;
                
                if (response === "deleted") {
                    group.closest("tr").remove();
                } else if (!isNaN(response)) {
                    qtyInput.val(response);
                    location.reload(); // optional: reload totals
                } else {
                    alert("Failed to update cart");
                }
            }
        });
    
});
