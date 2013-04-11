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
<body>
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
    if (isset($id_voluntario)) {
        
      	
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
   		 
    	// Mostrar las filas de eventos con checkboxes para poder registrarse.
   		/*$query2 = "SELECT `Eventos`.`id_evento`, `Eventos`.`nombre_evento`, `Eventos`.`fecha_hora_inicio`, `Eventos`.`fecha_hora_fin`, " .
                "`Eventos`.`nombre_lugar`, `Eventos`.`provincia`, `Eventos`.`descripcion`, `Eventos`.`tipo_evento`, `Eventos`.`tipo_frecuencia`, " .
                "`Eventos`.`tipo_compromiso`, `Entrenamiento`.`nombre_entrenamiento` FROM `Eventos`, `Entrenamiento_Evento`, `Entrenamiento_Voluntario`, " .
                "`Entrenamiento` WHERE `Entrenamiento_Evento`.`id_entrenamiento` = `Entrenamiento_Voluntario`.`id_entrenamiento` AND " .
                "`Eventos`.`id_evento` = `Entrenamiento_Evento`.`id_evento` AND `Entrenamiento`.`id_entrenamiento` = `Entrenamiento_Voluntario`.`id_entrenamiento` " .
                "AND `Entrenamiento_Voluntario`.`id_voluntario` = '$id_voluntario' AND `Eventos`.`fecha_hora_inicio` > NOW()"; //Muestra eventos pasados y futuros. */
   		$query2 = "SELECT `Eventos`.`id_evento`, `Eventos`.`nombre_evento`, `Eventos`.`fecha_hora_inicio`, `Eventos`.`fecha_hora_fin`, " .
                "`Eventos`.`nombre_lugar`, `Eventos`.`provincia`, `Eventos`.`descripcion`, `Eventos`.`tipo_evento`, `Eventos`.`tipo_frecuencia`, " .
                "`Eventos`.`tipo_compromiso`, `Entrenamiento`.`nombre_entrenamiento` FROM `Eventos`, `Entrenamiento_Evento`, `Entrenamiento_Voluntario`, " .
                "`Entrenamiento` WHERE `Entrenamiento_Evento`.`id_entrenamiento` = `Entrenamiento_Voluntario`.`id_entrenamiento` AND " .
                "`Eventos`.`id_evento` = `Entrenamiento_Evento`.`id_evento` AND `Entrenamiento`.`id_entrenamiento` = `Entrenamiento_Voluntario`.`id_entrenamiento` " .
                "AND `Entrenamiento_Voluntario`.`id_voluntario` = '$id_voluntario' AND `Eventos`.`fecha_hora_inicio` > NOW() and " .
                "`Eventos`.`fecha_hora_fin` > `Eventos`.`fecha_hora_inicio`"; //Eventos Futuros. 
   		
      $result2 = mysqli_query($dbc, $query2)
      	or die('Error al hacer query2 en la base de datos!');

      echo "<table border='1'>
        <tr>
          <th>Check</th>
          <th>ID</th>
          <th>Nombre Evento</th>
          <th>Fecha</th>
          <th>Nombre Lugar</th>
          <th>Provincia</th>
          <th>Descripción</th>
          <th>Tipo Evento</th>
          <th>Tipo Frecuencia</th>
          <th>Tipo Compromiso</th>
          <th>Entrenamiento</th>
        </tr>";
      while ($row = mysqli_fetch_array($result2)) {
        echo "<tr>";
          echo "<td> <input type='checkbox' value='" . $row['id_evento'] . "'name='reservar[]' /></td>";
          $id_evento = $row['id_evento'];
          echo "<td>" . $row['id_evento'] . "</td>";
          echo "<td>" . $row['nombre_evento'] . "</td>";
          echo "<td>";
          $dtime1 = new DateTimeEspanol($row['fecha_hora_inicio']);
          print $dtime1->format("g:ia l jS F Y");
          echo "<br /><strong> hasta las </strong>";
          $dtime2 = new DateTimeEspanol($row['fecha_hora_fin']);
          print $dtime2->format("g:ia l jS F Y");      
          echo "</td>";
          echo "<td>" . $row['nombre_lugar'] . "</td>";
          echo "<td>" . $row['provincia'] . "</td>";
          echo "<td>" . $row['descripcion'] . "</td>";
          echo "<td>" . $row['tipo_evento'] . "</td>";
          echo "<td>" . $row['tipo_frecuencia'] . "</td>";
          echo "<td>" . $row['tipo_compromiso'] . "</td>";
          echo "<td>" . $row['nombre_entrenamiento'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
		}else{
        $query2 = "SELECT * FROM `Eventos` WHERE `Eventos`.`fecha_hora_inicio` > NOW() and " .
                  "`Eventos`.`fecha_hora_fin` > `Eventos`.`fecha_hora_inicio`"; //Eventos Futuros. 
      
        $result2 = mysqli_query($dbc, $query2)
          or die('Error al hacer query2 en la base de datos!');

        echo "<table border='1'>
          <tr>
            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Fecha</th>
            <th>Nombre Lugar</th>
            <th>Provincia</th>
            <th>Descripción</th>
            <th>Tipo Evento</th>
            <th>Tipo Frecuencia</th>
            <th>Tipo Compromiso</th>

          </tr>";

        while ($row = mysqli_fetch_array($result2)) {
          echo "<tr>";
            $id_evento = $row['id_evento'];
            echo "<td>" . $row['id_evento'] . "</td>";
            echo "<td>" . $row['nombre_evento'] . "</td>";
            echo "<td>";
            $dtime1 = new DateTimeEspanol($row['fecha_hora_inicio']);
            print $dtime1->format("g:ia l jS F Y");
            echo "<br /><strong> hasta las </strong>";
            $dtime2 = new DateTimeEspanol($row['fecha_hora_fin']);
            print $dtime2->format("g:ia l jS F Y");      
            echo "</td>";
            echo "<td>" . $row['nombre_lugar'] . "</td>";
            echo "<td>" . $row['provincia'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "<td>" . $row['tipo_evento'] . "</td>";
            echo "<td>" . $row['tipo_frecuencia'] . "</td>";
            echo "<td>" . $row['tipo_compromiso'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";     
    }

		mysqli_close($dbc);
    	if (isset($_SESSION['tipo_usuario']) &&  $_SESSION['tipo_usuario'] == 'Voluntario') {
           echo '<input type="submit" name="submit" value="Reservar" />';
        }		

	?>
    
  </form>
</body>
</html>