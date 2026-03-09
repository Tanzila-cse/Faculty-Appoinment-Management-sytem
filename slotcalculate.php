<?php
session_start();

// Check if the form is submitted and start time and end time are provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['start_time']) && isset($_POST['end_time'])) {
    // Retrieve form data
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $appointmentDuration = $_POST['appointmentDuration'];

    // Convert start and end times to DateTime objects for easier calculation
    $start = new DateTime($startTime);
    $end = new DateTime($endTime);

    // Calculate the time difference in minutes between start and end times
    $interval = $start->diff($end);
    $totalMinutes = $interval->h * 60 + $interval->i;

    // Calculate how many appointments can fit within the time slot based on the provided duration
    $appointments = floor($totalMinutes / $appointmentDuration);

    // Display the result
    echo "Within the time slot from $startTime to $endTime, you can accommodate $appointments appointments of $appointmentDuration minutes each.";
} else {
    // If start time or end time is missing, display an error message
    echo "Error: Start time or end time is missing.";
}
?>
