<?php
class AbmUsuarioRol{
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
     * @return Usuario|null
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('idrol',$param) and array_key_exists('idusuario',$param)){
            $objRol = new Rol();
            $objRol->buscar($param['idrol']);

            $objUsuario = new Usuario();
            $objUsuario->buscar($param['idusuario']);

            $obj = new UsuarioRol();
            $obj->cargar($objRol, $objUsuario);
        }
        return $obj;
    }


    /**
     * Permite dar de alta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);

        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);

        if ($elObjtTabla != null and $elObjtTabla->modificar()) {
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
            if(isset($param['idrol']))
                $where.=" and idrol =".$param['idrol'];
            if(isset($param['idusuario']))
                $where.=" and idusuario ='".$param['idusuario']."'";
        }

        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

        /**
     * Retorna los roles de un usuario
     * @param array $param
     * @return array
     */
    public function buscarRoles($param){
        $where = " true ";

        if ($param<>null){
            if(isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
        }

        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}
?>