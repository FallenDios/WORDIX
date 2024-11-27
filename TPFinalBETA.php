<?php
include_once("wordix.php");
include_once("funcionesMenu.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/




/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Obtiene una colección de palabras
 * @return ARRAY
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "CERCA", "AYUDA", "DEDOS", "FORMA", "GASTO" 
    ];

    return ($coleccionPalabras);
}

/* PUNTO 2*/
/** Función que inicializa una estructura de datos con ejemplos de partidas y retorna la colección con datos aleatorios. El número de partidas es arbitrario.
 * @param INT $cantidadPartidas
 * @param ARRAY $palabras
 * @return ARRAY
*/
function cargarPartidas ($cantidadPartidas, $palabras) {
  //ARRAY $estadisticasPartidas, $nuevaPartida, $jugadores
  
  $jugadores = ["Franco", "jose", "emiliano", "gaston", "german", "carolina", "antonella", "agustin", "gonzalo", "mario", "roberto", "cristian", "miguel", "daiana", "florencia", "marta", "julieta", "fernanda", "ana", "marcos"];
  $estadisticasPartidas = [];
  
  for ($i = 0; $i < $cantidadPartidas; $i++) {
      
    $nuevaPartida = [
      "palabraWordix" => $palabras[rand(0,(count($palabras))-1)],
      "jugador" => $jugadores[rand(0, (count($jugadores))-1)],
      "intentos" => rand(1,6),
      "puntaje" => rand(0,16)
    ];
    array_push($estadisticasPartidas, $nuevaPartida);
  }
  return $estadisticasPartidas;
}

/**PUNTO 3 */
/** Función que muestra el menú principal en pantalla. Luego le pide la usuario que ingrese un número válido (correspondiente a la opción del menú que desea ejecutar). Si la opción no es válida, se le seguirá pidiendo al usuario un número, hasta que sea válido. La función retorna el número de opción elegida.
 * @return INT
*/
function seleccionarOpcion(){
  //$opcionSeleccionada
  echo "╔" . str_repeat("═", 69 - 2) . "╗\n";
  escribirGris("Menú de opciones");
  echo "                                                  ║\n";
  echo "║";
  echo "1- Jugar al Wordix con una palabra elegida                         ║\n";
  echo "║";
  echo "2- Jugar al Wordix con una palabra aleatoria                       ║\n";
  echo "║";
  echo "3- Mostrar una partida                                             ║\n";
  echo "║";
  echo "4- Mostrar la primer partida ganadora de un jugador                ║\n";
  echo "║";
  echo "5- Mostrar resumen del jugador                                     ║\n";
  echo "║";
  echo "6- Mostrar listado de partidas ordenadas por jugador y por palabra ║\n";
  echo "║";
  echo "7- Agregar una palabra de 5 letras a Wordix                        ║\n";
  echo "║";
  echo "8- Salir del programa                                              ║\n";
  echo "╚" . str_repeat("═", 69 - 2) . "╝\n";
  echo "Ingrese la opción deseada: ";
  
  $opcionSeleccionada = solicitarNumeroEntre(1,8);
  
  return $opcionSeleccionada;
}

/**PUNTO 6 */
/** Función que dado un número de partida (que corresponde al índice de un arreglo indexado de partidas) muestra en pantalla los datos de una partida particular.
 * @param INT $nroPartida
 * @param ARRAY $datosPartidas
*/
function mostrarPartida($nroPartida, $datosPartidas) {
    //INT $incrNroPartida
    $incrNroPartida = $nroPartida+1;
    escribirBlanco("***********************************************");
    echo " \n";
    echo "Partida WORDIX nro " . $incrNroPartida . ": palabra " . $datosPartidas[$nroPartida]["palabraWordix"] . " \n";
    echo "Jugador/a: " . $datosPartidas[$nroPartida]["jugador"] . " \n";
    echo "Puntaje: " . $datosPartidas[$nroPartida]["puntaje"] . " puntos \n";
    if (($datosPartidas[$nroPartida]["puntaje"]) == 0) {
      echo "Intento: No adivinó la palabra \n";
    } 
    else {
      echo "Intento: Adivinó la palabra en " . $datosPartidas[$nroPartida]["intentos"] . " intento(s). \n";
    }
    escribirBlanco("***********************************************");
    echo " \n";
}

