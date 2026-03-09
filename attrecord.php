<?php
// Include the connection.php file
require_once 'conn.php';
session_start();

// Display data from the database
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Corrected session variable name
    try {
        // Fetch semesters
        $semesterStmt = $conn->query("SELECT * FROM semester");
        $semesters = $semesterStmt->fetchAll(PDO::FETCH_ASSOC);

        // Display semester selection dropdown
        echo "<form method='post'>";
        echo "<label for='semester_id'>Select Semester:</label>";
        echo "<select name='semester_id' id='semester_id'>";
        echo "<option value=''>All</option>";
        foreach ($semesters as $semester) {
            echo "<option value='" . $semester['sem_id'] . "'>" . $semester['sem_name'] . "</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Show Records</button>";
        echo "</form>";

        // Fetch data from the database based on selected semester
        if(isset($_POST['semester_id']) && !empty($_POST['semester_id'])) {
            $semester_id = $_POST['semester_id'];
            $stmt = $conn->prepare("SELECT appoinment.app_id,appoinment.attendant_id, faculty.fname AS faculty, semester.sem_name AS semester, appoinment.day, appoinment.time,appoinment.status FROM appoinment
            INNER JOIN faculty ON appoinment.fid = faculty.fid
            INNER JOIN semester ON appoinment.sem_id = semester.sem_id
            WHERE appoinment.attendant_id = :user_id AND appoinment.sem_id = :semester_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':semester_id', $semester_id);
        } else {
            // Fetch all records if no specific semester selected
            $stmt = $conn->prepare("SELECT appoinment.app_id,appoinment.attendant_id, faculty.fname AS faculty, semester.sem_name AS semester, appoinment.day, appoinment.time,appoinment.status FROM appoinment
            INNER JOIN faculty ON appoinment.fid = faculty.fid
            INNER JOIN semester ON appoinment.sem_id = semester.sem_id
            WHERE appoinment.attendant_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Display data in a table
            echo "<h2>Appointment Records:</h2>";
            echo "<style>
            /* Style for the table */
            body{
                background-color:bisque;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }

            table, th, td {
                border: 4px solid black;
                padding: 8px;
            }

            th {
                background-color:burlywood;
            }

            /* Style for the links */
            a {
                display: inline-block;
                padding: 5px 10px;
                text-decoration: none;
                color: #333;
                border: 1px solid #333;
                border-radius: 5px;
                background-color: #f2f2f2;
            }

            a:hover {
                background-color: #e2e2e2;
            }
        </style>";
            echo "<table border='1'>
            <tr>
            <th>Faculty</th>
            <th>Semester</th>
            <th>Day</th>
            <th>Time</th>
            <th>Status</th>
            </tr>";

            // Output data of each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                <td>" . $row["faculty"] . "</td>
                <td>" . $row["semester"] . "</td>
                <td>" . $row["day"] . "</td>
                <td>" . $row["time"] . "</td>
                <td>" . $row["status"] . "</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$conn = null;
?>
