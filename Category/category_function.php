<?php
include_once('../config.php');

class Admin 
{
    public $conn;
    
    // Database call
    public function __construct($conn) 
    {
        $this->conn = $conn;  
    }

    // Insert Category
    public function insertCategory($name, $parent_id = null, $image) 
    {
        try {
            $sql = "INSERT INTO categories (name, parent_id, image) VALUES (:name, :parent_id, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
            $stmt->bindParam(':image', $image);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update Category
    public function updatecategory($id, $name, $parent_id, $image = null) 
    {
        try {
            if ($image) {
                $sql = "UPDATE categories SET name = :name, parent_id = :parent_id, image = :image WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':image', $image);
            } else {
                $sql = "UPDATE categories SET name = :name, parent_id = :parent_id WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
            }

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':parent_id', $parent_id);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Fetch All Products 
    public function fetchAllProduct() 
    {
        $stmt = $this->conn->prepare("SELECT child.id, parent.name as parent_name, child.image, child.name as sub_category 
                                      FROM categories as parent, categories as child 
                                      WHERE parent.id = child.parent_id;");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Fetch One Category
    public function fetchOneProduct($id) 
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
