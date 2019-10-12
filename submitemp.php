 <?php

session_start();

$name = $_POST["name"];
$addr = $_POST["addr"];
$tel = $_POST["tel"];
$email = $_POST["email"];
$gender = $_POST["gender"];
$id = $_POST["ida"];

// Create connection

require_once('connection.php');

$conn->select_db('offices');

$sql = "UPDATE employees SET name='$name', addr='$addr', tel='$tel', email='$email', gender='$gender' WHERE id='$id'";
$result = $conn->query($sql);

$conn->close();

header('Location: index.php');

?>