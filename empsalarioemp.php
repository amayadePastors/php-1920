<HTML>
<HEAD> <TITLE> CAMBIAR SUELDO EMPLEADO </TITLE>
</HEAD>
<BODY>
<h1>CAMBIAR SUELDO EMPLEADO</h1>
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
	<label for="porcentaje">Introduce el porcentaje a incrementar o decrementar:</label>
	<input type='text' name='porcentaje' value='' size=5><br/>
	<br/>
	<br/>
	<?php
	echo '<div><input type="submit" value="Actualizar Salario"></div>
	</form>';
} else {
	$dni=($_POST['dni']);
	$porcentaje= limpiarCampo($_POST['porcentaje']);
	cambiarSueldo($dni,$porcentaje,$conn);
	mysqli_close($conn);	
}
?>

</FORM>
</BODY>
</HTML>
