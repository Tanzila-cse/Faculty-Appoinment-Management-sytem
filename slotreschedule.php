<?php
// Include the connection.php file
require_once 'conn.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Fetch data based on ID
        $stmt = $conn->prepare("SELECT * FROM avail_slot WHERE slot_id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {
            // Display a form to edit the record
?>
            <link rel="stylesheet" href="style1.css">
            <form method="post" action="slotupdate.php">
            <div>
                <label for="semester">Semester:</label>
                <select name="semester" id="semester" required>
                    <option value=""></option>
                    <!-- Semester options will be populated dynamically -->
                </select>
           
                <label for="day">Day:</label>
                <select name="day" id="day" required>
                    <option value="ST">ST</option>
                    <option value="MW">MW</option>
                    <option value="R">R</option>
                    <option value="A">A</option>
                    <!-- Add other days as needed -->
                </select>
                </div>
                Start Time: <input type="text" name="time1" ><br>
                End Time: <input type="text" name="time2" ><br>
                <div>
                
                
                <input type="hidden" name="id" value="<?php echo $row['slot_id']; ?>">
                <button>Update</button>
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch semesters using AJAX
        $.ajax({
            url: 'fetch_semester.php',
            type: 'GET',
            success: function(data) {
                var semesters = JSON.parse(data);
                semesters.forEach(function(semester) {
                    $('#semester').append('<option value="' + semester.sem_id + '">' + semester.sem_name + '</option>');
                });
            }
        });

        
                }
            );
   
</script>


<?php
        } else {
            echo "Record not found";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
} else {
    echo "Invalid request";
}
?>