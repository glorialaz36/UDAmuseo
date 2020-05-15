<?php
session_start();
?>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("[name='giorno']").change(function(){
		//piglio la data dal form
	var d= $(this).val();
	//ricostruzione data da mandare al database
	var data = new Date(d);
	var anno=data.getFullYear();
	var mese='' + (data.getMonth()+1);
	var giorno= '' + data.getDate();
	
	if (mese.length < 2) 
        mese = '0' + mese;
    if (giorno.length < 2) 
        giorno = '0' + giorno;

    datastr=anno + "-" + mese + "-" + giorno;
//invio chiamata post a nBigliettiVenduti.php per il numero di biglietti
	$.ajax({
		type: "POST",
		url: "nBigliettiVenduti.php",
		data: "data=" + datastr,
		dataType: "xml",
		success:function(risposta){
			//ritorno della risposta e immissione dei dati in biglietti
			biglietti.innerHTML="Numero biglietti venduti : " + risposta.children[0].children[0].textContent;
		},
		error: function(){
			//non dovrebbe mai succedere ma invia un alert con il fallimento
	alert("Fallito");
	quad1.innerHTML="--";
}
});
	});
});

</script>
</head>
<body>
<?php

include("conndb.php");

if(($_SESSION['amministratore']==0) && ($_SESSION['mansione']==0)){
	header("location:index.php");
}
?>
<form id="no">
<input type="date" name="giorno" min=2020-01-01 max=2024-01-01>
 <span class="biglietti" id="biglietti">--</span>
</form>

<?php

