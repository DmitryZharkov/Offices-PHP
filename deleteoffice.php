<?php
session_start();
$off= $_SESSION['selof'];

require_once('connection.php');

    $conn->select_db('offices');
$sql ="DELETE FROM offices WHERE id='$off'";
$result = $conn->query($sql);

$conn->close();
header('Location: index.php');
?>
