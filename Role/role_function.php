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
    
    // insert product 
    public function insertCategory($name) 
    {
        // echo $parent_id;
        // die();
        try
       
        {
            // if(empty($parent_id))
            // {

            $sql = "INSERT INTO roles (name)VALUES (:name)";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':name', $name);
            $stmt->execute();  

        //     $stmt->debugDumpParams();
        //    die();
            return true;
           

        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  
        }
    }

   
    public function updatecategory($id, $name) 
    {
        try
        {
            
                echo "else";
              echo   $sql = "UPDATE roles 
                        SET name = :name WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name); 
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
    

    // all value get products
    public function fetchAllProduct() 
    {
      
            $stmt = $this->conn->prepare("SELECT *  FROM roles");
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

    $getOneQuery = "SELECT * FROM roles WHERE id=?";
    $stmt = $this->conn->prepare($getOneQuery);
    $stmt->execute([$id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    // die();
    return $row;
    }

     // delete employee record
     public function deleteEmployee($id) 
     {
         try
         {
            $del="delete from roles where id =:id";
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
