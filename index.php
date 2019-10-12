  <!DOCTYPE html>
<head>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php
session_start();
$var1="<h1>Offices</h1>\n";
$table="Offices";
$officeid=1;
$subid=1;
echo $var1;

require_once('connection.php');

if ($conn->select_db('offices') === false) {

    // Create db

$sql = "CREATE DATABASE offices";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

}
else
{
//echo "database exist";
}

$conn->select_db('offices');

//----------- Check if Offices table exist and create

$result = $conn->query("SHOW TABLES LIKE '".$table."'");

    if($result->num_rows == 1) {
        //echo "Table exists";
    }

else {
    echo "office Table does not exist";
$sql = "CREATE TABLE Offices (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL UNIQUE,
icon BLOB NOT NULL,
addr VARCHAR(30) NOT NULL,
rfio VARCHAR(50),
has_child BOOLEAN NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Offices created successfully";
} else {
    echo "Error creating table office: " . $conn->error;
}


}

//----------- Check if Subs table exist and create

$table="Subs";

$result = $conn->query("SHOW TABLES LIKE '".$table."'");

    if($result->num_rows == 1) {
        //echo "Table exists";
    }

else {
    echo "Table does not exist";
$sql = "CREATE TABLE Subs (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL UNIQUE,
icon BLOB NOT NULL,
addr VARCHAR(30) NOT NULL,
rfio VARCHAR(50),
has_child BOOLEAN NOT NULL,
parent VARCHAR(30)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Subs created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
}

//----------- Check if employees table exist and create

$table="Employees";

$result = $conn->query("SHOW TABLES LIKE '".$table."'");

    if($result->num_rows == 1) {
//        echo "Table exists";
    }

else {
    echo "Table does not exist";
$sql = "CREATE TABLE Employees (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50) NOT NULL,
icon BLOB NOT NULL,
gender TINYINT NOT NULL,
addr VARCHAR(50) NOT NULL,
tel VARCHAR(50),
email VARCHAR(50),
sub INT(6)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Employees created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
}

//--------------------Draw Offices Tree------------------------

echo "<ul id=\"myUL\">";
$sql = "SELECT id, name, has_child FROM offices";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    if ($row["has_child"]!=0)
    {
        echo "<li>"."<span class=\"careta\""." id=\"o".$row["id"]."\">".$row["name"]."</span>";
        TreeSub($row["name"],$conn);
        echo "</li>";
    }
    else
    {
    echo "<li>"."<span "." id=\"o".$row["id"]."\">";
        echo $row["name"];
        echo "</li>";
        }
       $officeid++;
    }
} else {
    echo "Please, Add office.";
}
echo "</ul>";

function TreeSub($parent,$conn)
{
global $subid;
    $sql="SELECT id, name, has_child FROM subs WHERE parent='$parent'";
$result = $conn->query($sql);
       echo " <ul class=\"nesteda\">";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

    if ($row["has_child"]!=0)
    {
        echo "<li>"."<span "." id=\"s".$row["id"]."\" class=\"careta\">". $row["name"]."</span>";
        $subid++;
        TreeSub($row["name"],$conn);
        echo "</li>";

    }
    else{
    echo "<li>"."<span "." id=\"s".$row["id"]."\">";
        echo $row["name"];
        echo "</li>";
        $subid++;
        }

    }

} else {
    echo "0 results";
}
echo " </ul>";
}
?>

 <button class="btn btn-primary btn-md" onclick=window.location.replace("addoffice.htm")>Add office</button>

<div id="odiv" style="position: absolute; top: 0;left: 50%;text-align:center;display:none;">
<h1> Office</h1>
<div id="oicon" style="width:40%; height:40%;"></div>
<ul>
<h4>Name</h4><li id="oname"></li>
<h4>Address</h4><li id="oaddr"></li>
<h4>Head Name</h4><li id="orfio"></li>
</ul>
<div class="btn-group">
<button id="deleteofficebutton" class="btn btn-primary" onclick=window.location.replace("deleteoffice.php")>Delete</button>
<button class="btn btn-primary" onclick=window.location.replace("addsub.htm")>New Subsidiary</button>
<button class="btn btn-primary" onclick=window.location.replace("editoffice.php")>Edit</button>
</div>
</div>

<div id="sdiv" style="top: 0;right:50%; text-align:center; display:none;">
<h1> Subsidiary</h1>
<div id="sicon" style="margin: 0 auto; width:12.5%; height:12.5%;"></div>
<ul>
<h4>Name</h4><li id="sname"></li>
<h4>Address</h4><li id="saddr"></li>
<h4>Head Name</h4><li id="srfio"></li>
</ul>
<div class="btn-group">
<button id="deletesubbutton" class="btn btn-primary" onclick=window.location.replace("deletesub.php")>Delete</button>
<button class="btn btn-primary" onclick=window.location.replace("editsub.php?id="+selsubid)>Edit</button>
<button class="btn btn-primary" onclick=window.location.replace("addsubs.htm")>New Subsidiary</button>
<button class="btn btn-primary" onclick=window.location.replace("addemp.htm")>Add Employee</button>
</div>

<div class="container"id="emtable">
</div>

<div id="empage" style="display:none">
</div>

<span id="sorttitle" style="display:none">Sort by </span>
 <select id="sortsel" class="selectpicker btn-primary" style="display:none;" onchange="SortChanged();">
  <option value="name">Name</option>
  <option value="email">Email</option>
  <option value="addr">Address</option>
  <option value="tel">Tel</option>
