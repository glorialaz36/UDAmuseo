<?php
include("conndb.php");
$data=$_POST['data'];
$xml="<errore>Nessun biglietto</errore>";
$sql="select count(*) as biglietti from biglietto where dataVal='$data'";
$query = mysqli_query($mysqli,$sql);
		//controllo errori
		if($query){
			$xml="<numero>";
			while($cicle=mysqli_fetch_array($query)){
				$xml=$xml."<NumeroVal>".$cicle['biglietti']."</NumeroVal>";
				
			}
			$xml=$xml."</numero>";
			echo $xml;
			
		}else{
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
		
?>
