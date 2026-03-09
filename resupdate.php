<?php
// Include the connection.php file
require_once 'conn.php';

// Assuming form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id= $_POST['id'];
    $semester = $_POST['semester'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $day = $_POST['day'];
    
    try {
        // Prepare and execute your update query
        $stmt = $conn->prepare("UPDATE pending   SET date=:date,time=:time,day=:day  WHERE pen_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':time', $time);
        
        $stmt->execute();

        echo "Record updated successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$conn = null;
?>