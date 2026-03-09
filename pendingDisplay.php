<?php
// Include the connection.php file
require_once 'conn.php';
session_start();

// Display data from the database
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Corrected session variable name
    try {
        // Fetch data from the database
        $stmt = $conn->query("SELECT pending.pen_id,
                                    CASE 
                                        WHEN pending.attendant_type = 'faculty' THEN faculty.fname
                                        WHEN pending.attendant_type = 'student' THEN student.sname
                                        WHEN pending.attendant_type = 'staff' THEN staff.stname
                                    END AS attendant_name,
                                    faculty.fname AS faculty,
                                    semester.sem_name AS semester,
                                    pending.day,
                                    pending.time,pending.purpose,pending.date
                            FROM pending
                            LEFT JOIN faculty ON pending.attendant_id = faculty.fid AND pending.attendant_type = 'faculty'
                            LEFT JOIN student ON pending.attendant_id = student.st_id AND pending.attendant_type = 'student'
                            LEFT JOIN staff ON pending.attendant_id = staff.s_id AND pending.attendant_type = 'staff'
                            INNER JOIN semester ON pending.sem_id = semester.sem_id
                            WHERE pending.fid = $user_id");
        
        if ($stmt->rowCount() > 0) {
            // Display data in a table
            echo "<h2>Pending Records:</h2>";
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
            <th>Attendant</th>
          
            <th>Semester</th>
            <th>Date</th>
            <th>Day</th>
            <th>Time</th>
            <th>Purpose</th>
            <th colspan=3>Action</th>
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
                <td>
                    <a href='reschedule.php?id=" . $row["pen_id"] . "'>Reschedule</a>
                </td>
                <td>
                    <a href='consult.php?id=" . $row["pen_id"] . "'>Consulted</a>
                </td>
                <td>
                    <a href='cancel.php?id=" . $row["pen_id"] . "'>Cancel</a>
                </td>
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
