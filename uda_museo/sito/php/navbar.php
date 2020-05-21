
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
								echo "<li><a class='nav-link-drop' href='sito/php/account.php'>account</a></li>";
								echo "<li ><a class='nav-link-drop' href='sito/php/bigliettiUtente.php'>acquisti</a></li>";
								if($_SESSION['amministratore']){
									echo "<li ><a class='nav-link-drop' href='sito/php/amministrazione.php'>gestisci</a></li>";
								}
								echo "<li><a class='nav-link-drop' href='sito/php/destroy.php'>esci</a></li>";
							echo "</ul>";
						echo "</li>";
					}
				?>
