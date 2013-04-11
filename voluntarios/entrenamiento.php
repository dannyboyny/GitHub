<?php
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
		or die('Error al intentar conexion con el servidor MySQL!');

	$query7 = "SELECT * FROM Entrenamiento";
	$result7 = mysqli_query($dbc, $query7)
		or die('Error al hacer query7 en la base de datos!');

	if (mysqli_num_rows($result7) !=0) {
		echo '<label for="entrenamiento1">Entrenamiento Requerido:</label>';
		echo '<select name="entrenamiento1" id="entrenamiento1">' .
			 '<option value="sin entrenamiento" selected="selected">entrenamiento</option>';
			while ($entrenamiento = mysqli_fetch_array($result7)) {
				echo '<option value="' . $entrenamiento['nombre_entrenamiento'] . ' ">' . $entrenamiento['nombre_entrenamiento'] . '</option>';
			}
			echo '</select> <br />';
	}

	mysqli_close($dbc);	
?>