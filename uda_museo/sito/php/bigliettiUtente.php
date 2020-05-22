
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><body id="page-top">
</head>

<body>
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
                            $no=explode(' ', $_SESSION['nome']);
                            $nom=" ".$no[0]." ";
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
	echo"<h2>Biglietti acquistati:<h2>";
		$sql="SELECT dataVal, descCat, titolo
				FROM biglietto, categoria, evento
				WHERE Eve = codEve AND catBig = codCat AND vis = \"".$_SESSION['email']."\";";
		$result = $mysqli -> query($sql);
		//controllo esito query
		if($result){
			//esito positivo
			echo "<table><tr>
				<td>Data acquisto</td>
				<td>Evento</td>
				<td>Categoria</td>
			</tr>";
				while($row = $result -> fetch_assoc()){
					echo "<tr>
						<td>".$row['dataVal']."</td>
						<td>".$row['titolo']."</td>
						<td>".$row['descCat']."</td>
					</tr>";
				}
			echo "</table>";
		}else{
			//esito egativo
			//errore 
			echo "Error: ". $sql . "<br>" .mysqli_error($mysqli);
		}
	?>
</body>
</html>