<?php
class AbmCompraItem{

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
     * @return CompraItem|null
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('idcompraitem',$param) && array_key_exists('idproducto', $param) && array_key_exists('idcompra', $param) && array_key_exists('cicantidad', $param)){
            $objProducto = new Producto();
            $objProducto->buscar($param['idproducto']);

            $objCompra = new Compra();
            $objCompra->buscar($param['idcompra']);

            $obj = new CompraItem();
            $obj->cargar($param['idcompraitem'], $objProducto, $objCompra, $param['cicantidad']);
        }

        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraItem|null
     */
    private function cargarObjetoConClave($param){
        $obj = null;

        if(isset($param['idcompraitem'])){
            $obj = new Compra();
            $obj->buscar($param["idcompraitem"]);
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
        if (isset($param['idcompraitem']))
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
            if(isset($param['idcompraitem']))
                $where.=" and idcompraitem =".$param['idcompraitem'];
            if(isset($param['idproducto']))
                $where.=" and idproducto ='".$param['idproducto']."'";
            if(isset($param['idcompra']))
                $where.=" and idcompra ='".$param['idcompra']."'";
            if(isset($param['cicantidad']))
                $where.=" and cicantidad ='".$param['cicantidad']."'";
        }

        $obj = new CompraItem();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}


?>