<?php
class AbmCompraEstado{

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
     * @return CompraEstado|null
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('idcompra',$param)){
            // obtengo el obj compra asociado
            $objCompra = new Compra();
            $objCompra->buscar($param['idcompra']);

            // obtengo el obj compraestadotipo
            if (array_key_exists('idcompraestadotipo', $param)){
                $objCompraEstado = new CompraEstadoTipo();
                $objCompraEstado->buscar($param['idcompraestadotipo']);
            } else $objCompraEstado = null;

            if (array_key_exists('cefechaini', $param)){
                $cefechaini = $param['cefechaini'];
            } else $cefechaini = '0000-00-00 00:00:00';

            if (array_key_exists('cefechafin', $param)){
                $cefechafin = $param['cefechafin'];
            } else $cefechafin = '0000-00-00 00:00:00';

            // armo el compraestado
            $obj = new CompraEstado();
            $obj->cargar($param['idcompraestado'], $objCompra, $objCompraEstado, $cefechaini, $cefechafin);
        }

        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraEstado|null
     */
    private function cargarObjetoConClave($param){
        $obj = null;

        if(isset($param['idcompraestado'])){
            $obj = new CompraEstado();
            $obj->buscar($param["idcompraestado"]);
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
        if (isset($param['idcompraestado']))
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
            $elObjtTabla->setId($param["idcompraestado"]);
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
            if(isset($param['idcompraestado']))
                $where.=" and idcompraestado =".$param['idcompraestado'];

            if(isset($param['idcompra']))
                $where.=" and idcompra ='".$param['idcompra']."'";

            if(isset($param['idcompraestadotipo']))
                $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";

            if(isset($param['cefechaini']))
            $where.=" and cefechaini ='".$param['cefechaini']."'";

            if(isset($param['cefechafin']))
            $where.=" and cefechafin ='".$param['cefechafin']."'"; 
        }

        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}


?>