</select>
</div>

<script>
var toggler = document.getElementsByClassName("careta");
var i;
var selsubid=0;
   
for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nesteda").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
var toggler = document.getElementsByTagName("span");
for (i = 0; i < toggler.length; i++) {
toggler[i].addEventListener("click", function(){
  if (this.id[0]=='o')
  {
  showOffice(this.id);
  }
  else
  {
  selsubid=this.id;
  showSub(this.id);
  }
 });
 }

 function showOffice(id)
 {
 $("#sdiv").hide();
  $("#odiv").show();
    $.get("getoffice.php",{id:id.slice(1)}, function(data, status){
      var res= JSON.parse(data);
      $("#oicon").html(res.icon);
      $("#oname").text(res.name);
      $("#oaddr").text(res.addr);
      $("#orfio").text(res.rfio);
      var ohc=res.has_child;
      if (ohc==1){
       $("#odl").attr("class", "not-active");
	$("#deleteofficebutton").attr("disabled", true);
      }
      else
      {
      $("#odl").attr("class", "");
	$("#deleteofficebutton").attr("disabled", false);
        }
    });
 }
 function showSub(id,p)
 {
 sort=$("#sortsel").val();
 var $selsubid=id;

  $("#odiv").hide();
  $("#sdiv").show();
  $("#empage").hide();$("#emtable").empty();
    $.get("getsub.php",{id:id.slice(1)}, function(data, status){
    //alert("Data: " + data + "\nStatus: " + status);
      var res= JSON.parse(data);
      $("#sicon").html(res.icon);
      $("#sname").text(res.name);
      $("#saddr").text(res.addr);
      $("#srfio").text(res.rfio);
	var shc=res.has_child;
	if (shc==1){
       $("#odl").attr("class", "not-active");
	$("#deletesubbutton").attr("disabled", true);
      }
      else
      {
      $("#odl").attr("class", "");
	$("#deletesubbutton").attr("disabled", false);
        }
    });
	$("#sortsel").hide();$("#sorttitle").hide();

    $.get("getemp.php",{page:0,id:id.slice(1), off:0, sort:sort}, function(data, status){
      var res= JSON.parse(data);
     
     $("#emtable").empty();
	$("#emtable").append("<h3>Employees</h3>");
     var tab="<table class=\"table table-striped table-hover\" style=\"text-align: center\"><tr><th style=\"text-align: center\">Icon</th><th style=\"text-align: center\">Name</th><th style=\"text-align: center\">Address</th><th style=\"text-align: center\">Tel</th><th style=\"text-align: center\">Email</th></tr>"
     
       if( res.length!=0){
       for(i=0;i<res.length-1;i++)
       {
       tab +="<tr><td style=\"width:15%; height:15%;\">"+res[i].data.icon+"</td>"+"<td>"+res[i].data.name+"</td>"+"<td>"+res[i].data.addr+"</td>"+"<td>"+res[i].data.tel+"</td>"+"<td>"+res[i].data.email+"</td>"+"<td> <a href=\"deleteemployee.php?id="+res[i].data.id+"\">Delete / </a><a href=\"editemployee.php?id="+res[i].data.id+"\">Edit</a></td>"+"<tr>";
        }
        tab+= "</table>";
        $("#emtable").append(tab);
         $("#sortsel").show();$("#sorttitle").show();
         if(res[res.length-1].data.total>10){
         var page=res[res.length-1].data.total/10;
         $("#empage").empty();
         $("#empage").show();
         var empage="<ul class=\"pagination pagination-lg\">";
         for(i=0;i<page;i++)
         {
            empage+="<li class=\"page-item\"><a class=\"page-link\" onclick=RefreshTable("+i+","+id.slice(1)+")>"+(i+1)+"</a></li>"
         }
         empage+="</ul>";
         $("#empage").append(empage);
         }
        }
    });
 }
   function RefreshTable(page, id){
    sort=$("#sortsel").val();
   $("#emtable").empty(); $("#sortsel").hide();$("#sorttitle").hide();
   $.get("getemp.php",{page:0,id:id, off:page*10, sort:sort}, function(data, status){
      var res= JSON.parse(data);

     $("#emtable").empty();$("#emtable").append("<h3>Employees</h3>");
     var tab="<table class=\"table table-striped table-hover\" style=\"text-align: center\"><tr><th style=\"text-align: center\">Icon</th><th style=\"text-align: center\">Name</th><th style=\"text-align: center\">Address</th><th style=\"text-align: center\">Tel</th><th style=\"text-align: center\">Email</th></tr>"

       if( res.length!=0){
       for(i=0;i<res.length-1;i++)
       {
       tab +="<tr><td style=\"width:15%; height:15%;\">"+res[i].data.icon+"</td>"+"<td>"+res[i].data.name+"</td>"+"<td>"+res[i].data.addr+"</td>"+"<td>"+res[i].data.tel+"</td>"+"<td>"+res[i].data.email+"</td>"+"<td> <a href=\"deleteemployee.php?id="+res[i].data.id+"\">Delete / </a><a href=\"editemployee.php?id="+res[i].data.id+"\">Edit</a></td>"+"<tr>";
        }
        tab+= "</table>";
        $("#emtable").append(tab);
         $("#sortsel").show();$("#sorttitle").show();

        }
    });
   }

function SortChanged(){

showSub(selsubid);
   }

</script>
</html>
