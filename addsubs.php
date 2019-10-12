<?php
session_start();
$name = $_POST["name"];
$addr = $_POST["addr"];
$rfio = $_POST["rfio"];
$off= $_SESSION['selsub'];
$randstring=RandomString();

//The URL you want to send a cURL proxy request to.
$url = "https://avatars.dicebear.com/v2/jdenticon/{$randstring}.svg";
 
//The IP address of the proxy you want to send
//your request through.
//$proxyIP = '172.22.30.3';
 
//The port that the proxy is listening on.
//$proxyPort = '3128';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
 
//Set the proxy IP.
//curl_setopt($ch, CURLOPT_PROXY, $proxyIP);
 
//Set the port.
//curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
 
//Execute the request.
$icon = curl_exec($ch);
 
//Check for errors.
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

// Create connection

require_once('connection.php');

    $conn->select_db('offices');
$sql ="SELECT id, name, addr, rfio, has_child FROM subs WHERE id='$off'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $offname = $row['name'];
    }
} else {
    echo "0 results";
    }
    $sql = "UPDATE subs SET has_child=1 WHERE id='$off'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$sql = "INSERT INTO subs (id, name, icon, addr, rfio, has_child, parent) VALUES (0, '$name', '$icon', '$addr', '$rfio', 0, '$offname')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('Location: index.php');

function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
