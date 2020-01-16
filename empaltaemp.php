<HTML>
<HEAD> <TITLE> ALTA EMPLEADO </TITLE>
</HEAD>
<BODY>
<h1>ALTA EMPLEADO</h1>
<br/>
<br/>
<?php
require "funciones-generales.php";
require "funciones.php";
set_error_handler("errores");

/* Conexión BD */
$servername = "localhost";
$username = "root";
$password = "rootroot";
$dbname="empleados07";

$conn=conectarBD($servername, $username, $password, $dbname);

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 
	/*Función que obtiene los departamentos de la empresa*/
	$departamentos = obtenerDepartamentos($conn);
	
	/* Se inicializa el formulario*/
	echo '<form action="" method="post">';
	?>
	<label for="dni">DNI:</label>
	<input type='text' name='dni' value='' size=9><br/>
	<br/>
	<label for="nombre">NOMBRE:</label>
	<input type='text' name='nombre' value='' size=40><br/>
	<br/>
	<label for="apellidos">APELLIDOS:</label>
	<input type='text' name='apellidos' value='' size=40><br/>
	<br/>
	<label for="fchnacimiento">FECHA DE NACIMIENTO:</label>
	<input type='date' name='fchnacimiento' value='' size=15><br/>
	<br/>
	<label for="salario">SALARIO:</label>
	<input type='number' name='salario' value='' size=15><br/>
	<br/>
	<label for="departamento">DEPARTAMENTO:</label>
	<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select>
	<br/>
	<label for="fchinicio">FECHA DE INICIO:</label>
	<input type='date' name='fchinicio' value='' size=15><br/>
	<br/>
	<br/>

	<?php
	echo '<div><input type="submit" value="Dar de alta Empleado"></div>
	</form>';
} else {

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$dni=limpiarCampo($_POST['dni']);
		$nombre= limpiarCampo($_POST['nombre']);
		$apellidos= limpiarCampo($_POST['apellidos']);
		$salario= limpiarCampo($_POST['salario']);
		$departamento= $_POST['departamento'];
		$fecha_nac=$_POST['fchnacimiento'];
		$fecha_ini=$_POST['fchinicio'];
	}
	$codigo=obtenerCodigoDep($conn, $departamento);
	insertarEmpleado($dni,$nombre,$apellidos,$salario,$codigo,$fecha_nac,$fecha_ini,$conn);
	mysqli_close($conn);
}
?>

</FORM>
</BODY>
</HTML>