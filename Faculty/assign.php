<?php
include '../config.php';

$faculty_id = $_GET['id'] ?? null;

if (!$faculty_id) {
    die("Faculty not found.");
}

$stmt = $con->prepare("SELECT * FROM faculty WHERE id = ?");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$faculty = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subjects = $_POST['subject'] ?? [];

    if (!empty($subjects)) {

        $stmt = $con->prepare("
            INSERT INTO faculty_assignment (faculty_id, subject_id)
            VALUES (?, ?)
        ");

        foreach ($subjects as $s) {
            $stmt->bind_param("ii", $faculty_id, $s);
            $stmt->execute();
        }
    }

    header("Location: ../Faculty/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Subjects</title>
</head>
<body>

<h2>Assign Subjects to <?= htmlspecialchars($faculty['full_name']) ?></h2>

<form method="POST">

<?php
$result = $con->query(" SELECT * FROM subject WHERE id NOT IN (SELECT subject_id FROM faculty_assignment)");
?>

<?php if ($result->num_rows == 0) { ?>

    <p style="color:red; font-weight:bold;">
        No available subjects to assign.
    </p>

<?php } else { ?>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <label>
            <input type="checkbox" name="subject[]" value="<?= $row['id'] ?>">
            <?= htmlspecialchars($row['subject_code'] . " - " . $row['subject_name']) ?>
        </label>
        <br>

    <?php } ?>

    <br>
    <button type="submit">Assign Selected Subjects</button>

<?php } ?>

</form>

<br>
<a href="../Faculty/index.php">Back</a>

</body>
</html>
   