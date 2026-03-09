<?php
require_once 'conn.php';
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Corrected session variable name
    try {
        ?>
        <link rel="stylesheet" href="style1.css">
        <h3>Calculate Appointment</h3>
        <form method='post' action='slotcalculate.php'>
            <label for='appointmentDuration'>Appointment Duration (minutes):</label>
            <input type='number' name='appointmentDuration' id='appointmentDuration' required>
            <!-- Add hidden inputs for start_time and end_time -->
            <?php
            $startTime = isset($_GET['start_time']) ? htmlspecialchars($_GET['start_time']) : '';
            $endTime = isset($_GET['end_time']) ? htmlspecialchars($_GET['end_time']) : '';
            echo "<input type='hidden' name='start_time' id='start_time' value='$startTime'>";
            echo "<input type='hidden' name='end_time' id='end_time' value='$endTime'>";
            ?>
            <button type='submit'>Calculate</button>
        </form>
<?php
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


