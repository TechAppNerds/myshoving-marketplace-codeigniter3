<?php
$host="localhost";
$user="myshovin_admin";
$pass="7h}X9_z5SG";
$dabname="myshovin_marketplace";
	
$conn = mysql_connect( $host, $user, $pass) or die('Tidak bisa terkoneksi ke database!' );
mysql_select_db($dabname, $conn) or die('Tidak bisa connect ke database');

$a=16000;

while($a<=20000)
{
	//$nama_kolom1="pos";
	//$nm_kolom=$nama_kolom1.strval($a);
	
	$input=mysql_query("insert into posisi (`posisi`,`ket`) values ('$a','0')");
    $query_input=mysql_query($input);
	$a++;
}

if($query_input)
{
	//Jika Sukses
	echo"<script>
			alert('Data berhasil diinput ke database');						
	    </script>";				
}
?>
