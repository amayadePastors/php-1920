<?php

require "funciones-generales.php";
require "funciones.php";
set_error_handler("errores");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nombredep= limpiarCampo($_POST['nombredep']);
}

$servername = "10.128.16.52";
$username = "root";
$password = "rootroot";
$dbname="empleados07";

$conn=conectarBD($servername, $username, $password, $dbname);
insertarBD($nombredep,$conn);
mysqli_close($conn);

?>
