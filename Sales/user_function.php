<?php
include_once('config.php');

class Admin 
{
    public $conn;
    // database call
    public function __construct($conn) 
    {
        $this->conn=$conn; // call the parent constructor database connection
    }

    // Check login function
    public function checkLogin($email, $newPassword) 
    {
        try
        {
             // Email check
             $stmt = $this->conn->prepare("SELECT *  FROM admins WHERE email = :email and password = :password");
             $stmt->bindParam(':email', $email);
             $stmt->bindParam(':password', $newPassword);
             $stmt->execute();
            //  $stmt->debugDumpParams();
             $row = $stmt->fetch(PDO::FETCH_ASSOC);
             return $row;
                  
    }
    catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
}

     // check  email and company is already exit or not
    //  public function checkEmailAndCompany($email,$companyId,$id=null) 
    // {
    //     try
    //     {
    //             if(empty($id))
    //             {
    //                 //check email id exit or not
    //                 $checkEmailAndCompany = "SELECT email, company_id FROM employees WHERE email = '$email'";
              
    //             }
    //             else
    //             {
    //                 // check email and company name  exit or not
    //                 $checkEmailAndCompany = "SELECT email, company_id FROM employees WHERE email = '$email' And id !='$id'";
            
    //             }
                    
    //         $result = $this->conn->query($checkEmailAndCompany);
            
    //         if ($result->num_rows > 0) 
    //         {
    //             $row = $result->fetch_assoc();
    //             // Check  the company_id matches
    //             if ($row['company_id'] == $companyId) 
    //             {
                
    //                return  $errorMassage="This Email id exit in this Company.";
    //             } 
    //             else 
    //             {
    //                 return  $errorMassage= "This Email is Already exit.";                                   
    //             }
    //         }
    //         return null;
    //     }
    //    catch (PDOException $e) {
    //     echo "error: " . $e->getMessage();
    // }
    // }
    
    // insert employee record
    public function insertEmployee($firstName, $lastName, $companyId, $email, $phoneNumber, $status, $image) 
    {
        try
        {
         $insertSql = "INSERT INTO employees (first_name, last_name, company_id, email, phone_number, image, status) 
                VALUES ('$firstName', '$lastName', '$companyId', '$email', '$phoneNumber', '$image', '$status')";
      
        return $this->conn->query($insertSql);
        }
        catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
    }

    // get company data for dropdown
    public function companyData() 
    {
        try
        {
           return $this->conn->query("SELECT id, name FROM roles");
        }
        catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
    }
    
    // get all employee data
    public function fetchAllEmployees() 
    {
        try
        {
            $fetchAllEmployees = "SELECT e.*,c.name AS company_name 
                    FROM employees e 
                    LEFT JOIN companies c ON e.company_id = c.id
                    ORDER by id DESC";

            return $this->conn->query($fetchAllEmployees);
        }
        catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
    }

    // get a single employee record
    public function fetchOneEmployee($id) 
    {
        try
        {
            $fetchOneEmployee = "SELECT * FROM employees WHERE id = $id";
            return $this->conn->query($fetchOneEmployee);
        }
        catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
    }
    // update Employee Record
    public function updateEmployee($id,$firstName, $lastName, $companyId, $email, $phoneNumber, $status, $image=null) 
    {
        try
        {
        if ($_FILES['image']['name']) 
        {
            // Image update with image
             $updateImageEmployee = "UPDATE employees SET first_name = '$firstName', last_name = '$lastName', company_id = '$companyId', 
            email = '$email', phone_number = '$phoneNumber', image = '$image', status = '$status' WHERE id = '$id' order by id desc";
               return $this->conn->query($updateImageEmployee);
            
        } else {
            // Image update with no image select
             $updateNoImageEmployee  = "UPDATE employees SET first_name = '$firstName', last_name = '$lastName', company_id = '$companyId', 
                email = '$email', phone_number = '$phoneNumber',status = '$status' WHERE id = '$id' order by id desc";
        return $this->conn->query($updateNoImageEmployee);
   }
}
catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}
    }

    // delete employee record
    // public function deleteEmployee($id, $image) 
    // {
    //     try
    //     {
    //     // $imageRecord = new Admin($conn);
        
    //     $image ="select image from employees where id = $id";
    //     $sql = $imageRecord->fetchOneEmployee($id);
    //     $row = mysqli_fetch_array($sql);
    //     $oldImage = $row['image']; // get image 
    //     $deleteSql = "DELETE FROM employees WHERE id = '$id'";
    //     $deleteEmployee = $this->conn->query($deleteSql); 

    //     // image exit or not
    //     if (file_exists($oldImage)) 
    //     {
    //         unlink($oldImage);  // Delete image on folder
    //     }

    //     return $deleteEmployee;
    // }
    // catch (PDOException $e) {
    //     echo "error: " . $e->getMessage();
    // }
    // }

    //  image upload
    public function uploadImage($image) 
    {
        try
        {
        $file = "upload/";
        if (!is_dir($file)) 
        {  
            mkdir($file, 0777);  // Create directory 
            chmod($file,0777);  // give the folder permission with all access
        }

        $ext = "." . pathinfo($image['name'], PATHINFO_EXTENSION);  // get image extension
        $fileName = "user_" . time() . $ext;  // set image defult name
        $targetFile = $file . basename($fileName); 

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            chmod($targetFile, 0777);  // set file permission
            return $targetFile; 
        } else {
            return false;  
        }
    }
    catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
    }
}
?>
