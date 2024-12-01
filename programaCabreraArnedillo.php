<?php
include_once("wordix.php");



/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Apellido, Nombre. Legajo. Carrera. mail. Usuario Github */

// IVAN ARNEDILLO FAI- 1153- TUDW- ivan.arnedillo@gmail.com  -ivanarnedillo

// FRANCO CABRERA FAI-2682 - TUDW - francocabrera585@gmail.com- FallenDios


/**************************************/
/****** FUNCIONES COMPLEMENTARIAS******/
/**************************************/


/** Funcion diseñada para el menu principal para que cualquier tecla que se ingrese se muestre el menu.
 */

 function presionarEnterContinuar(){
    escribirAmarillo("Presione ENTER para continuar \n");
    trim(fgets(STDIN));
 }

/** Funcion que segun la opcion que se le pasa por parametro obtiene una palabra de un arreglo indexado de palabras.
 * En la primera opcion la eleccion de la palabra estara a cargo del usuario.
 * En la segunda opcion la eleccion de la palabra sera aleatoria y  estara a cargo del programa 
 * La funcion retorna la palabra para jugar la partida 
 * 
 * @param ARRAY $palabras
 * @param INT $opcion
 * @return STRING
 */

 function obtenerPalabra($palabras,$opcion){
     //STRING $palabra
    // INT $indicePalabra

    if($opcion==1){
        echo"Por favor, ingrese un numero de palabra con la que desea jugar WORDIX \n";
        $indicePalabra= solicitarNumeroEntre(1, count($palabras));
        $palabra= $palabras[($indicePalabra-1)];
    }
    elseif($opcion==2){
        $palabra= $palabras[array_rand($palabras)];  //Mas optimizada pero tambien se puede utilizar $palabras[rand(0,count($palabras)-1)];

    }
    return $palabra;
 }


/** Función que verifica si un jugador ya jugó una partida con una palabra.
 *  Si ya existe una partida, la función devuelve true, de lo contrario devuelve false.
* @param ARRAY $partidas
* @param STRING $nombreJugador 
* @param STRING $palabra
* @return BOOLEAN
*/
function verificarPalabra($partidas, $nombreJugador, $palabra) {
    //BOOLEAN $palabraUtilizada
    //INT $indice, $limite
    $limite = count($partidas);
    $palabraUtilizada = false;
    $indice = 0;
    while (!$palabraUtilizada && $indice < $limite) {
      if (($partidas[$indice]["jugador"]) == $nombreJugador && ($partidas[$indice]["palabraWordix"]) == $palabra) {
        $palabraUtilizada = true;
      }
      $indice ++;
    }
    return $palabraUtilizada;
}


/**************************************/
/****** FIN FUNCIONES COMPLETARIAS******/
/**************************************/



/** Funcion del menu principal que corresponde a las opcones 1 y 2.
 * Opcion 1 el jugador juega WORDIX con una palabra elegida e ingresada por el mismo.
 * Opcion 2 el jugador juega WORDIX con una palabra elegida al azar por el programa.
 * La funcion devuelve el arreglo de la nueva partida 
 * 
 * @param ARRAY $palabrasWordix
 * @param ARRAY $partidasWordix
 * @param INT $opcionMenu
 * @return ARRAY
 */


 function opcionMenu1y2($palabrasWordix,$partidasWordix,$opcionMenu){
     //STRING $jugador, $palabra
     //ARRAY $nuevapartida
     //BOOLEAN $palabraUtilizada

     $jugador= solicitarJugador();
     $palabraUtilizada= true;
     $nuevapartida=[];

     while($palabraUtilizada){
        $palabra= obtenerPalabra($palabrasWordix, $opcionMenu);
        $palabraUtilizada= verificarPalabra($partidasWordix,$jugador, $palabra);
        if(!$palabraUtilizada){
            $nuevapartida= jugarWordix($palabra,$jugador);
        }else{
            if($opcionMenu==1){
                escribirRojo("Palabra ya utilizada por el jugador. Por favor ingrese otra palabra ");
                echo "\n";
            }
        }
     }
     return $nuevapartida;
 }

 /** Funcion opcion 3 del menu principal
  * Pide al usuario un numero de partida y llama a una funcion "MostrarPartida"
  * pasandole por parametro dicho numero y coleccion de partidas jugadas generadas en la sesion actual
  * Si la partida existe, muestra sus datos. Caso contrario solicita nuevamente al usuario que ingrese un numero valido.
  * @param ARRAY $coleccionPartidas
  */

  function menuOpcion3($coleccionPartidas){
    //INT $partidaNro

    echo"Ingrese el numero de partida que desea ver :\n";
    $partidaNro= solicitarNumeroEntre(1, count($coleccionPartidas));
    $partidaNro -=1;
    echo"Buscando partida..... \n";
    mostrarPartida($partidaNro,$coleccionPartidas);
  }


