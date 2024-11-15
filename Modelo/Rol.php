<?php
class Rol extends BaseDatos{
    private $id;
    private $rolDescripcion;
    private $mensajeOperacion;

    /**
     * Método Constructor
     */
    public function __construct(){
        parent::__construct();
        $this->id = null;
        $this->rolDescripcion = null;
        $this->mensajeOperacion = null;
    }

    /**
     * Carga datos al objeto
     * @param int $id
     * @param string $rolDescripcion
     */
    public function cargar($id, $rolDescripcion){
        $this->setId($id);
        $this->setRolDescripcion($rolDescripcion);
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getRolDescripcion(){
        return $this->rolDescripcion;
    }
    public function setRolDescripcion($rolDescripcion){
        $this->rolDescripcion = $rolDescripcion;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }


    /**
     * Busca un rol por id
     * Sus datos son colocados en el objeto
     * @param string $id
     * @return boolean true si encontro, false caso contrario
     */
    public function buscar($id){
        $resp = false;
        $consulta = "SELECT * FROM rol WHERE idrol = '" . $id . "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                if($fila = $this->Registro()){
                    $this->cargar($id,$fila["roldescripcion"]);
                    $resp = true;
                }
            }else{
                $this->setMensajeOperacion("rol->buscar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("rol->buscar: ".$this->getError());
        }

        return $resp;
    }

    /**
     * Lista roles de la base de datos
     * @param string $condicion (opcional)
     * @return array|null colección de usuarios o null si no hay ninguno
     */
    public function listar($condicion = ""){
        $arreglo = null;
        $consulta = "SELECT * FROM rol";

        if($condicion != ""){
            $consulta .= " WHERE " . $condicion;
        }

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $arreglo = [];
                while($fila = $this->Registro()){
                    $objRol = new Rol();
                    $objRol->cargar($fila["idrol"],$fila["roldescripcion"]);
                    array_push($arreglo, $objRol);
                }
            }else{
                $this->setMensajeOperacion("rol->listar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("rol->listar: ".$this->getError());
        }

        return $arreglo;
    }

    /**
     * Inserta los datos del objeto Usuario actual a la base de datos.
     * @return boolean true si se concretó, false caso contrario
     */
    public function insertar(){
        $resp = null;
        $res = false;

        $consulta = "INSERT INTO rol(roldescripcion) VALUES ('". $this->getRolDescripcion()."');";

        if($this->Iniciar()){
            $resp = $this->Ejecutar($consulta);
            if($resp){
                $this->setId($resp);
                $res = true;
            }else{
                $this->setmensajeoperacion("rol->insertar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("rol->insertar: ".$this->getError());
        }

        return $res;
    }

    /**
     * Modifica los datos de la usuario, colocando los del objeto actual
     * @return boolean true si se concretó, false caso contrario
     */
    public function modificar(){
        $resp = false;

        $consulta = "UPDATE rol SET roldescripcion = '" . $this->getRolDescripcion() . "' WHERE idrol = '" . $this->getId(). "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeOperacion("rol->modificar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("rol->modificar: ".$this->getError());
        }

        return $resp;
    }

    /**
     * Elimina el objeto actual de la base de datos
     * @return boolean true si se concretó, false caso contrario
     */
    public function eliminar(){
        $resp = false;

        $consulta = "DELETE FROM rol WHERE idrol = '" . $this->getId() ."'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeOperacion("rol->eliminar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("rol->eliminar: ".$this->getError());
        }

        return $resp;
    }
}


?>