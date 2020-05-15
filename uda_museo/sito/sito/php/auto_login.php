<?php
	session_start();
	include("conndb.php");
	
	
		$email=$_SESSION['email'];
		$password=$_SESSION['password'];
		//sql login
		$sql="select * from UTENTE where email='$email' AND pwd='$password'";
		$query = mysqli_query($mysqli,$sql);
		//controllo errori
		if($query){
			//controllo corrispondenza password e email
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_array($query);
				$_SESSION['email']=$email;
				$_SESSION['nome']=$row['nome'];
				$_SESSION['password']=$password;
				$sql2="select * from AMMINISTRATORE where email='$email'";
				$query2 = mysqli_query($mysqli,$sql2);
				if($query2){
					if(mysqli_num_rows($query2)>0) {
						
						//loggato come amministratore
						while($riga=mysqli_fetch_array($query2)){
						$_SESSION['amministratore']=true;
						$_SESSION['mansione']=$riga['mansione'];
					}
						
				}else{
					//loggato come utente visitatore
					$_SESSION['amministratore']=false;
					$_SESSION['mansione']=0;
				header("location: ../../index.php"); 
			}
			}else{
					"errore sconosciuto";
				}
			
		}else{
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
	}
	?>
