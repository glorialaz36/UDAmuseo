<?php
$mysqli = mysqli_connect("127.0.0.1","root","","uda");

if(mysqli_connect_errno($mysqli)){
	echo "failed to connect to the database ". mysqli_connect_error();
}
?>
