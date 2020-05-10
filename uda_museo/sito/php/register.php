

<html>
	
<?php
//avvio sessione e connessione database
	session_start();
	include("conndb.php");
	//controllo variabili non settate per esecuzione ramo del codice
	if(!isset($_POST['nome']) && !isset($_POST['cognome']) && !isset($_POST['email']) && !isset($_POST['psw']) && !isset($_POST['categoria'])){
	
	//primo ramo. Form per l'inserimento dei dati
	echo "<form action=\"register.php\" method=\"POST\">
		Nome :  <input type=\"text\" name = \"nome\" size =\"20\" placeholder=\"Inserici il tuo nome\" required /><br><br>
		Cognome :  <input type=\"text\" name = \"cognome\" size =\"20\" placeholder=\"Inserici il tuo nome\" required /><br><br>
		Email :  <input type=\"email\" name = \"email\" placeholder=\"Inserici la tua email\" required /><br><br>
		Password :  <input type=\"password\" name = \"psw\" size =\"20\" id=myPassword required />
		<input type=\"checkbox\" onclick=\"myFunction()\">Show Password<br><br>
		<input type=\"submit\" name=\"registrati\" value=\"Registrati\" />
		<input type=\"reset\" name=\"cancella\" value=\"Reset\" /> <br><br>
	
		</form>";
		if(strstr($_SERVER['HTTP_REFERER'],"register.php") ){
		echo "email già utilizzata";	
	}
	}else{
		//secondo ramo. Controllo dati e registrazione sul database
		$nome=$_POST['nome']. " " .$_POST['cognome'] ;
		$email=$_POST['email'];
		//criptazione password
		$password=sha1($_POST['psw']);
		//sql inserimento nuovo visitatore
		$sql="insert into UTENTE(email,nome,pwd) values ('$email','$nome','$password')";
		$query = mysqli_query($mysqli,$sql);
		//controllo esito query
		if($query){
			//esito positivo
			//inizializzazione variabili di sessione e passaggio ad auto_login.php
			$_SESSION['email']=$email;
			$_SESSION['password']=$password;
			header("location: auto_login.php");
	}else{
		//esito egativo
		//errore e ripetizione dell'inserimento dei dati
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		header("location: register.php");
	}
}
	echo "<li class='dropdown nav-item'>";
		echo "<a class='nav-link' href='login.php'>";
			echo "<i>register</i>Hai già un account? Login</a>";
	echo "</li>";
?>
<script>
	//script per rendere visibile o meno la password mentre la si inserisce
function myFunction() {
  var x = document.getElementById("myPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
	}
</script>
</html>
