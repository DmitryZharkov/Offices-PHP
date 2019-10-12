 <?php

session_start();

$oname = $_POST["name"];
$oaddr = $_POST["addr"];
$orfio = $_POST["rfio"];
$origin = $_POST["origin"];
$id=$_SESSION['selsub'];

// Create connection

require_once('connection.php');

$conn->select_db('offices');

$sql = "UPDATE subs SET name='$oname', addr='$oaddr', rfio='$orfio' WHERE id='$id'";
$result = $conn->query($sql);

$sql = "UPDATE subs SET parent='$oname' WHERE parent='$origin'";
$result = $conn->query($sql);

$conn->close();

header('Location: index.php');
?>