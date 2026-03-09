<?php

// Include the connection.php file
require_once 'conn.php';
session_start();

// Display data from the database
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Corrected session variable name
    try {
        // Fetch data from the database
        $stmt = $conn->query("SELECT student.st_id,student.sname,student.email,student.contact,student.password,department.dept_name as department FROM student
        INNER JOIN department ON student.dept_id = department.dept_id
        where student.st_id =$user_id");
        
        if ($stmt->rowCount() > 0) {
            // Display data in a table
            echo "<h2>Your Records:</h2>";
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
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Department</th>
            <th>Password</th>
            
            <th colspan=2>Action</th>
            </tr>";
    
            // Output data of each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                <td>" . $row["sname"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["contact"] . "</td>
                <td>" . $row["department"] . "</td>
                <td>" . $row["password"] . "</td>
              
                <td>
                    <a href='studentedit.php.?id=" . $row["st_id"] . "'>Edit</a>
                    </td>
                    <td>
                    <a href='studentdelete.php?id=" . $row["st_id"] . "'>Delete</a>
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
} else {
    echo "User ID session variable not set.";
}

// Close the connection
$conn = null;
?>