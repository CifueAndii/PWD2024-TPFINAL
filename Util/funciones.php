<?php
/////////////////////////////
// FUNCIONES ÚTILES //
/////////////////////////////

/**
 * Retorna los datos enviados a través de POST o GET.
 * @return array
 */
function data_submitted() {
    $_AAux= array();
    if (!empty($_POST))
        $_AAux =$_POST;
        else
            if(!empty($_GET)) {
                $_AAux =$_GET;
            }
        if (count($_AAux)){
            foreach ($_AAux as $indice => $valor) {
                if ($valor=="")
                    $_AAux[$indice] = 'null' ;
            }
        }
        return $_AAux;
}

/**
 * Permite ver código. Útil para debug.
 * Combinar con print_r
 */
function verEstructura($e){
    echo "<pre>";
    print_r($e);
    echo "</pre>"; 
}

/**
 * Función de autocarga de clases.
 */
spl_autoload_register(function($class_name){
    $directories = array(
         $GLOBALS['ROOT'].'Modelo/',
         $GLOBALS['ROOT'].'Modelo/Conector/',
         $GLOBALS['ROOT'].'Control/'
    );

    foreach($directories as $directory){
        if(file_exists($directory . $class_name . '.php')){
            require_once($directory . $class_name . '.php');
            return;
        }
    }
});

/**
 * Recibe un objeto y convierte sus propiedades a un arreglo asociativo.
 * @param object $object
 * @return array  
 */
function dismount($object) {
    // con get_class obtenemos el nombre de la clase y reflectionClass obtenemos y manipulamos información sobre el $object
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();
    // recorremos la lista de propiedades de $reflectionClass (adquiridas de $object),
    foreach ($reflectionClass->getProperties() as $property) {
        // cambiamos la visibilidad de la propiedad a Accesible (en caso de que fuera private o protected), para poder acceder a sus valores.
        $property->setAccessible(true);
        // ingresamos el nombre de la propiedad como una clave en el arreglo asociativo creado, con su respectivo valor.
        $array[$property->getName()] = $property->getValue($object);
        // reestablecemos la visibilidad de la propiedad a su estado original. 
        $property->setAccessible(false);
    }
    return $array;
}

/**
 * Recibe un arreglo de objetos y devuelve un arreglo con arreglos asociativos.
 * @param array
 */
function convert_array($param) {
    $_AAux= array();
    if (!empty($param)) {
        if (count($param)){
            foreach($param as $obj) {
                // itera sobre el arreglo de objetos y los convierte a arreglos asociativos
                array_push($_AAux,dismount($obj));    
            }
        }
    }
    return $_AAux;
}

?>
