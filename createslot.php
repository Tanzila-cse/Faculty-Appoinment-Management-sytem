<?php
// Include the connection.php file
require_once 'conn.php';
session_start();

// Check if user is logged in
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    ?>
            <link rel="stylesheet" href="style1.css">
            <form method="post" action="slotcreate.php">
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
                
                
                <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                <button>Create</button>
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
    

    $conn = null;

?>