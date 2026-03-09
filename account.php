<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<center><h1>Create Account</h1></center>
    <div class="container">
        <form action="createrecord.php" method="post">
        <label for="person">Who are you?:</label>

<select name="person" id="person">
  <option value="faculty">Faculty</option>
  <option value="student">Student</option>
  <option value="staff">Staff</option>
</select>    

        <div>
                <label for="id">ID:</label>
                 <input type="text" name="id" placeholder="Enter your ID(your id will consist of 4digit)">
            </div>
            <div>
                <label for="name">Name:</label>
                 <input type="text" name="name" placeholder="Enter your name">
            </div>
            <div>
                <label for="email">Email:</label>
                 <input type="text" name="email" placeholder="Enter your email">
            </div>
            <div>
                <label for="dept">Department:</label>
                <select name="dept" id="dept">
                    <!-- Department options will be populated dynamically -->
                </select>
            </div>
            <div>
                <label for="contact">Contact:</label>
                 <input type="text" name="contact" placeholder="Enter your phone no.">
            </div>
            <div>
                <label for="password">Password:</label>
                 <input type="password" name="password" placeholder="Enter a password">
            </div>
           
               
            <div class="btn">
                <button type="submit" name="button">Create</button>
            </div>
              
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch department names using AJAX
            $.ajax({
                url: 'fetch_departments.php',
                type: 'GET',
                success: function(data) {
                    var departments = JSON.parse(data);
                    departments.forEach(function(department) {
                        $('#dept').append('<option value="' + department.dept_id + '">' + department.dept_name + '</option>');
                    });
                }
            });
        });
    </script>
</body>
</html>
