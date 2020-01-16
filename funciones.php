<?php

function insertarBD($nombredep,$conn){
	$codigo=calcularCodigoDpto($conn);
	$sql = "INSERT INTO departamento (cod_dpto, nombre) VALUES ('$codigo', '$nombredep')";
	if (mysqli_query($conn, $sql)) {
		echo "Registro creado correctamente";
	} else {
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($conn));
	}
}

function calcularCodigoDpto($conn){
	$sql = "select lpad(max(substr(cod_dpto,2))+1,3,'0') as MAXIMO from departamento";
	$codigo;
	$max=mysqli_query($conn,$sql);
	if($max){
		if (mysqli_num_rows($max) < 1) {
			$codigo="D001";
		}else if (mysqli_num_rows($max) == 1) {
			$row =mysqli_fetch_assoc($max);
			$codigo="D".$row["MAXIMO"];
		} else {
			trigger_error("Error: " . $sql . "<br/>" . mysqli_error($conn));
			
		}
		return $codigo;
	}
	else{
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($conn));
	}
}	
	
function obtenerDepartamentos($conn) {
	$departamentos = array();
	$sql = "SELECT cod_dpto,nombre FROM departamento";
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row['nombre'];
		}
	}
	return $departamentos;
}

function obtenerEmpleados($conn){
	$empleados = array();
	
	$sql = "SELECT dni FROM empleado";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row['dni'];
		}
	}
	return $empleados;
}

function obtenerCodigoDep($conn, $nombredpto) {
	$idDepartamento = null;
	$sql = "SELECT cod_dpto FROM departamento WHERE nombre = '$nombredpto'";
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$idDepartamento = $row['cod_dpto'];
		}
	}
	return $idDepartamento;

}

function insertarEmpleado($dni,$nombre,$apellidos,$salario,$codigo,$fecha_nac,$fecha_ini,$conn){

	$sql2 = "INSERT INTO empleado (dni,nombre,apellidos,fecha_nac,salario) VALUES ('$dni','$nombre','$apellidos','$fecha_nac','$salario')";
	$sql3 =	"INSERT INTO emple_depart (dni,cod_dpto,fecha_ini) VALUES ('$dni','$codigo','$fecha_ini')";

	if (mysqli_query($conn, $sql2)) {
		echo "Registro creado correctamente <br/>";
	} else {
		trigger_error("Error: " . $sql2 . "<br/>" . mysqli_error($conn));
	}
	
	if (mysqli_query($conn, $sql3)) {
		echo "Registro creado correctamente";
	} else {
		trigger_error("Error: " . $sql3 . "<br/>" . mysqli_error($conn));
	}
}
function comprobarCambioDep($dni,$departamento,$conn){
	$hayCambio = true;
	$sql = "SELECT * FROM emple_depart WHERE dni = '$dni' and cod_dpto=(select cod_dpto from departamento where nombre='$departamento') and fecha_fin is NULL";
	$resultado = mysqli_query($conn, $sql);
	if($resultado){
		if (mysqli_num_rows($resultado)>0) 
				$hayCambio = false;
	}
	else{
		trigger_error("Error: " . $sql3 . "<br/>" . mysqli_error($conn));
	}
	return $hayCambio;
}

function cambiarEmpleado($dni,$codigo,$departamento,$conn){
	$sql1 = "update emple_depart set fecha_fin=sysdate() where dni='$dni' and fecha_fin is NULL";
	
	if (mysqli_query($conn, $sql1)) {
		echo "Empleado con DNI $dni dado de baja en el departamento anterior<br/>";
	} else {
		trigger_error("Error: " . $sql1 . "<br/>" . mysqli_error($conn));
	}
	
	$sql2 =	"INSERT INTO emple_depart (dni,cod_dpto,fecha_ini) VALUES ('$dni','$codigo',sysdate())";
	
	if (mysqli_query($conn, $sql2)) {
		echo "Empleado con DNI $dni dado de alta en el departamento $departamento <br/>";
	} else {
		trigger_error("Error: " . $sql2 . "<br/>" . mysqli_error($conn));
	}
}

