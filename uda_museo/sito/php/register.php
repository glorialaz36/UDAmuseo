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
        <link href="../css/other.css" rel="stylesheet">
        <!--<link href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
									echo "<a class='nav-link' data-toggle='dropdown'><i class='fa fa-user'></i><i class='fa fa-angle-down'></i></a>";
									echo "<ul class='dropdown-menu' id='dropdown'>";
										echo "<li><a class='nav-link-drop' href='sito/php/login.php'>login</a></li>";
										echo "<li ><a class='nav-link-drop' href='sito/php/register.php'>register</a></li>";
									echo "</ul>";
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

        <div class="wrapper fadeInDown">
            <div id="formContent">
                <div class="fadeIn first">
                    <h2> registrati</h2>
                </div>
                <?php 
                //controllo variabili non settate per esecuzione ramo del codice
                if(!isset($_POST['nome']) && !isset($_POST['cognome']) && !isset($_POST['email']) && !isset($_POST['psw']) && !isset($_POST['categoria'])){
                    //Form per l'inserimento dei dati 
                    echo "<form action='register.php' method='POST'>
                    <input type='text' id='nome' class='fadeIn second' name='nome' placeholder='Inserisci il tuo nome' required>
                    <input type='text' id='cognome' class='fadeIn second' name='cognome' placeholder='Inserisci il tuo cognome' required>
                    <input type='email' id='email' class='fadeIn second' name='email' placeholder='Inserisci la tua e-mail' required>
                    <input type='password' id='password' class='fadeIn third' name='psw' placeholder='Inserisci la tua password' required> <br>
                    <input type='checkbox' class='fadeIn fourth' onclick='myFunction()'>Mostra password <br>
                    <input type='submit' class='fadeIn fifth' value='REGISTRATI'>
                    <input type='reset' class='fadeIn fifth' value='CANCELLA'>
                    </form>";
                    if(strstr($_SERVER['HTTP_REFERER'],"register.php") ){
						  if(isset($_SESSION['erroreInput'])){
								$app=$_SESSION['erroreInput'];
								echo "$app";
								unset($_SESSION['erroreInput']);
					}else{
                    echo "email già utilizzata";
				}	
                    }

                }else{
                    //secondo ramo. Controllo dati e registrazione sul database
                    $prova=$_POST['nome']. " " .$_POST['cognome'];
                    $nome=mysqli_real_escape_string($mysqli,$prova);
                    if(!strstr($nome, "delete") && !strstr($nome, "update") && !strstr($nome, "alter") && !strstr($nome, "create") && !strstr($nome, "drop")){
                    $email=$_POST['email'];
                    //criptazione password
                    $password=sha1($_POST['psw']);
                    //sql inserimento nuovo visitatore
                    $sql="insert into utente(email,nome,pwd) values ('$email','$nome','$password')";
                    $query = mysqli_query($mysqli,$sql);
                    //controllo esito query
                    if($query){
                        //esito positivo
                        //inizializzazione variabili di sessione e passaggio ad auto_login.php
                        $_SESSION['email']=$email;
                        $_SESSION['password']=$password;
                        header("location: auto_login.php");
                }else{
                    //esito negativo, errore e ripetizione dell'inserimento dei dati
                    echo "email già utilizzata";
                    header("location: register.php");
                }
                }else{
					
					
					$_SESSION['erroreInput']="carattere di input non valido";
					header("location:register.php");
				}
			}
                // link a regiatrati
                echo "<div id='formFooter'>
                    <p>Hai già un account? <a class='underlineHover' href='login.php'>Accedi</a></p>
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
<script>
	//script per rendere visibile o meno la password mentre la si inserisce
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
	}
</script>
<!-- Bootstrap core JavaScript -->
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.bundle.js"></script>

<!-- Plugin JavaScript -->
<script src="../js/jquery.easing.js"></script>

<!-- Contact form JavaScript -->

<script src="../js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="../js/index.js"></script>
