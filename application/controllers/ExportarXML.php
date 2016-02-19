<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportarXML extends CI_Controller {

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
}