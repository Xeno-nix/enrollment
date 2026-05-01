<?php
include '../config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM student WHERE id=?";
$stmt = $con -> prepare($sql);
$stmt -> bind_param("i",$id);
$stmt -> execute();

$result = $stmt -> get_result();
$row = $result -> fetch_assoc();

$nameParts = explode(" ", $row['full_name'], 2);

$first_name = $nameParts[0];
$last_name = $nameParts[1] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $full_name = $first_name . " " . $last_name;
    $email = $_POST['email'];
    $course = $_POST['course'];

    $image_path = $row['profile_picture'];

    if (!empty($_FILES['img']['name'])) {

        $image_name = time() . "_" . $_FILES['img']['name'];
        $tmp = $_FILES['img']['tmp_name'];
        $destination = "../uploads/" . $image_name;

        move_uploaded_file($tmp, $destination);

        $image_path = $destination;
    }

    $sql = "UPDATE student SET full_name=?, email=?, course=?, profile_picture=? WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssi", $full_name, $email, $course, $image_path, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form method="POST" enctype="multipart/form-data">

First Name:
<input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required><br>

Last Name:
<input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required><br>

Email:
<input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required><br>

Course:
<select name="course">
    <option value="BSIT" <?= htmlspecialchars($row['course'])=="BSIT"?"selected":"" ?>>BSIT</option>
    <option value="BSED" <?= htmlspecialchars($row['course'])=="BSED"?"selected":"" ?>>BSED</option>
    <option value="BSABE" <?= htmlspecialchars($row['course'])=="BSABE"?"selected":"" ?>>BSABE</option>
</select><br>

Current Image:<br>
<img src="<?= htmlspecialchars($row['profile_picture']) ?>" width="100"><br>

Change Image:
<input type="file" name="img"><br><br>

<button type="submit">Update</button>

</form>

</body>
</html>