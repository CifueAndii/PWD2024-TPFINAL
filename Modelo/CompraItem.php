<?php
class CompraItem extends BaseDatos{
    private $id;
    private $objProducto;
    private $objCompra;
    private $cantidad;
    private $mensajeOperacion;

    /**
     * Método constructor
     */
    public function __construct(){
        parent::__construct();
        $this->id = -1;
        $this->objCompra = new Compra();
        $this->objProducto = new Producto;
        $this->cantidad = null;
        $this->mensajeOperacion = null;
    }

    /**
     * Carga datos a un objeto
     */
    public function cargar($id, $objProducto, $objCompra, $cantidad){
        $this->setId($id);
        $this->setObjProducto($objProducto);
        $this->setObjCompra($objCompra);
        $this->setCantidad($cantidad);
    }

    /**
     * Carga claves del objeto CompraItem
     * @param int $idCompra
     * @param int $idUsuario
     */
    public function cargarClaves($idCompra, $idProducto){
        $objCompra = $this->getObjCompra();
        $objProducto = $this->getObjProducto();

        $objCompra->setId($idCompra);
        $objProducto->setId($idProducto);

        $this->setObjCompra($objCompra);
        $this->setObjProducto($objProducto);
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getObjProducto(){
        return $this->objProducto;
    }
    public function setObjProducto($objProducto){
        $this->objProducto = $objProducto;
    }
    public function getObjCompra(){
        return $this->objCompra;
    }
    public function setObjCompra($objCompra){
        $this->objCompra = $objCompra;
    }
    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }


    /**
     * Busca un item por id.
     * Coloca su datos al objeto actual.
     * @param int $id
     * @return boolean
     */
    public function buscar($id){
        $resp = false;
        $consulta = "SELECT * FROM compraitem WHERE idcompraitem = '" . $id . "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                if($fila = $this->Registro()){
                    $objProducto = new Producto;
                    $objProducto->buscar($fila["idproducto"]);

                    $objCompra = new Compra();
                    $objCompra->buscar($fila["idcompra"]);

                    $this->cargar($fila["idcompraitem"],$objProducto,$objCompra,$fila["cicantidad"]);

                    $resp = true;
                }
            }else{
                $this->setMensajeOperacion("compraitem->buscar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("compraitem->buscar: ".$this->getError());
        }

        return $resp;
    }

    /**
     * Lista compras de la base de datos
     * @param string $condicion (opcional)
     * @return array|null
     */
    public function listar($condicion = ""){
        $arreglo = null;
        $consulta = "SELECT * FROM compraitem";

        if($condicion != ""){
            $consulta .= " WHERE " . $condicion;
        }

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $arreglo = [];
                while($fila = $this->Registro()){
                    $objCompraItem = new CompraItem();
                    $objCompraItem->buscar($fila["idcompraitem"]);
                    array_push($arreglo, $objCompraItem);
                }
            }else{
                $this->setMensajeOperacion("compraitem->listar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("compraitem->listar: ".$this->getError());
        }

        return $arreglo;
    }

    /**
     * Inserta una compra a la db
     * @return boolean
     */
    public function insertar(){
        $resp = null;
        $res = false;

        $consulta = "INSERT INTO compraitem(idproducto, idcompra, cicantidad)
        VALUES ('".$this->getObjProducto()->getId()."','". $this->getObjCompra()->getId() ."','". $this->getCantidad()  . "');";

        if($this->Iniciar()){
            $resp = $this->Ejecutar($consulta);
            if ($resp) {
                $this->setId($resp);
                $res = true;
            }else{
                $this->setmensajeoperacion("compraitem->insertar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("compraitem->insertar: ".$this->getError());
        }

        return $res;
    }

    /**
     * Modifica los datos de un compraitem
     * @return boolean
     */
    public function modificar(){
        $resp = false;

        $consulta = "UPDATE compraitem SET cicantidad = '". $this->getCantidad() . "'  WHERE idcompraitem = '" . $this->getId(). "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeOperacion("compraitem->modificar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("compraitem->modificar: ".$this->getError());
        }

        return $resp;
    }

    /**
     * Elimina una compra de la db
     * @return boolean
     */
    public function eliminar(){
        $resp = false;

        $consulta = "DELETE FROM compraitem WHERE idcompraitem = '" . $this->getId() ."'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeOperacion("compraitem->eliminar: ".$this->getError());
            }
        }else{
            $this->setMensajeOperacion("compraitem->eliminar: ".$this->getError());
        }

        return $resp;
    }
}
?>