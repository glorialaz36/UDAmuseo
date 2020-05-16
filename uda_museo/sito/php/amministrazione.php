<!DOCTYPE html>
<html lang="it">	
<?php
	session_start();
	include("conndb.php");
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
<script>
function Annulla() {
  window.location="amministrazione.php";
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
									echo "<li><a class='nav-link-drop' href='sito/php/account.php'>account</a></li>";
									echo "<li ><a class='nav-link-drop' href='sito/php/bigliettiUtente.php'>acquisti</a></li>";
									if($_SESSION['amministratore']){
										echo "<li ><a class='nav-link-drop' href='#'>gestisci</a></li>";
                                    }
                                echo "<li><a class='nav-link-drop' href='sito/php/destroy.php'>esci</a></li>";
								echo "</ul>";
							echo "</li>";
						}
					?>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#">
                            <i class="fa fa-shopping-cart"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	<?php
		session_start();

		include("conndb.php");

		if(($_SESSION['amministratore']==0) && ($_SESSION['mansione']==0)){
			header("location:index.php");
		}
		echo "<div id='corpo'>";
				echo "<div id='subCorpo'>";
				
							//visualizzare tutti gli eventi
							$sql= "select * from Evento";
							$query = mysqli_query($mysqli,$sql);
							//controllo errori
							if($query){
								echo "<h2>Eventi diponibili</h2>";
								
								echo "<table id='tabEvents' class='table table-bordered'>
									<tr>
									<th>NOME</th>
									<th>CATEGORIA</th>
									<th>INIZIO</th>
									<th>FINE</th>
									<th>TARIFFA</th>
									<th>BIGLIETTI RIMANENTI</th>";

								while($cicle=mysqli_fetch_array($query)){
									echo "<tr>
									<td>".$cicle['titolo']."</td>
									<td>".$cicle['catEve']."</td>
									<td>".$cicle['dataIni']."</td>
									<td>".$cicle['dataFin']."</td>
									<td>".$cicle['tariffa']." €"."</td>
									<td>".$cicle['biglRim']."</td>
									</tr>";
								}
								echo "</table> <br>";
							}else{
								echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
							}
				
				
							echo
							"<div id='modifica'>
								<form  action='amministrazione.php' method='POST'>
								<input type='radio' name='Evento' id='crea' value='crea' required>Aggiungi nuovo Evento<br>
								<input type='radio' name='Evento' id='modifica' value='modifica' required>Modifica un evento esistente<br>
								<input type='submit' name='invia' value='Conferma' />
								<input type='reset' name='cancella' value='Reset' /> <br><br> 
							</form>	
							</div>
				</div>";

				

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
						echo "<div id='formModifica'>
								<div class='wrapper fadeInDown'>
									<div id='formContent'>
										<div class='fadeIn second'>
											<form action='amministrazione.php' method='POST'>
											<h2>Aggiungi un nuovo evento</h2>
												<input type='text' name='titolo' placeholder='nome evento' required \> 
												<input type='text' name='categoria' placeholder='categoria' required \>
												<input type='double' name='tariffa'  placeholder='tariffa' required \>
												<input type='number' name='biglietti'  placeholder='numero biglietti' required \>
												<p>data di inizio: </p><input type='date' name='dataIni' required \>
												<p>data di fine: </p><input type='date' name='dataFin' required \><br><br>
												<input type='submit' name='creaEvento' value='crea' />
												<input type='reset' name='cancella' value='Reset' />
												<input type='button' onclick='Annulla()' value='Annulla'>
											</form
										</div>
									</div>
								</div>
							</div>";
						
						
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
									echo "</select><br><br>
										<div id='formModifica'>
											<div class='wrapper fadeInDown'>
												<div id='formContent'>
													<div class='fadeIn second'>
														<form action='amministrazione.php' method='POST'>
														<h2>Modifica un evento</h2>
														<p>seleziona l'evento da modificare: </p> <select name='eventi' required> ";
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
						
										echo"</select><br><br>
										<input type='text' name='titoloNuovo' placeholder='nome evento'\> 
										<input type='double' name='tariffa'  placeholder='tariffa' \>
										<input type='number' name='biglietti'  placeholder='numero biglietti' \>
										<input type='text' name='categoria' placeholder='categoria'  \>
										<p>data di inizio: </p> <input type='date' name='dataIni'  \><br><br>
										<p>data di fine:  </p><input type='date' name='dataFin'\><br><br>
										<input type='submit' name='modificaEvento' value='modifica' />
										<input type='reset' name='cancella' value='Reset' />
										<input type='button' onclick='Annulla()' value='Annulla'> <br><br> 
									</form>
									</div>
								</div>
								</div>
						</div>";
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
							//esito negativo
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
							//esito negativo
							//errore 
							echo "Error: ". $sql4 . "<br>" .mysqli_error($mysqli);
							
						}
						
							}
						
						}
					}
					echo"</div>";
			echo"</div>";

				//tabella accessiori attualmente nel database
				echo "<div id='subCorpo'>";;
					$sql5= "select * from Accessorio";
					$query5 = mysqli_query($mysqli,$sql5);
							//controllo errori
							if($query5){
								echo "<h2>Accessori diponibili</h2>";
								echo "<table id='tabAccessori' class='table table-bordered'>
									<tr>
										<th>ACESSORIO</th>
										<th>PREZZO</th>
									</tr>";
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
							
					
						//Replica codice precedente leggermente modificato per permettere modificazione/crezione di accessori
						echo "<div id='modifica'>
							<form  action='amministrazione.php' method='POST'>
								<input type='radio' name='Accessorio' id='crea' value='crea' required>Aggiungi nuovo Accessorio<br>
								<input type='radio' name='Accessorio' id='modifica' value='modifica' required>Modifica un accessorio esistente<br>
								<input type='submit' name='invia' value='Conferma'/>
								<input type='reset' name='cancella' value='Reset' /> <br><br> 
							</form>
						</div>";

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
							echo "<div id='formModifica'>
									<div class='wrapper fadeInDown'>
										<div id='formContent'>
											<div class='fadeIn second'>
												<form action='amministrazione.php' method='POST'>
													<h2>Aggiungi un nuovo accessorio</h2>
													<input type='text' name='descAcc' placeholder='nome accessorio'  required />
													<input type='double' min=0 name='przun' placeholder='prezzo' required><br><br>
													<input type='submit' name='creaAccessorio' value='crea' />
													<input type='reset' name='cancella' value='Reset' /> 
													<input type='button' onclick='Annulla()' value='Annulla Operazione'><br><br> 
												</form>
											</div>
										</div>
									</div>
								</div>";
							
							
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
									echo"<div id='formModifica'>
										<div class='wrapper fadeInDown'>
											<div id='formContent'>
												<div class='fadeIn second'>
													<form action='amministrazione.php' method='POST'>
													<h2>Modifica un accessorio</h2>
													<p>seleziona l'accessorio da modificare: </p> <select name='eventi' required> ";
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
													<input type='text' name='descAcc' placeholder='nome accessorio'  />
													<input type='double' min=0 name='przun' placeholder='prezzo' />
													<input type='submit' name='modificaAccessorio' value='modifica' />
													<input type='reset' name='cancella' value='Reset' /> 
													<input type='button' onclick='Annulla()' value='Annulla Operazione'><br><br> 
												</form>
											</div>
										</div>
									</div>
								</div>";
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
				echo"</div>";

					//numero di biglietti venduti per data
					echo"<div id='buttom'>
						<form id='no'>
							<input type='date' name='giorno' min=2020-01-01 max=2024-01-01>
								<span class='biglietti' id='biglietti'>
						</form>
					</div>
			</div>
		</div>";
		
		
?>	
 <!-- Footer -->
 <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/mercedes.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/ferrari.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/redbull.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/mclaren.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/renault.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/alphatauri.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/bwt.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/haas.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="sito/img/team/williams.png" alt="">
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
<script src="sito/js/jquery.js"></script>
<script src="sito/js/bootstrap.bundle.js"></script>

<!-- Plugin JavaScript -->
<script src="sito/js/jquery.easing.js"></script>

<!-- Contact form JavaScript -->

<script src="sito/js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="sito/js/index.js"></script>
	














	
		

























