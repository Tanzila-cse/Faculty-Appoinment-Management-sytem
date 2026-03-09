<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
   
    $id= $_POST['id'];
    $semester = $_POST['semester'];
    $time1 = $_POST['time1'];
    $time2 = $_POST['time2'];
    $day = $_POST['day'];
   
 


    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO avail_slot ( fid,sem_id, day,start_time,end_time ) VALUES (:id, :semester, :day, :time1,:time2)");
        // Bind parameters
       
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':time1', $time1);
        $stmt->bindParam(':time2', $time2);
        $stmt->bindParam(':day', $day);
        

        // Execute the statement
        $stmt->execute();

        echo "New record created successfully";
        header('Location:faculty.php');
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?>
