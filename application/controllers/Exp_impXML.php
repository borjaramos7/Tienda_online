<?php
/**
 * Controlador dedicado a la exportacion e importacion de XML
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Exp_impXML extends CI_Controller {

    public function index() {
        
    }
/**
 * Con una llamada al modelo saca las categorias actuales y las inserta en un XML
 * esta funcion se encarga de ,una vez que este completo crear el fichero xml.
 */
function exporta_cat() {
        
        $categorias = $this->Modelo_tv->Categorias();
        $xml = new SimpleXMLElement('<Productos_Por_Categoria/>');
        
        foreach ($categorias as $categoria) {    
             $catxml = $xml->addChild('categoria');
            foreach ($categoria as $clave => $valor) {
                
                if ($clave!= 'idcat')
                $catxml->addChild($clave, utf8_encode($valor));
                
                
            } $this->IncluyeArticulos($catxml, $categoria['idcat']);
        } 
        
         
        
        Header('Content-type: text/xml; charset=utf-8');
        Header('Content-type: octec/stream');
        Header('Content-disposition: filename="productosXcategorias.xml"');
        print($xml->asXML());
        //redirect('','location',301); 
    }


/**
 * Esta funcion es llamada en el for de la funcion anterior para cada categoria y recibe la etiqueta de la que es hijo
 * ($catxml) y la id de la categoria para que pueda sacar los productos de la categoria adecuada
 * @param type $catxml
 * @param type $idcateg
 */
function IncluyeArticulos($catxml,$idcateg) {
        
        
    
    $ProXCat = $this->Modelo_tv->ProductosCategoria($idcateg);
    
    
        $xmlarticulos = $catxml->addChild('articulos'); 
        
        foreach ($ProXCat as $articulo) {
            $xmlarticulo = $xmlarticulos->addChild('articulo'); 
          
            foreach ($articulo as $clave => $valor) {
                $xmlarticulo->addChild($clave, utf8_encode($valor));
                
            }           
        }
    
    }
     /**
      * Se encarga de llamar a la vista de importar datos pasandole la funcion que tiene que procesar el archivo subido
      */
    public function importar() {
        
        $action = "/Exp_impXML/Procesa";
        $this->CargaPlantilla(
                        $this->load->view('importarDatos',array(
                        'action' => $action
                            ),TRUE),"Selecciona un archivo para importar(XML)");
        /*$cuerpo = $this->load->view('importarXML', Array('' => ''), true);
        $this->load->view('View_plantilla', Array('cuerpo' => $cuerpo, 'homeactive' => 'active', 'titulo' => 'Importación en XML'));*/
    }
    
    /**
     * Coge el archivo subido especifica que se trata de un xml y llama a la funcion que se encarga
     * de insertarlo en la BBDD
     */
    public function Procesa() {

        $archivo = $_FILES['uploadedfile'];

        if (file_exists($archivo['tmp_name'])) {
            $contentXML = utf8_encode(file_get_contents($archivo['tmp_name']));
            $xml = simplexml_load_string($contentXML);

            $this->InsertaXMLEnBBDD($xml);

            $this->CargaPlantilla(" ","Has importado los datos con exito");
        } else {
            exit('Los datos no hasn sido importados satisfactoriamente');
        }
    }

    /**
     * Recibe el xml con los datos a insertar y le pasa los datos necesarios al modelo para su insercion
     * @param type $xml
     */
    function InsertaXMLEnBBDD($xml) {

        foreach ($xml as $categoria) {

            $cat['codcat'] = (string) $categoria->codcat;
            $cat['nombrecat'] = (string) $categoria->nombrecat;
            $cat['descrip_cat'] = (string) $categoria->descrip_cat;

            $categoria_id = $this->Modelo_tv->AddCategoria($cat);

            foreach ($categoria->articulos->articulo as $articulo) {
                
                
                $pro['categoria_idcat'] = $categoria_id;
                $pro['codpro'] = (string) $articulo->codpro;
                $pro['nombrepro'] = (string) $articulo->nombrepro;
                $pro['precio'] = (string) $articulo->precio;
                $pro['descuento'] = (string) $articulo->descuento;
                $pro['imagenpro'] = (string) $articulo->imagenpro;
                $pro['iva'] = (string) $articulo->iva;
                $pro['descripcion'] = (string) $articulo->descripcion; 
                $pro['anuncio'] = (string) $articulo->anuncio;
                $pro['destacado'] = (string) $articulo->destacado;
                $pro['fechacom'] = (string) $articulo->fechacom;
                $pro['fechafin'] = (string) $articulo->fechafin;
                $pro['stock'] = (string) $articulo->stock;
                $pro['oculto'] = (string) $articulo->oculto;

                $this->Modelo_tv->AddProducto($pro);
            }
        }
    }
    
    protected function CargaPlantilla($cuerpo='',$encabezado="") {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo,
                'encabezado'=>$encabezado
                ));   
           }
}