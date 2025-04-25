<?php
session_start();
include_once('../config.php');
include_once('category_function.php');

// If session not set then login page show
if(!isset($_SESSION['name'])) {
    header("location:../login.php");
    exit();
}

$admin = new Admin($conn);  // Create object Admin class

// Initialize variables for form data
$name = $description = $price = $discount = $quantity = $category_id = $image = "";
$nameError = $descriptionError = $priceError = $discountError = $quantityError = $category_idError = $imageError = "";


    $id = $_GET['id'];
    $onerecord = new Admin($conn);
    $row = $onerecord->fetchOneProduct($id);
    $name = $row['name'];
    $category_id = $row['parent_id'];
    $oldimage = $row['image'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $image = $oldimage;  
    
    
    if ($_FILES['image']['name']) {
        $targetDir = "upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777);
        }
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $timestamp = time();
        $filename = "category_" . $timestamp . "." . $ext;
        $image = $targetDir . basename($filename);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            chmod($image, 0777);
        } else {
            $imageError = "Failed to upload image.";
        }
    }

    try {
        $updateSql = $admin->updatecategory($id, $name, $category_id, $image);
        
        if ($updateSql) {
            header("Location: category.php"); 
            exit();
        } else {
            $errorMessage = "Category not updated.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<style>
    span, p, .error { color: red; }
</style>
<body>
    <button><a href="category.php">Back to category</a></button>
    <h1>Edit Category</h1>
    <form action="" method="post" enctype="multipart/form-data" id="category_form">
        <div class="input-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="category_id">Parent Category</label>
            <select name="category_id" readonly="readonly">
                <option value="" readonly="readonly">Select Parent Category</option>
                <?php
                try {
                    $sql = "SELECT id, name FROM categories WHERE parent_id IS NULL";  // Get only parent categories
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($category_id == $row['id']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "Error fetching categories: " . $e->getMessage();
                }
                ?>
            </select> 
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="image">Image</label>
            <img src="<?php echo $oldimage ?: 'upload/no_image_icon_23500.jpg'; ?>" width="80px" height="80px">
            <input type="file" name="image">
        </div>
        
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
