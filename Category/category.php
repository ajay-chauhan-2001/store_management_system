<?php
include_once('category_function.php');

// Session start
session_start();

// If session not set then login page show
if(!isset($_SESSION['name'])) {
    header('location:../login.php');
    exit();
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
    <button><a href="../dashboard.php">Back</a></button>
    <button><a href="../Category/add_category.php">Add Category</a></button>
  
    <table id="tbl">
        <thead>
            <tr>
                <td>id</td>
                <td>Category Name</td>
                <td>Sub Category Name</td>
                <td>Image</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
        <?php         
            $fetchData = new Admin($conn); // Create object Admin class
            $products = $fetchData->fetchAllProduct();  // Get all products
            $i = 1;
           
            foreach($products as $row) {
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['parent_name']; ?></td>
                <td><?php echo $row['sub_category']; ?></td>
                <td>
                    <img src="<?php echo $row['image'] ? $row['image'] : 'no_image_icon_23500.jpg'; ?>" width="80px" height="80px">                          
                </td>
                <td>
                    <a href="edit_category.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete_category.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
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
<script>
    $("#tbl").DataTable({
        "pageLength": 5, // Default per page
        "lengthMenu": [5, 10, 15, 20, 25],
    });
</script>
</html>
