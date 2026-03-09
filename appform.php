<?php
// Include the connection.php file
require_once 'conn.php';
session_start();

// Check if user is logged in
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    ?>
            <link rel="stylesheet" href="style1.css">
          
    <title>Appointment Form</title>
    
   

    <center><h1>Appointment Form</h1></center>
    <div class="container">
        <form action="pending.php" method="post">
            
            <div>
                <label for="attendant_type">Attendant Type:</label>
                <select name="attendant_type" id="attendant_type" required>
                    <option value="faculty">Faculty</option>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div>
                <label for="faculty">Faculty:</label>
                <select name="faculty" id="faculty" required>
                    <option value=""></option>
                    <!-- Faculty options will be populated dynamically -->
                </select>
            </div>
            <div>
                <label for="semester">Semester:</label>
                <select name="semester" id="semester" required>
                    <option value=""></option>
                    <!-- Semester options will be populated dynamically -->
                </select>
            </div>
            <div>
                <label for="date">Date:</label>
                <input type="text" name="date" id="date" placeholder="Enter your preferrable date" required>
            </div>
            <div>
                <label for="day">Day:</label>
                <select name="day" id="day" required>
                    <option value="ST">ST</option>
                    <option value="MW">MW</option>
                    <option value="R">R</option>
                    <option value="A">A</option>
                    <!-- Add other days as needed -->
                </select>
            </div>
            <div>
                <label for="time">Time:</label>
                <select name="time" id="time" required>
                    <!-- Time slots will be populated dynamically -->
                </select>
            </div>
            
            <div>
                <label for="purpose">Purpose:</label>
                <input type="text" name="purpose" id="purpose" placeholder="Enter your purpose for this meeting" required>
            </div>
            <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                <button>Create</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Fetch faculty names using AJAX
        $.ajax({
            url: 'fetch_faculty.php',
            type: 'GET',
            success: function(data) {
                var faculties = JSON.parse(data);
                faculties.forEach(function(faculty) {
                    $('#faculty').append('<option value="' + faculty.fid + '">' + faculty.fname + '</option>');
                });
            }
        });

        // Fetch semester names using AJAX
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

        // Handle change event for faculty, semester, and day selections
        $('#faculty, #semester, #day').change(function() {
            var facultyId = $('#faculty').val();
            var semesterId = $('#semester').val();
            var day = $('#day').val();
            // Fetch time slots using AJAX
            $.ajax({
                url: 'fetch_slots.php',
                type: 'GET',
                data: { facultyId: facultyId, semesterId: semesterId, day: day },
                success: function(data) {
                    var slots = JSON.parse(data);
                    $('#time').empty(); // Clear previous options
                   
                    slots.forEach(function(slot) {
                        $('#time').append('<option value="' + slot.start_time + '">' + slot.start_time + '</option>');
                        
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
    

    $conn = null;

?>
