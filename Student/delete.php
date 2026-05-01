<?php 
include '../config.php';

$id = $_GET['id'];

$sql = "SELECT profile_picture FROM student WHERE id = ?";
$stmt = $con -> prepare($sql);
$stmt -> bind_param("i",$id);
$stmt -> execute();

$result = $stmt -> get_result();
$row = $result -> fetch_assoc();

if(!empty($row['profile_picture'])){
    unlink($row['profile_picture']);
}

$sql = "delete FROM student WHERE id=?";
$stmt = $con -> prepare($sql);
$stmt -> bind_param("i",$id);
$stmt -> execute();
header("Location: index.php");
?>