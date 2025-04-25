<?php
include_once('order_function.php');

// session start
session_start();

// if session not set then login page show
if(!isset($_SESSION['name']))
{
    header('location:../login.php');
   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
   
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    
</head>
<body>
<button>
        <a href="../dashboard.php">Back</a>
    </button>
    <table id="tbl">
        <thead>
            <tr>
                <td>id</td>
                <td>Order id</td>
                <td>Order Date</td>
                <td>Customer Info</td>
                <td>Total Amount</td>
                <td>Total Discount</td>

                <td>Status</td>
               
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
        <?php         
            $fetchData = new Admin($conn); // create object Admin class
            $products = $fetchData->fetchAllProduct();  // get all products
            $i = 1;
           
            foreach($products as $row)
            {
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <?php echo $row['username']."<br>"; 
                          echo $row['phone_number'];?>
                </td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>

                <td><?php echo $row['status']; ?></td>
                <!-- <td><?php echo $row['updated_at']; ?></td> -->
                
                   <td> <a href="view_order.php?id=<?php echo $row['id']; ?>">view</a> 
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
</html>

<script>
   
    $("#tbl").DataTable({
        "pageLength": 5, // Default per page
        "lengthMenu": [5, 10, 15, 20, 25],
    });
</script>
