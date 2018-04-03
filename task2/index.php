<?php
    if(isset($_POST["submitbtn"])){
        
        include_once($_SERVER['DOCUMENT_ROOT']."/classes/class.main.php");
        
        $mainObj = new main;
        
        echo '<table id="output"><tr><td>Processing...</td></tr></table>';

        $mainObj->submit_form();
        
        die;
    }
?>

<!DOCTYPE html>
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}

fieldset {
    margin: 20px;
}

/* Full-width input fields */
input[type=text], input[type=password], input[type=file] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

button:hover {
    opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>
<body>

<form action="/action_page.php" style="border:1px solid #ccc">
  <div class="container">
    <h1>Input Form</h1>
    <p>Please fill in this form to process the request.</p>
    <hr>

    <fieldset>
        <legend>S3 Credenitals</legend>

        <label><b>Bucket</b></label>
        <input type="text" placeholder="Enter Bucket" name="s3[bucket]" required>

        <label><b>Access Key</b></label>
        <input type="text" placeholder="Enter Access Key" name="s3[access_key]" required>

        <label><b>Secret Key</b></label>
        <input type="text" placeholder="Secret Key" name="s3[secret_key]" required>

        <label><b>CSV File Name</b></label>
        <input type="text" placeholder="CSV File name" name="s3[csv_file]" required>

        <label><b>Column Name</b></label>
        <input type="text" placeholder="Column name" name="s3[csv_col]" required>
    </fieldset>

    <fieldset>
        <legend>MYSQL Credenitals</legend>

        <label><b>Host</b></label>
        <input type="text" placeholder="Enter Host" name="mysql[host]" required>

        <label><b>Port</b></label>
        <input type="text" placeholder="Enter Port" name="mysql[port]" required>

        <label><b>User</b></label>
        <input type="text" placeholder="User" name="mysql[user]" required>

        <label><b>Password</b></label>
        <input type="text" placeholder="Password" name="mysql[password]" required>

        <label><b>Database</b></label>
        <input type="text" placeholder="Database" name="mysql[database]" required>

        <label><b>Table</b></label>
        <input type="text" placeholder="Table" name="mysql[tbl_name]" required>

        <label><b>Column Name</b></label>
        <input type="text" placeholder="tbl_col" name="mysql[tbl_col]" required>
    </fieldset>

    <fieldset>
        <legend>SCP Credenitals</legend>

        <label><b>Host</b></label>
        <input type="text" placeholder="Enter Host" name="scp[host]" required>

        <label><b>User</b></label>
        <input type="text" placeholder="User" name="scp[user]" required>

        <label><b>Password</b></label>
        <input type="text" placeholder="Password" name="scp[password]" required>

        <label><b>CSV File Name</b></label>
        <input type="text" placeholder="CSV File name" name="scp[csv_file]" required>

        <label><b>Column Name</b></label>
        <input type="text" placeholder="Column name" name="scp[csv_col]" required>
    </fieldset>

    <fieldset>
        <legend>CSV File Upload</legend>

        <label><b>CSV File Upload</b></label>
        <input type="file" placeholder="CSV File upload" name="csv_file" required>

        <label><b>Column Name</b></label>
        <input type="text" placeholder="Column name" name="csv_col" required>
    </fieldset>

    <div class="clearfix">
      <button type="submit" class="signupbtn" name="submitbtn">Submit</button>
    </div>
  </div>
</form>

</body>
</html>