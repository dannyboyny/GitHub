<?php   //Proyecto de Voluntarios por Daniel Hernández 1999-0808 ISC PUCMM
  require_once('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulario para Registrarse</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
  require_once('login.php');
?>
	<br /><h3>Formulario para Registrar Voluntario</h3>
	<p>Por Favor llenar este formulario para registrarse en esta página web:</p>

<?php
	require_once('connectvars.php');
	if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		$clave1 = $_POST['clave1'];
		$clave2 = $_POST['clave2'];
		$primer_nombre = $_POST['primernombre'];
		$primer_apellido = $_POST['primerapellido'];
		$output_form = false;

		if (empty($email)) {
			echo '<font color="red">*Debes digitar un email!</font><br />';
			$output_form = true;
		}

		if (empty($clave1)) {
			echo '<font color="red">*Debes digitar una clave!</font><br />';
			$output_form = true;
		}

		if (empty($clave2)) {
			echo '<font color="red">*Debes repetir la clave!</font><br />';
			$output_form = true;
		}

		if ($clave1 != $clave2) {
			echo '<font color="red">*La claves deben ser iguales!</font><br />';
			$output_form = true;
		}

		if (empty($primer_nombre)) {
			echo '<font color="red">*Debes digitar su primer nombre!</font><br />';
			$output_form = true;
		}

		if (empty($primer_apellido)) {
			echo '<font color="red">*Debes digitar su primer apellido!</font><br />';
			$output_form = true;
		}

	}
	else {
		$output_form = true;
	}

	/* Datos de Voluntarios */
	if (isset($_POST['segundonombre'])) {
		$segundo_nombre = $_POST['segundonombre'];
	}else {
		$segundo_nombre = NULL;
	}
	if (isset($_POST['segundoapellido'])) {
		$segundo_apellido = $_POST['segundoapellido'];
	}else {
		$segundo_apellido = NULL;
	}
	
	if (isset($_POST['sexo'])) {
		$sexo = $_POST['sexo'];
	}else {
		$sexo = NULL;
	}

	if ((isset($_POST['ano'])) && (isset($_POST['mes'])) && (isset($_POST['dia']))) {
		$fecha_nacimiento = $_POST['ano'] . '-' . $_POST['mes'] . '-' . $_POST['dia'];
	}
	
	if (isset($_POST['ciudadnacimiento'])) {
		$ciudad_nacimiento = $_POST['ciudadnacimiento'];
	}
	if (isset($_POST['nacionalidad'])) {
		$nacionalidad = $_POST['nacionalidad'];
	}
	
	if (isset($_POST['estadocivil'])) {
		$estado_civil = $_POST['estadocivil'];
	}

	if (isset($_POST['niveleducacion'])) {
		$nivel_educacion = $_POST['niveleducacion'];
	}

	if (isset($_POST['ocupacion'])) {
		$id_ocupacion = $_POST['ocupacion'];
	}

	if (isset($_POST['tiposangre'])) {
		$tipo_sangre = $_POST['tiposangre'];
	}
	
	if (isset($_POST['esconductor'])) {
		$es_conductor = $_POST['esconductor'];
	}else{
		$es_conductor = NULL;
	}
	if (isset($_POST['vehiculopropio'])) {
		$vehiculo_propio = $_POST['vehiculopropio'];
	}else{
		$vehiculo_propio = NULL;
	}
	if (isset($_POST['brigada'])) {
		$brigada = $_POST['brigada'];
	}
	if (isset($_POST['rango'])) {
		$rango = $_POST['rango'];
	}
	
	if (isset($_POST['estaactivo'])) {
		$esta_activo = $_POST['estaactivo'];
	}else{
		$esta_activo = NULL;
	}
	if (isset($_POST['tipodireccion'])) {
		$tipo_direccion = $_POST['tipodireccion'];
	}
	
	if (isset($_POST['pais'])) {
		$id_pais = $_POST['pais'];
	}
	if (isset($_POST['provincia'])) {
		$provincia = $_POST['provincia'];
	}
	if (isset($_POST['direccion'])) {
		$direccion = $_POST['direccion'];
	}
	if (isset($_POST['nombreciudad'])) {
		$ciudad = $_POST['nombreciudad'];
	}
	if (isset($_POST['codigopostal'])) {
		$codigo_postal = $_POST['codigopostal'];
	}

	if (isset($_POST['entrenamiento'])) {
		$nombre_entrenamiento = $_POST['entrenamiento'];
	}

	if (isset($_POST['tipoentrenamiento'])) {
		$tipo_entrenamiento = $_POST['tipoentrenamiento'];
	}
	if (isset($_POST['escertificado'])) {
		$es_certificado = $_POST['escertificado'];
	}
	if ((isset($_POST['anocert'])) && (isset($_POST['mescert'])) && (isset($_POST['diacert']))) {
		$fecha_certificado = $_POST['anocert'] . '-' . $_POST['mescert'] . '-' . $_POST['diacert'];
	}
	if (isset($_POST['tipoidentificacion'])) {
		$tipo_identificacion = $_POST['tipoidentificacion'];
	}
	if (isset($_POST['numidentificacion'])) {
		$num_identificacion = $_POST['numidentificacion'];
	}
	if (isset($_POST['tipotelefono1'])) {
		$tipo_telefono1 = $_POST['tipotelefono1'];
	}
	if (isset($_POST['telefono1'])) {
		$telefono1 = $_POST['telefono1'];
	}
	if (isset($_POST['tipotelefono2'])) {
		$tipo_telefono2 = $_POST['tipotelefono2'];
	}
	if (isset($_POST['telefono2'])) {
		$telefono2 = $_POST['telefono2'];
	}
	if (isset($_POST['bbpin'])) {
		$BB_PIN = $_POST['bbpin'];
	}

	$tipo_usuario = 'Voluntario';



	if ((!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2)) {
		$dbc1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		//Verificar que el email es único!
		$query = "SELECT * FROM Usuarios WHERE email = '$email'";
		$result = mysqli_query($dbc1, $query);
		if (mysqli_num_rows($result) == 0) {
			$query1 = "INSERT INTO Usuarios (email, clave, tipo_usuario, fecha_usuario_creado) " .
				"VALUES('$email', SHA('$clave1'), '$tipo_usuario', NOW())";
				//"VALUES('$email', '$clave1', '$tipo_usuario')";

			$result1 = mysqli_query($dbc1, $query1)
				or die('Error al hacer query1 en la base de datos!');

			$id_usuario = mysqli_insert_id($dbc1);

			echo '<font color="green">Usuario Creado! </font><br />';
			//echo "$id_usuario <br />";
			mysqli_close($dbc1);
		}else{
			echo '<font color="red">Ya existe una cuenta con este email!</font>';
			$email = ""; //borrar este email del formulario.
		}
	}

	if ((!empty($primer_nombre)) && (!empty($primer_apellido)) && (!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2)) {
		$dbc2 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query2 = "INSERT INTO Voluntarios (id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, " .
			"sexo, fecha_nacimiento, ciudad_nacimiento, nacionalidad, estado_civil, nivel_educacion, id_ocupacion, " . 
			"tipo_sangre, es_conductor, vehiculo_propio, brigada, rango, esta_activo, " .
			"tipo_direccion, id_pais, provincia, ciudad, direccion, codigo_postal) " .
			"Values('$id_usuario', '$primer_nombre', '$segundo_nombre', '$primer_apellido', '$segundo_apellido', '$sexo', " .
			"'$fecha_nacimiento', '$ciudad_nacimiento', '$nacionalidad', '$estado_civil', '$nivel_educacion', '$id_ocupacion', " .
			"'$tipo_sangre', '$es_conductor', '$vehiculo_propio', '$brigada', '$rango', '$esta_activo', " .
			"'$tipo_direccion', '$id_pais', '$provincia', '$ciudad', '$direccion', '$codigo_postal')";

		$result2 = mysqli_query($dbc2, $query2)
			or die('Error al hacer query2 en la base de datos!');

		$id_voluntario = mysqli_insert_id($dbc2);

		echo 'Gracias ' . $primer_nombre . ' por completar el formulario! <br />';

		mysqli_close($dbc2);
	}

	if ((!empty($nombre_entrenamiento)) && (!empty($primer_nombre)) && (!empty($primer_apellido)) && (!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2)) {
		$dbc3 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query3 = "INSERT INTO `Entrenamiento_Voluntario` (id_entrenamiento, id_voluntario) " .
				  "VALUES((SELECT `Entrenamiento`.`id_entrenamiento` FROM `Entrenamiento` " .
				  "WHERE `Entrenamiento`.`nombre_entrenamiento` = '$nombre_entrenamiento'), '$id_voluntario')";

		$result3 = mysqli_query($dbc3, $query3)
			or die('Error al hacer query3 en la base de datos!');



		/* $query3 = "INSERT INTO Entrenamiento (nombre_entrenamiento)" .
			"VALUES('$nombre_entrenamiento')";

		$result3 = mysqli_query($dbc3, $query3)
			or die('Error al hacer query3 en la base de datos!');
		$id_habilidad = mysqli_insert_id($dbc3);

		$query4 = "INSERT INTO Entrenamiento_Voluntario (id_entrenamiento, id_voluntario)" .
			"VALUES('$id_entrenamiento', '$id_voluntario')";

		$result4 = mysqli_query($dbc3, $query4)
			or die('Error al hacer query4 en la base de datos!');
		*/
		echo 'Entrenamiento Guardado! <br />';

		mysqli_close($dbc3);
	}

	if ((!empty($num_identificacion)) && (!empty($primer_nombre)) && (!empty($primer_apellido)) && (!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2)) {
		$dbc4 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query5 = "INSERT INTO Identificaciones (tipo_identificacion)" .
			"VALUES('$tipo_identificacion')";

		$result5 = mysqli_query($dbc4, $query5)
			or die('Error al hacer query5 en la base de datos!');
		$id_identificacion = mysqli_insert_id($dbc4);

		$query6 = "INSERT INTO Identificacion_Voluntario (id_identificacion, id_voluntario, num_identificacion)" .
			"VALUES('$id_identificacion', '$id_voluntario', '$num_identificacion')";

		$result6 = mysqli_query($dbc4, $query6)
			or die('Error al hacer query6 en la base de datos!');

		echo $tipo_identificacion . " Guardada! <br />";
		mysqli_close($dbc4);
	}

	if ((!empty($telefono1)) && (!empty($primer_nombre)) && (!empty($primer_apellido)) && (!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2)) {
		$dbc5 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query7 = "INSERT INTO Telefonos (telefono, tipo_telefono)" .
			"VALUES('$telefono1', '$tipo_telefono1')";
		$result7 = mysqli_query($dbc5, $query7)
			or die('Error al hacer query7 en la base de datos!');

		if ($tipo_telefono1 == 'celular') {
			$query8 = "INSERT INTO Telefono_Usuario (telefono, id_usuario, BB_PIN)" .
				"VALUES('$telefono1', '$id_usuario', '$BB_PIN')";
			$result8 = mysqli_query($dbc5, $query8)
				or die('Error al hacer query8 en la base de datos!');
		}
		else {
			$query8 = "INSERT INTO Telefono_Usuario (telefono, id_usuario)" .
				"VALUES('$telefono1', '$id_usuario')";
			$result8 = mysqli_query($dbc5, $query8)
				or die('Error al hacer query8 en la base de datos!');
		}
		
		echo 'Teléfono de ' . $tipo_telefono1 . ' Guardado! <br />';
		mysqli_close($dbc5);
	}

	if ((!empty($telefono2)) && (!empty($primer_nombre)) && (!empty($primer_apellido)) && (!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2)) {
		$dbc6 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query9 = "INSERT INTO Telefonos (telefono, tipo_telefono)" .
			"VALUES('$telefono2', '$tipo_telefono2')";
		$result9 = mysqli_query($dbc6, $query9)
			or die('Error al hacer query9 en la base de datos!');

		if ($tipo_telefono2 == 'celular') {
			$query10 = "INSERT INTO Telefono_Usuario (telefono, id_usuario, BB_PIN)" .
				"VALUES('$telefono2', '$id_usuario', '$BB_PIN')";
			$result10 = mysqli_query($dbc6, $query10)
				or die('Error al hacer query10 en la base de datos!');
		}
		else {
			$query10 = "INSERT INTO Telefono_Usuario (telefono, id_usuario)" .
				"VALUES('$telefono2', '$id_usuario')";
			$result10 = mysqli_query($dbc6, $query10)
				or die('Error al hacer query10 en la base de datos!');			
		}


		echo 'Teléfono de ' . $tipo_telefono2 . ' Guardado! <br />';
		mysqli_close($dbc6);
	}
	

	if ($output_form) {
?>


	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<p> Campos con * son obligatorios! </p>
		<!-- Datos de Usuarios -->
		<p> Digite su email y contraseña: </p>

		<label for="email">*Email:</label>
		<input type="text" id="email" name="email" value="<?php if (isset($email)) {echo $email;} ?>" /> <br />
		<label for="clave1">*Contraseña:</label>
		<input type="password" id="clave1" name="clave1" value="<?php if (isset($clave1)) {echo $clave1;} ?>" /> <br />
		<label for="clave2">*Repetir Contraseña:</label>
		<input type="password" id="clave2" name="clave2" value="<?php if (isset($clave2)) {echo $clave2;} ?>" /> <br />

		<!-- Datos de Voluntarios -->
		<p> Datos del Voluntario: </p>
		<label for="primernombre">*Primer Nombre:</label>
		<input type="text" id="primernombre" name="primernombre" value="<?php if (isset($primer_nombre)) {echo $primer_nombre;} ?>" /> <br />
		<label for="segundonombre">Segundo Nombre:</label>
		<input type="text" id="segundonombre" name="segundonombre" value="<?php if (isset($segundo_nombre)) {echo $segundo_nombre;} ?>" /> <br />
		<label for="primerapellido">*Primer Apellido:</label>
		<input type="text" id="primerapellido" name="primerapellido" value="<?php if (isset($primer_apellido)) {echo $primer_apellido;} ?>" /> <br />
		<label for="segunoapellido">Segundo Apellido:</label>
		<input type="text" id="segundoapellido" name="segundoapellido" value="<?php if (isset($segundo_apellido)) {echo $segundo_apellido;} ?>" /> <br />
		<label for="sexo">Sexo:</label>
		M <input id="sexo" name="sexo" type="radio" value="M" />
		F <input id="sexo" name="sexo" type="radio" value="F" /><br />	

		<label for="fechanacimiento">Fecha de Nacimiento:</label>
		<!-- <label for="dia">Dia:</label> -->
		<select name="dia">
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
		<select name="mes">
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
		<select name="ano">
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
			<option value="1959">1959</option>
			<option value="1958">1958</option>
			<option value="1957">1957</option>
			<option value="1956">1956</option>
			<option value="1955">1955</option>
			<option value="1954">1954</option>
			<option value="1953">1953</option>
			<option value="1952">1952</option>
			<option value="1951">1951</option>
			<option value="1950">1950</option>
			<option value="1949">1949</option>
			<option value="1948">1948</option>
			<option value="1947">1947</option>
			<option value="1946">1946</option>
			<option value="1945">1945</option>
			<option value="1944">1944</option>
			<option value="1943">1943</option>
			<option value="1942">1942</option>
			<option value="1941">1941</option>
			<option value="1940">1940</option>
			<option value="1939">1939</option>
			<option value="1938">1938</option>
			<option value="1937">1937</option>
			<option value="1936">1936</option>
			<option value="1935">1935</option>
			<option value="1934">1934</option>
			<option value="1933">1933</option>
			<option value="1932">1932</option>
			<option value="1931">1931</option>
			<option value="1930">1930</option>			
	    </select><br />


		<label for="ciudadnacimiento">Ciudad de Nacimiento:</label>
		<input type="text" id="ciudadnacimiento" name="ciudadnacimiento" value="<?php if (isset($ciudad_nacimiento)) {echo $ciudad_nacimiento;} ?>" /> <br />
		<label for="nacionalidad">*Nacionalidad:</label>

		<?php
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query10 = "SELECT nacionalidad FROM Paises";
		$result10 = mysqli_query($dbc, $query10)
			or die('Error al hacer query10 en la base de datos!');
		if (mysqli_num_rows($result10) !=0) {
			echo '<select name="nacionalidad" id="nacionalidad">' .
				 '<option value=" " selected="selected">nacionalidad</option>';
				while ($nacionalidad = mysqli_fetch_array($result10)) {
					echo '<option value="' . $nacionalidad['nacionalidad'] . ' ">' . $nacionalidad['nacionalidad'] . '</option>';
				}
				echo '</select> <br />';
		}

		mysqli_close($dbc);	
		?>

		<label for="estadocivil">Estado Civil:</label>
		<select name="estadocivil">
			<option value="">estado civil</option>
			<option value="Soltero">Soltero/a</option>
			<option value="Casado">Casado/a</option>
			<option value="Divorciado">Divorciado/a</option>
			<option value="Viudo">Viudo/a</option>
			<option value="Union Libre">Unión Libre</option>
			<option value="Separado">Separado/a</option>
	    </select><br />

	    <label for="niveleducacion">Nivel de Educación:</label>
		<select name="niveleducacion">
			<option value="">nivel educación</option>
			<option value="primaria">Primaria</option>
			<option value="bachiller">Bachiller</option>
			<option value="universitario">Universitario</option>
			<option value="maestria">Maestría</option>
			<option value="doctorado">Doctorado</option>
	    </select><br />

	 	<label for="ocupacion">Ocupación:</label>
		<?php
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query11 = "SELECT * FROM Ocupaciones";
		$result11 = mysqli_query($dbc, $query11)
			or die('Error al hacer query11 en la base de datos!');
		if (mysqli_num_rows($result11) !=0) {
			echo '<select name="ocupacion" id="ocupacion">' .
				 '<option value=" " selected="selected">ocupación</option>';
				while ($ocupacion = mysqli_fetch_array($result11)) {
					echo '<option value="' . $ocupacion['id_ocupacion'] . ' ">' . $ocupacion['ocupacion'] . '</option>';
				}
				echo '</select> <br />';
		}
		mysqli_close($dbc);	
		?>

		<label for="tiposangre">Tipo de Sangre:</label>
		<select name="tiposangre">
			<option value="">tipo sangre</option>
			<option value="O+">O+</option>
			<option value="A+">A+</option>
			<option value="B+">B+</option>
			<option value="AB+">AB+</option>
			<option value="O-">O-</option>
			<option value="A-">A-</option>
			<option value="B-">B-</option>
			<option value="AB-">AB-</option>
	    </select><br />

		<label for="esconductor">¿Sabes Conducir?</label>
		Si <input id="esconductor" name="esconductor" type="radio" value="Si" />
		No <input id="esconductor" name="esconductor" type="radio" value="No" /><br />
		<label for="vehiculopropio">¿Tienes vehículo propio?</label>
		Si <input id="vehiculopropio" name="vehiculopropio" type="radio" value="Si" />
		No <input id="vehiculopropio" name="vehiculopropio" type="radio" value="No" /><br />
		<p> Información sobre voluntariado: </p>
		<label for="brigada">Nombre Brigada:</label>
		<input type="text" id="brigada" name="brigada" value="<?php if (isset($brigada)) {echo $brigada;} ?>" /> <br />
		<label for="rango">Rango Actual:</label>
		<input type="text" id="rango" name="rango" value="<?php if (isset($rango)) {echo $rango;} ?>" /> <br />
		<label for="estaactivo">¿Es voluntario activo?</label>
		Si <input id="estaactivo" name="estaactivo" type="radio" value="Si" />
		No <input id="estaactivo" name="estaactivo" type="radio" value="No" /><br />	


		<!-- Direcciones -->
		<p> Digite su dirección: </p>

		<label for="tipodireccion">Tipo Dirección:</label>
		<select name="tipodireccion">
			<option value="">tipo dirección</option>
			<option value="casa">Casa</option>
			<option value="apartamento">Apartamento</option>
	    </select><br />

	    <label for="pais">*País:</label>
		<?php
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query12 = "SELECT * FROM Paises";
		$result12 = mysqli_query($dbc, $query12)
			or die('Error al hacer query12 en la base de datos!');
		if (mysqli_num_rows($result12) !=0) {
			echo '<select name="pais" id="pais">' .
				 '<option value=" " selected="selected">país</option>';
				while ($pais = mysqli_fetch_array($result12)) {
					echo '<option value="' . $pais['id_pais'] . ' ">' . $pais['nombre_pais'] . '</option>';
				}
				echo '</select> <br />';
		}

		mysqli_close($dbc);	
		?>
		<!--<select name="pais">
			<option value="">seleccionar país</option>
			<option value="Republica Dominicana<">República Dominicana</option>
			<option value="Estados Unidos">Estados Unidos</option>
			<option value="Haiti">Haití</option>
			<option value="Afganistan">Afganistán</option>
			<option value="Africa del Sur">Africa del Sur</option>
			<option value="Albania">Albania</option>
			<option value="Alemania">Alemania</option>
			<option value="Andorra">Andorra</option>
			<option value="Angola">angola</option>
			<option value="Antigua y Barbuda">Antigua y Barbuda</option>
			<option value="Antillas Holandesas">Antillas Holandesas</option>
			<option value="Arabia Saudita">Arabia Saudita</option>
			<option value="Argelia">Argelia</option>
			<option value="Argentina">Argentina</option>
			<option value="Armenia">Armenia</option>
			<option value="Aruba">Aruba</option>
			<option value="Australia">Australia</option>
			<option value="Austria">Austria</option>
			<option value="Azerbaijan">Azerbaiyán</option>
			<option value="Bahamas">Bahamas</option>
			<option value="Bahrain">Bahrain</option>
			<option value="Bangladesh">Bangladesh</option>
			<option value="Barbados">Barbados</option>
			<option value="Belarusia">Belarusia</option>
			<option value="Belgica">Bélgica</option>
			<option value="Belice">Belice</option>
			<option value="Benin">Benín</option>
			<option value="Bermudas">Bermudas</option>
			<option value="Bolivia">Bolivia</option>
			<option value="Bosnia">Bosnia</option>
			<option value="Botswana">Botswana</option>
			<option value="Brasil">Brasil</option>
			<option value="Brunei Darussulam">Brunei Darussulam</option>
			<option value="Bulgaria">Bulgaria</option>
			<option value="Burkina Faso">Burkina Faso</option>
			<option value="Burundi">Burundi</option>
			<option value="Butan">Bután</option>
			<option value="Camboya">Camboya</option>
			<option value="Camerun">Camerún</option>
			<option value="Canada">Canada</option>
			<option value="Cape Verde">Cape Verde</option>
			<option value="Chad">Chad</option>
			<option value="Chile">Chile</option>
			<option value="China">China</option>
			<option value="Chipre">Chipre</option>
			<option value="Colombia">Colombia</option>
			<option value="Comoros">Comoros</option>
			<option value="Congo">Congo</option>
			<option value="Corea del Norte">Corea del Norte</option>
			<option value="Corea del Sur">Corea del Sur</option>
			<option value="Costa de Marfil">Costa de Marfil</option>
			<option value="Costa Rica">Costa Rica</option>
			<option value="Croasia">Croasia</option>
			<option value="Cuba">Cuba</option>
			<option value="Dinamarca">Dinamarca</option>
			<option value="Djibouti">Djibouti</option>
			<option value="Dominica">Dominica</option>
			<option value="Ecuador">Ecuador</option>
	    </select><br /> -->

		<label for="provincia">Provincia/Estado:</label>
		<input type="text" id="provincia" name="provincia" value="<?php if (isset($provincia)) {echo $provincia;} ?>" /> <br />
		<!-- <select name="provincia">
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
	    </select><br />
		-->
		<label for="direccion">Dirección:</label>
		<input type="text" id="direccion" name="direccion" value="<?php if (isset($direccion)) {echo $direccion;} ?>" /> <br />
 		<label for="nombreciudad">Ciudad:</label>
		<input type="text" id="nombreciudad" name="nombreciudad" value="<?php if (isset($nombre_ciudad)) {echo $nombre_ciudad;} ?>" /> <br />
		<label for="codigopostal">Código Postal:</label>
		<input type="text" id="codigopostal" name="codigopostal" value="<?php if (isset($codigo_postal)) {echo $codigo_postal;} ?>" /> <br />  


		<!-- Entrenamientos -->
		<p> Certificaciones o Entrenamientos: </p>
		<?php

		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		$query13 = "SELECT * FROM Entrenamiento";
		$result13 = mysqli_query($dbc, $query13)
			or die('Error al hacer query13 en la base de datos!');
		if (mysqli_num_rows($result13) !=0) {
			echo '<label for="entrenamiento">Entrenamiento:</label>';
			echo '<select name="entrenamiento" id="entrenamiento">' .
				 '<option value="sin entrenamiento" selected="selected">entrenamiento</option>';
			while ($entrenamiento = mysqli_fetch_array($result13)) {
				echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
			}
			echo '</select> <br />';
		}
		/*
		$query14 = "SELECT * FROM Entrenamiento";
		$result14 = mysqli_query($dbc, $query14)
			or die('Error al hacer query14 en la base de datos!');
		if (mysqli_num_rows($result14) !=0) {
			echo '<label for="entrenamiento">Entrenamiento 2:</label>';			
			echo '<select name="entrenamiento" id="entrenamiento">' .
				 '<option value=" " selected="selected">entrenamiento 2</option>';
				while ($entrenamiento = mysqli_fetch_array($result14)) {
					echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
				}
				echo '</select> <br />';
		}

		$query15 = "SELECT * FROM Entrenamiento";
		$result15 = mysqli_query($dbc, $query15)
			or die('Error al hacer query15 en la base de datos!');
		if (mysqli_num_rows($result15) !=0) {
			echo '<label for="entrenamiento">Entrenamiento 3:</label>';
			echo '<select name="entrenamiento" id="entrenamiento">' .
				 '<option value=" " selected="selected">entrenamiento 3</option>';
			while ($entrenamiento = mysqli_fetch_array($result15)) {
				echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
			}
			echo '</select> <br />';
		}
		*/
		mysqli_close($dbc);	
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

		<!-- Identificaciones -->
		<p> Identificacion: </p>
		<label for="tipoidentificacion">Tipo Identificación:</label>
		<select name="tipoidentificacion">
			<option value="cedula">Cédula</option>
			<option value="pasaporte">Pasaporte</option>
			<option value="licenciadeconducir">Licencia de Conducir</option>
	    </select><br />
		<label for="numidentificacion">Número Identificación:</label>
		<input type="text" id="numidentificacion" name="numidentificacion" value="<?php if (isset($num_identificacion)) {echo $num_identificacion;} ?>" /> <br />

		<!-- Telefonos -->
		<p> Información de Contacto: </p>
		<label for="tipotelefono1">Teléfono 1:</label>
		<select name="tipotelefono1">
			<option value="celular">Celular</option>
			<option value="casa">Casa</option>
			<option value="trabajo">Trabajo</option>
	    </select>
		<input type="text" id="telefono1" name="telefono1" value="<?php if (isset($telefono1)) {echo $telefono1;} ?>" /> <br />
		<label for="tipotelefono2">Teléfono 2:</label>
		<select name="tipotelefono2">
			<option value="casa">Casa</option>
			<option value="celular">Celular</option>
			<option value="trabajo">Trabajo</option>
	    </select>
		<input type="text" id="telefono2" name="telefono2" value="<?php if (isset($telefono2)) {echo $telefono2;} ?>" /> <br />
		<label for="bbpin">BB PIN:</label>
		<input type="text" id="bbpin" name="bbpin" value="<?php if (isset($BB_PIN)) {echo $BB_PIN;} ?>" /> <br />

		<br/>
		<input type="submit" value="Registrarse" name="submit" /> <br/>
	</form>

<?php	
	}
?>

</body>
</html>