<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php
session_start();
$id=$_SESSION['selof'];

require_once('connection.php');

    $conn->select_db('offices');
$sql ="SELECT id, name, icon, addr, rfio, has_child FROM offices WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

$row = $result->fetch_assoc();

} else {
    echo "0 results";
}
?>
<body>

<h1> Edit Office </h1>
<div style="width:10%; height:10%;"><?php echo $row["icon"] ?></div>

 <div style="margin-top:6%">
  <form action="submitoffice.php" method="post" style="width:30%">
  <div class="form-group">
    <label for="text">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row["name"] ?>">
  </div>
  <div class="form-group">
    <label for="text">Address:</label>
    <input type="text" class="form-control" id="addr" name="addr" value="<?php echo $row["addr"] ?>">
  </div>
  <div class="form-group">
    <label for="text">Head Name:</label>
    <input type="text" class="form-control" name="rfio" id="rfio" value="<?php echo $row["rfio"] ?>">
  </div>
<input type="hidden" id="origin" name="origin" value="<?php echo $row["name"] ?>">
  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
<a href="index.php" class="btn btn-primary btn-sm">Discard</a>
</form> </div>

</body>
</html>

<script>
var test=<?php echo $test ?>;
alert(test);
</script>