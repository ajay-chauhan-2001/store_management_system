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
    public function insertProduct($name, $description, $price,$discount, $quantity, $category_id, $image) 
    {
        try
        {
            $sql = "INSERT INTO products (name, description, price,discount, quantity, category_id,image) 
                    VALUES (:name, :description, :price,:discount, :quantity, :category_id, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':discount', $discount);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':category_id', $category_id);
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

   
    public function updateCustomer($id,$userName,$name,$email,$address,$phoneNumber,$role_id,$image=null)
    {
        try
        {
            if ($image) {
                echo "if";
               echo  $sql = "UPDATE users 
                        SET username = :username,name = :name, email = :email, address = :address, phone_number = :phone_number,role_id = :role_id, 
                         image = :image
                        WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':image', $image);
            } else {
                echo "else";
              echo   $sql = "UPDATE users 
                         SET username = :username,name = :name, email = :email, address = :address, phone_number = :phone_number,role_id = :role_id,
                        WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
            }

            
            $stmt->bindParam(':username', $userName);
            $stmt->bindParam(':name', $name);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone_number', $phoneNumber);

            // $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':role_id', $role_id);
            $stmt->bindParam(':id', $id);

            $stmt->execute();  
        //      $stmt->debugDumpParams();
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
      
            $stmt = $this->conn->prepare("SELECT u.*,r.name AS role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id;");
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

    $getOneQuery = "SELECT * FROM users WHERE id=?";
    $stmt = $this->conn->prepare($getOneQuery);
    $stmt->execute([$id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    // die();
    return $row;
    }

     // delete employee record
     public function deleteCustomer($id,$image)
     {
         try
         {
            $get = $this->conn->prepare("select image from users where id =:id");
            $get->bindParam(':id',$id);
            $get->execute();
        //        $get->debugDumpParams();
        //    die();
            $row = $get->fetch(PDO::FETCH_ASSOC);
              $image=$row['image'];
       
            $del="delete from users where id =:id";
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
