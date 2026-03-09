<?php
// fetch_faculty.php
require_once 'conn.php';

$stmt = $conn->query("SELECT fid, fname FROM faculty");
$facultyNames = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($facultyNames);
?>
