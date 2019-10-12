<?php
session_start();
$id=$_GET["id"];
$_SESSION['sel'] = "s";

require_once('connection.php');

    $conn->select_db('offices');
$sql ="SELECT id, name, icon, addr, rfio, has_child FROM subs WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $_SESSION['selsub'] = $row["id"];
        echo json_encode($row);
    }
} else {
    echo "0 results";
}
?>
