<?php
	//sessione, connessione al db e recupero variabili dalla sessione
	session_start();
	include("conndb.php");
?>
Biglietti acquistati:
<?php
	$sql="SELECT dataVal, descCat, titolo, (tariffa-(tariffa*sconto/100)+IFNULL(pAcc, 0)) as prezzo
		  FROM biglietto JOIN categoria ON catBig = codCat JOIN evento ON Eve = codEve LEFT JOIN(SELECT cBigl, SUM(przun) as pAcc
																								   FROM biglacc, accessorio
                                                                                                   WHERE cAcc = codAcc
                                                                                                   GROUP BY cBigl) as Acc ON codBig = cBigl
          WHERE vis = \"".$_SESSION['email']."\";";
	$result = $mysqli -> query($sql);
	$sql1="";
	$result1 = $mysqli -> query($sql1);
	//controllo esito query
	if($result){
		//esito positivo
		//creazione tabella
		echo "<table border = 1>";
			//titoli delle colonne
			while($row = $result -> fetch_assoc()){
				//valori
				echo "<tr>";
					echo "<td>";
						echo "<table>";
							echo "<tr>";
								echo "<th>".$row['titolo']."</th>";
								echo "<td>".$row['descCat']."</td>";
								echo "<td>".$row['prezzo']." &#8364</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>".$row['dataVal']."</td>";
							echo"</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
	}
?>