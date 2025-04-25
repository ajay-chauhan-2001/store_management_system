$(document).ready(function() {

   $('#cart').click(function(e) {

        e.preventDefault();
  
        let pid=document.getElementById('product_id').value;
        // alert(pid);
        let quantity=document.getElementById('quantity').value;
        // alert(quantity);

        $.ajax({
            type: 'POST',
            url: 'cart_count.php',
            data: {
                product_id:$('#product_id').val(),
              quantity:$('#quantity').val(),
            },
           
            success: function(response) 
            {
                
                console.log(response); 

                // return false;
                if (response) 
                {
                    // alert("hello");
                   $("#cart-count").text(response);
                    // console.log("data insert");
                    // document.getElementById('cart-count').append();
                    // return false;

                } 
                else 
                {
                    // alert("else");
                    console.log("fail");
                           
                }
            },
            error: function() {
             
                console.log("not insert");
                
            }
        });
        
    });

   
});