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
})

?>
