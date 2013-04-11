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
  if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
  }

  require_once('connectvars.php');

  $id_organizacion = $_GET["org"];


  class DateTimeEspanol extends DateTime
     {
      
      public function format($format)
      {
        $english = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
          'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'th', 'rd', 'nd', 'st');
        $espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo', 
          'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', ' de', ' de', ' de', 'ero de');
        return str_replace($english, $espanol, parent::format($format));
      }
     }


  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
  if ($id_organizacion == 0) {
    $query = "SELECT * FROM `Eventos`";//" WHERE `Eventos`.`fecha_hora_inicio` > NOW()"; // Eventos Futuros
  }
  else{
    $query = "SELECT `Eventos`.id_evento, `Eventos`.nombre_evento, `Eventos`.nombre_lugar, `Eventos`.fecha_hora_inicio, `Eventos`.fecha_hora_fin, " .
             "`Eventos`.provincia, `Eventos`.descripcion, `Eventos`.tipo_evento, `Eventos`.tipo_frecuencia, `Eventos`.tipo_compromiso FROM Eventos, " . 
             "Evento_Organizacion, Organizaciones WHERE `Eventos`.`id_evento` = `Evento_Organizacion`.`id_evento` and " . 
             "`Evento_Organizacion`.`id_organizacion` = `Organizaciones`.`id_organizacion` and `Organizaciones`.id_organizacion = '$id_organizacion' " . 
             "and `Eventos`.`fecha_hora_inicio` > NOW()";
  }
  $result = mysqli_query($dbc, $query)
    or die('Error al hacer query en la base de datos!');

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
      </tr>";
  while ($row = mysqli_fetch_array($result)) {
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
    echo "</tr>";
  }
  echo "</table>";
  
  mysqli_close($dbc);

?>
