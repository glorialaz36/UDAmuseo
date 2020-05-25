<!DOCTYPE html>
<?php ob_start(); ?>
<html lang="it">	
<?php
	session_start();
	include("conndb.php");
	$email= $_SESSION['email'];
	$nBiglietti= $_SESSION['nBiglietti'];
	$evento= $_SESSION['eventi'];
	$accessori=$_SESSION['accessori'];
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>F1 Museum</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../css/gestisci.css" rel="stylesheet">
    <!--<link href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script>
function clearForm(){
	//script per l'annullamento della transazione e redirect al index.php in caso di risposta negativa al form di conferma dei dati
	  alert('transazione annullata');
      window.location='index.php';
  }
      </script>
      
</head>

<body id="page-top">
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
        <div class="container">
            <a href="../../index.php" class="navbar-brand" onmouseover="logo.src='../img/logo/LOGOrs.png';" onmouseout="logo.src='../img/logo/LOGOrc.png';">
                <!-- Logo Image -->
                <img id="logo" src="../img/logo/LOGOrc.png" onmouseover="this.src='../img/logo/LOGOrs.png';" onmouseout="this.src='../img/logo/LOGOrc.png';" width="120" alt="" class="d-inline-block align-middle mr-2">
                <!-- Logo Text -->
                <span id="titolo" class="text-uppercase font-weight-bold">F1 museum </span>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menù <i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../../index.php#events">eventi e mostre</a>
                    </li>
					<?php
						if(!isset($_SESSION['nome'])){
							//non è loggato
							echo "<li class='dropdown nav-item'>";
								echo "<a class='nav-link' href='#'>";
									echo "<i class='fa fa-user' ></i></a>";
							echo "</li>";
						}else{
                            //è loggato
                            $nome=explode(' ', $_SESSION['nome']);
                            $nom=" ".$nome[0]." ";
							echo "<li class='dropdown nav-item'>";
                                echo "<a class='nav-link' data-toggle='dropdown'><i class='fa fa-user'></i>".$nom."<i class='fa fa-angle-down'></i></a>";
								echo "<ul class='dropdown-menu' id='dropdown'>";
									echo "<li><a class='nav-link-drop' href='account.php'>account</a></li>";
									echo "<li ><a class='nav-link-drop' href='bigliettiUtente.php'>acquisti</a></li>";
									if($_SESSION['amministratore']){
										echo "<li ><a class='nav-link-drop' href='#'>gestisci</a></li>";
                                    }
                                echo "<li><a class='nav-link-drop' href='destroy.php'>esci</a></li>";
								echo "</ul>";
							echo "</li>";
						echo "<li class='nav-item'>";
							echo "<a class='nav-link js-scroll-trigger' href='biglietteria.php'>";
							echo "<i class='fa fa-shopping-cart'></i></a>";
						echo "</li>";
						}
					?>
                </ul>
            </div>
        </div>
    </nav>
