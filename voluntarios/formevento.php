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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulario de Eventos</title>
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<!-- Container Principal -->
<div id="container">
    
<?php
	require_once('connectvars.php');
	  // Asegurar que el usuario esta autenticado como una organización antes de mostrar el formulario de eventos.
  	if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] == 'Voluntario') {
   		echo '<p class="login">Favor <a href="index.php"> autenticarse </a> como una organización para poder crear eventos.</p>';
?>
<?php
  		// Si la sesión esta vacía entonces mostar un error y el form de Log in.
  		if (empty($_SESSION['id_usuario'])) {
    		echo '<p class="error">' . $error_msg . '</p>';
?>
   			<div id="login">
     		   	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      		    	<input type='hidden' name='submitted' id='1'/>
	            	<label for='email' >Email:</label>
    	    	    <input type='text' name='email' id='email' maxlength="50" /><br/>
        		    <label for='password' >Contraseña:</label>
    	        	<input type='password' name='clave' id='clave' maxlength="50" /><br />
	            	<input type='submit' name='submitlogin' value='Login' />
            		<a href="http://localhost:8888/voluntarios/formorganizacion.php">Registrarse</a>                         
        		</form>
    		</div>
<?php
  		}
  		else {
    		// Confirmar que está autenticado.
   			 echo('<div id="login"><p class="login"><a href="http://localhost:8888/voluntarios/perfil.php">Ver perfil de </a> ' . $_SESSION['email'] . '.</p>');
    		echo ($_SESSION['tipo_usuario'] . ' ' . '<a href="logout.php">Salir</a></div>');
  		}
  		require_once('menu.php');
?> 		
		</div>
			<br /><h3>Formulario para Crear un Evento</h3>
   		<?php
    	exit();
  	}
  	else {
    echo('<div id="login"><p class="login">Estas autenticado como ' . $_SESSION['email'] . '.</p>');
    echo '<a href="logout.php">Log Out (' . $_SESSION['email'] . ')</a></div>';
  	}
  	require_once('menu.php');
?>
</div>
	<br /><h3>Formulario para Crear un Evento</h3>
