<HTML>
<HEAD> <TITLE> CAMBIAR EMPLEADO DE DEPARTAMENTO </TITLE>
</HEAD>
<BODY>
<h1>CAMBIAR EMPLEADO DE DEPARTAMENTO</h1>
<br/>
<br/>
<?php
require "funciones-generales.php";
require "funciones.php";
set_error_handler("errores");

/* Conexión BD */
$servername = "10.130.7.110";
$username = "root";
$password = "rootroot";
$dbname="empleados07";

$conn=conectarBD($servername, $username, $password, $dbname);

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 
	/*Función que obtiene los departamentos de la empresa*/
	$departamentos = obtenerDepartamentos($conn);
	/*Función que obtiene los DNIs de los empleados de la empresa*/
	$empleados = obtenerEmpleados($conn);
	
	/* Se inicializa el formulario*/
	echo '<form action="" method="post">';
?>
	<label for="dni">DNI:</label>
	<select name="dni">
		<?php foreach($empleados as $empleado) : ?>
			<option> <?php echo $empleado ?> </option>
		<?php endforeach; ?>
	</select>
	<br/>
	<br/>
	<label for="departamento">DEPARTAMENTO:</label>
	<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select>
	<br/>
	<br/>
	<?php
	echo '<div><input type="submit" value="Cambiar Departamento"></div>
	</form>';
} else {
	$dni=$_POST['dni'];
	$departamento= $_POST['departamento'];
	$hayCambio=comprobarCambioDep($dni,$departamento,$conn);
	 if (!$hayCambio) {
		trigger_error("No hay cambio de departamento");
	 }else{
		$codigo=obtenerCodigoDep($conn, $departamento);
		cambiarEmpleado($dni,$codigo,$departamento,$conn);
		mysqli_close($conn);
	}
}
?>

</FORM>
</BODY>
</HTML>