/**PUNTO 7 */
/** Función que agrega una palabra a la colección de palabras que el juego trae por defecto.
* @param ARRAY $coleccionPalabras
* @param STRING $palabra
* @return ARRAY 
*/
function agregarPalabra($coleccionPalabras, $palabra) {
  //STRING $palabra
  //INT $indice
  //BOOLEAN $palabraExiste
  
  $indice = 0;
  $palabraExiste = false;
  
  while (!$palabraExiste && $indice < count($coleccionPalabras)) {
    if ($coleccionPalabras[$indice] == $palabra) { 
      $palabraExiste = true;
    }
    $indice++;
  }
  
  if (!$palabraExiste)
  {
    array_push($coleccionPalabras, $palabra); 
    echo "Se agregó una nueva palabra a la colección!\n";
  }
  else{
    echo "La palabra ya existe en la colección\n";
  }
  return $coleccionPalabras;
}

/**PUNTO 8 */
/** Función que dada una colección de partidas y el nombre de un jugador, retorna el índice de la primer partida ganada por dicho jugador. Si el jugador no ganó ninguna partida, la función retornará -1
 * @param ARRAY $partidas
 * @param STRING $nombre
 * @return INT
*/
function primerPartidaGanada($partidas, $nombre){
  //INT $i, $indice, $limite
  //BOOLEAN $encontrado
  $i = 0;
  $encontrado = false;
  $indice = -1;
  $limite = count($partidas);
  
  while (!$encontrado && $i < $limite) {
    if ($partidas[$i]["jugador"] == $nombre && $partidas[$i]["puntaje"] != 0) {
      $encontrado  = true;
      $indice = $i;
    }
   $i++;
  }
  
  return $indice;
}

/**PUNTO 9 */
/** Función que dada la colección de partidas y el nombre de un jugador, retorna el resumen del mismo
 * @param ARRAY $partidas
 * @param STRING $nombreJugador
*/
function estadisticasJugador($partidas, $nombreJugador){
  //INT $partidasJugadas, $puntajeAcumulado, $victorias, $i, $intento
  //ARRAY $resumenJugador
  $intento = 0;
  
  $resumenJugador = [
    "jugador" => $nombreJugador,
    "partidas" => 0,
    "puntaje" => 0,
    "victorias" => 0,
    "intento1" => 0,
    "intento2" => 0,
    "intento3" => 0,
    "intento4" => 0,
    "intento5" => 0,
    "intento6" => 0,
  ];

  for ($i=0; $i < count($partidas); $i++) { 
    if (($partidas[$i]["jugador"]) == $nombreJugador) {
      $resumenJugador["partidas"]++;
      $resumenJugador["puntaje"]+=($partidas[$i]["puntaje"]);
     
      if (($partidas[$i]["puntaje"]) != 0) {
        $resumenJugador["victorias"]++;
        $intento = $partidas[$i]["intentos"];
        
        switch ($intento) {
          case '1':
            $resumenJugador["intento1"]++;
            break;
          case '2':
            $resumenJugador["intento2"]++;
            break;
          case '3':
              $resumenJugador["intento3"]++;
              break;
          case '4':
              $resumenJugador["intento4"]++;
              break;
          case '5':
              $resumenJugador["intento5"]++;
              break;
          default:
            $resumenJugador["intento6"]++;
            break;
        }
      }
    }
  }

  return $resumenJugador;
}

/**PUNTO 10 */
/** Función que solicita al usuario el nombre de un jugador y retorna el mismo en minúsculas. La función se asegura que el nombre comience con una letra del alfabeto.
 * @return STRING 
*/
function solicitarJugador(){
  //STRING $jugador
  do{
      echo"Ingrese el nombre del jugador :";
      $jugador=trim(fgets(STDIN)); // Elimina los espacios en blanco al principio y al final de una cadena.
      $jugador = preg_replace('/\s+/', ' ', $jugador); //remplaza todos los espacios en blanco con un espacio.

      // Validar que el nombre no esté vacío, que comience con una letra y tenga más de un carácter útil
      if((!empty($jugador) &&  ctype_alpha($jugador[0]) && strlen(str_replace(" ", "", $jugador)) )){
          escribirVerde("El nombre ha sido ingresado correctamente....");
          echo"\n";
      }else{
          escribirRojo("!!ERROR!!. El nombre debe comenzar con una letra");
      }
  }while( (empty($jugador)) || !(ctype_alpha($jugador[0])));

  return strtolower($jugador);
}

