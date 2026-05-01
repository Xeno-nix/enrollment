<?php
include 'config.php';

// fetch students
$students = $con->query("SELECT * FROM student");


$filter_day = $_GET['filter_day'] ?? '';
$filter_faculty = $_GET['filter_faculty'] ?? '';

$query = "
SELECT s.id, s.subject_code, s.subject_name,
c.day, c.start_time, c.end_time,
f.full_name, f.id as faculty_id
FROM subject s 
LEFT JOIN faculty_assignment a ON s.id = a.subject_id
LEFT JOIN faculty f ON a.faculty_id = f.id
LEFT JOIN schedule c ON s.id = c.subject_id
WHERE 1=1
";

// apply filters
if (!empty($filter_day)) {
    $query .= " AND c.day = '$filter_day'";
}

if (!empty($filter_faculty)) {
    $query .= " AND f.id = '$filter_faculty'";
}


// fetch subjects + schedule
$subjects = $con->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST['student_id'];
    $subject_ids = $_POST['subject_ids'];

    foreach ($subject_ids as $subject_id) {

        $check = $con->query("SELECT * FROM enroll WHERE student_id=$student_id AND subject_id=$subject_id");

        if ($check->num_rows == 0) {
            $con->query("INSERT INTO enroll (student_id, subject_id) VALUES ($student_id, $subject_id)");
        } else {
            echo "Already enrolled in subject ID $subject_id <br>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enroll Student</title>
</head>
<body>

<h2>Enroll Student</h2>

<form method="POST">

<label>Filter by Day:</label>
<select name="filter_day">
    <option value="">All</option>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
</select>

<label>Filter by Faculty:</label>
<select name="filter_faculty">
    <option value="">All</option>
    <?php
    $faculties = $con->query("SELECT id, full_name FROM faculty");
    while ($f = $faculties->fetch_assoc()) {
        echo "<option value='{$f['id']}'>{$f['full_name']}</option>";
    }
    ?>
</select>

<select name="student_id">
    <option value="">-- Choose student --</option>
    <?php while($s = $students->fetch_assoc()) { ?>
        <option value="<?= $s['id'] ?>"><?= $s['full_name'] ?></option>
    <?php } ?>
</select>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Select</th>
        <th>Code</th>
        <th>Subject</th>
        <th>Schedule</th>
        <th>Faculty Assigned</th>
        <th>status</th>
    </tr>

<?php while ($row = $subjects->fetch_assoc()) { 

$isEnrolled = false;

if (!empty($_POST['student_id'])) {
    $sid = $_POST['student_id'];

    $checkEnroll = $con->query("
        SELECT 1 FROM enroll 
        WHERE student_id=$sid AND subject_id={$row['id']}
    ");

    $isEnrolled = ($checkEnroll->num_rows > 0);
}
?>
<tr>
    <td>
        <input type="checkbox" name="subject_ids[]" value="<?= $row['id'] ?>" <?= $isEnrolled ? "disabled checked" : ""?>>
    </td>
    <td><?= htmlspecialchars($row['subject_code']) ?></td>
    <td><?= htmlspecialchars($row['subject_name']) ?></td>
    <td>
        <?= htmlspecialchars($row['day']) . " " .
            htmlspecialchars($row['start_time']) . " - " .
            htmlspecialchars($row['end_time']) ?>
    </td>
    <td><?=$row['full_name'] ? htmlspecialchars($row['full_name']) : "None Assigned"  ?></td>
    <td><?= $isEnrolled ? "Enrolled" : "Not Enrolled" ?></td>
</tr>
<?php } ?>

</table>

<br>

<button type="submit">Confirm Enrollment</button>

</form>

</body>
</html>