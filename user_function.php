<?php
include('config.php');

class User 
{
    public $conn;
    
    // Database call
    public function __construct($conn) 
    {
        $this->conn = $conn;  // Assign database connection to the class
    }

    // Check login function
     public function checkLogin($email, $newPassword) 
    {
        try
        {
             // Email check
             $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email and password = :password");
             $stmt->bindParam(':email', $email);
             $stmt->bindParam(':password', $newPassword);
             $stmt->execute();
             $row = $stmt->fetch(PDO::FETCH_ASSOC);
             return $row;
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
 
    // public function getUserById($user_id, $session_id) {
    //     if($user_id)
    //     {

    //         $getOneQuery = "select * from users WHERE id='$user_id'";

    //     }
    //     else
    //     {
    //         $getOneQuery = "select * from users WHERE id='$session_id'";
    //     }
    //     $stmt = $this->conn->prepare($getOneQuery);
    //     $stmt->execute();
    //     // $stmt->debugDumpParams();
    //     //    die();
    //          $row = $stmt->fetch();
    //         // echo "<pre>"; print_r($row);
    //          return $row; 
    // }
    
    // public function updatePassword($id, $newPassword) {
    //     $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    //     return $stmt->execute([$newPassword, $id]);
    // }
    

    public function checkEmail($email)
    {

        try
        {
                $checkEmail = $this->conn->prepare("SELECT email FROM users WHERE email = :email");
                $checkEmail->bindParam(':email', $email);
                $checkEmail->execute();

                
                if ($checkEmail->rowCount() > 0) 
                {
                    $emailError= "Email already exists!";
                    return $emailError;


                }
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
         
    }

    // insert product 
    public function insertUser($userName, $newPassword, $roleId,$name, $email, $phoneNumber,$address ,$image) 
    {
        try
        {
          echo   $insertSql = "INSERT INTO `users`(`username`, `password`, `role_id`, `name`, `email`, `phone_number`, `address`, `image`)  
                    VALUES (:username, :password, 2,:name, :email, :phone_number,:address, :image)";
            $stmt = $this->conn->prepare($insertSql);

            $stmt->bindParam(':username', $userName);
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':image', $image);

            $stmt->execute();  
        //              $stmt->debugDumpParams();
        //    die();

            return true;


        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  
        }
    }

//     public function updateUserEditableFields($id, $name, $address, $phoneNumber, $image) 
//     {
//     //     $stmt = $this->conn->prepare("UPDATE users SET name = ?, address = ?, phone_number = ?, image = ? WHERE id = ?");
//     //     return $stmt->execute([$name, $address, $phone, $image, $id]);
//     // 

//     try
//     {
//         if ($image) {
//             echo "if";
//            echo  $sql = "UPDATE users 
//                     SET name = :name, address = :address, phoneNumber = :phoneNumber,image = :image WHERE id = :id";
//             $stmt = $this->conn->prepare($sql);
//             $stmt->bindParam(':image', $image);
//         } else {
//             echo "else";
//           echo   $sql = "UPDATE users 
//                     SET name = :name, address = :address, phoneNumber = :phoneNumber , discount = :discount ,quantity = :quantity, 
// WHERE id = :id";
//             $stmt = $this->conn->prepare($sql);
//         }   
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':address', $address);
//         $stmt->bindParam(':phoneNumber', $phoneNumber);
//         $stmt->bindParam(':id', $id);

//         $stmt->execute();  
//         return true;  
//     }
//     catch (PDOException $e) {
//         echo "Error: " . $e->getMessage();
//         return false;  
//     }
//     }
    
   
    public function updateProduct($id, $name, $description, $price,$discount, $quantity, $category_id, $image = null) 
    {
        try
        {
            if ($image) {
                echo "if";
               echo  $sql = "UPDATE products 
                        SET name = :name, description = :description, price = :price, discount = :discount,quantity = :quantity, 
                            category_id = :category_id, image = :image
                        WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':image', $image);
            } else {
                echo "else";
              echo   $sql = "UPDATE products 
                        SET name = :name, description = :description, price = :price , discount = :discount ,quantity = :quantity, 
                            category_id = :category_id 
                        WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
            }   
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':discount', $discount);

            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':id', $id);

            $stmt->execute();  
            return true;  
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  
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
      
            $stmt = $this->conn->prepare("SELECT p.*,c.name AS category_name  FROM products p LEFT JOIN categories c ON p.category_id = c.id ");
            $stmt->execute();