<?php
//ramificazione del flusso
if(!isset($_POST['Procedere'])){
	//riepilogo del ordine
echo "<br><br><div id='corpo'>
<div id='subCorpo'>
	
<h2>riepilogo</h2>";
echo"<p>Numero biglietti: $nBiglietti</p>";
echo"<p>evento: $evento</p>";
echo "<p>Accessori: </p>";
foreach($accessori as $accessorio){
echo $accessorio." ";
}
echo "<br><br>
<div id='formModifica'>
		<div class='wrapper fadeInDown'>
			<div id='formContent'>
				<div class='fadeIn second'>
<form action=\"riepilogo e reg biglietti.php\" method=\"POST\">
<h2>seleziona la categoria per ogni biglietto</h2>";




//creazione radio buttor per le categorie del biglietto(normable,disabile,ecc...)
		for($n=0;$n<$nBiglietti;$n++){
		$sql="select * from CATEGORIA ";
		$query = mysqli_query($mysqli,$sql);
		//controllo esito query
		if($query){
			//esito positivo
			//while per creazione menu a tendina con le categorie diponibili
					
						echo "<p>Biglietto ".$n."</p>";
						while($cicle=mysqli_fetch_array($query)){
							echo "<input type=\"radio\" name=\"radioCategoria[$n]\" value=\"".$cicle['codCat']."\" required>".$cicle['descCat']."<br>";
						}
						echo "<br><br>";
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		
	}
}
		
		
		echo "<p>Procedere?</p>
		<input type=\"submit\" name=\"Procedere\" value=\"Si\" />
		<input type=\"reset\" onclick=\"clearForm()\"name=\"cancella\" value=\"No\" /> <br><br>
		</form>";
		
}else{
	//secondo ramo
	
	//recupero data odierna per il biglietto
	$categorie=$_POST['radioCategoria'];
	$timestamp=strtotime("+0 day");
	$date = date('Y-m-d',$timestamp);
	//recupero codice dell'evento
	$codEve=0;
	$sql1="select codEve from EVENTO where titolo='$evento'";
	$query1 = mysqli_query($mysqli,$sql1);
	if($query1){
		while($cicle1=mysqli_fetch_array($query1)){
		$codEve=$cicle1['codEve'];
	}
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql1 . "<br>" .mysqli_error($mysqli);
	}
	
	
	
	
	
	//registrazione del biglietto/biglietti nel database 
	//ciclo per ripetere le azioni successive nel caso di acquisto simultaneo di piu biglietti
	for($i=0;$i<$nBiglietti;$i++){
	$sql2="insert into BIGLIETTO(dataVal,Eve,vis,catBig) values ('$date','$codEve','$email','$categorie[$i]')";
		$query2 = mysqli_query($mysqli,$sql2);
		//controllo esito query
		if($query2){
			
	}else{
		//esito egativo
		//errore 
		echo "Error: ". $sql2 . "<br>" .mysqli_error($mysqli);
	}
	
	
	
	
	//recupero del codice del biglietto appena inserito
	$codBig=0;
	$sql3="select codBig from BIGLIETTO where dataVal='$date' AND Eve='$codEve' AND vis='$email'";
	$query3 = mysqli_query($mysqli,$sql3);
		//controllo esito query
		if($query3){
			//esito positivo
			//controllo per impedire un errato abbinamento nel caso l'utente abbia più di un biglietto acquistato nello stesso giorno
			while($cicle3=mysqli_fetch_array($query3)){
		$codBig=$cicle3['codBig'];
	}
	}else{
		//esito egativo 2
		//errore 
		echo "Error: ". $sql3 . "<br>" .mysqli_error($mysqli);
	}
	
	
	
	//ciclo per l'abbinamento biglietto -> 1 o piu accessori
	if(!empty($accessori)){
	foreach($accessori as $accessorio){
		//recupero del codice del accessorio in esame
	$codAcc=0;
	$sql4="select codAcc from ACCESSORIO where descAcc='$accessorio'";
	$query4 = mysqli_query($mysqli,$sql4);
		//controllo esito query
		if($query4){
			//esito positivo
			//sarà sempre un giro ma se non metto un while non funziona(bho)
			while($cicle4=mysqli_fetch_array($query4)){
			$codAcc=$cicle4['codAcc'];
	}
	
	
	
				// abbinamento biglietto accessorio in apposita tabella
				$sql5="insert into BIGLACC(cBigl,cAcc) values($codBig,$codAcc)";
				$query5 = mysqli_query($mysqli,$sql5);
				//controllo esito query
				if($query5){
					//esito positivo
					//termine inserimento dati senza errori, l'utente viene riportato a index(temporaneo)
					
					
					
					$codEve=0;
					$biglRim=0;
					$sql6="select codEve,biglRim from EVENTO where titolo='$evento' ";
					$query6 = mysqli_query($mysqli,$sql6);
					//controllo esito query
					if($query6){
						//esito positivo
							//controllo per impedire un errato abbinamento nel caso di eventi con lo stesso nome
							while($cicle6=mysqli_fetch_array($query6)){
							$codEve=$cicle6['codEve'];
							$bigRim=$cicle6['biglRim'];
	
	
								}
							
						}else{
							//esito egativo 2
							//errore 
							echo "Error: ". $sql6 . "<br>" .mysqli_error($mysqli);
						}
						$bigRim=$bigRim-1;
					$sql7="update EVENTO set biglRim='$bigRim' where codEve=$codEve";
					$query7 = mysqli_query($mysqli,$sql7);
					//controllo esito query
					if($query7){
						
						//esito positivo di tutte le query 
							header("location:../../index.php");
						}else{
							//esito egativo 2
							//errore 
							echo "Error: ". $sql7 . "<br>" .mysqli_error($mysqli);
						}
			
						}else{
		//esito egativo 5
		//errore 
		echo "Error: ". $sql5 . "<br>" .mysqli_error($mysqli);
	}
	
	}else{
		//esito egativo 4
		//errore e ripetizione dell'inserimento dei dati
		echo "Error: ". $sql4 . "<br>" .mysqli_error($mysqli);
	}
	
	
	
	
		
}
}else{
	$accessori="no accessori";//modificare quando si farà il conteggio del prezzo
}
}


	
}	
echo"</div>
                </div>
			</div>
			</div>
        </div><br><br>";
?>
<!-- Footer -->
<footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/mercedes.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/ferrari.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/redbull.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/mclaren.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/renault.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/alphatauri.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/bwt.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/haas.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../img/team/williams.png" alt="">
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-distributed">
            <div class="footer-left">
                <div class="footer-icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-google-plus-g"></i></a>
                </div>
            </div>

            <div class="footer-center">
                <div>
                    <i class="fa fa-map-marker"></i>
                    <p><span>Via Luigi Pettinati, 46</span>35129 - Padova  </p>
                </div>

                <div>
                    <i class="fa fa-phone"></i>
                    <p>+39 000 000 0000</p>
                </div>

                <div>
                    <i class="fa fa-envelope"></i>
                    <p><a href="mailto:support@company.com">museoF1@email.it</a></p>
                </div>

			</div>
			
            <div class="footer-right">
            	<div class="map">
            	<iframe src="https://maps.google.com/maps?width=400&amp;height=300&amp;hl=en&amp;q=Via%20Luigi%20Pettinati%2C%2046%2035129%20-%20Padova%20%20+(Titolo)&amp;ie=UTF8&amp;t=p&amp;z=11&amp;iwloc=B&amp;output=embed" 
             		frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
            	</iframe>
            
				</div>
				</div>

            <div class="footer-bottom">
                <p class="section-subheading text-muted">This product includes PHP software, freely available from
                    <a href="http://www.php.net/software/">http://www.php.net/software/</a>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
<!-- Bootstrap core JavaScript -->
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.bundle.js"></script>

<!-- Plugin JavaScript -->
<script src="../js/jquery.easing.js"></script>

<!-- Contact form JavaScript -->

<script src="../js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="../js/index.js"></script>







      
      
      
      
      
      
      
      
      
