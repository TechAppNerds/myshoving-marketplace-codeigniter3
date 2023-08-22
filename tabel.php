<?php
//include('db.php');
$dbHost = 'localhost';
$dbUsername = 'myshovin_admin';
$dbPassword = '7h}X9_z5SG';
$dbName = 'myshovin_marketplace';
// menghubungkan ke db
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

?>
<html>
<head>	
	<link href="tabel/css/bootstrap.css" rel="stylesheet" />
    <link href="tabel/css/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    <!-- theme -->
    <!--link rel="stylesheet" type="text/css" href="css/theme/default.css" /-->
    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="tabel/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/tables.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/form.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/bootstrap-wysihtml5.css" />
	
</head>
<body>

<div class="panel panel-default">
<div class="panel-body">
	<table class="table table-striped table-bordered table-hover dataTables-example" >
	<thead class='alert-info'>
	<tr>
       <th>ID Reseller</th>
       <th>Username</th>
	   <th>Nama Reseller</th>
	   <th>Upline</th>
	   <th>Reffwork</th>
	   <th>Position</th>	 
     </tr>
	</thead>
	<tbody>
	<?php
	$result_temp=$db->query("SELECT id_reseller,username,nama_reseller,upline,reff_work,position FROM rb_reseller order by position asc");
	$rows_temp=mysqli_num_rows($result_temp);
	echo"<tr class='gradeX'>"; 
	while($row_temp=$result_temp->fetch_assoc())
	{
		echo "<td>".$row_temp["id_reseller"]."</td>";
		echo "<td>".$row_temp["username"]."</td>";
		echo "<td>".$row_temp["nama_reseller"]."</td>";
		echo "<td>".$row_temp["upline"]."</td>";
		echo "<td>".$row_temp["reff_work"]."</td>";
		echo "<td>".$row_temp["position"]."</td>";		
		echo "</tr>";		
	}
	mysqli_close($db);
	?>
	</tbody>
	</table>
</div>
</div>

</body>
</html>