/**PUNTO 11 */
/** Función personalizada de ordenamiento. Compara dos valores de un arreglo asociativo, para ordenarlos. Primero ordena por nombre de jugador y luego por palabra. 
* @param STRING $a
* @param STRING $b
* @return STRING
*/
function compararJugadorPalabra($a, $b) {
  //STRING $resultado
  $resultado = strcmp($a['jugador'], $b['jugador']);
    
  if ($resultado === 0) {
      $resultado = strcmp($a['palabraWordix'], $b['palabraWordix']);
  }
    
  return $resultado;
} 

/** Función que dada una colección de partidas muestra la colección ordenada por el nombre de jugador y por palabra.
 * @param ARRAY $coleccionPartidas
*/
function ordenarPartidas($coleccionPartidas){
  
  uasort($coleccionPartidas, 'compararJugadorPalabra'); //el método uasort ordena arreglos asociativos, manteniento la relación clave-valor luego del ordenamiento. El primer parámetro formal será el arreglo asociativo a ordenar. El segundo parámetro es una función personalizada de ordenamiento, que determina cómo se comparan los valores del arreglo asociativo.
  print_r($coleccionPartidas); //el método print_r se utiliza para mostrar información sobre variables de una manera legible. En este caso, la utilizamos en un arreglo indexado de arreglos asociativos. El método muestra la información de una manera estructurada y legible, indicando los índices, y los pares clave-valor.
}

/**************************************/
/********** PROGRAMA PRINCIPAL ********/
/**************************************/

/*******DECLARACION DE VARIABLES*******/
//INT $opcion
//ARRAY $palabras, $partidas, $nuevaPartida
//STRING $palabraNueva

/*******INICIALIZACIÓN ESTRUCTURAS DE DATOS*******/
$palabras = cargarColeccionPalabras();
$partidas = cargarPartidas(100, $palabras);
  
do {
  $opcion = seleccionarOpcion();
  switch ($opcion) { //La sentencia switch es una estructura alternativa múltiple. También se la llama estructura selectiva.
    case 1: //Evalúa una expresión multi-valor y ejecuta las intrucciones de cada caso según el valor que corresponda a dicha expresión.
      escribirGris("Opcion 1 seleccionada");
      echo " \n\n";
      $nuevaPartida = opcionMenu1y2($palabras, $partidas, $opcion);
      array_push($partidas, $nuevaPartida);
      presionarEnterContinuar();
      break; //La sentencia break provoca que el flujo de control "salga" del switch, una vez ejecutadas las instrucciones del caso, y continúe con el programa.
    case 2:
      escribirGris("Opcion 2 seleccionada");
      echo " \n\n";
      opcionMenu1y2($palabras, $partidas, $opcion);
      presionarEnterContinuar();
      break;
    case 3:
      escribirGris("Opcion 3 seleccionada");
      echo " \n\n";
      menuOpcion3($partidas);
      presionarEnterContinuar();
      break;
    case 4:
      escribirGris("Opcion 4 seleccionada");
      echo " \n\n";
      menuOpcion4($partidas);
      presionarEnterContinuar();
      break;
    case 5:
      escribirGris("Opcion 5 seleccionada");
      echo " \n\n";
      menuOpcion5($partidas);
      presionarEnterContinuar();
      break;
    case 6:
      escribirGris("Opcion 6 seleccionada");
      echo " \n\n";
      ordenarPartidas($partidas);
      presionarEnterContinuar();
      break;
    case 7:
      escribirGris("Opcion 7 seleccionada");
      echo " \n\n";
      $palabraNueva = leerPalabra5Letras();
      $palabras = agregarPalabra($palabras, $palabraNueva);
      presionarEnterContinuar();
      break;
    
    default:
      escribirRojo("Fin del programa");
      break;
  }

} while ($opcion != 8);