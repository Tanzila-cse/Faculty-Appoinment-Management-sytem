<?php
// Include the connection.php file
require_once 'conn.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Fetch data based on ID
        $stmt = $conn->prepare("SELECT * FROM pending WHERE pen_id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {
            // Display a form to edit the record
?>
            <link rel="stylesheet" href="style1.css">
            <form method="post" action="resupdate.php">
            <div>
                <label for="semester">Semester:</label>
                <select name="semester" id="semester" required>
                    <option value=""></option>
                    <!-- Semester options will be populated dynamically -->
                </select>
            </div>
                Date: <input type="text" name="date" value="<?php echo $row['date']; ?>"><br>
                <div>
                <label for="day">Day:</label>
                <select name="day" id="day" required>
                    <option value="ST">ST</option>
                    <option value="MW">MW</option>
                    <option value="R">R</option>
                    <option value="A">A</option>
                    <!-- Add other days as needed -->
                </select>
                <div>
                <label for="time">Time:</label>
                <select name="time" id="time" required>
                    <!-- Time slots will be populated dynamically -->
                </select>
            </div>
                
                
                <input type="hidden" name="id" value="<?php echo $row['pen_id']; ?>">
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

        $('#semester, #day').change(function() {
            var semesterId = $('#semester').val();
            var day = $('#day').val();
            var facultyId = '<?php echo $row["fid"]; ?>'; // Get facultyId from PHP variable

            // Fetch time slots using AJAX
            $.ajax({
                url: 'fetch_slots.php',
                type: 'GET',
                data: { facultyId: facultyId, semesterId: semesterId, day: day }, // Pass facultyId parameter
                success: function(data) {
                    var slots = JSON.parse(data);
                    $('#time').empty(); // Clear previous options
                    slots.forEach(function(slot) {
                        $('#time').append('<option value="' + slot.slot + '">' + slot.slot + '</option>');
                    });
                }
            });
        });
    });
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