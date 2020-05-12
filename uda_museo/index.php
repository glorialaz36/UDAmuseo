<!DOCTYPE html>
<html lang="it">
<?php
session_start();
?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>F1 Museum</title>

    <!-- Bootstrap core CSS -->
    <link href="sito/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="sito/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="sito/css/index.css" rel="stylesheet">
    <!--<link href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->

</head>
<body id="page-top">
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a href="#" class="navbar-brand" onmouseover="logo.src='sito/img/logo/LOGOrs.png';" onmouseout="logo.src='sito/img/logo/LOGOrc.png';">
                <!-- Logo Image -->
                <img id="logo" src="sito/img/logo/LOGOrc.png" onmouseover="this.src='sito/img/logo/LOGOrs.png';" onmouseout="this.src='sito/img/logo/LOGOrc.png';" width="120" alt="" class="d-inline-block align-middle mr-2">
                <!-- Logo Text -->
                <span id="titolo" class="text-uppercase font-weight-bold">F1 museum </span>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menù <i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#events">eventi e mostre</a>
                    </li>
					<?php
						if(!isset($_SESSION['nome'])){
							//non è loggato
							echo "<li class='dropdown nav-item'>";
								echo "<a class='nav-link' href='sito/php/login.php'>";
									echo "<i class='fa fa-user' ></i></a>";
							echo "</li>";
						}else{
                            //è loggato
                            $nome=explode(' ', $_SESSION['nome']);
                            $nom=" ".$nome[0]." ";
							echo "<li class='dropdown nav-item'>";
                                echo "<a class='nav-link' data-toggle='dropdown'><i class='fa fa-user'></i>".$nom."<i class='fa fa-angle-down'></i></a>";
								echo "<ul class='dropdown-menu' id='dropdown'>";
									echo "<li><a class='nav-link-drop' href='sito/php/account.php'>account</a></li>";//<!--da visualizzare se loggato, sia per utente che amministratore-->
									echo "<li ><a class='nav-link-drop' href='sito/php/bigliettiUtente.php'>acquisti</a></li>";//<!--da visualizzare se loggato, sia per utente che amministratore-->
									if($_SESSION['amministratore']){
										echo "<li ><a class='nav-link-drop' href='#'>gestisci</a></li>";//<!--da vedere se loggato da amministratore-->
									}
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

    <!--Carousel Wrapper-->
    <div id="video-carousel" class="carousel slide carousel-fade" data-ride="carousel">
        <!--Indicators-->
        <ol class="carousel-indicators">
            <li data-target="#video-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#video-carousel" data-slide-to="1"></li>
            <li data-target="#video-carousel" data-slide-to="2"></li>
        </ol>
        <!--/.Indicators-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
            <!-- First slide -->
            <div class="carousel-item active">
                <!--Mask color-->
                <div>
                    <!--Video source-->
                    <img class="img-fluid" src="sito/img/carousel/cars.jpg"/>
            </video>
                    <div class="mask rgba-black-strong"></div>
                </div>

                <!--Caption-->
                <div class="carousel-caption">
                    <div class="animated fadeInDown">
                        <h3 class="h3-responsive"><a href="#interests">VUOI SAPERNE DI PIU' SUL MONDO DELLE CORSE?</a></h3>
                        <p>Aspetti generali</p>
                    </div>
                </div>
                <!--Caption-->
            </div>
            <!-- /.First slide -->

            <!-- Second slide -->
            <div class="carousel-item">
                <!--Mask color-->
                <div>
                    <!--Video source-->
                    <img class="img-fluid" src="sito/img/carousel/mechanic.jpg"/>
                    </video>
                    <div class="mask rgba-black-strong"></div>
                </div>

                <!--Caption-->
                <div class="carousel-caption">
                    <div class="animated fadeInDown">
                        <h3 class="h3-responsive"><a href="#interests">SEI UN APPASSIONATO DEL SETTORE?</a></h3>
                        <p>Meccanica e fisica</p>
                    </div>
                </div>
                <!--Caption-->
            </div>
            <!-- /.Second slide -->

            <!-- Third slide -->
            <div class="carousel-item">
                <!--Mask color-->
                <div>
                    <!--Video source-->
                    <img class="img-fluid" src="sito/img/carousel/economy1.jpg"/>
          </video>
                    <div class="mask rgba-black-strong"></div>
                </div>

                <!--Caption-->
                <div class="carousel-caption">
                    <div class="animated fadeInDown">
                        <h3 class="h3-responsive"><a href="#interests">SCOPRI GLI ASPETTI PIU' NASCOSTI NEL MONDO DELLE CORSE</a></h3>
                        <p>Economia</p>
                    </div>
                </div>
                <!--Caption-->
            </div>
            <!-- /.Third slide -->
        </div>
        <!--/.Slides-->
        <!--Controls-->
        <a class="carousel-control-prev" href="#video-carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#video-carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!--/.Controls-->
    </div>
    <!--Carousel Wrapper-->

    <!-- intersts -->
    <!--DA IMPLEMENTARE con php (e javascript forse) quando l'utente seleziona il suo intersse viene mandato al paragrafo 
    sottostante con le mostre del suo interesse e sotto le altre-->
    <section class="page-section" id="interests">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Quali sono i tuoi interessi?</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-car fa-stack-1x fa-inverse"></i>
          </span>
                    <h4 class="intereses-heading">Aspetti generali</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-cogs fa-stack-1x fa-inverse"></i>
          </span>
                    <h4 class="intereses-heading">Meccanica e fisica</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-chart-line fa-stack-1x fa-inverse"></i>
          </span>
                    <h4 class="intereses-heading">Economia</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Mostre Grid -->
    <!--da implementare con php per mostrare le mostre in corso e in programmazione
        la foto della mostra è generica in base alla categoria a cui appartiene-->
    <section class="bg-light page-section" id="events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Eventi e mostre</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h3>
                    <!--<h3 class="section-subheading text-muted"><?php echo $_SESSION['email'];?></h3>-->
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-sm portfolio-item">
                        <a class="portfolio-link" data-toggle="modal" href="#nomeMostra">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content">
                                    <p>Clicca per saperne di più</p>
                                </div>
                            </div>
                            <img class="img-fluid" src="sito/img/mostreGrid/general.jpg" alt="">
                        </a>
                        <div class="portfolio-caption">
                            <h4>nomeMostra</h4>
                        </div>

                    </div>
                    <div class="col-sm portfolio-item">
                        <a class="portfolio-link" data-toggle="modal" href="#nomeMostra">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content">
                                    <p>Clicca per saperne di più</p>
                                </div>
                            </div>
                            <img class="img-fluid" src="sito/img/mostreGrid/mechanic.jpg" alt="">
                        </a>
                        <div class="portfolio-caption">
                            <h4>nomeMostra</h4>
                        </div>
                    </div>
                    <div class="col-sm portfolio-item">
                        <a class="portfolio-link" data-toggle="modal" href="#nomeMostra">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content">
                                    <p>Clicca per saperne di più</p>
                                </div>
                            </div>
                            <img class="img-fluid" src="sito/img/mostreGrid/mechanic.jpg" alt="">
                        </a>
                        <div class="portfolio-caption">
                            <h4>nomeMostra</h4>
                        </div>
                    </div>
                    <div class="col-sm portfolio-item">
                        <a class="portfolio-link" data-toggle="modal" href="#nomeMostra">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content">
                                    <p>Clicca per saperne di più</p>
                                </div>
                            </div>
                            <img class="img-fluid" src="sito/img/mostreGrid/economy.jpg" alt="">
                        </a>
                        <div class="portfolio-caption">
                            <h4>nomeMostra</h4>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Portfolio Modals -->

    <!-- Modal 1 -->
    <div class="portfolio-modal modal fade" id="nomeMostra" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl"></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2 class="text-uppercase">nome mostra</h2>
                                <p class="item-intro text-muted">categorie </p>
                                <!--<img class="img-fluid d-block mx-auto" src="img/portfolio/01-full.jpg" alt="">-->
                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis
                                    facere nemo!</p>
                                <ul class="list-inline">
                                    <li>Disponibile dal 27/08/2020</li>
                                    <li>Disponibile fino al 27/08/2021</li>
                                    <li>Prezzi</li>
                                    <table>
                                        <tr>
                                            <td>ridotto</td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>normale</td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>adulto</td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>studente</td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>over 65</td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>disabile</td>
                                            <td>€</td>
                                        </tr>
                                    </table>
                                </ul>
                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                      <i class="fas fa-times"></i>
                     chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <!-- Pianifica-->
    <section class="page-section" id="pianifica">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">

                    <h2 class="section-heading text-uppercase">Pianifica la tua visita</h2>
                    <h3 class="section-subheading text-muted">
                        <a href="biglietteria.php">Clicca qui per pianificare la tua visita</a>
                    </h3>
                </div>
            </div>
        </div>
    </section>


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
