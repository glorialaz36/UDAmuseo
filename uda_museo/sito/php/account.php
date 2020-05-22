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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        //funzione per tornare al 1 stadio della pagina dai form del camio password/nome
    function Annulla() {
    window.location="account.php";
    }
    </script>

    <script>
        //script per rendere visibile o meno la nuova password mentre la si inserisce
    function myFunction() {
        var x = document.cambioPassword.myPassword;
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
    </script>
    <script>
        //script per rendere visibile o meno la vecchia password mentre la si inserisce
    function myFunction2() {
        var x = document.cambioPassword.vecchiaPWD;
    
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
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
                            $no=explode(' ', $_SESSION['nome']);
                            $nom=" ".$no[0]." ";
							echo "<li class='dropdown nav-item'>";
                                echo "<a class='nav-link' data-toggle='dropdown'><i class='fa fa-user'></i>".$nom."<i class='fa fa-angle-down'></i></a>";
								echo "<ul class='dropdown-menu' id='dropdown'>";
									echo "<li><a class='nav-link-drop' href='account.php'>account</a></li>";
									echo "<li ><a class='nav-link-drop' href='bigliettiUtente.php'>acquisti</a></li>";
									if($_SESSION['amministratore']){
										echo "<li ><a class='nav-link-drop' href='amministrazione.php'>gestisci</a></li>";
                                    }
                                echo "<li><a class='nav-link-drop' href='destroy.php'>esci</a></li>";
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
        //riepilogo dati utente
        echo "<br><br><br>
        <div id='corpo'>
            <div id='subCorpo'>
                <p> La tua email: $email </p>
                <p>nome utente: $nome</p><br><br> ";

        if( !isset($_POST['scelta']) && !isset($_POST['nuovoNome']) && !isset($_POST['cambiaPWD'])){
        //form di scelta iniziale
             echo "<div id='formModifica'>
                <p>Cosa vuoi modificare? </p>
                <form action='account.php' method='POST'>
                    <select name='modifica' required>
                    <option value='password'> la password</option>
                    <option value='nomeUtente'>il nome utente</option>
                    </select><br><br>
                    <input type='submit' name='scelta' value='Modifica' />
                    <input type='reset' name='cancella' value='Reset' /><br><br>
                </form>
            </div>";
            //risultati dalle modifiche sottostanti
            if(isset($_SESSION['errore'])){
                $errore=$_SESSION['errore'];
            echo "$errore";
        }
            if(isset($_SESSION['successo'])){
                $succ=$_SESSION['successo'];
                echo "$succ";
            }
            
            if(isset($_SESSION['erroreInput'])){
				$app=$_SESSION['erroreInput'];
				echo "$app";
				unset($_SESSION['erroreInput']);
			}
			
			
            //ripuliamo le variabili per il ricaricamento della pagina senza risultati fasulli per annullamento dell'operazione
            unset($_SESSION['successo']);
            unset($_SESSION['errore']);
        
    }else{
        
        if(isset($_POST['modifica'])){
        $_SESSION['modifica']=$_POST['modifica'];
    }
    //ramo modifica della password
        if($_SESSION['modifica']==="password"){
            if(!isset($_POST['cambiaPWD'])){
                //form per il cambio password
                echo"<div id='formModifica'>
                    <div class='wrapper fadeInDown'>
                        <div id='formContent'>
                            <div class='fadeIn second'>
                                <form action='account.php' method='POST' name='cambioPassword'>
                                    <input type='password' name ='vecchiaPWD' size ='20' placeholder='vecchia password' required />
                                    <input type='checkbox' onclick='myFunction2()'>Show Password<br>
                                    <input type='password' name = 'myPassword' size ='20' placeholder='nuova password' required />
                                    <input type='checkbox' onclick='myFunction()'>Show Password<br><br>
                                    <input type='submit' name='cambiaPWD' value='Cambia' />
                                    <input type='reset' name='cancella' value='Reset' /> 
                                    <input type='button' onclick='Annulla()' value='Annulla'><br><br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
            }else{
                //recupero vecchia password dal database
                $vecchiaPassword=sha1($_POST['vecchiaPWD']);
                $sql="select * from utente where email='$email'";
                $query = mysqli_query($mysqli,$sql);
                //controllo esito query
                if($query){
                    //esito positivo
                    while($cicle=mysqli_fetch_array($query)){
                        //controllo corrispondenza con password vecchia 
                        if($vecchiaPassword===$cicle["pwd"]){
                            //le password vecchie combaciano quindi inserisco quella nuova
                            $nuovaPassword=sha1($_POST['myPassword']);
                            $sql2="update utente set pwd='$nuovaPassword' where email='$email'";
                            $query2 = mysqli_query($mysqli,$sql2);
                            //controllo esito query
                            if($query2){
                                //successo quindi resetto le variabili di sessione utilizzate, comunico che è tutto ok e ricarico la pagina al 1 stadio
                                $_SESSION['successo']= "Password cambiata correttamente";
                                $_SESSION['password']=$nuovaPassword;
                                unset($_SESSION['modifica']);
                                unset($_SESSION['errore']);
                            header("location:account.php");
                            }else{
                                echo "Error: ". $sql2 . "<br>" .mysqli_error($mysqli);
                                }
                        }else{
                            //le password vecchie non coicidono, abort e ritorno al 1 stadio
                            $_SESSION['errore']="Le password non coincidono! ";
                                unset($_SESSION['modifica']);
                                unset($_SESSION['successo']);
                            header("location:account.php");
                        }
                    
                }
        
            }else{
                //esito negativo query
                //errore 
                echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);	
            }
        }
        
        }else{
            //ramo modifica nome utente
            if(!isset($_POST['nuovoNome'])){
                //form cambio nome
                echo"<div id='formModifica'>
                    <div class='wrapper fadeInDown'>
                        <div id='formContent'>
                            <div class='fadeIn second'>
                                <form action='account.php' method='POST'>
                                    <input type='text' name = 'nuovoNome' size ='20' placeholder='nuove nome ' required />
                                    <input type='submit' name='cambiaPWD' value='Cambia' />
                                    <input type='reset' name='cancella' value='Reset' /> 
                                    <input type='button' onclick='Annulla()' value='Annulla'><br><br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
                

								
								
            }else{
                //aggiunta di 1 spazio per evitare problemi nella navbar
                $nome=mysqli_real_escape_string($mysqli,$_POST['nuovoNome']." ");
                if(!strstr($nome, "delete") && !strstr($nome, "update") && !strstr($nome, "create") && !strstr($nome, "drop")){
                //query
                $sql3="select * from utente where email='$email'";
                $query3 = mysqli_query($mysqli,$sql3);
                //controllo esito query
                if($query3){
                    //esito positivo
                    //
                    while($cicle=mysqli_fetch_array($query3)){
                        //query per il cambio del nome
                            $sql4="update utente set nome='$nome' where email='$email'";
                            $query4 = mysqli_query($mysqli,$sql4);
                            //controllo esito query
                            if($query4){
                                //tutto ok quindi segnalo il cambio avvenuto e riporto la pagina al 1 stadio
                                $_SESSION['successo']= "Nome cambiato correttamente";
                                $_SESSION['nome']=$nome;
                                unset($_SESSION['modifica']);
                                unset($_SESSION['errore']);
                            header("location:account.php");
                            }else{
                                echo "Error: ". $sql4 . "<br>" .mysqli_error($mysqli);
                                }
                    }
                }else{
                    //esito negativo query
                    //errore 
                    echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);	
                }
					}else{
							$_SESSION['erroreInput']="carattere in input non valido";
							header("location:account.php");
						}
						
				}
            }
					
        }	
    
    }else{
        header("location:../../index.php");
    }

        echo"</div>";
    echo"</div>";
}

?>
 <!-- Footer -->
 <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/mercedes.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/ferrari.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/redbull.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/mclaren.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/renault.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/alphatauri.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/bwt.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/haas.png" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="#">
                        <img class="img-fluid d-block mx-auto" src="../../sito/img/team/williams.png" alt="">
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

</body>
<!-- Bootstrap core JavaScript -->
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.bundle.js"></script>

<!-- Plugin JavaScript -->
<script src="../js/jquery.easing.js"></script>

<!-- Contact form JavaScript -->

<script src="../js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="../js/index.js"></script>
</html>



