<?php
include_once('../config.php');

class Admin 
{
    public $conn;
    
    // Database call
    public function __construct($conn) 
    {
        $this->conn = $conn;  // Assign database connection to the class
    }

    // Check login function
    // public function checkLogin($email, $newPassword) 
    // {
    //     try
    //     {
    //          // Email check
    //          $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email and password = :password");
    //          $stmt->bindParam(':email', $email);
    //          $stmt->bindParam(':password', $newPassword);
    //          $stmt->execute();
    //          $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //          return $row;
    //     }
    //     catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    // insert product 
    // public function insertProduct($name, $description, $price,$discount, $quantity, $category_id, $image,) 
    // {
    //     try
    //     {
    //         $sql = "INSERT INTO products (name, description, price,discount, quantity, category_id,image) 
    //                 VALUES (:name, :description, :price,:discount, :quantity, :category_id, :image)";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->bindParam(':name', $name);
    //         $stmt->bindParam(':description', $description);
    //         $stmt->bindParam(':price', $price);
    //         $stmt->bindParam(':discount', $discount);
    //         $stmt->bindParam(':quantity', $quantity);
    //         $stmt->bindParam(':category_id', $category_id);
    //         $stmt->bindParam(':image', $image);
    //         $stmt->execute();  

    //     //     $stmt->debugDumpParams();
    //     //    die();
    //         return true;

    //     }
    //     catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return false;  
    //     }
    // }

   
    public function updateOrder($id, $newStatus) 
    {
        try {
            $updateStatusSql = "UPDATE orders SET  status = :status ,status = :status WHERE id = :id";
            // $updateStatusSql = "UPDATE orders SET total_amount= :total_amount, status = :status ,status = :status WHERE id = :id";
            $stmt =$this->conn->prepare($updateStatusSql);
            $stmt->bindParam(':status', $newStatus);
            // $stmt->bindParam(':total_amount', $totalAmount);

            $stmt->bindParam(':id', $id);  
            $stmt->execute();
        //          $stmt->debugDumpParams();
        //    die();
            return true;

        } catch (PDOException $e) {
            echo "Error updating status: " . $e->getMessage();
        }
    }



    // Get all categories for dropdown
    public function categoryData() 
    {
        try
        {
            return $this->conn->query("SELECT id, name FROM categories");  // Get all categories from the database
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // all value get products
    public function fetchAllProduct() 
    {
      
            $stmt = $this->conn->prepare("
            SELECT o.*,u.username,u.phone_number from orders as o 
            LEFT JOIN users as u 
            ON o.customer_id=u.id;");
            $stmt->execute();
            // $stmt->debugDumpParams();
        //    die();
            $products = $stmt->fetchAll();
            return $products;

    }

    public function fetchAllOrder() 
    {
      
            $stmt = $this->conn->prepare("SELECT o.*,u.username from orders as o LEFT JOIN users as u ON o.customer_id=u.id;");
            $stmt->execute();
            // $stmt->debugDumpParams();
        //    die();
            $products = $stmt->fetchAll();
            return $products;

                                                                                                                                
    }

    public function fetchAllOrderItem($id) 
    {
      
            $stmt = $this->conn->prepare("
            SELECT oi.*,p.name,p.price,p.discount,p.quantity,p.image 
            from order_items as oi 
            LEFT JOIN products as p 
            on p.id=oi.product_id 
            WHERE oi.order_id=?;
            ");
            $stmt->execute([$id]); 
        //     $stmt->debugDumpParams();
        //    die();
            $products = $stmt->fetchAll();
            return $products;

      
    }

    
// 
    // get one record for order
    public function fetchOneOder($id) 
    {

    $getOrderQuery = "SELECT * FROM orders WHERE id=?";
    $stmt = $this->conn->prepare($getOrderQuery);
    $stmt->execute([$id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
    }

    // get one user record 
    public function fetchOneUser($id) 
    {

    $getUserQuery = "
            SELECT o.id,u.name,u.email,u.phone_number,u.image,u.address 
            from orders as o LEFT JOIN users as u ON o.customer_id=u.id 
            where o.id=$id;
            ";
    $stmt = $this->conn->prepare($getUserQuery);
    $stmt->execute(); 
    // $stmt->debugDumpParams();
    //        die();
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userRow;
    }

    public function fetchOneOderItem($id) 
    {

    $getOneQuery = "SELECT * FROM order_items WHERE id=?";
    $stmt = $this->conn->prepare($getOneQuery);
    $stmt->execute([$id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    // die();
    return $row;
    }

     // delete employee record
     public function deleteEmployee($id, $image) 
     {
            try
            {
                $del="delete from orders where id =:id";

                $deleteSql = $this->conn->prepare($del);
                $deleteSql -> bindParam(':id', $id);
                $deleteSql->execute();
                // $deleteSql->debugDumpParams();
                //    die();
            

            
            return $deleteSql;

        }
        catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
     }

}
?>
