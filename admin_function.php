<?php
include('config.php');

class Admin 
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

    public function checkEmail($email)
    {

        // if (mysqli_num_rows($result) > 0) {
        //     //   email exists
            
        //       $row = mysqli_fetch_assoc($result);
        //       // echo $cid;
        //   //   echo $row['cid'];
        //       if ($row['cid'] == $cid) {
        //           //if email and company same  company name error show
        //          $company_error = "This email is already in use for this company.";
        //      } else {
        //          // not same email error shoe
        //          $email_error = "This email is already used.";
        //      }
        //   }
        try
        {
                $checkEmail = $this->conn->prepare("SELECT email FROM users WHERE email = :email");
                $checkEmail->bindParam(':email', $email);
                $checkEmail->execute();
                // $checkEmail->debugDumpParams();
                //    die();
                
                if ($checkEmail->rowCount() > 0) 
                {
                    $emailError= "Email already exists!";
                    // return $emailError;
                    return $emailError;
                    // exit();

                }
                // if (mysqli_num_rows($row) > 0) {
                //     print_r(mysqli_num_rows($row));
                //     die();
                   
                //        return $email_error = "This email is Already Registered.";
                //     }
                
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
            $insertSql = "INSERT INTO `users`(`username`, `password`, `role_id`, `name`, `email`, `phone_number`, `address`, `image`)  
                    VALUES (:username, :password, :role_id,:name, :email, :phone_number,:address, :image)";
            $stmt = $this->conn->prepare($insertSql);

            $stmt->bindParam(':username', $userName);
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':role_id', $roleId);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':image', $image);
            // $query = $stmt->execute();
            $stmt->execute();  
        //     $stmt->debugDumpParams();
        //    die();
            return true;
            // return $query;

        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  
        }
    }

   
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
            //  $stmt->debugDumpParams();
        //    die();
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
            // $stmt->debugDumpParams();
        //    die();
            $products = $stmt->fetchAll();
            // print_r($products);
            // die();
            return $products;

      
    }
    // get one record for products
    public function fetchOneProduct($id) {

    $getOneQuery = "SELECT * FROM products WHERE id=?";
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
            $get = $this->conn->prepare("select image from products where id =:id");
            $get->bindParam(':id',$id);
            $get->execute();
        //        $get->debugDumpParams();
        //    die();
            $row = $get->fetch(PDO::FETCH_ASSOC);
             $image=$row['image'];
       
            $del="delete from products where id =:id";
            $deleteSql = $this->conn->prepare($del);
            $deleteSql -> bindParam(':id', $id);
            $deleteSql->execute();
            // $deleteSql->debugDumpParams();
            //    die();
          

         // image exit or not
         if (file_exists($image)) 
         {
             unlink($image);  // Delete image on folder
         }
 
        //  return $deleteEmployee;
        return $deleteSql;

     }
     catch (PDOException $e) {
         echo "error: " . $e->getMessage();
     }
     }

}
?>