/** Funcion correspondiente a la opcion numero 4 del menu principal.
 * Consulta en la base de datos de las partidas existentes, la primera partida ganada por un jugador.
 * En caso de existir esos datos, los muestra por pantalla de lo contrario mostrara un mensaje por pantalla.
 * @param ARRAY $coleccionPartidas
 */

 function menuOpcion4($coleccionPartidas){
    //STRING $jugador
    //INT $indice

    $jugador= solicitarJugador();
    $indice= primerPartidaGanada($coleccionPartidas,$jugador);
    if($indice != -1){
        mostrarPartida($indice,$coleccionPartidas);
    }else{
        escribirRojo("El/la jugador/a $jugador no ha ganado ninguna partida ");
        echo "\n";
    }
 }



 /** Funcion que correspondiente a la opcion 5 del menu principal
  * Muestra las estadisticas de un jugador 
  * Partidas jugadas, ganadas y porcentaje de victorias.
  * @param ARRAY $coleccionPartidas
  */

  function menuOpcion5($coleccionPartidas){
    //STRING $jugador
    //ARRAY $resumenJugador
    //FLOAT $porcentajeVictorias

    $jugador = solicitarJugador();
    $resumenJugador = estadisticasJugador($coleccionPartidas, $jugador);
    $porcentajeVictorias = 0;

    if ($resumenJugador["partidas"] == 0) {
        echo "El jugador " . $resumenJugador["jugador"] . " no ha registrado ninguna partida.\n";
        escribirGris("***********************************************");
        echo "\n";
        echo "Jugador: " . $resumenJugador["jugador"] . "\n";
        echo "Partidas: 0\n";
        echo "Puntaje total: 0\n";
        echo "Victorias: 0\n";
        echo "Porcentaje de victorias: 0.00%\n";
        escribirGris("***********************************************");
        echo "\n";
    } else {
        if ($resumenJugador["victorias"] != 0) {
            $porcentajeVictorias = ($resumenJugador["victorias"] * 100) / $resumenJugador["partidas"];
        } else {
            $porcentajeVictorias = 0;
        }

        escribirGris("***********************************************");
        echo "\n";
        echo "Jugador: " . $resumenJugador["jugador"] . "\n";
        echo "Partidas: " . $resumenJugador["partidas"] . "\n";
        echo "Puntaje total: " . $resumenJugador["puntaje"] . "\n";
        echo "Victorias: " . $resumenJugador["victorias"] . "\n";
        echo "Porcentaje de victorias: " . number_format($porcentajeVictorias, 2) . "%\n";

        // Solo se muestra la estadistica "ADIVINADAS" solo si hay partidas
        echo "ADIVINADAS:\n";
        foreach ($resumenJugador as $clave => $valor) {
            if (strpos($clave, "intento") === 0) {
                echo $clave . ": " . $valor . "\n";
            }
        }
        escribirGris("***********************************************");
        echo "\n";
    }
}



/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Obtiene una colección de palabras
 * @return array
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "CANTO", "TIERRA", "LUNES", "CARNE", "BROMA",
        
    ];

    return ($coleccionPalabras);
}
//PUNTO 2 CARGAR PARTIDAS

/**
 * Funcion que inicializa una estructura de datos con ejemplos de partidas y retorna la coleccion con datos aleatorios. 
 * El numero de partidas es arbitrario.
 * @param INT $cantidadPartidas
 * @param ARRAY $palabras
 * @return ARRAY
 */

 function cargarPartidas ($cantidadPartidas, $palabras) {
     //ARRAY $estadisticasPartidas, $nuevaPartida, $jugadores

     $jugadores = ["german", "florencia", "gonzalo", "cristian", "azul", "antonella", "julieta", "franco", "ivan", "carolina", "maria", "jose", "emiliano", "agustin", "mario", "fernanda", "miguel", "roberto", "ana", "gaston"];
     $estadisticasPartidas = [];

     for ($i = 0; $i < $cantidadPartidas; $i++) {
        $nuevaPartida=[
            "palabraWordix" => $palabras[rand(0,(count($palabras))-1)],
            "jugador" => $jugadores[rand(0, (count($jugadores))-1)],
            "intentos" => rand(1,6),
            "puntaje" => rand(0,16)
        ];
        array_push($estadisticasPartidas, $nuevaPartida);
    }
    return $estadisticasPartidas;
 }

