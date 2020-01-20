<HTML>
<HEAD> <TITLE> LISTADO HISTORICO EMPLEADOS POR DEPARTAMENTO </TITLE>
</HEAD>
<BODY>
<h1>LISTADO HISTORICO EMPLEADOS POR DEPARTAMENTO</h1>
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
	/*Función que obtiene los departamentos de la empresa*/
	$departamentos = obtenerDepartamentos($conn);
	
	/* Se inicializa el formulario*/
	echo '<form action="" method="post">';
	?>
	<label for="departamento">DEPARTAMENTO:</label>
	<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select>
	<?php
	echo '<div><input type="submit" value="Mostrar Empleados"></div>
	</form>';
} else {

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		$departamento= $_POST['departamento'];
	
	$codigo=obtenerCodigoDep($conn, $departamento);
	mostrarHistoricoEmpleadosDepartamento($conn,$codigo,$departamento);
	mysqli_close($conn);
}
?>

</FORM>
</BODY>
</HTML>
