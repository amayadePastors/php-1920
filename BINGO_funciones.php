<HTML>
<HEAD> <TITLE> Bingo </TITLE> </HEAD>

<BODY>
	<h1>Esto es un test de DOCKER </h1>
<?php

//generamos un array tridimensional vacío, con los nombres de jugadores y cartones como clave
$arrayjugadores=array("jugador1"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()),
"jugador2"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()),
"jugador3"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()),
"jugador4"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()));

//Array copia del anterior, para almacenar los aciertos
$aciertos=array("jugador1"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()),
"jugador2"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()),
"jugador3"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()),
"jugador4"=>array("carton1"=>array(),"carton2"=>array(),"carton3"=>array()));


rellenarCartones($arrayjugadores);
//esta funcion rellena los 3 cartones de cas jugador con números aleatorios de 1 a 60
function rellenarCartones(&$arrayjugadores){
	
	
	for($a=1; $a<5; $a++){
		$jugador="jugador".$a;
		for($j=1; $j<4; $j++){
			$carton="carton".$j;
			$numerossacados=array();//este array lo creamos para guardar los números que ya han salido para cada cartón, para que no se repitan
			for( $i=0; $i<15; $i++){
				$num=comprobarNumero($numerossacados);//comprobamos que el número no ha salido ya para ese cartón
				$numerossacados[$i]=$num;
				$arrayjugadores[$jugador][$carton][$i]=$num;
			 }
		}
	}
}
//esta función genera un número aleaotio y comprueba que el número no haya salido en ese cartón
function comprobarNumero($array){
	$num;
	do{
		$num=mt_rand(1,60);		
	}while(in_array($num, $array));
return $num;
}

//pintamos los cartones
foreach($arrayjugadores as $clave1 => $valor1){
	echo "<table border='1px'>";
	echo "<th colspan='5'>$clave1</th>";
	foreach ($valor1 as $clave => $valor){
		echo "<tr><th colspan='5'>CARTON</th></tr>";
		echo "<tr>";
		for($i=0;$i<15;$i++){
			rellenarCelda($valor, $i);//rellenamos el contenido de cada celda de los cartones
		}

	 }
	 echo "</table> <br/>";
 }
//rellenamos el contenido de cada celda de los cartones
function rellenarCelda($valor, $i){
	echo "<td> $valor[$i] </td>";
	if($i==4 ||$i==9 || $i==14){
		echo "</tr>";
		echo "<tr>";
	}
}

//rellenamos un array con las bolas del bombo aleatorio
$bombo=array();
for( $i=0; $i<60; $i++){

	$bola=comprobarNumero($bombo);
	$bombo[$i]=$bola;
}

//extraemos una a una las 60 bolas del bombo y las pintamos
sacarBola($bombo, $arrayjugadores, $aciertos);

function sacarBola($bombo, $arrayjugadores, &$aciertos){
	$esbingo=false;
	for($b=0; $b<count($bombo) && !$esbingo; $b++){
		echo "<img src='./img/$bombo[$b].png' width=40px>";
		//comprobamos si el número de la bola está en los cartones y si ha habido bingo
		$esbingo=comprobarBingo($bombo[$b],$arrayjugadores,$aciertos,$esbingo);
	}

}
//comprobamos si el número de la bola está en los cartones y si ha habido bingo
function comprobarBingo($numerobombo, $arrayjugadores, &$aciertos,$esbingo){
	for($a=1; $a<5; $a++){
		$jugador="jugador".$a;
		for($j=1; $j<4; $j++){
			$carton="carton".$j;
			for($i=0; $i<15; $i++){
				if($arrayjugadores[$jugador][$carton][$i]==$numerobombo){
					//Si el número está en el cartón x, rellenamos la posicion del carton x en el array $aciertos
					$aciertos [$jugador][$carton][$i]= -1;
				}	
			}
			//si el carton de aciertos está completo, ha habido bingo
			if(count($aciertos[$jugador][$carton])==15){
				echo"<br/><br>";
				echo"BINGO del " . $jugador . " en el ". $carton;
				$esbingo=true;	
			}
		//Comprobamos esa bola para todos los jugadores, para permitir que haya más de un ganador, en el caso de que ambos tengan ese número 
		//y ambos tengan 15 aciertos
		}
	}
	return $esbingo;
}
//pintamos la tabla con los aciertos
 echo"<br/><br/>";
 echo "<table border='1px'>";
 echo "<tr><th colspan='4'>ACIERTOS</th></tr>";
 echo "<tr>";
	 echo "<th></th>";
	 echo "<td> Carton 1 </td>";
	 echo "<td> Carton 2 </td>";
	 echo "<td> Carton 3 </td>";
	 echo "</tr>";

 foreach($aciertos as $clave=>$valor){
	 echo "<tr>";
	 echo "<th>". $clave ."</th>";
	 foreach($valor as $clave1=>$valor1){
		echo "<td>". count($valor1)." </td>";
	}
	 echo "</tr>";
 }
 echo "</table>";


?>
</BODY>
</HTML>
 
