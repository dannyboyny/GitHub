<?php   //Proyecto de Voluntarios por Daniel Hernández 1999-0808 ISC PUCMM
  require_once('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulario de Organizaciones</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<!-- Container Principal -->
<div id="container">
 
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
	<br /><h3>Formulario para Registrar la Organización</h3>
	<p>Por Favor llenar este formulario para registrar la organización en esta página web:</p>
<?php
	require_once('connectvars.php');
	if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		$clave1 = $_POST['clave1'];
		$clave2 = $_POST['clave2'];
		$nombre_organizacion = $_POST['nombreorganizacion'];
		$output_form = false;

		if (empty($email)) {
			echo '<font color="red">*Debes digitar un email!</font><br />';
			$output_form = true;
		}

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo 'Email es valido!<br />';
		}else {
			echo '<font color="red">*Email no es valido!</font><br />';
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

		if (empty($nombre_organizacion)) {
			echo '<font color="red">*Debes digitar el nombre de la organizacion!</font><br />';
			$output_form = true;
		}
	}
	else {
		$output_form = true;
	}

	if (isset($_POST['tipoorganizacion'])) {
		$tipo_organizacion = $_POST['tipoorganizacion'];
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

	$tipo_usuario = 'Organizacion';

	if ((!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2) && (!empty($nombre_organizacion))) {
		$dbc1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
			or die('Error al intentar conexion con el servidor MySQL!');

		//Verificar que el email es único!
		$query1 = "SELECT * FROM Usuarios WHERE email = '$email'";
		$result1 = mysqli_query($dbc1, $query1);
		if (mysqli_num_rows($result1) == 0) {
			$query1 = "INSERT INTO Usuarios (email, clave, tipo_usuario, fecha_usuario_creado) " .
				"VALUES('$email', SHA('$clave1'), '$tipo_usuario', NOW())";
				//"VALUES('$email', '$clave1', '$tipo_usuario')";

			$result1 = mysqli_query($dbc1, $query1)
				or die('Error al hacer query1 en la base de datos!');
			$id_usuario = mysqli_insert_id($dbc1);

			echo 'Usuario Creado! <br />';

			$query2 = "INSERT INTO Organizaciones (id_usuario, nombre_organizacion, tipo_organizacion, " .
				"id_pais, provincia, ciudad, direccion, codigo_postal) " .
				"VALUES('$id_usuario', '$nombre_organizacion', '$tipo_organizacion', " .
				"'$id_pais', '$provincia', '$ciudad', '$direccion', '$codigo_postal')";

			$result2 = mysqli_query($dbc1, $query2)
				or die('Error al hacer query2 en la base de datos!');

			$id_organizacion = mysqli_insert_id($dbc1);

			echo 'Gracias ' . $nombre_organizacion . ' por completar el formulario! <br />';

			mysqli_close($dbc1);
		}else{
			echo '<font color="red">Ya existe una cuenta con este email!</font>';
			$email = ""; //borrar este email del formulario.
		}
	}

	if ($output_form) {
?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">	



		<p> Campos con * son obligatorios! </p>
		<!-- Datos de Usuarios -->
		<p> Digite su email y clave: </p>

		<label for="email">*Email:</label>
		<input type="text" id="email" name="email" /> <br />
		<label for="clave1">*Contraseña:</label>
		<input type="password" id="clave1" name="clave1" /> <br />
		<label for="clave2">*Repetir Contraseña:</label>
		<input type="password" id="clave2" name="clave2" /> <br />

		<!-- Datos de la Organizacion -->
		<p> Datos de la Organizacion: </p>
		<label for="nombreorganizacion">*Nombre de Organización:</label>
		<input type="text" id="nombreorganizacion" name="nombreorganizacion" /> <br />
		<label for="tipoorganizacion">Tipo de Organización:</label>
		<!-- <input type="text" id="tipoorganizacion" name="tipoorganizacion" /> <br /> -->
		<select name="tipoorganizacion">
			<option value="">tipo organización</option>
			<option value="con fines de lucro">con fines de lucro</option>
			<option value="sin fines de lucro">sin fines de lucro</option>
	    </select> <br />
		<!--
		<label for="tipousuario">Tipo de Usuario:</label>
		Voluntario <input id="tipousuario" name="tipousuario" type="radio" value="Voluntario" />
		Organizacion <input id="tipousuario" name="tipousuario" type="radio" value="Organizacion" /><br />
		-->
		<!-- Direcciones -->

		<!--
		<label for="nombrelugar">Nombre Lugar:</label>
		<input type="text" id="nombrelugar" name="nombrelugar" /> <br />
		-->
		<!--
		<label for="tipodireccion">Tipo Direccion:</label>
		<select name="tipodireccion">
		<option value=""></option>
		<option value="casa">Casa</option>
		<option value="apartamento">Apartamento</option>
		<option value="comercial">Comercial</option>
   		 </select><br />
   	 	-->
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
		<!-- <select name="id_pais">
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
			<option value="ntigua y Barbuda">Antigua y Barbuda</option>
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

		<!-- Telefonos -->
		<p> Información de Contacto: </p>
		<label for="tipotelefono1">Teléfono 1:</label>
		<select name="tipotelefono1">
			<option value="trabajo">Trabajo</option>
			<option value="celular">Celular</option>
			<option value="fax">Fax</option>
			<!-- <option value="casa">Casa</option> -->
			
	    </select>
		<input type="text" id="telefono1" name="telefono1" value="<?php if (isset($telefono1)) {echo $telefono1;} ?>" /> <br />
		<label for="tipotelefono2">Teléfono 2:</label>
		<select name="tipotelefono2">
			<option value="celular">Celular</option>
			<option value="trabajo">Trabajo</option>
			<option value="fax">Fax</option>
			<!-- <option value="casa">Casa</option> -->
	    </select>
		<input type="text" id="telefono2" name="telefono2" value="<?php if (isset($telefono2)) {echo $telefono2;} ?>" /> <br /> <br />


		<input type="submit" value="Registrarse" name="submit" /> <br/>
	</form>

<?php	
	}
?>

</body>
</html>