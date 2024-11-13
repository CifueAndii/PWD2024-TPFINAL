<?php
class AbmUsuario{
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

        if(array_key_exists('nombre',$param) and array_key_exists('pass',$param) and array_key_exists('mail', $param) and array_key_exists('deshabilitado', $param)){
            $obj = new Usuario();
        
            $obj->cargar(null, $param["nombre"],$param["pass"],$param["mail"],$param["deshabilitado"]);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Usuario|null
     */
    private function cargarObjetoConClave($param){
        $obj = null;

        if(isset($param['id']) ){
            $obj = new Usuario();
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
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);

            $elObjtTabla->setDeshabilitado("NOW()");

            if ($elObjtTabla!=null and $elObjtTabla->modificar()){
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
                $where.=" and idusuario =".$param['id'];
            if(isset($param['nombre']))
                $where.=" and usnombre ='".$param['nombre']."'";
            if(isset($param['pass']))
                $where.=" and uspass ='".$param['pass']."'";
            if(isset($param['mail']))
                $where.=" and usmail ='".$param['mail']."'";
            if(isset($param['deshabilitado']))
                $where.=" and usdeshabilitado ='".$param['deshabilitado']."'";
        }

        $obj = new Usuario();
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
            if(isset($param['id']))
                $where.=" and idusuario =".$param['id'];
        }

        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}
?>