function mostrarEmpleadosDepartamento($conn,$codigo,$departamento){
	$sql = "SELECT empleado.nombre, empleado.apellidos FROM empleado,emple_depart where empleado.dni=emple_depart.dni and emple_depart.cod_dpto='$codigo' and emple_depart.fecha_fin is NULL";
	$resultado = mysqli_query($conn, $sql);
	if($resultado){
		if (mysqli_num_rows($resultado) > 0) {
			echo "<table>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				 echo "<tr>".$row['nombre']." ".$row['apellidos']."</tr><br/>";
			}
			echo "</table>";
		} else {
			trigger_error("El departamento $departamento no tiene empleados.");	
		}
	}else{
		trigger_error("Error: " . $sql2 . "<br/>" . mysqli_error($conn));
	}
}

function mostrarHistoricoEmpleadosDepartamento($conn,$codigo,$departamento){
	$sql = "SELECT empleado.nombre, empleado.apellidos,emple_depart.fecha_ini,emple_depart.fecha_fin  FROM empleado,emple_depart where empleado.dni=emple_depart.dni and emple_depart.cod_dpto='$codigo' and emple_depart.fecha_fin is not NULL";
	$resultado = mysqli_query($conn, $sql);
	if($resultado){
		if (mysqli_num_rows($resultado) > 0) {
			echo "<table border=1px><tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA_INICIO</th><th>FECHA_FIN</th></tr>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				 echo "<tr>";
				 echo "<td>".$row['nombre']."</td>";
				 echo "<td>".$row['apellidos']."</td>";
				 echo "<td>".$row['fecha_ini']."</td>";
				 echo "<td>".$row['fecha_fin']."</td>";
				 echo "</tr>";
			}
			echo "</table>";
		} else {
			trigger_error("El departamento $departamento no tiene empleados en el historico.");	
		}
	}else{
		trigger_error("Error: " . $sql2 . "<br/>" . mysqli_error($conn));
	}
}
function cambiarSueldo($dni,$porcentaje,$conn){
	$sql = "update empleado set salario=salario+((salario*$porcentaje)/100) where dni='$dni'";
	
	if (mysqli_query($conn, $sql)) {
		echo "Se ha cambiado el sueldo al empleado con DNI $dni <br/>";
	} else {
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($conn));
	}
}

function mostrarEmpleadosFecha($fechalistado,$conn){
	$sql = "select empleado.nombre empnom,empleado.apellidos,departamento.nombre depnom,emple_depart.fecha_ini,emple_depart.fecha_fin from empleado,departamento,emple_depart where empleado.dni=emple_depart.dni and departamento.cod_dpto=emple_depart.cod_dpto and emple_depart.fecha_ini<='$fechalistado' and (emple_depart.fecha_fin>'$fechalistado' or emple_depart.fecha_fin is null)";
	$resultado = mysqli_query($conn, $sql);
	if($resultado){
		if (mysqli_num_rows($resultado) > 0) {
			echo "<table border=1px><tr><th>NOMBRE</th><th>APELLIDOS</th><th>DEPARTAMENTO</th><th>FECHA_INICIO</th><th>FECHA_FIN</th></tr>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				 echo "<tr>";
				 echo "<td>".$row['empnom']."</td>";
				 echo "<td>".$row['apellidos']."</td>";
				 echo "<td>".$row['depnom']."</td>";
				 echo "<td>".$row['fecha_ini']."</td>";
				 echo "<td>".$row['fecha_fin']."</td>";
				 echo "</tr>";
			}
			echo "</table>";
		} else {
			trigger_error("La empresa no tiene empleados en esa fecha.");	
		}
	}else{
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($conn));
	}
}

?>