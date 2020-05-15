<?php
//sessione e connessione al db
session_start();
include("conndb.php");
//ramificazione del flusso	
if(isset($_SESSION["email"])){
if(!isset($_POST['eventi']) && !isset($_POST['nBiglietti']) ){
	//primo ramo . Inserimento dati 
echo "<form action=\"biglietteria.php\" method=\"POST\">
		Numero di Biglietti:<input type=\"number\" name=\"nBiglietti\" min=\"1\" max=\"40\"><br><br>
		Eventi : <select name=\"eventi\" required>";
		$sql="select * from EVENTO ";
		$query = mysqli_query($mysqli,$sql);
		//controllo esito query
		if($query){
			//esito positivo
			//while per creazione menu a tendina con gli eventi diponibili
			while($cicle=mysqli_fetch_array($query)){
				$dataAdesso=strtotime("now");
				$strdataEvento=$cicle['dataFin'];
				$DataEvento=strtotime("$strdataEvento");
				if($dataAdesso<=$DataEvento){
				echo "<option value=".$cicle['titolo'].">".$cicle['titolo']."</option>";
			}
			}
			
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		
	}
	echo "</select><br><br>";
	
	
	
			//recupero numero e descrizione degli accessori disponibili
		$sql="select * from ACCESSORIO";
		$query = mysqli_query($mysqli,$sql);
		//controllo esito query
		if($query){
			//esito positivo
			//
			while($cicle=mysqli_fetch_array($query)){
				//creazione checkbox in funzione degli accessori 
				echo "<input type=\"checkbox\" name =\"accessori[] \" value=".$cicle['descAcc'] .">".$cicle['descAcc']."";
			}
			
	}else{
		//esito negativo query
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		
		
		
		
	}
	//conclusione form 
	echo "<br><br><input type=\"submit\" name=\"paga\" value=\"Paga\" />
			<input type=\"reset\" name=\"cancella\" value=\"Reset\" /> <br><br>"; 
}else{
	//registrazione di tutti i dati necessari per procedere al riepilogo e al pagamento
	$numeroBiglietti=$_POST['nBiglietti'];
	$evento=$_POST['eventi'];
	$accessori=$_POST['accessori'];
	$_SESSION['nBiglietti']=$_POST['nBiglietti'];
	$_SESSION['eventi']=$_POST['eventi'];
	$_SESSION['accessori']=$_POST['accessori'];
	header("location: riepilogo e reg biglietti.php");
}  
}else{
	header("location:index.php ");
}
?>




