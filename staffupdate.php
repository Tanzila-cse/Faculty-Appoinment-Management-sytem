<?php
// Include the connection.php file
require_once 'conn.php';

// Assuming form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $dept = $_POST['dept'];
    $password = $_POST['password'];

    try {
        // Prepare and execute your update query
        $stmt = $conn->prepare("UPDATE staff   SET stname = :name, contact = :contact,email=:email,dept_id=:dept,password=:password  WHERE s_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':email', $email);
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