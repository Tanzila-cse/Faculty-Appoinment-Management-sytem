<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login panel</title>
    <link rel="stylesheet" href="style1.css">
    
</head>
<body>
<center> <h1>Login Form </h1> </center>   
<form action="login.php" method="post"> 
        <div class="container">   
        <label for="person">Who are you?:</label>

<select name="person" id="person">
  <option value="faculty">Faculty</option>
  <option value="student">Student</option>
  <option value="staff">Staff</option>

</select>
            <label>AppId : </label>   
            <input type="text" placeholder="Enter your app id" name="id" required>  
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" name="password" required>  
            <button>Log In</button>
                
                
           
              
        </div>   
    </form>     
</body>     
</html>  


