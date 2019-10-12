<?php
$id=$_GET["id"];
$off=$_GET["off"];
$sort=$_GET["sort"];

require_once('connection.php');

    $conn->select_db('offices');
    
    //$result=mysql_query("SELECT count(*) as total from employees WHERE sub='$id'");
    //$data=mysql_fetch_assoc($result);
    $sql ="SELECT count(*) as total from employees WHERE sub='$id'";
    $result = $conn->query($sql);
    $data=$result->fetch_assoc();
    
$sql ="SELECT id, name, icon, addr, tel, email FROM employees WHERE sub='$id'"." ORDER BY ".$sort." LIMIT 10 OFFSET ".$off;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $rows[] = array('data' => $row);
    }
    $rows[] = array('data' => $data);
    echo json_encode($rows);
} else {
    echo "0 results";
}
?>