//PUNTO 6 MOSTRAR PARTIDA

/**
 * Funcion que dado un numero de partida(Corresponde al indice de un arreglo indexado de partida )
 * Muestra  en pantalla los datos de una partida en particular 
 * @param INT $nroPartida
 * @param ARRAY $datosPartidas
 */

 function mostrarPartida($nroPartida, $datosPartidas){
    //INT $incrNroPartida

    $incrNroPartida= $nroPartida + 1;
    escribirAzul("***********************************************");
    echo"\n";
    echo"Partida WORDIX nro". $incrNroPartida. ": palabra". $datosPartidas[$nroPartida]["palabraWordix"]. "\n";
    echo"Jugador/a: ". $datosPartidas [$nroPartida]["jugador"]. "\n";
    echo"Puntaje:".  $datosPartidas [$nroPartida]["puntaje"]. " puntos \n";
    if(($datosPartidas[$nroPartida]["puntaje"]) == 0){
        echo"Intento: No adivinó la palabra \n";
    }else{
        echo"Intento: Adivino la palabra en ". $datosPartidas[$nroPartida]["intentos"]. " intento(s). \n";
    }
    escribirAzul("***********************************************");
    echo"\n";
 }

 //PUNTO 7 AGREGAR PALABRA

 /**
  * Funcion que agrega una palabra a la coleccion de palabras  que el juego trae por defecto
  * @param ARRAY $coleccionPalabras
  * @param ARRAY $palabras
  * @return ARRAY
  */

  function agregarPalabra($coleccionPalabras, $palabras){
      //STRING $$palabra
      //INT $indice
      //BOOLEAN $palabraExiste

      $indice = 0;
      $palabraExiste = false;

      while(!$palabraExiste && $indice < count($coleccionPalabras)){
          if($coleccionPalabras[$indice] == $palabras){
              $palabraExiste = true;
          }
          $indice++;  // Se incrementa para evitar un bucle infinito 
      }

      // Si la palabra no existe, se agrega 

      if(!$palabraExiste){
        array_push($coleccionPalabras, $palabras);
        echo"Palabra agregada a la coleccion \n";
      }
      else{
        echo"La palabra ya existe en la coleccion \n";
      }
      return $coleccionPalabras;
  }

//PUNTO 3 MENU
 
/** Esta función muestra por pantalla un menú para que el usuario
 * elija que quiere hacer.
 * @return int
 */


 function seleccionarOpcion() {
  //int $opcion
  echo "╔════════════════════════════════════════════════════════════════════════════╗\n";
  echo "║                           Menú de opciones                                 ║\n"; 
  echo "║                                                                            ║\n";
  echo "║ ► 1- Jugar al Wordix con una palabra elegida                               ║\n";
  echo "║ ► 2- Jugar al Wordix con una palabra aleatoria                             ║\n";
  echo "║ ► 3- Mostrar una partida                                                   ║\n";
  echo "║ ► 4- Mostrar la primer partida ganadora de un jugador                      ║\n";
  echo "║ ► 5- Mostrar resumen del jugador                                           ║\n";
  echo "║ ► 6- Mostrar listado de partidas ordenadas por jugador y por palabra       ║\n";
  echo "║ ► 7- Agregar una palabra de 5 letras a Wordix                              ║\n";
  echo "║ ► 8- Salir del programa                                                    ║\n";
  echo "╚════════════════════════════════════════════════════════════════════════════╝\n";
  echo "► Ingrese la opción deseada: ";
  $opcion = solicitarNumeroEntre(1, 8); // Invoco a esta función para que el usuario ingrese una opción válida entre 1 y 8.
  return $opcion;
 }
//PUNTO 8  PRIMER PARTIDA GANADA

