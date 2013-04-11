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
            <a href="http://localhost:8888/voluntarios/formvoluntario.php">Registrarse</a>                         
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