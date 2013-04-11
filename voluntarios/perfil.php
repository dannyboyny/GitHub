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
      //$id_usuario = $_SESSION['id_usuario'];        
    }
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Perfil</title>
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
<!-- Container Principal -->
<div id="container">
    
<?php

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
	require_once('connectvars.php');
	// Asegurar que el usuario esta autenticado antes de mostrar el formulario de eventos.
  if (!isset($_SESSION['id_usuario'])) {
   	echo '<p class="login">Favor <a href="index.php"> autenticarse </a> para poder ver esta página.</p>';
  }	
  // Si la sesión esta vacía entonces mostar un error y el form de Log in.
  if (!empty($_SESSION['id_usuario'])) {
    // Confirmar que está autenticado.
    echo('<div id="login"><p class="login">Estas autenticado como ' . $_SESSION['email'] . '.</p>');
    echo ($_SESSION['tipo_usuario'] . ' ' . '<a href="logout.php">Salir</a></div>');
  }
  $id_usuario = $_SESSION['id_usuario'];
  $tipo_usuario = $_SESSION['tipo_usuario'];
  require_once('menu.php');
?>
</div>
	<br /><h3>Perfil de <?php echo $_SESSION['email']; ?></h3>

  <?php
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');

  if (isset($_SESSION['tipo_usuario']) &&  $_SESSION['tipo_usuario'] == 'Voluntario') {
    $query = "SELECT id_voluntario FROM Voluntarios WHERE id_usuario = '$id_usuario' ";
    $result = mysqli_query($dbc, $query);
    $voluntario = mysqli_fetch_array($result);
    $id_voluntario = $voluntario['id_voluntario'];    
    if (isset($_POST['submit'])) {
      $nombre_entrenamiento = $_POST['entrenamiento'];
      $output_form = false; //No mostrar el form de nuevo.
      
      if (isset($_POST['escertificado'])) {
        $es_certificado = $_POST['escertificado'];
      }
      if ((isset($_POST['anocert'])) && (isset($_POST['mescert'])) && (isset($_POST['diacert']))) {
        $fecha_certificado = $_POST['anocert'] . '-' . $_POST['mescert'] . '-' . $_POST['diacert'];
      }      

      if (empty($nombre_entrenamiento)) {
        echo '<font color="red">*Debes elegir un entrenamiento antes de agregarlo!</font><br />';
        $output_form = true; //Mostrar el form de nuevo.
      }
    }
    else {
      $output_form = true;
    }

    if ((!empty($nombre_entrenamiento))) {
      $dbc3 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Error al intentar conexion con el servidor MySQL!');

      $query3 = "INSERT INTO `Entrenamiento_Voluntario` (id_entrenamiento, id_voluntario) " .
            "VALUES((SELECT `Entrenamiento`.`id_entrenamiento` FROM `Entrenamiento` " .
            "WHERE `Entrenamiento`.`nombre_entrenamiento` = '$nombre_entrenamiento'), '$id_voluntario')";

      $result3 = mysqli_query($dbc3, $query3)
        or die('Error al hacer query3 en la base de datos!');









      echo 'Entrenamiento Guardado! <br /><br />';
      echo "<a href='http://localhost:8888/voluntarios/perfil.php'>Regresar al Perfil</a> <br />";

      mysqli_close($dbc3);
    }
    //Mostrar el form de nuevo si es necesario.
    if ($output_form) {    
    ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php
          $query13 = "SELECT * FROM Entrenamiento";
          $result13 = mysqli_query($dbc, $query13)
            or die('Error al hacer query13 en la base de datos!');
          if (mysqli_num_rows($result13) !=0) {
            echo '<label for="entrenamiento">Agregar Entrenamiento:</label>';
            echo '<select name="entrenamiento" id="entrenamiento">' .
               '<option value="" selected="selected">entrenamiento</option>';
            while ($entrenamiento = mysqli_fetch_array($result13)) {
              echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
            }
            echo '</select> <br />';
          }
        ?>
    <label for="escertificado">¿Entrenamiento Certificada?</label>
    Si <input id="escertificado" name="escertificado" type="radio" value="Si" />
    No <input id="escertificado" name="escertificado" type="radio" value="No" /><br />

    <label for="fechacertificado">Fecha Certificada:</label>
    <select name="diacert">
      <option value="">día</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
      </select>
    
    <select name="mescert">
      <option value="">mes</option>
      <option value="1">Enero</option>
      <option value="2">Febrero</option>
      <option value="3">Marzo</option>
      <option value="4">Abril</option>
      <option value="5">Mayo</option>
      <option value="6">Junio</option>
      <option value="7">Julio</option>
      <option value="8">Agosto</option>
      <option value="9">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
      </select>
    
    <select name="anocert">
      <option value="">año</option>
      <option value="2012">2012</option>
      <option value="2011">2011</option>
      <option value="2010">2010</option>
      <option value="2009">2009</option>
      <option value="2008">2008</option>
      <option value="2007">2007</option>
      <option value="2006">2006</option>
      <option value="2005">2005</option>
      <option value="2004">2004</option>
      <option value="2003">2003</option>
      <option value="2002">2002</option>
      <option value="2001">2001</option>
      <option value="2000">2000</option>
      <option value="1999">1999</option>
      <option value="1998">1998</option>
      <option value="1997">1997</option>
      <option value="1996">1996</option>
      <option value="1995">1995</option>
      <option value="1994">1994</option>
      <option value="1993">1993</option>
      <option value="1992">1992</option>
      <option value="1991">1991</option>
      <option value="1990">1990</option>
      <option value="1989">1989</option>
      <option value="1988">1988</option>
      <option value="1987">1987</option>
      <option value="1986">1986</option>
      <option value="1985">1985</option>
      <option value="1984">1984</option>
      <option value="1983">1983</option>
      <option value="1982">1982</option>
      <option value="1981">1981</option>
      <option value="1980">1980</option>
      <option value="1979">1979</option>
      <option value="1978">1978</option>
      <option value="1977">1977</option>
      <option value="1976">1976</option>
      <option value="1975">1975</option>
      <option value="1974">1974</option>
      <option value="1973">1973</option>
      <option value="1972">1972</option>
      <option value="1971">1971</option>
      <option value="1970">1970</option>
      <option value="1969">1969</option>
      <option value="1968">1968</option>
      <option value="1967">1967</option>
      <option value="1966">1966</option>
      <option value="1965">1965</option>
      <option value="1964">1964</option>
      <option value="1963">1963</option>
      <option value="1962">1962</option>
      <option value="1961">1961</option>
      <option value="1960">1960</option>
      </select><br />        
        <input type="submit" value="Agregar Entrenamiento" name="submit" /> <br /><br />
      </form>
    <?php
    }
  

    $query1 = "SELECT * FROM Voluntarios WHERE id_usuario = '$id_usuario'";

    $result1 = mysqli_query($dbc, $query1)
      or die('Error al hacer query1 en la base de datos!');
  
    if (mysqli_num_rows($result1) == 1) {
      $row = mysqli_fetch_array($result1);
      echo '<table>';

      if (!empty($row['primer_nombre'])) {
        echo '<tr><td class="label">Primer Nombre:</td><td>' . $row['primer_nombre'] . '</td></tr>';
      }
      if (!empty($row['segundo_nombre'])) {
        echo '<tr><td class="label">Segundo Nombre:</td><td>' . $row['segundo_nombre'] . '</td></tr>';
      }
      if (!empty($row['primer_apellido'])) {
        echo '<tr><td class="label">Primer Apellido:</td><td>' . $row['primer_apellido'] . '</td></tr>';
      } 
      if (!empty($row['segundo_apellido'])) {
        echo '<tr><td class="label">Segundo Apellido:</td><td>' . $row['segundo_apellido'] . '</td></tr>';
      }
      if (!empty($row['sexo'])) {
        echo '<tr><td class="label">Sexo:</td><td>' . $row['sexo'] . '</td></tr>';
      }

      echo '</table><br/><br/><br/>';
      echo "<h3 align='center'>Eventos Futuros</h3>";
    }


      $query12 = "SELECT `Eventos`.`id_evento`, Eventos.`nombre_evento`, Eventos.`nombre_lugar`, Eventos.`fecha_hora_inicio`, " .
                "`Eventos`.`fecha_hora_fin`, `Eventos`.`provincia`, `Eventos`.`descripcion`, `Eventos`.`tipo_evento`, `Eventos`.`tipo_frecuencia`," .
                "`Eventos`.`tipo_compromiso`" .
                "FROM Eventos, Voluntarios, Voluntario_Evento ve, Usuarios WHERE ve.`id_voluntario` = Voluntarios.`id_voluntario` " .
                "and Eventos.`id_evento` = ve.`id_evento` and Voluntarios.`id_usuario` = Usuarios.`id_usuario` and " .
                "Usuarios.`id_usuario` = '$id_usuario' and Eventos.`fecha_hora_inicio` > NOW()"; //Eventos Anteriores. 
      
      $result12 = mysqli_query($dbc, $query12)
        or die('Error al hacer query12 en la base de datos!');

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
      while ($row = mysqli_fetch_array($result12)) {
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
      echo "</table> <br />";



      echo "<h3 align='center'>Eventos Pasados</h3>";
      $query2 = "SELECT `Eventos`.`id_evento`, Eventos.`nombre_evento`, Eventos.`nombre_lugar`, Eventos.`fecha_hora_inicio`, " .
                "`Eventos`.`fecha_hora_fin`, `Eventos`.`provincia`, `Eventos`.`descripcion`, `Eventos`.`tipo_evento`, `Eventos`.`tipo_frecuencia`," .
                "`Eventos`.`tipo_compromiso`" .
                "FROM Eventos, Voluntarios, Voluntario_Evento ve, Usuarios WHERE ve.`id_voluntario` = Voluntarios.`id_voluntario` " .
                "and Eventos.`id_evento` = ve.`id_evento` and Voluntarios.`id_usuario` = Usuarios.`id_usuario` and " .
                "Usuarios.`id_usuario` = '$id_usuario' and Eventos.`fecha_hora_inicio` <= NOW()"; //Eventos Anteriores. 
      
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
  }else{
    
  }






?>
  


  <br /> <br /> <br /> <br /> <br /> <br />
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
  $query2 = "SELECT Eventos.`id_evento`, Eventos.`nombre_evento`, Eventos.`nombre_lugar`, Eventos.`fecha_hora_inicio` FROM Eventos, Voluntarios, " .
            "Voluntario_Evento ve, Usuarios WHERE ve.`id_voluntario` = Voluntarios.`id_voluntario` and Eventos.`id_evento` = ve.`id_evento` and " . 
            "Voluntarios.`id_usuario` = Usuarios.`id_usuario` and Usuarios.`id_usuario` = '$id_usuario' and Eventos.`fecha_hora_inicio` < NOW()";
  $result2 = mysqli_query($dbc, $query2)
    or die('Error al hacer query2 en la base de datos!');

  $query3 = "SELECT Eventos.`id_evento`, Eventos.`nombre_evento`, Eventos.`nombre_lugar`, Eventos.`fecha_hora_inicio` FROM Eventos, Voluntarios, " .
            "Voluntario_Evento ve, Usuarios WHERE ve.`id_voluntario` = Voluntarios.`id_voluntario` and Eventos.`id_evento` = ve.`id_evento` and " . 
            "Voluntarios.`id_usuario` = Usuarios.`id_usuario` and Usuarios.`id_usuario` = '$id_usuario' and Eventos.`fecha_hora_inicio` > NOW()";
  $result3 = mysqli_query($dbc, $query3)
    or die('Error al hacer query3 en la base de datos!');    

  mysqli_close($dbc);
?>


</body>
</html>