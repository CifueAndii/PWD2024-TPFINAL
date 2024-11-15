<?php
class Producto extends BaseDatos{
    private $id;
    private $nombre;
    private $proartista;
    private $proprecio;
    private $detalle;
    private $cantStock;
    private $protipo;
    private $prodeshabilitado;
    private $proimg64;
    private $mensajeOperacion;

    /////////////////////////////
    // CONSTRUCTOR //
    /////////////////////////////

    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        parent::__construct();
        $this->id = -1;
        $this->nombre = "";
        $this->proartista = "";
        $this->proprecio = 0;
        $this->detalle = "";
        $this->cantStock = 0;
        $this->protipo = "";
        $this->prodeshabilitado = null;
        $this->proimg64 = "";
    }

    /////////////////////////////
    // SET Y GET //
    /////////////////////////////

    /**
     * Carga datos al producto actual
     * @param int $id
     * @param string $nombre
     * @param string $proartista
     * @param float $proprecio
     * @param string $detalle
     * @param int $cantStock
     * @param string $protipo
     * @param timestamp|null $prodeshabilitado
     * @param string $proimg64
     */
    public function cargar($id, $nombre, $proartista, $proprecio, $detalle, $cantStock, $protipo, $prodeshabilitado, $proimg64){
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setArtista($artista);
        $this->setPrecio($proprecio);
        $this->setDetalle($detalle);
        $this->setCantStock($cantStock);
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
    public function getArtista(){
        return $this->proartista;
    }
    public function setArtista($artista){
        $this->proartista = $artista;
    }
    public function getPrecio(){
        return $this->proprecio;
    }
    public function setPrecio($precio){
        $this->proprecio = $precio;
    }
    public function getDetalle(){
        return $this->detalle;
    }
    public function setDetalle($detalle){
        $this->detalle = $detalle;
    }
    public function getCantStock(){
        return $this->cantStock;
    }
    public function setCantStock($cantStock){
        $this->cantStock = $cantStock;
    }
    public function getTipo(){
        return $this->protipo;
    }
    public function setTipo($tipo){
        $this->protipo = $tipo;
    }
    public function getDeshabilitado(){
        return $this->prodeshabilitado;
    }
    public function setDeshabilitado($timestamp){
        $this->prodeshabilitado = $timestamp;
    }
    public function getImg64(){
        return $this->proimg64;
    }
    public function setImg64($img){
        $this->proimg64 = $img;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /////////////////////////////
    // INTERACCIÓN CON LA DB //
    /////////////////////////////

    /**
     * Busca una producto por id.
     * Coloca su datos al objeto actual.
     * @param int $id
     * @return boolean
     */
    public function buscar($id){
        $encontro = false;
        $consulta = "SELECT * FROM producto WHERE idproducto = '" . $id . "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                if($fila = $this->Registro()){
                    $this->cargar(
                        $fila["idproducto"],
                        $fila["pronombre"],
                        $fila["proartista"],
                        $fila["proprecio"],
                        $fila["prodetalle"],
                        $fila["procantstock"],
                        $fila["protipo"],
                        $fila["prodeshabilitado"],
                        $fila["proimg64"]
                    );

                    $encontro = true;
                }
            }else{$this->setMensajeOperacion("producto->buscar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->buscar: ".$this->getError());}

        return $encontro;
    }

    /**
     * Lista productos de la base de datos
     * @param string $condicion (opcional)
     * @return array|null
     */
    public function listar($condicion = ""){
        $arreglo = null;
        $consulta = "SELECT * FROM producto";

        if($condicion != ""){
            $consulta .= " WHERE " . $condicion;
        }

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $arreglo = [];
                while($fila = $this->Registro()){
                    $objProducto = new Producto();
                    $objProducto->cargar(
                        $fila["idproducto"],
                        $fila["pronombre"],
                        $fila["proartista"],
                        $fila["proprecio"],
                        $fila["prodetalle"],
                        $fila["procantstock"],
                        $fila["protipo"],
                        $fila["prodeshabilitado"],
                        $fila["proimg64"]
                    );

                    array_push($arreglo, $objProducto);
                }
            }else{$this->setMensajeOperacion("producto->listar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->listar: ".$this->getError());}

        return $arreglo;
    }

    /**
     * Inserta un producto a la db
     * @return boolean
     */
    public function insertar(){
        $resp = null;
        $resultado = false;

        $consulta = "INSERT INTO producto(pronombre, proartista, proprecio, prodetalle, procantstock, protipo, prodeshabilitado, proimg64)
        VALUES ('". $this->getNombre(). "','". $this->getArtista() . "',". $this->getPrecio() .",'". $this->getDetalle() ."',". $this->getCantStock() .",'" . $this->getTipo() . "'," . $this->getDeshabilitado() . ",'" .$this->getImg64() ."');";

        if($this->Iniciar()){
            $resp = $this->Ejecutar($consulta);
            if ($resp) {
                $this->setId($resp);
                $resultado = true;
            }else{$this->setmensajeoperacion("producto->insertar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->insertar: ".$this->getError());}

        return $resultado;
    }

    /**
     * Modifica los datos de un producto
     * @return boolean
     */
    public function modificar(){
        $seConcreto = false;

        $consulta = "UPDATE producto SET pronombre = '". $this->getNombre() ."',
        proartista = '" . $this->getArtista() . "', 
        proprecio =". $this->getPrecio(). ", 
        prodetalle = '". $this->getDetalle() ."',
        procantstock = ". $this->getCantStock() .",
        protipo = '" . $this->getTipo() . "',
        prodeshabilitado = " . $this->getDeshabilitado() . ",
        proimg64 = '" . $this->getImg64() . "' 
        WHERE idproducto = '" . $this->getid(). "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $seConcreto = true;
            }else{$this->setMensajeOperacion("producto->modificar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->modificar: ".$this->getError());}

        return $seConcreto;
    }

    /**
     * Elimina un producto de la db
     * @return boolean
     */
    public function eliminar(){
        $seConcreto = false;

        $consulta = "DELETE FROM producto WHERE idproducto = '" . $this->getId() ."'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $seConcreto = true;
            }else{$this->setMensajeOperacion("producto->eliminar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->eliminar: ".$this->getError());}

        return $seConcreto;
    }
}


?>