<?php
class AbmCompra{

    //Espera como parametro un arreglo asociativo donde las claves coinciden con las variables instancias del objeto
    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('idusuario',$param)){
            $obj = new Compra();

            $objUsuario = new Usuario;
            $objUsuario->buscar($param["idusuario"]);
        
            $obj->cargar(null,"NOW()", $objUsuario);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjetoConClave($param){
        $obj = null;

        if(isset($param['id'])){
            $obj = new Compra();
            $obj->buscar($param["id"]);
        }
        return $obj;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['id']))
            $resp = true;
        return $resp;
    }

    /**
     * Permite dar de alta un objeto
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);

        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * Permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * Permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            $elObjtTabla->setId($param["id"]);
            if($elObjtTabla!=null and $elObjtTabla->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";

        if($param<>NULL){
            if(isset($param['id']))
                $where.=" and idcompra =".$param['id'];
            if(isset($param['cofecha']))
                $where.=" and cofecha ='".$param['cofecha']."'";
            if(isset($param['idusuario']))
                $where.=" and idusuario ='".$param['idusuario']."'";
        }

        $obj = new Compra();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Retorna el carrito de un usuario
     * @param array $param
     * @return Compra|null
     */
    public function retornarCarrito($param){
        $resp = null;

        if(isset($param["idusuario"])){
            $objUsuario = new Usuario;
            $objUsuario->buscar($param["idusuario"]);

            $objCompra = new Compra;
            $objCompra->setObjUsuario($objUsuario);
            $resp = $objCompra->buscarCompraCarrito();
        }

        return $resp;
    }

    /**
     * Ingresa el estado inicial de una compra
     * @param array $param
     * @return boolean
     */
    public function estadoInicial($param){
        $resp = false;
        $objCompra = $this->seteadosCamposClaves($param);

        if($objCompra){
            $estadoCompra = 1;
            $objCompraEstado = new CompraEstado;
            $objCompraEstado->cargarClaves($param["id"], $estadoCompra);

            if($objCompraEstado->insertar()){
                $resp = true;
            }
        }
        return $resp;
    }

    //FUNCIONES DEL ESTADO DE UNA COMPRA

    /**
     * Busca el estado de una compra
     * @param array $param
     * @return array|null
     */
    public function buscarEstado($param){
        $where = " true ";

        if($param<>NULL){
            if(isset($param['id']))
                $where.=" and idcompra =".$param['id'];
            if(isset($param['idcompraestadotipo']))
                $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";
            if(isset($param['fechafin']))
                $where.=" and cefechafin ='".$param['fechafin']."'";
        }

        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Cambia el estado de una compra
     * @param array $param
     * @return boolean
     */
    public function cambiarEstado($param){
        $resp = false;
        $objCompra = $this->seteadosCamposClaves($param);

        if($objCompra && isset($param["idcompraestadotipo"]) && $this->finalizarEstado($param)){
            $objCompraEstado = new CompraEstado;
            $objCompraEstado->cargarClaves($param["id"],$param["idcompraestadotipo"]);

            if($objCompraEstado->insertar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Finaliza el estado de una compra
     * @param array $param
     * @return boolean
     */
    public function finalizarEstado($param){
        $resp = false;
        $objCompra = $this->seteadosCamposClaves($param);

        if($objCompra){
            $objCompraEstado = new CompraEstado();
            $arreglo = $objCompraEstado->listar("idcompra = " . $param["id"] . " AND cefechafin = '0000-00-00 00:00:00'");
            
            if(isset($arreglo) && count($arreglo) > 0 && $arreglo[0]->finalizarEstado()){
                $resp = true;
            }
        }
        return $resp;
    }


    //FUNCIONES DEL ITEM DE UNA COMPRA

    /**
     * Agrega un Item a una compra
     * @param array
     * @return boolean
     */
    public function agregarItem($param){
        $resp = false;
        $objCompra = $this->seteadosCamposClaves($param);

        if($objCompra && isset($param["idproducto"]) && isset($param["cantidad"])){
            $objCompraItem = new CompraItem();
            $objCompraItem->cargarClaves($param["id"], $param["idproducto"]);
            $objCompraItem->setCantidad($param["cantidad"]);
            if($objCompraItem->insertar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modifica un Item de la compra
     * @param array
     * @return boolean
     */
    public function modificarItem($param){
        $resp = false;

        if(isset($param["idcompraitem"]) && isset($param["cantidad"])){
            $objCompraItem = new CompraItem();
            $objCompraItem->buscar($param["idcompraitem"]);
            $objCompraItem->setCantidad($param["cantidad"]);
            if($objCompraItem->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Elimina un Item de la compra
     * @param array
     * @return boolean
     */
    public function eliminarItem($param){
        $resp = false;

        if(isset($param["idcompraitem"])){
            $objCompraItem = new CompraItem();
            $objCompraItem->buscar($param["idcompraitem"]);
            if($objCompraItem->eliminar()){
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * Retorna todos los Items de la compra
     * @param array $param
     * @return array|null
     */
    public function buscarItems($param){
        $where = " true ";

        if($param<>NULL){
            if(isset($param['id']))
                $where.=" and idcompra =".$param['id'];
            if(isset($param['idcompraitem']))
                $where.=" and idcompraitem ='".$param['idcompraitem']."'";
            if(isset($param['idproducto']))
                $where.=" and idproducto ='".$param['idproducto']."'";
        }

        $obj = new CompraItem();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**Cambia de estado todas las variables relacionadas a concretar un pago
     * @param array $param
     * @return boolean
     */
    public function pago($param){
        $res = false;
    
        $param["idcompraestadotipo"] = 2;
        $resp = $this->cambiarEstado($param);
    
        if($resp){
            $abmProducto = new AbmProducto();
            $items = $this->buscarItems($param);
    
            if(isset($items)){
                foreach($items as $item){
                    $abmProducto->cambiarStock(["id" => $item->getObjProducto()->getId(),"cantidad" => $item->getCantidad(),"operacion" => "resta"]);
                }
                $res = true;
            }
        }
    
        return $res;
    }
}


?>