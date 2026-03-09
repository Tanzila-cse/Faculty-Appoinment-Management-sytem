<?php
// Include the connection.php file
require_once 'conn.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Fetch data based on ID
        $stmt = $conn->prepare("SELECT * FROM faculty where fid=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {
            // Fetch department data
            $dept_stmt = $conn->query("SELECT * FROM department");
            $departments = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display a form to edit the record
            ?>
            <link rel="stylesheet" href="style1.css">
            <form method="post" action="facultyupdate.php">
                Name: <input type="text" name="name" value="<?php echo $row['fname']; ?>"><br>
                Email: <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>
                Contact: <input type="text" name="contact" value="<?php echo $row['contact']; ?>"><br>
                Department: 
                <select name="dept">
                    <?php foreach($departments as $dept) { ?>
                        <option value="<?php echo $dept['dept_id']; ?>" <?php if($dept['dept_id'] == $row['dept_id']) echo 'selected'; ?>><?php echo $dept['dept_name']; ?></option>
                    <?php } ?>
                </select><br>
                Password: <input type="password" name="password" value="<?php echo $row['password']; ?>"><br>
                <input type="hidden" name="id" value="<?php echo $row['fid']; ?>">
                <button>Update</button>
            </form>

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