            $products = $stmt->fetchAll();
            return $products;

      
    }
    // get one record for products
    public function fetchOneProduct($id) {

    $getOneQuery = "SELECT * FROM products WHERE id=?";
    $stmt = $this->conn->prepare($getOneQuery);
    $stmt->execute([$id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
    }

     // delete employee record
     public function deleteEmployee($id, $image) 
     {
         try
         {
            $get = $this->conn->prepare("select image from products where id =:id");
            $get->bindParam(':id',$id);
            $get->execute();
            $row = $get->fetch(PDO::FETCH_ASSOC);
             $image=$row['image'];
       
            $del="delete from products where id =:id";
            $deleteSql = $this->conn->prepare($del);
            $deleteSql -> bindParam(':id', $id);
            $deleteSql->execute();

         // image exit or not
         if (file_exists($image)) 
         {
             unlink($image);  // Delete image on folder
         }
        return $deleteSql;

     }
     catch (PDOException $e) {
         echo "error: " . $e->getMessage();
     }
     }

     public function insertCart($user_id, $session_id, $product_id,$quantity, $price, $discount) 
     {
         try
         {
             $insertSql = "INSERT INTO `carts`(`user_id`, `session_id`, `product_id`, `quantity`, `price`,discount) 
             VALUES  (:user_id, :session_id, :product_id,:quantity, :price, :discount)";
             $stmt = $this->conn->prepare($insertSql);
 
             $stmt->bindParam(':user_id', $user_id);
             $stmt->bindParam(':session_id', $session_id);
             $stmt->bindParam(':product_id', $product_id);
             $stmt->bindParam(':quantity', $quantity);
             $stmt->bindParam(':price', $price);
             $stmt->bindParam(':discount', $discount);

             $stmt->execute();  

             return true;
             // return $query;
 
         }
         catch (PDOException $e) {
             echo "Error: " . $e->getMessage();
             return false;  
         }
     }

    public function fetchOneCart($id) 
    {

        $getOneQuery = "SELECT c.id,c.price,c.quantity,c.discount, p.name,p.image 
         FROM carts as c 
         LEFT JOIN products as p
         on p.id=c.id 
         WHERE c.user_id=:id";
        $stmt = $this->conn->prepare($getOneQuery);
        $stmt -> bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
        }
    

        public function fetchAllCart($id) 
    {
      
        $getOneQuery = "SELECT c.id,c.price,c.quantity,c.discount, p.name,p.image 
        FROM carts as c 
        LEFT JOIN products as p
        on p.id=c.id 
        WHERE c.user_id=:id";
       $stmt = $this->conn->prepare($getOneQuery);
       $stmt -> bindParam(':id', $id);
       $stmt->execute();

            $cart = $stmt->fetchAll();

            return $cart;

      
    }

    public function fetchAllCartRecord($id,$user_id=null,$session_id=null) 
    {

      
        if($user_id)
        {

            $getOneQuery = "select * from carts WHERE user_id='$user_id'";

        }
        else
        {
            $getOneQuery = "select * from carts WHERE session_id='$session_id'";
        }
       $stmt = $this->conn->prepare($getOneQuery);
       $stmt->execute();
            $cart = $stmt->fetchAll();
            return $cart; 
    }
    // updateCartQuantity

    public function updateCartQuantity($id, $quantity, $user_id = null, $session_id = null)
{
    $query = "UPDATE carts SET quantity = :quantity WHERE id = :id";
    if ($user_id) {
        $query .= " AND user_id = :uid";
    } else {
        $query .= " AND session_id = :sid";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':id', $id);
    if ($user_id) {
        $stmt->bindParam(':uid', $user_id);
    } else {
        $stmt->bindParam(':sid', $session_id);
    }
    return $stmt->execute();
}

// deleteCartItem

public function deleteCartItem($id, $user_id = null, $session_id = null)
{
    $query = "DELETE FROM carts WHERE id = :id";
    if ($user_id) {
        $query .= " AND user_id = :uid";
    } else {
        $query .= " AND session_id = :sid";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    if ($user_id) {
        $stmt->bindParam(':uid', $user_id);
    } else {
        $stmt->bindParam(':sid', $session_id);
    }
    return $stmt->execute();
}

public function insertOrders($id,$name, $phone_number, $address,$city, $country, $state,$pin_code,$full_address,$customer_id,$totalAmount,$totalDiscount,$status)
{
    try
    {
        $json=array(

            "id"=>$id,
            "name"=>$name,
            "phone_number"=>$phone_number,
            "address"=>$address,
            "city"=>$city,
            "country"=>$country,
            "state"=>$state,
            "pin_code"=>$pin_code,
            "full_address"=>$full_address,
        );
        $status='pending';
        $shiping=json_encode($json);
        $sql = "INSERT INTO `orders`(`customer_id`, `total_amount`, `discount`, `shipping_address`, `status`) VALUES  (:customer_id, :total_amount,:discount, :shiping,:status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':total_amount', $totalAmount);
        $stmt->bindParam(':discount', $totalDiscount);
        $stmt->bindParam(':shiping', $shiping);
        $stmt->bindParam(':status', $status);
        $stmt->execute();  

        return true;

    }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;  
    }

}

public function insertOrdersItems($id) {
    try {
        $sql = "SELECT c.product_id, c.quantity,c.price,o.id FROM carts as c RIGHT JOIN orders as o ON o.customer_id= c.id WHERE o.customer_id=:id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($items as $item) {
          
               $orderId= $item['id'];
              $productId= $item['product_id'];
             $quantity= $item['quantity'];
             $price= $item['price'];

        }

         $insertStmt = $this->conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price) 
            VALUES ('$orderId', '$productId', '$quantity', '$price')
        ");
        $insertStmt->execute();      
           return true;
    } catch (PDOException $e) {
        echo "Insert Order Items Error: " . $e->getMessage();
        return false;
    }
}


public function clearCart($user_id, $session_id) {
    try {
        $stmt = $user_id
            ? $this->conn->prepare("DELETE FROM carts WHERE user_id = :user_id")
            : $this->conn->prepare("DELETE FROM carts WHERE session_id = :session_id");

        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':session_id', $session_id);
        }

        $stmt->execute();

    return true;

    } catch (PDOException $e) {
        echo "Clear Cart Error: " . $e->getMessage();
        return false;
    }
}


}
?>
