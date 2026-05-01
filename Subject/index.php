<?php
include '../config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Management</title>
</head>
<body>

<a href="add.php">Add Subject</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Subject Code</th>
        <th>Subject Name</th>
        <th>Schedule</th>
        <th>Faculty Assigned</th>
        <th>Action</th>
    </tr>

<?php
$result = $con->query("
SELECT s.id, s.subject_code, s.subject_name,c.day, c.start_time, c.end_time, f.full_name 
FROM subject s 
left join faculty_assignment a on s.id = a.subject_id
left join faculty f on a.faculty_id = f.id
left join schedule c on s.id = c.subject_id;
");

while ($row = $result->fetch_assoc()) {
?>

<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['subject_code']) ?></td>
    <td><?= htmlspecialchars($row['subject_name']) ?></td>
    <td>
        <?= htmlspecialchars($row['day']) . " ". 
        htmlspecialchars($row['start_time']). " - " . htmlspecialchars($row['end_time'])?>
    </td>
    <td><?=$row['full_name'] ? htmlspecialchars($row['full_name']) : "None Assigned"  ?></td>

    <td>
        <a href="update.php?id=<?= $row['id'] ?>">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this subject?')">Delete</a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>