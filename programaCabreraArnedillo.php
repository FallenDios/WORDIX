<?php
include_once("wordix.php");



/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Apellido, Nombre. Legajo. Carrera. mail. Usuario Github */


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
        "CANTO", "TIERRA", "LUNES", "VIENTO", "BROMA",
        
    ];

    return ($coleccionPalabras);
}

/** Esta función muestra por pantalla un menú para que el usuario
 * elija que quiere hacer.
 * @return int
 */

 function seleccionarOpcion(){
    //int $opcion
    echo "\n Menú de opciones: \n";
    echo "1) Jugar al Wordix con la palabra elegida. \n";
    echo "2) Jugar al Wordix con una palabra aleatoria. \n";
    echo "3) Mostrar una partida \n";
    echo "4) Mostrar la primer partida ganadora. \n";
    echo "5) Mostrar resumen de jugador. \n";
    echo "6) Mostrar listado de partidas ordenadas por jugador y por palabra . \n";
    echo "7) Agregar una palabra de cinco letras a Wordix. \n";
    echo "8) Salir. \n";
    echo "Seleccione una opción: ";
    $opcion = solicitarNumeroEntre(1,8); //Invoco a esta función para que el usuario ingrese una opción valida entre 1 y 8.
    return $opcion;
 }



/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:


//Inicialización de variables:


//Proceso:

$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);




do {
    
    $opcion = seleccionarOpcion();
    switch ($opcion) {
        case 1: 
        

            break;
        case 2: 
            

            break;
        case 3: 
            

            break;
        case 4:

            break;
        case 5:

            break;
        case 6:

            break;
        case 7:

            break;
        
            
    }
} while ($opcion != 8);

