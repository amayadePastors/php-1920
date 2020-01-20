<HTML>
<HEAD> <TITLE> LISTADO EMPLEADOS EN UNA FECHA CONCRETA </TITLE>
</HEAD>
<BODY>
<h1>LISTADO EMPLEADOS EN UNA FECHA CONCRETA</h1>
<br/>
<br/>
<?php
require "funciones-generales.php";
require "funciones.php";
set_error_handler("errores");

/* Conexión BD */
$servername = "10.128.16.52";
$username = "root";
$password = "rootroot";
$dbname="empleados07";

$conn=conectarBD($servername, $username, $password, $dbname);

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 
	/* Se inicializa el formulario*/
	echo '<form action="" method="post">';
	?>
	<label for="fechalistado">SELECCIONE UN FECHA:</label>
	<input type='date' name='fechalistado' value=''><br/>
	<br/>
	<?php
	echo '<input type="submit" value="Mostrar Empleados"></div></form>';
} else {
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		$fechalistado= $_POST['fechalistado'];
		
	mostrarEmpleadosFecha($fechalistado,$conn);
	mysqli_close($conn);
}
?>

</FORM>
</BODY>
</HTML>
