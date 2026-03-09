<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $attendantType = $_POST['attendant_type']; // Added to retrieve attendant type
    $attendantId = $_POST[$attendantType]; // Retrieve attendant ID based on attendant type
    $semester = $_POST['semester'];
    $date=$_POST['date'];
    $time = $_POST['time'];
    $day = $_POST['day'];
    $facultyId = $_POST['faculty'];
    $purpose=$_POST['purpose'];


    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO pending (attendant_id, attendant_type, fid,sem_id, day, time,purpose,date) VALUES (:id, :attendantType,:facultyId, :semester, :day, :time,:purpose,:date)");
        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':attendantType',  $attendantType);
        $stmt->bindParam(':facultyId', $facultyId); // Corrected the parameter name
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':purpose', $purpose);

        // Execute the statement
        $stmt->execute();

        echo "New record created successfully";
        header('Location: index.php');
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?>
