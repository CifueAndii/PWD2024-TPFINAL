<?php
class AbmProducto
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los uspasss de las variables instancias del objeto

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Producto|null
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('nombre', $param) and array_key_exists('proartista', $param) and array_key_exists('proprecio', $param) and array_key_exists('detalle', $param) and array_key_exists('cantstock', $param) and array_key_exists('protipo', $param) and array_key_exists('prodeshabilitado', $param) and array_key_exists('proimg64', $param)) {
            $obj = new Producto();

            $obj->cargar(null, $param["nombre"], $param["proartista"], $param['proprecio'], $param["detalle"],  $param["cantstock"], $param['protipo'], $param['prodeshabilitado'], $param['proimg64']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Rol|null
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['id'])) {
            $obj = new Producto();
            $obj->buscar($param["id"]);
        }
        return $obj;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['id']))
            $resp = true;
        return $resp;
    }

    /**
     * Permite dar de alta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = array();
        $elObjtTabla = $this->cargarObjeto($param);


        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = array('resultado' => true, 'error' => '', 'obj' => $elObjtTabla);
        } else {
            $resp = array('resultado' => false, 'error' => $elObjtTabla->getmensajeoperacion());
        }

        return $resp;
    }


    /**
     * Sube un archivo
     * @param array $param
     * @return boolean
     */
    public function subirArchivo($param)
    {
        $dir = "../../../Control/img_productos/";
        $resp = false;

        if ($param['imagen']['imagen']['error'] <= 0 && $param['imagen']['imagen']['type'] == "image/jpeg") {
            if (copy($param['imagen']['imagen']['tmp_name'], $dir . md5($param["id"]) . ".jpg")) {
                $resp = true;
            }
        }

        return $resp;
    }

    public function altaProducto($data)
    {
        $respuesta = false;

        if (isset($data['nombre'])) {
            if ($this->alta($data)){
                $respuesta = true;
            }

        } 

        if ($respuesta) {
            $this->subirArchivo(["imagen" => $_FILES, "id" => $respuesta["obj"]->getId()]);
        }

        return $respuesta;
    }

    /**
     * Permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
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
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            $elObjtTabla->setId($param["id"]);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
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
    public function buscar($param)
    {
        $where = " true ";
        $claves = ["idproducto" ?? "id", "nombre", "proartista", "proprecio", "detalle", "cantstock", "protipo", "deshabilitado", "proimg"];
        $db = ["idproducto", "pronombre", "proartista", "proprecio", "prodetalle", "procantstock", "protipo", "prodeshabilitado", "proimg64"];


        if ($param <> null) {
            for ($i = 0; $i < count($claves); $i++) {
                if (isset($param[$claves[$i]])) {
                    $where .= " and " . $db[$i] . " = '" . $param[$claves[$i]]  . "'";
                }
            }
        }

        $obj = new Producto();
        $arreglo = $obj->listar($where);

        return $arreglo;
    }

    /**
     * Suma al stock
     * @param array $param ["id" => 1, "cantidad" => "1", "operacion" => "suma"|"resta"]
     * @return boolean
     */
    public function cambiarStock($param)
    {
        $resp = false;

        if (isset($param["id"])) {
            $resultado = $this->buscar(["idproducto" => $param["id"]]);
        }

        if (isset($resultado) && count($resultado) > 0 && isset($param["cantidad"]) && isset($param["operacion"])) {

            $objProducto = $resultado[0];
            switch ($param["operacion"]) {
                case "suma":
                    $objProducto->setCantStock($objProducto->getCantStock() + $param["cantidad"]);
                    $resp = $objProducto->modificar();
                    break;
                case "resta":
                    $objProducto->setCantStock($objProducto->getCantStock() - $param["cantidad"]);
                    $resp = $objProducto->modificar();
                    break;
            }
        }

        return $resp;
    }


    public function listarProductosActivos(){
        $param["deshabilitado"] = null;
$list = $this->buscar($param);

$arreglo_salida =  array();

foreach ($list as $elem){
    $nuevoElem['id'] = $elem->getId();
    $nuevoElem["nombre"]=$elem->getNombre();
    $nuevoElem["artista"] = $elem->getArtista();
    $nuevoElem["proprecio"] = $elem->getPrecio();
    $nuevoElem["detalle"] = $elem->getDetalle();
    $nuevoElem["cantStock"] = $elem->getCantStock();

    $nuevoElem["imagen"] = '<a href="../Vista/'. $elem->getImg() .'" class="btn btn-secondary">Ver</a>';
    
    $nuevoElem["accion"] =
    '<button class="btn btn-warning" id="edit-' . $elem->getId() . '" onclick="editMenu();">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg>
    </button>';
    array_push($arreglo_salida,$nuevoElem);
}

return $arreglo_salida;
    }
}
