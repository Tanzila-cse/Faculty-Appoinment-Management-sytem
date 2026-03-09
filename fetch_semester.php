<?php
// fetch_semester.php
require_once 'conn.php';

$stmt = $conn->query("SELECT sem_id, sem_name FROM semester");
$semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($semesters);
?>
