<?php
// Include the connection.php file
require_once 'conn.php';

// Check if the required parameters are set
if (isset($_GET['facultyId']) && isset($_GET['semesterId']) && isset($_GET['day'])) {
    // Sanitize and store the parameters
    $facultyId = $_GET['facultyId'];
    $semesterId = $_GET['semesterId'];
    $day = $_GET['day'];

    try {
        // Prepare and execute the SQL query to fetch time slots based on faculty, semester, and day
        $stmt = $conn->prepare("SELECT * FROM avail_slot WHERE fid = :facultyId AND sem_id = :semesterId AND day = :day");
        $stmt->bindParam(':facultyId', $facultyId);
        $stmt->bindParam(':semesterId', $semesterId);
        $stmt->bindParam(':day', $day);
        $stmt->execute();

        // Fetch all rows as associative array
        $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any slots were found
        if ($slots) {
            // Convert the result to JSON format and output
            echo json_encode($slots);
        } else {
            // If no slots found, return an empty array
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If required parameters are not set, return an error message
    echo "Error: Required parameters are missing.";
}
?>
