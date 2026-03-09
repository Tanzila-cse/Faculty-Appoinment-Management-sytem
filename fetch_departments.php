<?php
// Include the connection.php file
require_once 'conn.php';

try {
    // Fetch department data from the database
    $stmt = $conn->query("SELECT dept_id, dept_name FROM department");
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert the data to JSON format
    $json = json_encode($departments);

    // Output the JSON data
    echo $json;
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
