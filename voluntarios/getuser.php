<?php   //Proyecto de Voluntarios por Daniel Hernández 1999-0808 ISC PUCMM
  session_start();

   // Borrar el mensaje de error.
  $error_msg = "";

  // Asignar los valores de la sesión si no tienen valores asignado usando un cookie.
  if (!isset($_SESSION['id_usuario'])) {
    if (isset($_COOKIE['id_usuario']) && isset($_COOKIE['email']) && isset($_COOKIE['tipo_usuario'])) {
      $_SESSION['id_usuario'] = $_COOKIE['id_usuario'];
      $_SESSION['email'] = $_COOKIE['email'];
      $_SESSION['tipo_usuario'] = $_COOKIE['tipo_usuario'];
    }
  }

  $id_usuario = $_SESSION['id_usuario'];
  require_once('connectvars.php');

  $id_organizacion = $_GET["org"];
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
  if ($id_organizacion == 0) {
  	$query = "SELECT * FROM Eventos";
  }
  else{
  	$query = "SELECT `Eventos`.nombre_evento, `Eventos`.nombre_lugar, `Eventos`.fecha_hora_inicio FROM Eventos, Evento_Organizacion, Organizaciones " .
             "WHERE `Eventos`.`id_evento` = `Evento_Organizacion`.`id_evento` and `Evento_Organizacion`.`id_organizacion` = `Organizaciones`.`id_organizacion` " .
             "and `Organizaciones`.id_organizacion = '$id_organizacion' ";
    //$query = "SELECT Eventos.`id_evento`, Eventos.`nombre_evento`, Eventos.`nombre_lugar`, Eventos.`fecha_hora_inicio` FROM Eventos, Voluntarios, " .
         //   "Voluntario_Evento ve, Usuarios WHERE ve.`id_voluntario` = Voluntarios.`id_voluntario` and Eventos.`id_evento` = ve.`id_evento` and " . 
         //   "Voluntarios.`id_usuario` = Usuarios.`id_usuario` and Usuarios.`id_usuario` = '$id_usuario' and Eventos.`fecha_hora_inicio` < NOW()";
 	
  }
  $result = mysqli_query($dbc, $query)
    or die('Error al hacer query en la base de datos!');

  echo "<table border='1'>
  		<tr>
  		<th>Nombre Evento</th>
  		<th>Nombre Lugar</th>
  		<th>Fecha</th>
  		</tr>";

  while ($row = mysqli_fetch_array($result)) {
  	echo "<tr>";
  	  echo "<td>" . $row['nombre_evento'] . "</td>";
  	  echo "<td>" . $row['nombre_lugar'] . "</td>";
  	  echo "<td>" . $row['fecha_hora_inicio'] . "</td>";
  	echo "</tr>";
  }
  echo "</table>";

  mysqli_close($dbc);

?>