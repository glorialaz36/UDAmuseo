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
                <img id="logo" src="..//img/logo/LOGOrc.png" onmouseover="this.src='../img/logo/LOGOrs.png';" onmouseout="this.src='../img/logo/LOGOrc.png';" width="120" alt="" class="d-inline-block align-middle mr-2">
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

    <div class="wrapper fadeInDown">
        <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <h2> Accedi</h2>
    </div>

    <?php 
	//connessionedb
	if(!isset($_POST['email']) && !isset($_POST['psw'])){
    //Login Form 
    echo "<form action='login.php' method='POST'>
            <input type='email' id='email' class='fadeIn second' name='email' placeholder='Inserisci la tua e-mail'>
            <input type='password' id='password' class='fadeIn second' name='psw' placeholder='Inserisci la tua password'> <br>
            <input type='checkbox' class='fadeIn second' onclick='myFunction()'>Mostra password <br>
            <input type='submit' class='fadeIn second' value='ACCEDI'>
        </form>";
        //controllo per pagina precedente causa password o email errati
        if(strstr($_SERVER['HTTP_REFERER'],"login.php") ){
            echo "email o password errati, riprova";	
        }
    }else{
        //login 
        $email=$_POST['email'];
        $password=sha1($_POST['psw']);
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
					}
				}else{
				echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
			}
					header("location: ..\..\index.php"); 
				}else{
						header("location: login.php");
					}
				
			}else{
				echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
			}
        }
        // link a regiatrati
        echo "<div id='formFooter'>
            <p>Non hai un account? <a class='underlineHover' href='register.php'>Registrati</a></p>
        </div>
        </div>
    </div>";
    
    ?>
    </div>

	
    
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
<script src="../../sito/js/jquery.js"></script>
<script src="../../sito/js/bootstrap.bundle.js"></script>

<!-- Plugin JavaScript -->
<script src="../../sito/js/jquery.easing.js"></script>

<!-- Contact form JavaScript -->

<script src="../../sito/js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="../../sito/js/index.js"></script>



