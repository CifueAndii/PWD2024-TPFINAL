<?php
class AbmMenuRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los uspasss de las variables instancias del objeto
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
     * @return MenuRol|null
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('idmenu',$param) and array_key_exists('idrol',$param)){
            $objMenu = new Menu();
            $objMenu->buscar($param['idmenu']);

            $objRol = new Rol();
            $objRol->buscar($param['idrol']);
        
            $obj = new MenuRol();
            $obj->cargar($objMenu, $objRol);
        }
        return $obj;
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

        $elObjtMenuRol = $this->cargarObjeto($param);

        if ($elObjtMenuRol != null and $elObjtMenuRol->eliminar()) {
            $resp = true;
        }

        return $resp;
    }

    /**
     * Permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->modificar()) {
            $resp = true;
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
            if(isset($param['idmenu']))
                $where.=" and idmenu =".$param['idmenu'];
            if(isset($param['idrol']))
                $where.=" and idrol ='".$param['idrol']."'";
        }

        $obj = new MenuRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}


?>