<?php
	if (isset($_POST['submit'])) {
		$nombre_evento = $_POST['nombreevento'];
		$nombre_lugar = $_POST['nombrelugar'];
		$id_pais = $_POST['pais'];
		

		if (isset($_POST['anoinicio'])) { 
			$ano_inicio = $_POST['anoinicio'];
		}
		
		$mes_inicio = $_POST['mesinicio'];
		$dia_inicio = $_POST['diainicio'];
		$hora_inicio = $_POST['horainicio'];
		$minuto_inicio = $_POST['minutoinicio'];

		$ano_fin = $_POST['anofin'];
		$mes_fin = $_POST['mesfin'];
		$dia_fin = $_POST['diafin'];
		$hora_fin = $_POST['horafin'];
		$minuto_fin = $_POST['minutofin'];

		$output_form = false;

		if (empty($nombre_evento)) {
			echo '<font color="red">*Debes digitar el nombre del evento!</font><br />';
			$output_form = true;
		}

		if (empty($nombre_lugar)) {
			echo '<font color="red">*Debes digitar el nombre del lugar!</font><br />';
			$output_form = true;
		}

		if (empty($id_pais)) {
			echo '<font color="red">*Debes digitar el país!</font><br />';
			$output_form = true;
		}		

		if ((empty($ano_inicio))) {
			echo '<font color="red">*Debes digitar la fecha del evento!</font><br />';
			$output_form = true;
		}
		if ((!empty($_POST['provincia'])) && (!empty($_POST['provincia1']))) {
			echo '<font color="red">*Debes elegir una sola provincia!</font><br />';
			$output_form = true;
		}
		if ((isset($_POST['anoinicio'])) && (isset($_POST['mesinicio'])) && (isset($_POST['diainicio'])) && (isset($_POST['horainicio'])) && (isset($_POST['minutoinicio']))) {
			$fecha_hora_inicio = $ano_inicio . '-' . $mes_inicio . '-' . $dia_inicio . ' ' . $hora_inicio . ':' . $minuto_inicio;
		}

		if ((isset($_POST['anofin'])) && (isset($_POST['mesfin'])) && (isset($_POST['diafin'])) && (isset($_POST['horafin'])) && (isset($_POST['minutofin']))) {
			$fecha_hora_fin = $ano_fin . '-' . $mes_fin . '-' . $dia_fin . ' ' . $hora_fin . ':' . $minuto_fin;
		}
		/*if ($fecha_hora_fin < $fecha_hora_inicio) {
			echo '<font color="red">*La fecha de fin de evento debe ser después de la fecha de inicio!</font><br />';
			$output_form = true;				
		}*/	
	}
	else {
		$output_form = true;
	}

	if (!empty($_POST['provincia'])) {
		$provincia = $_POST['provincia'];
	}
	elseif (!empty($_POST['provincia1'])) {
		$provincia = $_POST['provincia1'];
	}


	
	if (isset($_POST['tipoevento'])) {
		$tipo_evento = $_POST['tipoevento'];
	}

	if (isset($_POST['tipofrecuencia'])) {
		$tipo_frecuencia = $_POST['tipofrecuencia'];
	}

	if (isset($_POST['tipocompromiso'])) {
		$tipo_compromiso = $_POST['tipocompromiso'];
	}

	if (isset($_POST['entrenamiento1'])) {
		$entrenamiento1 = $_POST['entrenamiento1'];
	}

	if (isset($_POST['entrenamiento2'])) {
		$entrenamiento2 = $_POST['entrenamiento2'];
	}

	if (isset($_POST['entrenamiento3'])) {
		$entrenamiento3 = $_POST['entrenamiento3'];
	}

	if (isset($_POST['descripcion'])) {
		$descripcion = $_POST['descripcion'];
	}

	if (isset($_POST['cantvoluntariossolicitado'])) {
		$cant_voluntarios_solicitado = $_POST['cantvoluntariossolicitado'];
	}

	if (isset($_SESSION['id_usuario'])) {
		$id_usuario = $_SESSION['id_usuario'];
	}

	if ((!empty($nombre_evento)) && (!empty($nombre_lugar)) && (!empty($id_pais))) {
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query1 = "SELECT id_organizacion FROM Organizaciones WHERE id_usuario = '$id_usuario'";
		$result1 = mysqli_query($dbc, $query1)
			or die('Error al hacer query1 en la base de datos!');
		$fila = mysqli_fetch_array($result1);
		$id_organizacion = $fila['id_organizacion'];

		$query2 = "INSERT INTO Eventos (nombre_evento, nombre_lugar, id_pais, provincia, fecha_hora_inicio, fecha_hora_fin, " . 
			"tipo_evento, tipo_frecuencia, tipo_compromiso, cant_voluntarios_solicitado, descripcion, fecha_evento_creado) " .
			"VALUES('$nombre_evento', '$nombre_lugar', '$id_pais', '$provincia', '$fecha_hora_inicio', '$fecha_hora_fin', " .
				"'$tipo_evento', '$tipo_frecuencia', '$tipo_compromiso', '$cant_voluntarios_solicitado', '$descripcion', NOW())";
		$result2 = mysqli_query($dbc, $query2)
			or die('Error al hacer query2 en la base de datos!');
		$id_evento = mysqli_insert_id($dbc);

		$query3 = "INSERT INTO Evento_Organizacion (id_evento, id_organizacion) " .
			"VALUES('$id_evento', '$id_organizacion')";
		$result3= mysqli_query($dbc, $query3)
			or die('Error al hacer query3 en la base de datos!');
		
		$query4 = "SELECT `Entrenamiento`.id_entrenamiento FROM `Entrenamiento` WHERE `Entrenamiento`.nombre_entrenamiento = '$entrenamiento1'";
		$result4 = mysqli_query($dbc, $query4)
			or die('Error al hacer query4 en la base de datos!');
		$row = mysqli_fetch_array($result4);
		$id_entrenamiento = $row['id_entrenamiento'];

		$query5 = "INSERT INTO `Entrenamiento_Evento` (id_entrenamiento, id_evento) " .
			"VALUES('$id_entrenamiento', '$id_evento')";
		$result5 = mysqli_query($dbc, $query5)
			or die('Error al hacer query5 en la base de datos!');
		
		echo 'Evento Creado! <br />';
		mysqli_close($dbc);
	}

	if ($output_form) {
?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">	
	<p> Campos con * son obligatorios! </p>

	<!-- Datos de la Organizacion -->
	<label for="nombreevento">*Nombre del Evento:</label>
	<input type="text" id="nombreevento" name="nombreevento" /> <br />
	
	<label for="nombrelugar">*Nombre del Lugar:</label>
	<input type="text" id="nombrelugar" name="nombrelugar" /> <br />
	<label for="pais">*País:</label>
	<?php
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
		or die('Error al intentar conexion con el servidor MySQL!');

	$query6 = "SELECT * FROM Paises";
	$result6 = mysqli_query($dbc, $query6)
		or die('Error al hacer query6 en la base de datos!');
	if (mysqli_num_rows($result6) !=0) {
		echo '<select name="pais" id="pais">' .
			 '<option value=" " selected="selected">país</option>';
			while ($pais = mysqli_fetch_array($result6)) {
				echo '<option value="' . $pais['id_pais'] . ' ">' . $pais['nombre_pais'] . '</option>';
			}
			echo '</select> <br />';
	}

	mysqli_close($dbc);	
	?>
	
	<label for="provincia">Provincia:</label>
	<select name="provincia">
		<option value="">provincia dominicana</option>
		<option value="Azua">Azua</option>
		<option value="Bahoruco">Bahoruco</option>
		<option value="Barahona">Barahona</option>
		<option value="Dajabón">Dajabón</option>
		<option value="Districto Nacional">Districto Nacional</option>
		<option value="Duarte">Duarte</option>
		<option value="El Seibo">El Seibo</option>
		<option value="Elias Piña">Elias Piña</option>
		<option value="Espallat">Espallat</option>
		<option value="Hato Mayor">Hato Mayor</option>
		<option value="Hermanas Mirabal">Hermanas Mirabal</option>
		<option value="Independencia">Independencia</option>
		<option value="La Altagracia">La Altagracia</option>
		<option value="La Romana">La Romana</option>
		<option value="La Vega">La Vega</option>
		<option value="Maria Trinidad Sánchez">Maria Trinidad Sánchez</option>
		<option value="Monseñor Nouel">Monseñor Nouel</option>
		<option value="Monte Plata">Monte Plata</option>
		<option value="Montecristi">Montecristi</option>
		<option value="Pedernales">Pedernales</option>
		<option value="Peravia">Peravia</option>
		<option value="Puerto Plata">Puerto Plata</option>
		<option value="Samaná">Samaná</option>
		<option value="San Cristóbal">San Cristóbal</option>
		<option value="San José de Ocoa">San José de Ocoa</option>
		<option value="San Juan de la Maguana">San Juan de la Maguana</option>
		<option value="San Pedro de Macorís">San Pedro de Macorís</option>
		<option value="Santiago">Santiago</option>
		<option value="Santiago Rodríguez">Santiago Rodríguez</option>
		<option value="Santo Domingo">Santo Domingo</option>
		<option value="Sánchez Ramírez">Sánchez Ramírez</option>
		<option value="Valverde">Valverde</option>
    </select> <br />
	<label for="provincia1">Otra Provincia o Estado:</label>
	<input type="text" id="provincia1" name="provincia1" value="<?php if (isset($provincia1)) {echo $provincia1;} ?>" /> <br />	<br />

	<label for="fechainicio">*Fecha de Inicio:</label>
	<!-- Aquí se selecciona el día del inicio del evento. -->
	<select name="diainicio">
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
	<!-- Aquí se selecciona el mes del inicio del evento. -->
	<select name="mesinicio">
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
	<!-- En esta parte se selecciona el año del inicio del evento. -->
	<select name="anoinicio">
		<option value="">año</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020">2020</option>
		<option value="2021">2021</option>
		<option value="2022">2022</option>
		<option value="2023">2023</option>
		<option value="2024">2024</option>
		<option value="2025">2025</option>
		<option value="2026">2026</option>
		<option value="2027">2027</option>
		<option value="2028">2028</option>
		<option value="2029">2029</option>
		<option value="2030">2030</option>
		<option value="2031">2031</option>
		<option value="2032">2032</option>
		<option value="2033">2033</option>
		<option value="2034">2034</option>
		<option value="2035">2035</option>
		<option value="2036">2036</option>
		<option value="2037">2037</option>
		<option value="2038">2038</option>
		<option value="2039">2039</option>
		<option value="2040">2040</option>
		<option value="2041">2041</option>
		<option value="2042">2042</option>
		<option value="2043">2043</option>
		<option value="2044">2044</option>
		<option value="2045">2045</option>
		<option value="2046">2046</option>
		<option value="2047">2047</option>
		<option value="2048">2048</option>
		<option value="2049">2049</option>
		<option value="2050">2050</option>
    </select><br />

	<label for="horainicio">Hora de Inicio:</label>
	<select name="horainicio">
		<option value="">hora</option>
		<option value="6">6am</option>
		<option value="7">7am</option>
		<option value="8">8am</option>
		<option value="9">9am</option>
		<option value="10">10am</option>
		<option value="11">11am</option>
		<option value="12">12pm</option>
		<option value="13">1pm</option>
		<option value="14">2pm</option>
		<option value="15">3pm</option>
		<option value="16">4pm</option>
		<option value="17">5pm</option>
		<option value="18">6pm</option>
		<option value="19">7pm</option>
		<option value="20">8pm</option>
		<option value="21">9pm</option>
		<option value="22">10pm</option>
		<option value="23">11pm</option>
		<option value="00">12am</option>
		<option value="1">1am</option>
		<option value="2">2am</option>
		<option value="3">3am</option>
		<option value="4">4am</option>
		<option value="5">5am</option>		
    </select>

	<select name="minutoinicio">
		<option value="0">00 min</option>
		<option value="1">01</option>
		<option value="2">02</option>
		<option value="3">03</option>
		<option value="4">04</option>
		<option value="5">05</option>
		<option value="6">06</option>
		<option value="7">07</option>
		<option value="8">08</option>
		<option value="9">09</option>
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
		<option value="32">32</option>
		<option value="33">33</option>
		<option value="34">34</option>
		<option value="35">35</option>
		<option value="36">36</option>
		<option value="37">37</option>
		<option value="38">38</option>
		<option value="38">38</option>
		<option value="38">38</option>
		<option value="39">39</option>
		<option value="40">40</option>
		<option value="41">41</option>
		<option value="42">42</option>
		<option value="43">43</option>
		<option value="44">44</option>
		<option value="45">45</option>
		<option value="46">46</option>
		<option value="47">47</option>
		<option value="48">48</option>
		<option value="49">49</option>
		<option value="50">50</option>
		<option value="51">51</option>
		<option value="52">52</option>
		<option value="53">53</option>
		<option value="54">54</option>
		<option value="55">55</option>
		<option value="56">56</option>
		<option value="57">57</option>
		<option value="58">58</option>
		<option value="59">59</option>
	</select> <br /><br />

	<label for="fechafin">*Fecha Fin de Evento:</label>
	<select name="diafin">
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
	<!-- <label for="mes">Mes:</label> -->
	<select name="mesfin">
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
	<!-- <label for="ano">Ano:</label> -->
	<select name="anofin">
		<option value="">año</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020">2020</option>
		<option value="2021">2021</option>
		<option value="2022">2022</option>
		<option value="2023">2023</option>
		<option value="2024">2024</option>
		<option value="2025">2025</option>
		<option value="2026">2026</option>
		<option value="2027">2027</option>
		<option value="2028">2028</option>
		<option value="2029">2029</option>
		<option value="2030">2030</option>
		<option value="2031">2031</option>
		<option value="2032">2032</option>
		<option value="2033">2033</option>
		<option value="2034">2034</option>
		<option value="2035">2035</option>
		<option value="2036">2036</option>
		<option value="2037">2037</option>
		<option value="2038">2038</option>
		<option value="2039">2039</option>
		<option value="2040">2040</option>
		<option value="2041">2041</option>
		<option value="2042">2042</option>
		<option value="2043">2043</option>
		<option value="2044">2044</option>
		<option value="2045">2045</option>
		<option value="2046">2046</option>
		<option value="2047">2047</option>
		<option value="2048">2048</option>
		<option value="2049">2049</option>
		<option value="2050">2050</option>
    </select><br />

	<label for="horafin">Hora de Fin de Evento:</label>
	<select name="horafin">
		<option value="">hora</option>
		<option value="6">6am</option>
		<option value="7">7am</option>
		<option value="8">8am</option>
		<option value="9">9am</option>
		<option value="10">10am</option>
		<option value="11">11am</option>
		<option value="12">12pm</option>
		<option value="13">1pm</option>
		<option value="14">2pm</option>
		<option value="15">3pm</option>
		<option value="16">4pm</option>
		<option value="17">5pm</option>
		<option value="18">6pm</option>
		<option value="19">7pm</option>
		<option value="20">8pm</option>
		<option value="21">9pm</option>
		<option value="22">10pm</option>
		<option value="23">11pm</option>
		<option value="00">12am</option>
		<option value="1">1am</option>
		<option value="2">2am</option>
		<option value="3">3am</option>
		<option value="4">4am</option>
		<option value="5">5am</option>
    </select>

	<select name="minutofin">
		<option value="0">00 min</option>
		<option value="1">01</option>
		<option value="2">02</option>
		<option value="3">03</option>
		<option value="4">04</option>
		<option value="5">05</option>
		<option value="6">06</option>
		<option value="7">07</option>
		<option value="8">08</option>
		<option value="9">09</option>
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
		<option value="32">32</option>
		<option value="33">33</option>
		<option value="34">34</option>
		<option value="35">35</option>
		<option value="36">36</option>
		<option value="37">37</option>
		<option value="38">38</option>
		<option value="38">38</option>
		<option value="38">38</option>
		<option value="39">39</option>
		<option value="40">40</option>
		<option value="41">41</option>
		<option value="42">42</option>
		<option value="43">43</option>
		<option value="44">44</option>
		<option value="45">45</option>
		<option value="46">46</option>
		<option value="47">47</option>
		<option value="48">48</option>
		<option value="49">49</option>
		<option value="50">50</option>
		<option value="51">51</option>
		<option value="52">52</option>
		<option value="53">53</option>
		<option value="54">54</option>
		<option value="55">55</option>
		<option value="56">56</option>
		<option value="57">57</option>
		<option value="58">58</option>
		<option value="59">59</option>
	</select> <br /><br />

	<label for="tipoevento">Tipo de Evento:</label>
	<!-- <input type="text" id="tipoevento" name="tipoevento" /> <br /> -->
	<select name="tipoevento">
	<option value="">evento</option>
	<option value="Caminata">Caminata</option>
	<option value="Concierto">Concierto</option>
	<option value="Construcción">Construcción</option>
	<option value="Emergencias">Emergencias</option>
	<option value="Limpieza">Limpieza</option>
	<option value="Recolecta">Recolecta</option>
	<option value="Salud">Salud</option>
    </select><br />

	<label for="tipofrecuencia">Tipo Frecuencia:</label>
	<select name="tipofrecuencia">
		<option value="puntual">Puntual</option>
		<option value="diario">Diario</option>
		<option value="semanal">Semanal</option>
		<option value="mensual">Mensual</option>
		<option value="anual">Anual</option>
		<option value="enespera">En Espera</option>
    </select><br />
	<!-- <input type="text" id="tipofrecuencia" name="tipofrecuencia" /> <br /> -->

	<label for="tipocompromiso">Tipo Compromiso:</label>
	<!-- <input type="text" id="tipocompromiso" name="tipocompromiso" /> <br /> -->
	<select name="tipocompromiso">
		<option value="puntual">Puntual</option>
		<option value="continuo">Continuo</option>
    </select> <br /> <br />

<?php
	require ('entrenamiento.php');
?>
	<!--<br /> <button onclick="require ('entrenamiento.php')">Agregar Entrenamiento</button> <br /> -->




	<?php /*
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
		or die('Error al intentar conexion con el servidor MySQL!');

	$query8 = "SELECT * FROM Entrenamiento";
	$result8 = mysqli_query($dbc, $query8)
		or die('Error al hacer query8 en la base de datos!');
	if (mysqli_num_rows($result8) !=0) {
		echo '<label for="entrenamiento">Entrenamiento 2:</label>';
		echo '<select name="entrenamiento" id="entrenamiento">' .
			 '<option value=" " selected="selected">entrenamiento</option>';
			while ($entrenamiento = mysqli_fetch_array($result8)) {
				echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
			}
			echo '</select> <br />';
	}
	$query9 = "SELECT * FROM Entrenamiento";
	$result9 = mysqli_query($dbc, $query9)
		or die('Error al hacer query9 en la base de datos!');
	if (mysqli_num_rows($result9) !=0) {
		echo '<label for="entrenamiento">Entrenamiento 3:</label>';
		echo '<select name="entrenamiento" id="entrenamiento">' .
			 '<option value=" " selected="selected">entrenamiento</option>';
			while ($entrenamiento = mysqli_fetch_array($result9)) {
				echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
			}
			echo '</select> <br />';
	} 
	mysqli_close($dbc);	
	*/
	?>

	<!-- <label for="entrenamiento1">Entrenamiento 1:</label>
	<input type="text" id="entrenamiento1" name="entrenamiento1" /> <br />

	<label for="entrenamiento2">Entrenamiento 2:</label>
	<input type="text" id="entrenamiento2" name="entrenamiento2" /> <br /> -->

	<label for="cantvoluntariossolicitado">Cantidad Voluntarios Solicitado:</label>
	<!-- <input type="text" id="cantvoluntariossolicitado" name="cantvoluntariossolicitado" /> <br /> -->
		<select name="cantvoluntariossolicitado">
		<option value="0">cantidad</option>
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
		<option value="32">32</option>
		<option value="33">33</option>
		<option value="34">34</option>
		<option value="35">35</option>
		<option value="36">36</option>
		<option value="37">37</option>
		<option value="38">38</option>
		<option value="38">38</option>
		<option value="38">38</option>
		<option value="39">39</option>
		<option value="40">40</option>
		<option value="41">41</option>
		<option value="42">42</option>
		<option value="43">43</option>
		<option value="44">44</option>
		<option value="45">45</option>
		<option value="46">46</option>
		<option value="47">47</option>
		<option value="48">48</option>
		<option value="49">49</option>
		<option value="50">50</option>
		<option value="51">51</option>
		<option value="52">52</option>
		<option value="53">53</option>
		<option value="54">54</option>
		<option value="55">55</option>
		<option value="56">56</option>
		<option value="57">57</option>
		<option value="58">58</option>
		<option value="59">59</option>
		<option value="60">60</option>
		<option value="61">61</option>
		<option value="62">62</option>
		<option value="63">63</option>
		<option value="64">64</option>
		<option value="65">65</option>
		<option value="66">66</option>
		<option value="67">67</option>
		<option value="68">68</option>
		<option value="69">69</option>
		<option value="70">70</option>
		<option value="71">71</option>
		<option value="72">72</option>
		<option value="73">73</option>
		<option value="74">74</option>
		<option value="75">75</option>
		<option value="80">80</option>
		<option value="85">85</option>
		<option value="90">90</option>
		<option value="95">95</option>
		<option value="100">100</option>
		<option value="125">125</option>
		<option value="150">150</option>
		<option value="175">175</option>
		<option value="200">200</option>
		<option value="250">250</option>
		<option value="300">300</option>
		<option value="350">350</option>
		<option value="400">400</option>
		<option value="450">450</option>
		<option value="500">500</option>
		<option value="550">550</option>
		<option value="600">600</option>
		<option value="700">700</option>
		<option value="700">700</option>
		<option value="800">800</option>
		<option value="900">900</option>
		<option value="1000">100</option>
		<option value="1500">1500</option>
		<option value="2000">2000</option>
		<option value="2500">2500</option>
		<option value="3000">3000</option>
		<option value="3500">3500</option>
		<option value="4000">4000</option>
		<option value="4500">4500</option>
		<option value="5000">5000</option>
		<option value="5500">5500</option>
		<option value="6000">6000</option>
		<option value="7000">7000</option>
		<option value="8000">8000</option>
		<option value="9000">9000</option>
		<option value="10000">10000</option>
		<option value="20000">20000</option>
		<option value="30000">30000</option>
		<option value="40000">40000</option>
		<option value="50000">50000</option>
		<option value="100000">100000</option>
		<option value="1000000">1000000</option>
		<option value="10000000">10000000</option>
		<option value="100000000">100000000</option>
		<option value="1000000000">1000000000</option>
	</select> <br /><br />

	<label for="descripcion">Descripción del Evento:</label><br />
	<textarea id="descripcion" name="descripcion" rows="8" cols="48"></textarea><br />

    <br />
	<input type="submit" value="Crear Evento" name="submit" /> <br/>
	</form>

<?php	
	}
?>


</body>
</html>