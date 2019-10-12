<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php
session_start();
$id=$_GET["id"];

require_once('connection.php');

    $conn->select_db('offices');
$sql ="SELECT name, icon, gender, addr, tel, email FROM employees WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

$row = $result->fetch_assoc();

} else {
    echo "0 results";
}
?>
<body>


<h1> Edit Employee </h1>
<div style="width:10%; height:10%;"><?php echo $row["icon"] ?></div>

 <div style="margin-top:6%">
 <div style="align:center">
  <form action="/submitemp.php" method="post" style="width:30%">
  <div class="form-group">
    <label for="text">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row["name"] ?>">
  </div>
  <div class="form-group">
    <label for="text">Address:</label>
    <input type="text" class="form-control" id="addr" name="addr" value="<?php echo $row["addr"] ?>">
  </div>
  <div class="form-group">
    <label for="text">Tel:</label>
    <input type="tel" class="form-control" name="tel" id="tel" value="<?php echo $row["tel"] ?>">
  </div>
  <div class="form-group">
    <label for="text">Email:</label>
    <input type="text" class="form-control" name="email" id="email" value="<?php echo $row["email"] ?>">
  </div>
  <div class="form-group">
    <label for="text">Gender:</label>
    <input type="radio" class="form-control" name="gender" id="gender" value="<?php echo $row["gender"] ?>"> Male<br>
	<input type="radio" class="form-control" name="gender" id="gender" value=1> Female<br>
  </div>
<input type="hidden" id="ida" name="ida" value="<?php echo $id ?>">
  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
<a href="index.php" class="btn btn-primary btn-sm">Discard</a>
</form> </div>

</body>
</html>