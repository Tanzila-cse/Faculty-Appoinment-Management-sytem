<?php
// Include the connection.php file
require_once 'conn.php';
session_start();

// Display data from the database
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    try {
        // Fetch semesters
        $semesterStmt = $conn->query("SELECT * FROM semester");
        $semesters = $semesterStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch data from the database
        if(isset($_POST['semester_id']) && !empty($_POST['semester_id'])) {
            $semester_id = $_POST['semester_id'];
            $stmt = $conn->prepare("SELECT appoinment.app_id,
            CASE 
                WHEN appoinment.attendant_type = 'faculty' THEN faculty.fname
                WHEN appoinment.attendant_type = 'student' THEN student.sname
                WHEN appoinment.attendant_type = 'staff' THEN staff.stname
            END AS attendant_name,
            faculty.fname AS faculty,
            semester.sem_name AS semester,
            appoinment.day,
            appoinment.time,
            appoinment.purpose,
            appoinment.date,
            appoinment.status
            FROM appoinment
            LEFT JOIN faculty ON appoinment.attendant_id = faculty.fid AND appoinment.attendant_type = 'faculty'
            LEFT JOIN student ON appoinment.attendant_id = student.st_id AND appoinment.attendant_type = 'student'
            LEFT JOIN staff ON appoinment.attendant_id = staff.s_id AND appoinment.attendant_type = 'staff'
            INNER JOIN semester ON appoinment.sem_id = semester.sem_id
            WHERE appoinment.fid = :user_id AND appoinment.sem_id = :semester_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':semester_id', $semester_id);
        } else {
            $stmt = $conn->prepare("SELECT appoinment.app_id,
            CASE 
                WHEN appoinment.attendant_type = 'faculty' THEN faculty.fname
                WHEN appoinment.attendant_type = 'student' THEN student.sname
                WHEN appoinment.attendant_type = 'staff' THEN staff.stname
            END AS attendant_name,
            faculty.fname AS faculty,
            semester.sem_name AS semester,
            appoinment.day,
            appoinment.time,
            appoinment.purpose,
            appoinment.date,
            appoinment.status
            FROM appoinment
            LEFT JOIN faculty ON appoinment.attendant_id = faculty.fid AND appoinment.attendant_type = 'faculty'
            LEFT JOIN student ON appoinment.attendant_id = student.st_id AND appoinment.attendant_type = 'student'
            LEFT JOIN staff ON appoinment.attendant_id = staff.s_id AND appoinment.attendant_type = 'staff'
            INNER JOIN semester ON appoinment.sem_id = semester.sem_id
            WHERE appoinment.fid = :user_id");
            $stmt->bindParam(':user_id', $user_id);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Display semester selection dropdown
            echo "<h2>Appointment Records:</h2>";
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

          
            echo "<style>
            /* Style for the table */
            body{
                background-color:bisque;
            }
            h2{
                text-align:center;
            }
            label {
                margin-left: 470px; /* Add margin for spacing */
                font-size:20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            select {
                width: 10%;
                padding: 12px 20px;
                display: inline-block;
                border: 2px solid green;
                box-sizing: border-box;
            }
            
            /* Style for the table */
            table {
                border-collapse: collapse;
                width: 100%;
            }
            
            table, th, td {
                border: 4px solid black;
                padding: 8px;
            }
            
            th {
                background-color: burlywood;
            }
            @media print {
                /* Hide select and button when printing */
                label, select, button {
                    display: none;
                }
            }
            /* Center the print button */
            .print-button-container {
                text-align: center;
                margin-top: 20px;
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
            
            /* Style for the button */
            button {
                background-color: #4CAF50;   
                color: orange;   
                padding: 15px;   
                margin: 10px 0px;   
                border: none;   
                cursor: pointer; 
                width: 10%; /* Set width */
          
            }
            
            button:hover {
                background-color: #45a049; /* Change color on hover */
            }
            
        </style>";
            echo "<table border='1'>
            <tr>
            <th>Attendant</th>
            <th>Semester</th>
            <th>Date</th>
            <th>Day</th>
            <th>Time</th>
            <th>Purpose</th>
            <th>Status</th>
            </tr>";

            // Output data of each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                <td>" . $row["attendant_name"] . "</td>
            <td>" . $row["semester"] . "</td>
            <td>" . $row["date"] . "</td>
            <td>" . $row["day"] . "</td>
            <td>" . $row["time"] . "</td>
            <td>" . $row["purpose"] . "</td>
            <td>" . $row["status"] . "</td>
   
            </tr>";
        }
        echo "</table>";

        // Print button
        echo "<div class='print-button-container'><button onclick='window.print()'>Print</button></div>";

    } else {
        echo "0 results";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}}

// Close the connection
$conn = null;
?>
