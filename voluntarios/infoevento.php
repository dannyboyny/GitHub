<?php   //Proyecto de Voluntarios por Daniel Hernández 1999-0808 ISC PUCMM
  require_once('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> Eventos </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
  require_once('login.php');
?>
	<br /><h3> Información del Evento </h3>
<?php 
	$id_evento = $_POST['id_evento'];
	echo "$id_evento";



?>








</body>
</html>