$sql= "select * from Evento";
$query = mysqli_query($mysqli,$sql);
		//controllo errori
		if($query){
			echo "Eventi diponibili";
			echo "<table border=1>";
			while($cicle=mysqli_fetch_array($query)){
				echo "<tr>
				<td>".$cicle['titolo']."</td>
				<td>".$cicle['catEve']."</td>
				<td>".$cicle['dataIni']."</td>
				<td>".$cicle['dataFin']."</td>
				<td>".$cicle['biglRim']."</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
		
?>	
Azioni:
<form  action="amministrazione.php" method="POST">
<input type="radio" name="Evento" id="crea" value="crea" required>Crea nuovo Evento<br>
<input type="radio" name="Evento" id="modifica" value="modifica" required>Modifica un evento esistente<br>
<input type="submit" name="invia" value="Conferma" />
<input type="reset" name="cancella" value="Reset" /> <br><br> 
</form>	

	
		
<?php
//preparazione variabile di sessione per biforcazione al ricaricamento della pagina

	if(isset($_POST['Evento'])){
		$_SESSION['Evento']=$_POST['Evento'];
}
	
	//controllo evento modifica/crea
	if(isset($_POST['Evento']) || isset($_POST['modificaEvento']) || isset($_POST['creaEvento'])){
		//biforcazione in base a cosa si è scelto di fare sul primo form
	if($_SESSION['Evento']==="crea"){
		//crea un nuovo evento
		if(!isset($_POST['creaEvento'])){
			//form per l'inserimento dei dati relativi al nuovo evento
			//form per la creazione dell'evento
		echo "<form action=\"amministrazione.php\" method=\"POST\"><br><br>
		titolo: <input type=\"text\" name=\"titolo\" placeholder=\"Inserisci i nome dell'evento\" required \> <br><br>
		tariffa: <input type=\"double\" name=\"tariffa\" required \><br><br>
		Numero biglietti:<input type=\"number\" name=\"biglietti\" required \><br><br>
		Categoria: <input type=\"text\" name=\"categoria\" placeholder=\"Inserisci la categoria dell'evento\" required \><br><br>
		data Iniziale dell'evento: <input type=\"date\" name=\"dataIni\" required \><br><br>
		data Finale dell'evento: <input type=\"date\" name=\"dataFin\" required \>
		<br><br><input type=\"submit\" name=\"creaEvento\" value=\"crea\" />
		<input type=\"reset\" name=\"cancella\" value=\"Reset\" />
		<input type=\"button\" onclick=\"Annulla()\" value=\"Annulla Operazione\"><br><br>
		</form>";
		
		
	}else{
		//recupero variabili dal form
		$titolo=$_POST['titolo'];
		$tariffa=$_POST['tariffa'];
		$biglietti=$_POST['biglietti'];
		$categoria=$_POST['categoria'];
		$dataIni=$_POST['dataIni'];
		$dataFin=$_POST['dataFin'];
		//controllo correttezza date 
		$data1=strtotime($dataIni);
		$data2=strtotime($dataFin);
		$appoggio="";
		if($data1>$data2){
			// se la data di inizio è superiore a quella di fine per evitare malfunzionamenti le invertiamo
			$appoggio=$dataFin;
			$dataFin=$dataIni;
			$dataIni=$appoggio;
		}
		//inserimento evento nel database
	$sql2= "insert into Evento(titolo,tariffa,biglRim,catEve,dataIni,dataFin) values('$titolo',$tariffa,$biglietti,'$categoria','$dataIni','$dataFin')";
	$query2 = mysqli_query($mysqli,$sql2);
			//controllo errori
		if($query2){
					//tutto risolto correttamente, ritorno a stato base della pagina
					header("location:amministrazione.php");
				
			}else{
				//errore
				echo "Error: ". $sql2 . "<br>" .mysqli_error($mysqli);
			}	
	}
	
	}else{
		//ramo modifica di un evento gia esistente
		
			if(!isset($_POST['modificaEvento'])){
				//selezione dell'evento da modificare dinamico in base agli eventi nel database
				echo"<form action=\"amministrazione.php\" method=\"POST\">";
				echo"Evento : <select name=\"eventi\" required>";
				$sql="select * from EVENTO ";
		$query = mysqli_query($mysqli,$sql);
		//controllo esito query
		if($query){
			//esito positivo
			//while per creazione menu a tendina con gli eventi diponibili
			while($cicle=mysqli_fetch_array($query)){
				echo "<option value=".$cicle['titolo'].">".$cicle['titolo']."</option>";
			}
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		
	}
	//altri dati per l'update
	echo "</select><br><br>
	
		titolo: <input type=\"text\" name=\"titoloNuovo\" placeholder=\"Inserisci i nome dell'evento\"\> <br>
		tariffa: <input type=\"double\" name=\"tariffa\"  \><br>
		Numero biglietti:<input type=\"number\" name=\"biglietti\"  \><br>
		Categoria: <input type=\"text\" name=\"categoria\" placeholder=\"Inserisci la categoria dell'evento\"  \><br>
		data Iniziale dell'evento: <input type=\"date\" name=\"dataIni\"  \><br>
		data Finale dell'evento: <input type=\"date\" name=\"dataFin\"\><br>
		<input type=\"submit\" name=\"modificaEvento\" value=\"modifica\" />
		<input type=\"reset\" name=\"cancella\" value=\"Reset\" />
		<input type=\"button\" onclick=\"Annulla()\" value=\"Annulla Operazione\"> <br><br> 
		</form>";
		}else{
			//prendo il titolo dell'evento selezionato
			$titolo=$_POST['eventi'];
			//richiamo il suo record dal database 
			$sql3= "select * from Evento where titolo='$titolo'";
			$query3 = mysqli_query($mysqli,$sql3);				
			if($query3){
			//esito positivo
			//while che fara sempre un giro( se non lo metto fetch_array non va non so perchè
			while($cicle=mysqli_fetch_array($query3)){
				//inserisco tutti i valori del record richiamato nelle rispettive variabili
				$codEve=$cicle['codEve'];
				$tariffa=$cicle['tariffa'];
				$nBiglietti=$cicle['biglRim'];
				$catEve=$cicle['catEve'];
				$dataIni=$cicle['dataIni'];
				$dataFin=$cicle['dataFin'];	
			}
			
			}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		
	}
	//controllo, per ogni singola variabile, se è necessario aggiornare il valore contenuto in essa con quello ricevuto dal form
	if(isset($_POST['titoloNuovo']) && $_POST['titoloNuovo']!=""){
		$titolo=$_POST['titoloNuovo'];
	}
		if(isset($_POST['tariffa']) && $_POST['tariffa']!=""){	
		$tariffa=$_POST['tariffa'];	
			
	}
		if(isset($_POST['biglietti']) && $_POST['biglietti']!=""){
		$nBiglietti=$_POST['biglietti'];
	}
		if(isset($_POST['categoria']) && $_POST['categoria']!=""){
		$catEve=$_POST['categoria'];
	}
		if(isset($_POST['dataIni']) && $_POST['dataIni']!=""){
		$dataIni=$_POST['dataIni'];
	}
		if(isset($_POST['dataFin']) && $_POST['dataFin']!=""){
		$dataFin=$_POST['dataFin'];	
	}
	
	//controllo correttezza date 
		$data1=strtotime($dataIni);
		$data2=strtotime($dataFin);
		$appoggio="";
		if($data1>$data2){
			//scambio date nel caso dataFin sia precedente a dataIni
			$appoggio=$dataFin;
			$dataFin=$dataIni;
			$dataIni=$appoggio;
		}
		//aggiornamento dati nel database
		$sql4= "update Evento set titolo='$titolo',tariffa=$tariffa,biglRim=$nBiglietti,catEve='$catEve',dataIni='$dataIni', dataFin='$dataFin' where codEve=$codEve";
			$query4 = mysqli_query($mysqli,$sql4);				
			if($query4){
			//esito positivo
			//ritorno a stato base della pagina
			echo "updated correctly";
			header("location:amministrazione.php");
			}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql4 . "<br>" .mysqli_error($mysqli);
		
	}
	
		}
	
	}
}




