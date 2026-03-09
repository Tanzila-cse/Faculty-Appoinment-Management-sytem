<?php
// Include the connection.php file
require_once 'conn.php';

// Check if ID is provided in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare and execute the delete query
        $stmt = $conn->prepare("DELETE FROM faculty WHERE fid = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo "Record deleted successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}

// Close the connection
$conn = null;
?>