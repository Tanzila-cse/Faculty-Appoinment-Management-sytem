<?php
// Include the connection.php file
require_once 'conn.php';
session_start();

// Fetching all semesters for the dropdown menu
$semesters = $conn->query("SELECT * FROM semester")->fetchAll(PDO::FETCH_ASSOC);

// Display data from the database
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Corrected session variable name
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['semester']) && !empty($_POST['semester'])) {
            // If form is submitted and a semester is selected, filter by the selected semester
            $selected_semester = $_POST['semester'];
            $stmt = $conn->prepare("SELECT avail_slot.slot_id,
                                    avail_slot.fid,
                                    semester.sem_name AS semester,
                                    avail_slot.day,
                                    avail_slot.start_time,avail_slot.end_time
                            FROM avail_slot
                            INNER JOIN faculty ON avail_slot.fid = faculty.fid 
                            INNER JOIN semester ON avail_slot.sem_id = semester.sem_id
                            WHERE avail_slot.fid = :user_id AND semester.sem_name = :selected_semester");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':selected_semester', $selected_semester);
            $stmt->execute();
        } else {
            // If form is not submitted or no semester is selected, fetch all records without filtering
            $stmt = $conn->prepare("SELECT avail_slot.slot_id,
                                    avail_slot.fid,
                                    semester.sem_name AS semester,
                                    avail_slot.day,
                                    avail_slot.start_time,avail_slot.end_time
                            FROM avail_slot
                            INNER JOIN faculty ON avail_slot.fid = faculty.fid 
                            INNER JOIN semester ON avail_slot.sem_id = semester.sem_id
                            WHERE avail_slot.fid = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }
        
        if ($stmt->rowCount() > 0) {
            // Display data in a table
            echo "<h2>My Slots:</h2>";
            echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                  <label for='semester'>Select Semester:</label>
                  <select name='semester' id='semester'>
                  <option value=''>All</option>";
            // Populate dropdown menu with semesters
            foreach ($semesters as $semester) {
                echo "<option value='" . $semester['sem_name'] . "'>" . $semester['sem_name'] . "</option>";
            }
            echo "</select>
                  <button type='submit'>Show records</button>
                  </form>";

            echo "<style>
            /* Style for the table */
            body{
                background-color:bisque;
            }
            h2{
                text-align:center;
            }
            label {
                margin-left: 500px; /* Add margin for spacing */
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
            @media print {
                /* Hide select and button when printing */
                label, select, button {
                    display: none;
                }
                .action-column {
                    display: none;
                }
                
            }
            /* Center the print button */
            .print-button-container {
                text-align: center;
                margin-top: 20px;
            }

            a:hover {
                background-color: #e2e2e2;
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
                <th>Semester</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th colspan=3 class='action-column'>Action</th>
            </tr>";

            // Output data of each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                <td>" . $row["semester"] . "</td>
                <td>" . $row["day"] . "</td>
                <td>" . $row["start_time"] . "</td>
                <td>" . $row["end_time"] . "</td>
                <td class='action-column'>
                    <a href='slotreschedule.php?id=" . $row["slot_id"] . "'>Reschedule</a>
                </td>
                <td class='action-column'>
    <a href='calculateform.php?id=" . $row["slot_id"] . "&start_time=" . urlencode($row["start_time"]) . "&end_time=" . urlencode($row["end_time"]) . "'>Calculate</a>
</td>

                </tr>";
            }
            echo "</table>";
            echo "<div class='print-button-container'><button onclick='window.print()'>Print</button></div>";
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
