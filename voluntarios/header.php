<?php   //Proyecto de Voluntarios por Daniel Hernández 1999-0808 ISC PUCMM
  require_once('connectvars.php');

  // Iniciar la sesión.
  session_start();

  // Borrar el mensaje de error.
  $error_msg = "";

  // Si el usuario no esta autenticado intentar de hacer la autenticación.
  if (!isset($_SESSION['id_usuario'])) {
    if (isset($_POST['submitlogin'])) {
      // Conectarse a la base de datos.
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Guardar el email y la contraseña.
      $email_user = mysqli_real_escape_string($dbc, trim($_POST['email']));
      $clave_user = mysqli_real_escape_string($dbc, trim($_POST['clave']));

      if (!empty($email_user) && !empty($clave_user)) {
        // Verificar el email y la contraseña en la base de datos.
        $query = "SELECT id_usuario, email, tipo_usuario FROM Usuarios WHERE email = '$email_user' AND clave = SHA('$clave_user')";
        //$query = "SELECT id_usuario, email, tipo_usuario FROM Usuarios WHERE email = '$email_user' AND clave = '$clave_user'";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 1) {
          // El email y la contraseña estan verificados.
          $row = mysqli_fetch_array($result);
          $_SESSION['id_usuario'] = $row['id_usuario'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
          setcookie('id_usuario', $row['id_usuario'], time() + (60 * 60 * 24 * 30));    // Se expira en 30 días.
          setcookie('email', $row['email'], time() + (60 * 60 * 24 * 30));  // Se expira en 30 días.
          setcookie('tipo_usuario', $row['tipo_usuario'], time() + (60 * 60 * 24 * 30));  // Se expira en 30 días.
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
        else {
          $error_msg = 'El email o la contraseña no es valido!';
        }
      }
      else {
        $error_msg = 'Debes digitar su email y contraseña!';
      }
    }
  }
?>