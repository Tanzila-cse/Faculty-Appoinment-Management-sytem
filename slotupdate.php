<?php
// Include the connection.php file
require_once 'conn.php';

// Assuming form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id= $_POST['id'];
    $semester = $_POST['semester'];
    $time1 = $_POST['time1'];
    $time2 = $_POST['time2'];
    $day = $_POST['day'];
    
    try {
        // Prepare and execute your update query
        $stmt = $conn->prepare("UPDATE avail_slot   SET sem_id=:semester,start_time=:time1,end_time=:time2,day=:day  WHERE slot_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':semester', $semester);
     
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':time1', $time1);
        $stmt->bindParam(':time2', $time2);
        $stmt->execute();

        echo "Record updated successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$conn = null;
?>