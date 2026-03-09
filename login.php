<?php
require_once 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $selectedOption = $_POST['person'];

    try {
        switch ($selectedOption) {
            case 'faculty':
                $stmt = $conn->prepare("SELECT * FROM  faculty WHERE fid = $id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() == 1) {
                    if ($password == $row['password']) {
                        $_SESSION['id'] = $row['fid'];
                        echo "Session ID: " . session_id() . "<br>"; // Debug statement
                        echo "Session data: ";
                        print_r($_SESSION); // Debug statement
                        header('Location: faculty.php');
                        exit;
                    } else {
                        echo "Invalid request";
                    }
                }
                exit;
                break;
            case 'student':
                $stmt = $conn->prepare("SELECT * FROM  student WHERE st_id = $id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() == 1) {
                    if ($password == $row['password']) {
                        $_SESSION['id'] = $row['st_id'];
                        echo "Session ID: " . session_id() . "<br>"; // Debug statement
                        echo "Session data: ";
                        print_r($_SESSION); // Debug statement
                        header('Location: student.php');
                        exit;
                    } else {
                        echo "Invalid request";
                    }
                }
                exit;
                break;
            case 'staff':
                $stmt = $conn->prepare("SELECT * FROM  staff WHERE s_id = $id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() == 1) {
                    if ($password == $row['password']) {
                        $_SESSION['id'] = $row['s_id'];
                        echo "Session ID: " . session_id() . "<br>"; // Debug statement
                        echo "Session data: ";
                        print_r($_SESSION); // Debug statement
                        header('Location: staff.php');
                        exit;
                    } else {
                        echo "Invalid request";
                    }
                }
                exit;
                break;
            default:
                header('Location: main.php'); // Redirect to login page if no option selected
                exit;
                break;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$conn = null;
?>