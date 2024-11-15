<?php
class Menu extends BaseDatos{
    private $id;
    private $nombre;
    private $descripcion;
    private $objMenuPadre;
    private $deshabilitado;
    private $mensajeOperacion;

    /**
     * Método constructor
     */
    public function __construct(){
        parent::__construct();
        $this->id = -1;
        $this->nombre = "";
        $this->descripcion = "";
        $this->deshabilitado = "";
    }

    /**
     * Carga datos al objeto Menu
     * @param int $id
     * @param string $nombre
     * @param string $descripcion
     * @param Menu $objMenuPadre
     * @param string $deshabilitado
     */
    public function cargar($id, $nombre, $descripcion, $objMenuPadre, $deshabilitado){
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDescripcion($descripcion);
        $this->setObjMenuPadre($objMenuPadre);
        $this->setDeshabilitado($deshabilitado);
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function getObjMenuPadre(){
        return $this->objMenuPadre;
    }
    public function setObjMenuPadre($objMenuPadre){
        $this->objMenuPadre = $objMenuPadre;
    }
    public function getDeshabilitado(){
        return $this->deshabilitado;
    }
    public function setDeshabilitado($deshabilitado){
        $this->deshabilitado = $deshabilitado;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /**
     * Busca en la db por clave primaria
     * @param int $id
     */
    public function buscar($id){
        $resp = false;
        $consulta = "SELECT * FROM menu WHERE idmenu = '" . $id . "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                if($fila = $this->Registro()){
                    $objMenu = new Menu;
                    $objMenuPadre = null;
                    if($fila["idpadre"] != NULL){
                        $objMenuPadre = new Menu;
                        $objMenuPadre->buscar($fila["idpadre"]);
                    }

                    $this->cargar($fila["idmenu"],$fila["menombre"],$fila["medescripcion"],$objMenu,$fila["medeshabilitado"]);

                    $resp = true;
                }
            }else{
                $this->setMensajeOperacion("menu->buscar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("menu->buscar: ".$this->getError());
        }

        return $resp;
    }

    /**
     * Lista los menus de la db
     * @param string $condicion (opcional)
     * @return array
     */
    public function listar($condicion = ""){
        $arreglo = null;
        $consulta = "SELECT * FROM menu";

        if($condicion != ""){
            $consulta .= " WHERE " . $condicion;
        }

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $arreglo = [];
                while($fila = $this->Registro()){
                    $objMenu = new Menu;
                    $objMenuPadre = null;
                    if($fila["idpadre"] != NULL){
                        $objMenuPadre = new Menu;
                        $objMenuPadre->buscar($fila["idpadre"]);
                    }
                    $objMenu->cargar($fila["idmenu"],$fila["menombre"],$fila["medescripcion"],$objMenuPadre,$fila["medeshabilitado"]);
                    array_push($arreglo, $objMenu);
                }
            }else{
                $this->setMensajeOperacion("menu->listar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("menu->listar: ".$this->getError());
        }

        return $arreglo;
    }

    /**
     * Inserta a la db
     * @return boolean
     */
    public function insertar(){
        $resp = null;
        $res = false;
        $menuPadre[0] = ",";
        $menuPadre[1] = ",";

        if($this->getObjMenuPadre() != null && $this->getObjMenuPadre()->getId() != -1){
            $menuPadre[0] = ",idpadre,";
            $menuPadre[1] = ",idpadre = '". $this->getObjMenuPadre()->getId() . "',";
        }

        $consulta = "INSERT INTO menu(menombre, medescripcion". $menuPadre[0] ."medeshabilitado)
        VALUES ('" . $this->getNombre() . "', '". $this->getDescripcion() ."'". $menuPadre[1] ."
        '". $this->getDeshabilitado() ."');";

        echo $consulta;

        if($this->Iniciar()){
            $resp = $this->Ejecutar($consulta);
            if ($resp) {
                $this->setId($resp);
                $res = true;
            }else{
                $this->setMensajeOperacion("menu->insertar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("menu->insertar: ".$this->getError());
        }

        return $res;
    }

    /**
     * Modifica la db
     * @return boolean
     */
    public function modificar(){
        $resp = false;
        $padre = ",";

        if($this->getObjMenuPadre() != null && $this->getObjMenuPadre()->getId() != -1){
            $padre = ",idpadre = '". $this->getObjMenuPadre()->getId() . "',";
        }

        $consulta = "UPDATE menu SET menombre = '". $this->getNombre() ."', medescripcion = '". $this->getDescripcion() ."'
        ". $padre ." medeshabilitado = ".$this->getDeshabilitado()." WHERE idmenu = '" . $this->getId(). "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeOperacion("menu->modificar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("menu->modificar: ".$this->getError());
        }

        return $resp;
    }

    /**
     * Elimina de la db
     * @return boolean
     */
    public function eliminar(){
        $resp = false;

        $consulta = "DELETE FROM menu WHERE idmenu = '" . $this->getId() ."'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeOperacion("menu->eliminar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("menu->eliminar: ".$this->getError());
        }

        return $resp;
    }
}


?>