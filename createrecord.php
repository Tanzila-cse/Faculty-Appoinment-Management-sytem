<?php
require_once 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $selectedOption = $_POST['person']; 
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $dept = $_POST['dept'];
    $password = $_POST['password'];
   


    try {
        switch ($selectedOption) {
            case 'faculty':
                try {
 
                    $sql="insert into `faculty`(fid,fname,email,contact,dept_id,password) values(
                        '$id','$name','$email','$contact','$dept','$password')";
                        $conn->exec($sql);
                        echo "New record created successfully";
                        header('Location: index.php');
            
                    } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    }
                exit;
                break;
            case 'student':
                try {
 
                    $sql="insert into `student`(st_id,sname,email,contact,dept_id,password) values(
                        '$id','$name','$email','$contact','$dept','$password')";
                        $conn->exec($sql);
                        echo "New record created successfully";
                        header('Location: index.php');
            
                    } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    }
                exit;
                break;
            case 'staff':
                try {
 
                    $sql="insert into `staff`(s_id,stname,email,contact,dept_id,password) values(
                        '$id','$name','$email','$contact','$dept','$password')";
                        $conn->exec($sql);
                        echo "New record created successfully";
                        header('Location: index.php');
            
                    } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    }
                exit;
                break;
            default:
                header('Location: login.php'); // Redirect to login page if no option selected
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