<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exp_impXML extends CI_Controller {

    public function index() {
        
    }

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
    public function importar() {
        $this->CargaPlantilla(
                        $this->load->view('importarXML',array(
                        "" => ""
                            ),TRUE),"Selecciona un archivo para importar");
        /*$cuerpo = $this->load->view('importarXML', Array('' => ''), true);
        $this->load->view('View_plantilla', Array('cuerpo' => $cuerpo, 'homeactive' => 'active', 'titulo' => 'Importación en XML'));*/
    }

    public function ProcesaArchivo() {

        $archivo = $_FILES['archivo'];

        if (file_exists($archivo['tmp_name'])) {
            $contentXML = utf8_encode(file_get_contents($archivo['tmp_name']));
            $xml = simplexml_load_string($contentXML);

            $this->InsertFromXML($xml);

            $cuerpo = $this->load->view('View_importacionXMLCorrecta', '', true);
            $this->load->view('View_plantilla', Array('cuerpo' => $cuerpo, 'titulo' => 'Importación en XML', 'homeactive' => 'active'));
        } else {
            exit('Error abriendo el archivo XML');
        }
    }

    //Función que crea un array con los datos que lee desde el xml para insertarlos
    function InsertFromXML($xml) {

        foreach ($xml as $categoria) {

            $cat['codcat'] = (string) $categoria->codcat;
            $cat['nombrecat'] = (string) $categoria->nombrecat;
            $cat['descrip_cat'] = (string) $categoria->descrip_cat;

            $categoria_id = $this->Modelo_tv->AddCategoria($cat);//Guardamos su id para poder insertar las camisetas en esa categoría

            foreach ($categoria->articulos->articulo as $articulo) {
                
                
                $pro['categoria_idcat'] = $categoria_id;
                $pro['cod_pro'] = (string) $articulo->cod_pro;
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