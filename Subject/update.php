<?php
include '../config.php';

$id = $_GET['id'];

$sql = "SELECT s.*, l.day, l.start_time, l.end_time FROM subject s JOIN schedule l ON s.id = l.subject_id WHERE s.id = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];


    $sql = "UPDATE subject SET subject_code=?, subject_name=? WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssi", $subject_code, $subject_name, $id);
    $stmt->execute();

    $sql = "UPDATE schedule SET day=?, start_time=?, end_time=? WHERE subject_id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssi", $day, $start_time, $end_time, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Subject</title>
</head>
<body>

<h2>Edit Subject</h2>

<form method="POST">

Subject Code:
<input type="text" name="subject_code" value="<?= $row['subject_code'] ?>" required><br>

Subject Name:
<input type="text" name="subject_name" value="<?= $row['subject_name'] ?>" required><br>

Subject Schedule<br>

Day:
<select name="day" required>
    <option value="">Select</option>
    <option value="monday" <?= $row['day']=='monday'?'selected':'' ?>>Monday</option>
    <option value="tuesday" <?= $row['day']=='tuesday'?'selected':'' ?>>Tuesday</option>
    <option value="wednesday" <?= $row['day']=='wednesday'?'selected':'' ?>>Wednesday</option>
    <option value="thursday" <?= $row['day']=='thursday'?'selected':'' ?>>Thursday</option>
    <option value="friday" <?= $row['day']=='friday'?'selected':'' ?>>Friday</option>
    <option value="saturday" <?= $row['day']=='saturday'?'selected':'' ?>>Saturday</option>
</select><br>

Start:
<input type="time" name="start_time" value="<?= $row['start_time'] ?>" required><br>

End:
<input type="time" name="end_time" value="<?= $row['end_time'] ?>" required><br>

<button type="submit">Save</button>

</form>

</body>
</html>