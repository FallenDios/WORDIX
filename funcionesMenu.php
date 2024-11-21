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
        $palabra= $palabras[rand(0,count($palabras)-1)];
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
        $palabraUtilizada= verificarPalabra($palabrasWordix,$jugador, $palabra);
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


