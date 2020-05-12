<?php
	//sessione, connessione al db e recupero variabili dalla sessione
	session_start();
	include("conndb.php");
?>
Biglietti acquistati:
<?php
	$sql="	SELECT dataVal, descCat, titolo
			FROM biglietto, categoria, evento
			WHERE Eve = codEve AND catBig = codCat AND vis = \"".$_SESSION['email']."\";";
	$result = $mysqli -> query($sql);
	//controllo esito query
	if($result){
		//esito positivo
		echo "<table>";
			echo "<tr>";
					echo "<td>Data acquisto</td>";
					echo "<td>Evento</td>";
					echo "<td>Categoria</td>";
				echo "</tr>";
			while($row = $result -> fetch_assoc()){
				echo "<tr>";
					echo "<td>".$row['dataVal']."</td>";
					echo "<td>".$row['titolo']."</td>";
					echo "<td>".$row['descCat']."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
	}
?>