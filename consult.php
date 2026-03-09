<?php
    require_once 'conn.php';
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
try {
    $stmt = $conn->prepare("SELECT * FROM pending where pen_id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {

                 $stmt = $conn->prepare("insert into appoinment(attendant_id, attendant_type,fid,sem_id,date,day,time,purpose,status) select attendant_id, attendant_type,fid,sem_id,date,day,time,purpose,'Consulted' from pending where pen_id=:id");
                 $stmt->bindParam(':id', $id);
                 $stmt->execute();

                    echo "New record created successfully";
                    $stmt = $conn->prepare("DELETE FROM pending WHERE pen_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo "Record deleted successfully";
    }
                } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                }
            }
        ?>
                