
<!DOCTYPE html>
<html lang="it">
<?php ob_start(); ?>	
<?php
	session_start();
    include("conndb.php");
    if(isset($_SESSION['email']) && isset($_SESSION['nome']) && isset($_SESSION['password'])){
                    $email=$_SESSION['email'];
                    $nome=$_SESSION['nome'];
                    $password=$_SESSION['password'];
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><body id="page-top">
</head>

<body>
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
                            $no=explode(' ', $_SESSION['nome']);
                            $nom=" ".$no[0]." ";
							echo "<li class='dropdown nav-item'>";
                                echo "<a class='nav-link' data-toggle='dropdown'><i class='fa fa-user'></i>".$nom."<i class='fa fa-angle-down'></i></a>";
								echo "<ul class='dropdown-menu' id='dropdown'>";
									echo "<li><a class='nav-link-drop' href='account.php'>account</a></li>";
									echo "<li ><a class='nav-link-drop' href='#'>acquisti</a></li>";
									if($_SESSION['amministratore']){
										echo "<li ><a class='nav-link-drop' href='amministrazione.php'>gestisci</a></li>";
                                    }
                                echo "<li><a class='nav-link-drop' href='destroy.php'>esci</a></li>";
								echo "</ul>";
							echo "</li>";
						}
						echo "<li class='nav-item'>";
							echo "<a class='nav-link js-scroll-trigger' href='biglietteria.php'>";
							echo "<i class='fa fa-shopping-cart'></i></a>";
						echo "</li>";
					?>
                </ul>
            </div>
        </div>
    </nav>
	
	<?php
     echo"<div id='corpo'>
        <div id='subCorpo'>
       <br><br><h2>Biglietti acquistati</h2><br>";
		$sql="SELECT codBig, dataVal, titolo, tariffa, descCat, sconto
				FROM biglietto join evento on Eve=codEve join categoria on catBig=codCat 
                WHERE vis = \"".$_SESSION['email']."\";";
        /*$sql="SELECT dataVal, descCat, titolo
				FROM biglietto, categoria, evento
				WHERE Eve = codEve AND catBig = codCat AND vis = \"".$_SESSION['email']."\";";*/
		$result = $mysqli -> query($sql);
		//controllo esito query
		if($result){
            if($result->num_rows>0){
                    //esito positivo
                    echo "<table id='tabBig' class='table table-bordered'><tr>
                        <th>Data acquisto</th>
                        <th>Evento</th>
                        <th>Categoria</th>
                        <th>Accessori</th>
                        <th>Costo</th>
                    </tr>";
                        while($row = $result -> fetch_assoc()){
                            echo "<tr>
                                <td>".$row['dataVal']."</td>
                                <td>".$row['titolo']."</td>
                                <td>".$row['descCat']."</td>";
                                
                            $sql1="SELECT descAcc, przun 
                            FROM accessorio join biglacc on codAcc=cAcc
                            WHERE cBigl= \"".$row['codBig']."\";";
                            $result1 = $mysqli -> query($sql1);
                            $accessori= " ";
                            $przAcc=0;
                            if($result1->num_rows>0){
                                while($row1 = $result1 -> fetch_array()){
                                    $accessori= $accessori . $row1['descAcc']. " ";  
                                    $przAcc= $przAcc + $row1['przun'];     
                                }
                                echo"<td>$accessori</td>";
                            }else{
                                 echo"<td>"."nessun accessorio"."</td>";
                                 

                            }
                            $costo=($row['tariffa']*(1-$row['sconto']))+$przAcc;
                            
                            
                            echo"<td>$costo"." €</td>

                            
                        </tr>";
                    }
                echo "</table>";
            }else{
                echo"<p>Nessun biglietto acquistato</p>";
            }
		}else{
			//esito egativo
			//errore 
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
		if(!isset($_POST['bigiettoElimina']) && !isset($_POST['submit'])){
			
        echo"<div id='formModifica'>
            <div class='wrapper fadeInDown'>
                <div id='formContent'>
                    <div class='fadeIn second'>
                        <p>Vuoi annullare una transazione ?</p>
                        <form action='bigliettiUtente.php' method='POST'>
                        seleziona il biglietto da eliminare <select name='bigliettoElimina' required>";
                        $sql="select codBig,titolo,descCat,dataVal FROM biglietto join evento on Eve=codEve join categoria on catBig=codCat where vis='$email' order by codBig";
                                    $query = mysqli_query($mysqli,$sql);
                                    //controllo esito query
                                    if($query){
                                        //esito positivo
                                        //while per creazione menu a tendina con gli eventi diponibili
                                        while($cicle=mysqli_fetch_array($query)){
                                            echo "<option value=".$cicle['codBig'].">".$cicle['dataVal']." ".$cicle['titolo']." " .$cicle['descCat']. "</option>";
                                        }
                                }else{
                                    //esito egativo
                                    //errore 
                                    echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
                                    
                                }
                        echo "</select></p>
                        <br><input type='submit' name='submit' value='Elimina'>
                        <br>";
                    
				if(isset($_SESSION['BigliettoEliminato'])){
					echo $_SESSION['BigliettoEliminato'];
					unset($_SESSION['BigliettoEliminato']);
				}
                }else{
          
                    $biglietto=$_POST['bigliettoElimina'];
                    $sql2="delete from biglacc where cBigl=$biglietto";
                    $query2= mysqli_query($mysqli,$sql2);
                    if($query2){
                       
							$sql4="select biglRim,codEve from biglietto join evento on Eve=codEve where codBig=$biglietto";
							$query4= mysqli_query($mysqli,$sql4);
							if($query4){
								
								while($cicle2=mysqli_fetch_array($query4)){
									$_SESSION['BigliettoEliminato']="giro";
									$nBiglietti=$cicle2['biglRim'];
									$titoloEvento=$cicle2['codEve'];
								}
								$nBiglietti= 1 + $nBiglietti;
								$sql5="update evento set biglRim=$nBiglietti where codEve=$titoloEvento";
								$query5= mysqli_query($mysqli,$sql5);
								if($query5){
									$sql3="delete from biglietto where codBig=$biglietto";
									$query3= mysqli_query($mysqli,$sql3);
									if($query3){
									
										$_SESSION['BigliettoEliminato']= "Transazione annullata, ricevera un rimborso a breve ";
										header("location:BigliettiUtente.php");
										
									}else{
										//esito egativo
										//errore 
										$_SESSION['BigliettoEliminato']="Errore irreversibile, contattare l'assistenza 4";
										header("location:BigliettiUtente.php");  
									}
										
								}else{
									$_SESSION['BigliettoEliminato']=$_SESSION['BigliettoEliminato'].$nBiglietti.$titoloEvento;
									//"Errore irreversibile, contattare l'assistenza 2";
									header("location:BigliettiUtente.php");
								}
								
							}else{
								$_SESSION['BigliettoEliminato']="Errore irreversibile, contattare l'assistenza 3";
								header("location:BigliettiUtente.php");
							}    
                        
                    }else{
						//esito egativo
						//errore 
						$_SESSION['BigliettoEliminato']="Errore irreversibile, contattare l'assistenza 5";
						header("location:BigliettiUtente.php");
                            
                    }
                } 
            }else{
                header("location:../../index.php");
        }
            echo"</div>
            </div>
        </div>
    </div>";
	?>
    </div>
</div>
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
