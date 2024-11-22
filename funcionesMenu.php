<?php
/**************************************/
/****** FUNCIONES COMPLEMENTARIAS******/
/**************************************/


/**
 * Funcion diseñada para el menu principal para que cualquier tecla que se ingrese se muestre el menu
 */

 function presionarEnterContinuar(){
    escribirAmarillo("Presione ENTER para continuar \n");
    trim(fgets(STDIN));
 }


/**
 * Funcion que segun la opcion que se le pasa por parametro obtiene una palabra de un arreglo indexado de palabras.
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
    //INT $indice
    $palabraUtilizada = false;
    $indice = 0;
    while (!$palabraUtilizada && $indice < count($partidas)) {
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



/**
 * Funcion del menu principal que corresponde a las opcones 1 y 2.
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

 /**Funcion opcion 3 del menu principal
  * Pide al usuario un numero de partida y llama a una funcion "MostrarPartida"
  * pasandole por parametro dicho numero y coleccion de partidas jugadas generadas en la sesion actual
  * Si la partida existe, muestra sus datos. Caso contrario solicita nuevamente al usuario que ingrese un numero valido.
  *
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


/**Funcion correspondiente a la opcion numero 4 del menu principal.
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



 /**Funcion que correspondiente a la opcion 5 del menu principal
  * Muestra las estadisticas de un jugador 
  * Partidas jugadas, ganadas y porcentaje de victorias.
  *@param ARRAY $coleccionPartidas
  */

  function menuOpcion5($coleccionPartidas){
    //STRING $jugador
    //ARRAY $resumenJugador
    //FLOAT $porcentajeVictorias

    $jugador= solicitarJugador();
    $resumenJugador= estadisticasJugador($coleccionPartidas,$jugador);
    $porcentajeVictorias= 0;

    if($resumenJugador["partidas"] == 0){
        echo"El jugador". $resumenJugador["jugador"]. " no ha registrado ninguna  partida \n";
    }else{
        if($resumenJugador["victorias"] != 0){
            $porcentajeVictorias= ($resumenJugador["victorias"]*100)/ $resumenJugador["partidas"];
        }else{
            $porcentajeVictorias= 0;
        }
    }
    escribirGris("***********************************************");
    echo "\n";
    echo"Jugador: ". $resumenJugador["jugador"]. "\n";
    echo"Partidas:". $resumenJugador["partidas"]. "\n";
    echo"Puntaje total:". $resumenJugador["puntaje"]. "\n";
    echo"Victorias:". $resumenJugador["victorias"]. "\n";
    echo"Porcentaje de victorias:". number_format($porcentajeVictorias,2). "%  \n"; 
    echo" ADIVINADAS: \n";
    foreach($resumenJugador as $clave => $valor){
        if(strpos($clave,"intento")== 0){
            echo $clave. ": ". $valor. "\n";
        }
        }
        escribirGris("***********************************************");
        echo "\n";
  }