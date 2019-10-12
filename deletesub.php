<?php
session_start();
$off= $_SESSION['selsub'];

// Create connection

require_once('connection.php');

    $conn->select_db('offices');
    $sql ="SELECT id, name, addr, rfio, has_child, parent FROM subs WHERE id='$off'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $parent= $row['parent'];
echo $parent;
    }
     $sql ="SELECT id, name, addr, rfio, has_child FROM subs WHERE parent='$parent'";
	$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {echo "if sub";print_r ($row);}
     if ($result->num_rows > 0) {
	$sql ="SELECT id, name, addr, rfio, has_child FROM subs WHERE name='$parent'";
	$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {echo "if parent in sub";print_r ($row);}
	if ($result->num_rows == 0) {
    // output data of each row
echo "in offiice";
    		$sql = "UPDATE offices SET has_child=0 WHERE name='$parent'";
		$result = $conn->query($sql);
    		}
	else
	{
	echo "in subs";
	$sql = "UPDATE subs SET has_child=0 WHERE name='$parent'";
	$result = $conn->query($sql);
	}
}
}

$sql ="DELETE FROM subs WHERE id='$off'";
$result = $conn->query($sql);

$sql ="DELETE FROM employees WHERE sub='$off'";
$result = $conn->query($sql);

$conn->close();
header('Location: index.php');
?>