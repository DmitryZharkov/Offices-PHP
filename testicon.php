<?php
function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

    $randstring=RandomString();
    echo "Test string {$randstring}";


//The URL you want to send a cURL proxy request to.
$url = "https://avatars.dicebear.com/v2/identicon/{$randstring}.svg";
 
//The IP address of the proxy you want to send
//your request through.
$proxyIP = '172.22.30.3';
 
//The port that the proxy is listening on.
$proxyPort = '3128';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
 
//Set the proxy IP.
curl_setopt($ch, CURLOPT_PROXY, $proxyIP);
 
//Set the port.
curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
 
//Execute the request.
$output = curl_exec($ch);
 
//Check for errors.
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}
 
//Print the output.
echo "<div style=\"width:50; height:50;\">";
echo $output;
echo "</div>";
?>

