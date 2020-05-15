<?php
	// Cancelliamo l'eventuale cookie di sessione
if (isset($_COOKIE[session_name()]))
{
   setcookie(session_name(), '', time()-42000, '/');
}

// distruggiamo la sessione
session_destroy();

header("location:..\..\index.php");


?>
