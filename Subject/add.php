<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "insert into subject (subject_code, subject_name) values (?,?)";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("ss",$subject_code, $subject_name);
    $stmt -> execute();

    $sql = "select id from subject where subject_code = ?";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("s",$subject_code);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $id = $row['id'];


    $sql = "insert into schedule (subject_id, day, start_time, end_time) values (?,?,?,?)";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("isss", $id, $day, $start_time, $end_time);
    $stmt -> execute();


    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
</head>
<body>

<h2>Add Subject</h2>

<form method="POST" enctype="multipart/form-data">

Subject Code:
<input type="text" name="subject_code" required><br>

Subject Name:
<input type="text" name="subject_name" required><br>
Subject Schedule
<br>
Day:
<select name="day" required>
    <option value="">Select</option>
    <option value="monday">Monday</option>
    <option value="tuesday">Tuesday</option>
    <option value="wednesday">Wednesday</option>
    <option value="thursday">Thursday</option>
    <option value="friday">Friday</option>
    <option value="saturday">Saturday</option>
</select><br>
Start:
<input type="time" name="start_time" required><br>
End:
<input type="time" name="end_time" required><br>
<button type="submit">Save</button>

</form>

</body>
</html>