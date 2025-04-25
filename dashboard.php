<?php
session_start();

include "config.php";

if(!isset($_SESSION['name']))
{
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        <!--session name show  -->
    Welcome to  <?php echo $_SESSION['name'] ." Panel"?>
    <button>
        <a href="logout.php">logout</a>
    </button>
    </body>
    </h1>
   <h2>Store Management System</h2>
   
   <!-- products -->
        <button>          
        <a href="Products/products.php">Product</a>   
        <?php 
        echo "<br>";
        echo "<br>";
       echo  $count = $conn->query("SELECT count(*) FROM products")->fetchColumn();
        ?> 
        </button>

        <!-- category -->
        <button>          
        <a href="Category/category.php">category</a>   
        <?php 
        echo "<br>";
        echo "<br>";
       echo  $count = $conn->query("SELECT count(*) FROM categories where parent_id is not null")->fetchColumn();
        ?> 
        </button>
        <!-- customer -->
        <button>    
            <a href="Customer/customers.php">Customers</a>
            <?php 
            echo "<br>";
            echo "<br>";
            echo  $count = $conn->query("SELECT count(*) FROM users")->fetchColumn();
            ?> 
        </button>  

        <!-- Ordes -->
        <button>          
        <a href="Order/orders.php">Orders</a>
        <?php 
        echo "<br>";
        echo "<br>";
       echo  $count = $conn->query("SELECT count(*) FROM orders")->fetchColumn();
        ?> 
        </button>  
        
        <!-- Sales -->
         <button>          
        <a href="sales.php">Sales</a>
        <?php 
        echo "<br>";
        echo "<br>";
       echo  $count = $conn->query("SELECT count(*) FROM orders")->fetchColumn();
        ?> 
        </button>

        <!-- role -->

        <button>    
            <a href="Role/role.php">Role</a>
            <?php 
            echo "<br>";
            echo "<br>";
            echo  $count = $conn->query("SELECT count(*) FROM roles")->fetchColumn();
            ?> 
        </button>  

</html>