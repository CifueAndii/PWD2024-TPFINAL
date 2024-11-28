<?php

class AbmCompra{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con las variables instancias del objeto
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('idusuario',$param)){
            $obj = new Compra();

            $objUs = new Usuario;
            $objUs->buscar($param["idusuario"]);
        
            $obj->cargar(null,"NOW()", $objUs);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Rol|null
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
        $resp = array();
        $elObjtTabla = $this->cargarObjeto($param);

        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = array('resultado'=> true,'error'=>'', 'obj' => $elObjtTabla);
        }else {
            $resp = array('resultado'=> false,'error'=> $elObjtTabla->getMensajeOperacion());
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
        $claves = ["id","cofecha", "idusuario"];
        $db = ["idcompra","cofecha", "idusuario"];


        if ($param<>null){
            for($i = 0; $i < count($claves); $i++){
                if(isset($param[$claves[$i]])){
                    $where.= " and " . $db[$i] . " = '". $param[$claves[$i]]  ."'";
                }
            }
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
        $resultado = null;

        if(isset($param["idusuario"])){
            $obj = new Usuario;
            $obj->buscar($param["idusuario"]);

            $objCo = new Compra;
            $objCo->setObjUsuario($obj);
            $resultado = $objCo->buscarCarrito();
        }

        return $resultado;
    }

    /**
     * busca el carrito de un usuario
     * @param array $param
     * @return Compra|null
     */
    public function agregarCarrito($param){
        $respuesta = false;
        // Si no hay carrito, lo creo.
        if(!isset($param["carrito"])){
            $resultado = $this->alta($param);
                if(isset($resultado)){
                    $param["id"] = $resultado["obj"]->getId();
                    // Crear estado
                    $respuesta = $this->estadoInicial($param);
                    $respuesta = true;
                }
        }else{
            $param["id"] = $param["carrito"]->getId();
            $respuesta = true;
        }

        $banderaItem = false;

        // Retorna un unico resultado o null
        $item = $this->buscarItems($param);

        if(isset($item) && $respuesta){
            // Encontre producto igual
            $param["idcompraitem"] = $item[0]->getId();
            $param["cantidad"] = $item[0]->getCantidad() + $param["cantidad"];
    
            if($item[0]->getObjProducto()->getCantStock() >= $param["cantidad"]){
                $respuesta = $this->modificarItem($param);
                $banderaItem = true;
            }
        }elseif($respuesta){
        // No encontre producto igual
            if($param["producto"][0]->getCantStock() >= $param["cantidad"]){
                $respuesta = $this->agregarItem($param);
                $banderaItem = true;
            }
        }
        $array["bandera"] = $banderaItem;
        $array["respuesta"] = $respuesta;

        return $array;
    }

    // Cambios de estado

    /**
     * Cambia el estado de una compra
     * @param array $param
     * @return boolean
     */
    public function cambiarEstado($param){
        $resp = false;

        if($this->seteadosCamposClaves($param) && isset($param["idcompraestadotipo"]) && $this->finalizarEstado($param)){
            $objCompraEstado = new CompraEstado;
            $objCompraEstado->cargarClaves($param["id"],$param["idcompraestadotipo"]);

            if($objCompraEstado->insertar()){
                $resp = true;
                enviarMail($param);
            }
        }
        return $resp;
    }

    /**
     * Agrega el estado inicial de una compra
     * @param array $param
     * @return boolean
     */
    public function estadoInicial($param){
        $resp = false;

        if($this->seteadosCamposClaves($param)){
            $estadoInicial = 1;

            $objCompraEstado = new CompraEstado;
            $objCompraEstado->cargarClaves($param["id"], $estadoInicial);

            if($objCompraEstado->insertar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Finaliza el estado anterior
     * @param array $param
     * @return boolean
     */
    public function finalizarEstado($param){
        $resp = false;

        if($this->seteadosCamposClaves($param)){
            // Revisar si existe una compra estado que estÃ© activa
            $objCompraEstado = new CompraEstado();
            $arreglo = $objCompraEstado->listar("idcompra = " . $param["id"] . " AND cefechafin = '0000-00-00 00:00:00'");
            
            if(isset($arreglo) && count($arreglo) > 0 && $arreglo[0]->finalizar()){
                $resp = true;
            }
        }
        return $resp;

    }

    /**
     * Dado el id de una compra, obtiene su estado
     * @param array $param
     * @return array|null
     */
    public function buscarEstado($param){
        $where = " true ";
        $claves = ["id", "idcompraestadotipo", "fechafin"];
        $db = ["idcompra","idcompraestadotipo", "cefechafin"];


        if ($param<>null){
            for($i = 0; $i < count($claves); $i++){
                if(isset($param[$claves[$i]])){
                    $where.= " and " . $db[$i] . " = '". $param[$claves[$i]]  ."'";
                }
            }
        }

        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Agrega un item
     * @param array
     * @return boolean
     */
    public function agregarItem($param){
        $resp = false;

        if($this->seteadosCamposClaves($param) && isset($param["idproducto"]) && isset($param["cantidad"])){
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
     * Modifica un item
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
     * Elimina un item
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
     * Retorna todos sus obj item
     * @param array $param
     * @return array|null
     */
    public function buscarItems($param){
        $where = " true ";
        $claves = ["id", "idcompraitem", "idproducto"];
        $db = ["idcompra", "idcompraitem", "idproducto"];


        if ($param<>null){
            for($i = 0; $i < count($claves); $i++){
                if(isset($param[$claves[$i]])){
                    $where.= " and " . $db[$i] . " = '". $param[$claves[$i]]  ."'";
                }
            }
        }

        $obj = new CompraItem();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * 
     */
    public function accionPago($param){
        $resultado = false;
    
        // Cambio de estado de la compra a "iniciada"
        $param["idcompraestadotipo"] = 2; // iniciada
        $resultado = $this->cambiarEstado($param);
    
        if ($resultado) {
            $abmProducto = new AbmProducto();
    
            $list = $this->buscarItems($param);
    
            if (isset($list)) {
                foreach ($list as $item) {
                    $abmProducto->cambiarStock([
                        "id" => $item->getObjProducto()->getId(),
                        "cantidad" => $item->getCantidad(),
                        "operacion" => "resta"
                    ]);
                }
            }

        }
    
        return $resultado;
    }

    public function cancelarCompra($param){
        $resp = false;
        
        if ($this->cambiarEstado($param)){
            $resp = true;

            $abmProducto = new AbmProducto;

            $list = $this->buscarItems($param);

            if(isset($list)){
                foreach($list as $item){
                $abmProducto->cambiarStock(["idproducto" => $item->getObjProducto()->getId(),"cantidad" => $item->getCantidad(),"operacion" => "suma"]);
                }   
            }
        }

        return $resp;
    }

    public function listarPedidosVigentes()
    {
        $list = $this->buscarEstado(["fechafin" => '0000-00-00 00:00:00']);

        $arreglo_salida = array();

        if (isset($list) && count($list) > 0) {
            foreach ($list as $elem) {
                if ($elem->getObjCompraEstadoTipo()->getIdcet() != 1) {
                    $nuevoElem["id"] = $elem->getObjCompra()->getId();

                    $nuevoElem["productos"] = "";
                    $items = $this->buscarItems(["id" => $nuevoElem["id"]]);

                    $nuevoElem["usuario"] = $elem->getObjCompra()->getObjUsuario()->getNombre();

                    if (isset($items) && count($items) > 0) {
                        $nuevoElem["productos"] .= "<ul>";
                        foreach ($items as $item) {
                            $nuevoElem["productos"] .=
                            '<li>
                        ' .  mb_strimwidth($item->getObjProducto()->getNombre(), 0, 20, "...") . 'x ' . $item->getCantidad() . '
                        </li>';
                        }
                        $nuevoElem["productos"] .= "</ul>";
                    }


                    $nuevoElem["fecha"] = $elem->getObjCompra()->getCoFecha();

                    $nuevoElem["estado"] = "";

                    $nuevoElem["estadofecha"] = $elem->getFechaIni();


                    $nuevoElem["estado"] .= '<span class="badge rounded-pill text-bg-primary mx-1" id="' . $nuevoElem["id"] . '-' . $elem->getObjCompraEstadoTipo()->getIdcet() . '">
                    ' . $elem->getObjCompraEstadoTipo()->getCetdescripcion() . "</span>";

                    $nuevoElem["estadoid"] = $elem->getObjCompraEstadoTipo()->getIdcet();

                    $nuevoElem["accion"] = "";
                    if ($nuevoElem["estadoid"] != 5) {
                        $nuevoElem["accion"] =
                            '<button class="btn btn-warning" id="edit-' . $nuevoElem["id"] . '" onclick="editMenu();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                        </button>
                        <button class="btn btn-danger borrado" id="delete-' . $nuevoElem["id"] . '" onclick="destroyMenu();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </button>';
                    }

                    if ($nuevoElem["estadoid"] == 4) {
                        $nuevoElem["accion"] =
                            '
                        <button class="btn btn-danger borrado" id="delete-' . $nuevoElem["id"] . '" onclick="destroyMenu();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </button>';
                    }

                    array_push($arreglo_salida, $nuevoElem);
                }
            }
        }

        return $arreglo_salida;
    }


    public function listarPedidosUsuario($param)
    {


        $list = $this->buscar($param);

        $arreglo_salida =  array();

        if (isset($list) && count($list) > 0) {
            foreach ($list as $elem) {
                $nuevoElem["id"] = $elem->getId();

                $nuevoElem["productos"] = "";
                $items = $this->buscarItems(["id" => $elem->getId()]);

                if (isset($items) && count($items) > 0
                ) {
                    $nuevoElem["productos"] .= "<ul>";
                    foreach ($items as $item) {
                        $nuevoElem["productos"] .=
                        '<li>
                ' .  mb_strimwidth($item->getObjProducto()->getNombre(), 0, 20, "...") . 'x ' . $item->getCantidad() . '
                </li>';
                    }
                    $nuevoElem["productos"] .= "</ul>";
                }

                $nuevoElem["fecha"] = $elem->getCoFecha();

                $nuevoElem["estado"] = "";
                $estado = $this->buscarEstado(["id" => $elem->getId(), "fechafin" => "0000/00/00 00:00"]);

                if ($estado[0]->getObjCompraEstadoTipo()->getIdcet() == 2) {
                    $nuevoElem["accion"] =
                    '<button class="btn btn-danger borrado" id="delete-' . $elem->getId() . '" onclick="destroyMenu();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                </svg>
            </button>';
                } else {
                    $nuevoElem["accion"] =
                    '<button class="btn btn-danger borrado disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                </svg>
            </button>';
                }

                $nuevoElem["estado"] .= '<span class="badge rounded-pill text-bg-primary mx-1" id="' . $elem->getId() . '-' . $estado[0]->getObjCompraEstadoTipo()->getIdcet() . '">
                    ' . $estado[0]->getObjCompraEstadoTipo()->getCetdescripcion() . "</span>";

                array_push($arreglo_salida, $nuevoElem);
            }
        }

        return $arreglo_salida;
    }

}


?>