//tabella accessiori attualmente nel database

$sql5= "select * from Accessorio";
$query5 = mysqli_query($mysqli,$sql5);
		//controllo errori
		if($query5){
			echo "Accessori diponibili";
			echo "<table border=1>";
			while($cicle5=mysqli_fetch_array($query5)){
				echo "<tr>
				<td>".$cicle5['descAcc']."</td>
				<td>".$cicle5['przun']." euro</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "Error: ". $sql5 . "<br>" .mysqli_error($mysqli);
		}
		
?>	
<!--Replica codice precedente leggermente modificato per permettere modificazione/crezione di accessori -->
Azioni:
<form  action="amministrazione.php" method="POST">
<input type="radio" name="Accessorio" id="crea" value="crea" required>Crea nuovo Accessorio<br>
<input type="radio" name="Accessorio" id="modifica" value="modifica" required>Modifica un accessorio esistente<br>
<input type="submit" name="invia" value="Conferma" />
<input type="reset" name="cancella" value="Reset" /> <br><br> 
</form>

<?php
//preparazione variabile di sessione per biforcazione al ricaricamento della pagina

	if(isset($_POST['Accessorio'])){
		$_SESSION['Accessorio']=$_POST['Accessorio'];
}
	
	//controllo accessorio modifica/crea
	if(isset($_POST['Accessorio']) || isset($_POST['modificaAccessorio']) || isset($_POST['creaAccessorio'])){
		//biforcazione in base a cosa si è scelto di fare sul primo form
	if($_SESSION['Accessorio']==="crea"){
		//crea un nuovo evento
		if(!isset($_POST['creaAccessorio'])){
			//form per l'inserimento dei dati relativi al nuovo evento
			//form per la creazione dell'evento
		echo "<form action=\"amministrazione.php\" method=\"POST\"><br><br>
		Descrizione Accessorio : <input type=\"text\" name=\"descAcc\" placeholder=\"Inserisci il nome dell'accessorio\" size=\"30\" required /><br>
		Prezzo Unitario in euro: <input type=\"double\" min=0 name=\"przun\" required><br>
		<br><br><input type=\"submit\" name=\"creaAccessorio\" value=\"crea\" />
		<input type=\"reset\" name=\"cancella\" value=\"Reset\" /> 
		<input type=\"button\" onclick=\"Annulla()\" value=\"Annulla Operazione\"><br><br> 
		</form>";
		
		
	}else{
		//recupero variabili dal form
		$descAcc=$_POST['descAcc'];
		$przun=$_POST['przun'];
		//inserimento evento nel database
	$sql6= "insert into accessorio (descAcc,przun) values ('$descAcc',$przun)";
	$query6 = mysqli_query($mysqli,$sql6);
			//controllo errori
		if($query6){
					//tutto risolto correttamente, ritorno a stato base della pagina
					echo "created correctly";
					header("location:amministrazione.php");
				
			}else{
				//errore
				echo "Error: ". $sql6 . "<br>" .mysqli_error($mysqli);
			}	
	}
	
	}else{
		//ramo modifica di un evento gia esistente
		
			if(!isset($_POST['modificaAccessorio'])){
				//selezione dell'evento da modificare dinamico in base agli eventi nel database
				echo"<form action=\"amministrazione.php\" method=\"POST\">";
				echo"Accessorio : <select name=\"accessori\" required>";
				$sql7="select * from Accessorio ";
		$query7 = mysqli_query($mysqli,$sql7);
		//controllo esito query
		if($query7){
			//esito positivo
			//while per creazione menu a tendina con gli eventi diponibili
			while($cicle7=mysqli_fetch_array($query7)){
				echo "<option value=".$cicle7['descAcc'].">".$cicle7['descAcc']."</option>";
			}
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql7 . "<br>" .mysqli_error($mysqli);
		
	}
	//altri dati per l'update
	echo "</select><br><br>
		Nuova Descrizione: <input type=\"text\" name=\"descAcc\" placeholder=\"Inserisci il nome dell'accessorio\"  /><br>
		Nuovo Prezzo Unitario: <input type=\"double\" min=0 name=\"przun\" ><br>
		<input type=\"submit\" name=\"modificaAccessorio\" value=\"modifica\" />
		<input type=\"reset\" name=\"cancella\" value=\"Reset\" /> 
		<input type=\"button\" onclick=\"Annulla()\" value=\"Annulla Operazione\"><br><br> 
		</form>";
		}else{
			//prendo il titolo dell'evento selezionato
			$descAcc=$_POST['accessori'];
			//richiamo il suo record dal database 
			$sql8= "select * from Accessorio where descAcc='$descAcc'";
			$query8 = mysqli_query($mysqli,$sql8);				
			if($query8){
			//esito positivo
			//while che fara sempre un giro( se non lo metto fetch_array non va non so perchè
			while($cicle8=mysqli_fetch_array($query8)){
				//inserisco tutti i valori del record richiamato nelle rispettive variabili
				$codAcc=$cicle8['codAcc'];
				$przun=$cicle8['przun'];
			}
			
			}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql8 . "<br>" .mysqli_error($mysqli);
		
	}
	
	//controllo, per ogni singola variabile, se è necessario aggiornare il valore contenuto in essa con quello ricevuto dal form
	if(isset($_POST['descAcc']) && $_POST['descAcc']!=""){
		$descAcc=$_POST['descAcc'];
	}
		if(isset($_POST['przun']) && $_POST['przun']!=""){	
		$przun=$_POST['przun'];	
			
	}
	
		//aggiornamento dati nel database
		$sql9= "update Accessorio set descAcc='$descAcc',przun=$przun where codAcc=$codAcc";
			$query9 = mysqli_query($mysqli,$sql9);				
			if($query9){
			//esito positivo
			//ritorno a stato base della pagina
			echo "updated correctly";
			header("location:amministrazione.php");
			}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql9 . "<br>" .mysqli_error($mysqli);
		
	}
	
		}
	
	}
}
?>
<script>
function Annulla() {
  window.location="amministrazione.php";
}
</script>
</body>












