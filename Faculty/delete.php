<?php 
include '../config.php';

$id = $_GET['id'];

$sql = "delete FROM faculty WHERE id=?";
$stmt = $con -> prepare($sql);
$stmt -> bind_param("i",$id);
$stmt -> execute();
header("Location: index.php");
?>