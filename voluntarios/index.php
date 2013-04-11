<?php   //Proyecto de Voluntarios por Daniel Hernández 1999-0808 ISC PUCMM
  require_once('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> Home </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
  require_once('login.php');
?>
<br /><h3> Página Inicio </h3>
<p>Ser voluntario es muy fácil! Solo tienes que: </p>
<ol>
	<li><a href="http://localhost:8888/voluntarios/formvoluntario.php">Registrarte como voluntario.</a></li><br />
	<li><a href="http://localhost:8888/voluntarios/eventos.php">Elije tu evento preferido.</a></li><br />
	<li>Llegar al evento y participar.</li><br />
</ol>

</body>
</html>