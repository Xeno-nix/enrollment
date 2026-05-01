<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $full_name = $first_name . " " . $last_name;
    $email = $_POST['email'];

    $sql = "insert into faculty (full_name,email) values (?,?)";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("ss",$full_name,$email);
    $stmt -> execute();

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty</title>
</head>
<body>

<h2>Add Faculty</h2>

<form method="POST" enctype="multipart/form-data">

First Name:
<input type="text" name="first_name" required><br>

Last Name:
<input type="text" name="last_name" required><br>

Email:
<input type="email" name="email" required><br>

<button type="submit">Save</button>

</form>
</body>
</html>