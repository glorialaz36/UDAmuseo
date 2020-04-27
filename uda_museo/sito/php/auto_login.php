<?php
	
	session_start();
	include("conndb.php");
	
	
		$email=$_SESSION['email'];
		$password=$_SESSION['password'];
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
					"errore sconosciuto";
				}
			
		}else{
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
	?>
