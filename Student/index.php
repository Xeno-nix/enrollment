<?php
include '../config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Profile Management</title>
</head>
<body>

<a href="add.php">Add Student</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Action</th>
    </tr>

<?php
$result = $con->query("SELECT * FROM student");

while ($row = $result->fetch_assoc()) {
?>

<tr>
    <td><?= $row['id'] ?></td>
    <td>
        <img src="<?= $row['profile_picture'] ?>" width="100" hieght= "100">
        <?= htmlspecialchars($row['full_name']) ?>
    </td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['course']) ?></td>

    <td>
         <a href="view.php?id=<?= $row['id'] ?>">View</a>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>