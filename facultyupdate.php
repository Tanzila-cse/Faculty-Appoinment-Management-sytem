<?php
// Include the connection.php file
require_once 'conn.php';

// Assuming form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $dept = $_POST['dept'];
    $password = $_POST['password'];
  

    try {
        // Prepare and execute your update query
        $stmt = $conn->prepare("UPDATE faculty   SET fname = :name, email = :email ,contact=:contact,dept_id=:dept,password=:password WHERE fid = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':dept', $dept);
        $stmt->bindParam(':password', $password);
        
        $stmt->execute();

        echo "Record updated successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$conn = null;
?>