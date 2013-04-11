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

 	<script type="text/javascript">
    function mostrareventos (str) {
      if (str=="") {
        /*document.getElementById('listado').innerHTML="";
        return; */
        xmlhttp.open("GET", "getuser.php?org=0",true);
        xmlhttp.send();
      }
      if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
      }else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          document.getElementById("listado").innerHTML=xmlhttp.responseText;
        }
      }
      xmlhttp.open("GET", "getevento.php?org="+str,true);
      xmlhttp.send();
    }
 	</script>

</head>
<body onload="mostrareventos()">
<?php
  require_once('login.php');
?>
	<br /><h3> Eventos </h3>

  <p> Por favor selecionar el evento al que desee participar: </p>


	<?php
		require_once('connectvars.php');
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		if (isset($_SESSION['id_usuario'])) {
			$id_usuario = $_SESSION['id_usuario'];
			//mysqli_query("set names utf8");
			$query = "SELECT id_voluntario FROM Voluntarios WHERE id_usuario = '$id_usuario' ";
			$result = mysqli_query($dbc, $query);
			$voluntario = mysqli_fetch_array($result);
			$id_voluntario = $voluntario['id_voluntario'];	
			//echo $id_voluntario;			
		}
		// Traducir las palabras relacionada con el tiempo de Inglés al Español.
 		class DateTimeEspanol extends DateTime{
 		 	public function format($format){
 		 		$english = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
 		 			'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
 		 			'November', 'December', 'th', 'rd', 'nd', 'st');
 		 		$espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo', 
 		 			'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
 		 			'Noviembre', 'Diciembre', ' de', ' de', ' de', 'ero de');
 		 		return str_replace($english, $espanol, parent::format($format));
 		 	}
 		}		
 	?>
  	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	<?php 
 		// Registrarse en el evento. (Solo si se hace click en submit.)
		if (isset($_POST['submit'])) {		
    		foreach ($_POST['reservar'] as $id_evento) {
      			$query1 = "INSERT INTO Voluntario_Evento (id_voluntario, id_evento) " .
      				"VALUES('$id_voluntario', '$id_evento')";
      			$result1 = mysqli_query($dbc, $query1)
      		  		or die('Error al hacer query1 en la base de datos!');
  			} 
 		 	echo 'Listo! Ya estas inscripto en el evento! <br />';
 		 }
 	?>

 		<form id="form1" name="form1" method="post" action"">
   			<table align="center" border="1px">
      		<tr>
        	<td>Nombre Organización</td>
        	<td width="129px">
          	<?php
            $query = "SELECT * FROM Organizaciones";
            $result = mysqli_query($dbc, $query)
              or die('Error al hacer query en la base de datos!');

            if ($row = mysqli_fetch_array($result)) {
              echo "<select id='id_organizacion' onchange='mostrareventos(this.value)'>";
              echo "<option value='id_organizacion'>Todos los Eventos</option>";
              do{
                echo "<option value='". $row['id_organizacion'] ."'>". $row['nombre_organizacion'] ."</option>";
              }while($row = mysqli_fetch_array($result));
              echo "</select>";
            }
            
          	?>
        	</td>
      		</tr>
    		</table>
  		</form>
  		<div id="listado" align="center">Lista de Eventos</div>

  	<?php
 		 /*
  		// Mostrar las filas de eventos con checkboxes para poder registrarse.
 		//$query2 = "SELECT * FROM Eventos WHERE fecha_hora_fin > fecha_hora_inicio"; //Muestra eventos pasados y futuros.
 		 $query2 = "SELECT * FROM Eventos WHERE fecha_hora_inicio > NOW() and fecha_hora_fin > fecha_hora_inicio"; //Eventos Futuros. 
 		 $result2 = mysqli_query($dbc, $query2)
      		or die('Error al hacer query2 en la base de datos!');
		 while ($fila = mysqli_fetch_array($result2)) {
		 	echo '<input type="checkbox" value="' . $fila['id_evento'] . '" name="reservar[]" />';
		 	$id_evento = $fila['id_evento'];
		 	echo 'ID:' . $id_evento;
			echo '<strong> Nombre del Evento: </strong>' . $fila['nombre_evento'] . ',';
		 	echo '<strong> Nombre del Lugar: </strong>' . $fila['nombre_lugar'] . ',<br />';
		 	echo "<strong>Desde las </strong>";
		 	$dtime1 = new DateTimeEspanol($fila['fecha_hora_inicio']);
		 	print $dtime1->format("g:ia l jS F Y");

		 	echo "<strong> hasta las </strong>";
		 	$dtime2 = new DateTimeEspanol($fila['fecha_hora_fin']);
		 	print $dtime2->format("g:ia l jS F Y");

		 	echo '<br /> <strong>Descripción: </strong>' . $fila['descripcion'];
		 	echo '<br /> <br />';
		}
		*/



		mysqli_close($dbc);
    	if (isset($_SESSION['tipo_usuario']) &&  $_SESSION['tipo_usuario'] == 'Voluntario') {
           echo '<input type="submit" name="submit" value="Reservar" />';
        }		

	?>
    
  </form>
</body>
</html>