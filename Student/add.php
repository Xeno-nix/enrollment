<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $full_name = $first_name . " " . $last_name;
    $email = $_POST['email'];
    $course = $_POST['course'];

    $image_path = "";

    if (!empty($_FILES['img']['name'])) {
        $image_name = time() . "_" . $_FILES['img']['name'];
        $tmp = $_FILES['img']['tmp_name'];
        $destination = "../uploads/" . $image_name;

        move_uploaded_file($tmp, $destination);

        $image_path = $destination;
    }

    $sql = "INSERT INTO student (full_name, email, course, profile_picture)
            VALUES (?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $full_name, $email, $course, $image_path);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

<h2>Add Student</h2>

<form method="POST" enctype="multipart/form-data">

First Name:
<input type="text" name="first_name" required><br>

Last Name:
<input type="text" name="last_name" required><br>

Email:
<input type="email" name="email" required><br>

Course:
<select name="course" required>
    <option value="">Select</option>
    <option value="BSIT">BSIT</option>
    <option value="BSED">BSED</option>
    <option value="BSABE">BSABE</option>
</select><br>

Image:
<input type="file" name="img" accept="image/*"><br>

<button type="submit">Save</button>

</form>

</body>
</html>