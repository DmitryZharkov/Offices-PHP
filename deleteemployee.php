<?php
session_start();
$emp=$_GET["id"];

require_once('connection.php');

    $conn->select_db('offices');
$sql ="DELETE FROM employees WHERE id='$emp'";
$result = $conn->query($sql);

$conn->close();
header('Location: index.php');
?>
