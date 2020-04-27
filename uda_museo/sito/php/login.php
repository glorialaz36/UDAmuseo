
<html>
	
<?php
	session_start();
	include("conndb.php");
	//connessionedb
	if(!isset($_POST['email']) && !isset($_POST['psw'])){
	//form login
	echo "<form action=\"login.php\" method=\"POST\">
		Email :  <input type=\"email\" name = \"email\" placeholder=\"Inserici la tua email\" required /><br><br>
		Password :  <input type=\"password\" name = \"psw\" size =\"20\" id=myPassword required />
		<input type=\"checkbox\" onclick=\"myFunction()\">Show Password<br><br>
		<input type=\"submit\" name=\"login\" value=\"Login\" />
		<input type=\"reset\" name=\"cancella\" value=\"Reset\" /> <br><br>
		</form>";
		//controllo per pagina precedente causa password o email errati
		if(strstr($_SERVER['HTTP_REFERER'],"login.php") )){
		echo "email o password errati, riprova";	
	}
	}else{
		//login 
		$email=$_POST['email'];
		$password=sha1($_POST['psw']);
		//sql login
		$sql="select * from visitatore where email='$email' AND pwd='$password'";
		$query = mysqli_query($mysqli,$sql);
		//controllo errori
		if($query){
			//controllo corrispondenza password e email
			if(mysqli_num_rows($query)>0){
				$_SESSION['email']=$email;
				$_SESSION['password']=$password;
				header("location: index.php"); 
			}else{
					header("location: login.php");
				}
			
		}else{
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
	}
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