/** Función que dada una colección de partidas y el nombre de un jugador, 
 * retorna el índice de la primer partida ganada por dicho jugador.
 * Si el jugador no ganó ninguna partida, la función retornará -1
 * @param ARRAY $partidas
 * @param STRING $nombre
 * @return INT
*/
function primerPartidaGanada($partidas, $nombre){
    //INT $i, $indice
    //BOOLEAN $encontrado
    $i = 0;
    $encontrado = false;
    $indice = -1;
    
    while (!$encontrado && $i < count($partidas)) {
      if ($partidas[$i]["jugador"] == $nombre && $partidas[$i]["puntaje"] != 0) {
        $encontrado  = true;
        $indice = $i;
      }
     $i++;
    }
    
    return $indice;
  }






 //PUNTO 9 ESTADISCTICA JUGADOR

 /** Funcion que dada la coleccion de partidas y el nombre de un jugador.
  * Retorna el resumen del mismo
  * @param ARRAY $partidas
  * @param STRING $nombreJugador
  * @return ARRAY
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

        if ($partidas[$i]["puntaje"] > 0) {
          $resumenJugador["victorias"]++;
          $intento = $partidas[$i]["intentos"];
          switch ($intento) {
            case 1:
              $resumenJugador["intento1"]++;
              break;
            case 2:
              $resumenJugador["intento2"]++;
              break;
            case 3:
              $resumenJugador["intento3"]++;
              break;
            case 4:
              $resumenJugador["intento4"]++;
              break;
            case 5:
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

//PUNTO 10 SOLICITAR JUGADOR
/** Función que solicita al usuario el nombre de un jugador y retorna el mismo en minúsculas. La función se asegura que el nombre comience con una letra del alfabeto.
 * @return STRING 
*/
function solicitarJugador(){
    //STRING $jugador
    do{
        echo"Ingrese el nombre del jugador :";
        $jugador = trim(fgets(STDIN)); // Elimina los espacios en blanco al principio y al final de una cadena.
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
// PUNTO 11 COMPARAR JUGADOR PALABRA
/**
 * Funcion  personalizada de ordenamiento.
 * Compara dos valores de un arreglo asociativo, para ordenarlos.
 * Primero ordena por nombre de jugador y luego por palabra.
 * @param STRING $a
 * @param STRING $b
 * @return INT
 */

 function compararJugadorPalabra($a, $b){
    //STRING $resultado
    $resultado = strcmp($a["jugador"], $b["jugador"]);  //strcmp, que compara dos cadenas alfabéticamente.

    if($resultado === 0){
        $resultado = strcmp($a["palabraWordix"], $b["palabraWordix"]);
    }

    return $resultado;
    }

// ORDENAR PARTIDAS
/**
 * Funcion que dada una coleccion de partidas muestra la coleccion ordenada por el nombre de jugador y por palabra.
 * @param ARRAY $coleccionPartidas
 */

 function ordenarPartidas($coleccionPartidas){
    uasort($coleccionPartidas, 'compararJugadorPalabra'); // ordena arreglos asociativo utilizando una función de comparación definida por el usuario. 
    print_r($coleccionPartidas); //Se utiliza para mostrar informacion sobre variables de una manera legible.
 }




/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

//INT $opcion
//ARRAY $palabras, $partidas, $nuevaPartida
//STRING $palabraNueva

//Inicialización de variables:
$palabras = cargarColeccionPalabras();
$partidas = cargarPartidas(100, $palabras);
  


do {
    
  $opcion = seleccionarOpcion();
  switch ($opcion) {
    case 1: 
      escribirBlanco("Opcion 1 seleccionada");
      echo " \n\n";
      $nuevaPartida = opcionMenu1y2($palabras, $partidas, $opcion);
      array_push($partidas, $nuevaPartida);
      presionarEnterContinuar();
      break;

    case 2: 
      escribirBlanco("Opcion 2 seleccionada");
      echo " \n\n";
      $nuevaPartida = opcionMenu1y2($palabras, $partidas, $opcion);
      array_push($partidas, $nuevaPartida);
      presionarEnterContinuar();
      break;

    case 3: 
      escribirBlanco("Opcion 3 seleccionada");
      echo " \n\n";
      menuOpcion3($partidas);
      presionarEnterContinuar();
      break;

    case 4:
      escribirBlanco("Opcion 4 seleccionada");
      echo " \n\n";
      menuOpcion4($partidas);
      presionarEnterContinuar();
      break;

    case 5:
      escribirBlanco("Opcion 5 seleccionada");
      echo " \n\n";
      menuOpcion5($partidas);
      presionarEnterContinuar();
      break;

    case 6:
      escribirBlanco("Opcion 6 seleccionada");
      echo " \n\n";
      ordenarPartidas($partidas);
      presionarEnterContinuar();
      break;

    case 7:
      escribirBlanco("Opcion 7 seleccionada");   
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

