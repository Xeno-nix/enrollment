<?php
include '../config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Management</title>
</head>
<body>

<h2>Faculty List</h2>

<a href="add.php">Add Faculty</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Assigned Subjects</th>
        <th>Action </th>
    </tr>

<?php
$result = $con->query("
SELECT f.id, f.full_name, f.email,
GROUP_CONCAT(s.subject_code SEPARATOR ', ') AS subjects
FROM faculty f
left JOIN faculty_assignment fa ON f.id = fa.faculty_id
left JOIN subject s ON fa.subject_id = s.id
GROUP BY f.id
");

while($row = $result->fetch_assoc()){
?>

<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['full_name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td>
        <?= $row['subjects'] ? htmlspecialchars($row['subjects']) : "No Subjects Assigned" ?>
    </td>
    <td>
        <a href="assign.php?id=<?= $row['id'] ?>" >Assign Subject</a>
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>