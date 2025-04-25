<?php 

include "category_function.php";


// get id
$id = $_GET['id'];  
try
{
    $deleteData=new Admin($conn);  // create object Admin class

    //delete Employee function
    $deleteSql=$deleteData->deleteEmployee($id,$image);

    if($deleteSql)
    {
        header("Location:category.php"); // redirect employee page
    }
}
catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}

?>