<?php
class Session{
    /**
     * Clase constructor
     * @return boolean
     */
    public function __construct(){
        $resp = false;
        if(session_start()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados
     * @param string $nombreUsuario
     * @param string $psw
     * @return array
     */
    public function iniciar($nombreUsuario,$psw){
        $resp = false;
        $objAbmUsuario = new AbmUsuario();

        $param['usnombre'] = $nombreUsuario;
        $param['uspass'] = $psw;
        $param['usdeshabilitado'] = "0000-00-00 00:00:00";

        $res = $objAbmUsuario->buscar($param);
        if(count($res) > 0){
            $objUsuario = $res[0];
            $_SESSION['idusuario'] = $objUsuario->getId();
            $resp = true;
        }else{
            $this->cerrar();
        }
        return $resp;
    }

    /**
     * Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false
     * @return 
     */
    public function validar(){
        $resp = false;
        if($this->activa() && isset($_SESSION["idusuario"])){
            $resp = true;
        }

        return $resp;
    }

    /**
     * Devuelve true o false si la sesión está activa o no
     * @return boolean
     */
    public function activa(){
        $resp = false;
        if(session_status() == PHP_SESSION_ACTIVE){
            $resp = true;
        }

        return $resp;
    }

    /**
     * Devuelve el usuario logeado
     * @return Usuario
     */
    public function getUsuario(){
        $objUsuario = null;
        if($this->validar()){
            $objAbmUsuario = new AbmUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $res = $objAbmUsuario->buscar($param);
            if(count($res) > 0){
                $objUsuario = $res[0];
            }
        }
        return $objUsuario;
    }

    /**
     * Devuelve los roles del usuario logeado
     * @return array
     */
    public function getRol(){
        $_SESSION["roles"] = array();

        if($this->validar()){
            $abmUsuario = new AbmUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $res = $abmUsuario->buscarRoles($param);
            foreach($res as $rol){
                array_push($_SESSION["roles"], $rol->getObjRol()->getRolDescripcion());
            }
        }
        return $_SESSION["roles"];
    }

    /**
     * Revisa si el usuario tiene permisos para entrar a una página
     * @return boolean
     */
    public function tienePermiso(){
        $resp = false;

        $ruta = $_SERVER['PHP_SELF'];
        $ruta = explode("/" ,$ruta);
        $rutaStr = "../";
        $rutaStr .= $ruta[count($ruta)-2] . "/";
        $rutaStr .= $ruta[count($ruta)-1];

        $objMenuRol = new MenuRol();
        if($objMenuRol->verificarPermiso($_SESSION["idusuario"],$rutaStr)){
            $resp = true;
        }

        return $resp;
    }

    /**
     * Cierra la sesión actual
     */
    public function cerrar(){
        $resp = true;
        session_destroy();
        return $resp;
    }
}
?>