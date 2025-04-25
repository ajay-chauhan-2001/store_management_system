<?php
include_once('customer_function.php');

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
    <!-- <button>
        <a href="../Products/add_product.php">Add Product</a>
    </button> -->
  
    <table id="tbl">
        <thead>
            <tr>
                <td>id</td>
                <td>User Name</td>
                <td>Role</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone Number</td>
                <td>Address</td>
                <td>Image</td>
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
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['role_name']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>
                   
                    <img src="<?php echo $row['image'] ? $row['image'] : 'no_image_icon_23500.jpg'; ?>" width="80px" height="80px">                          
                </td>
                <td>
                    <a href="edit_customer.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete_customer.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
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
