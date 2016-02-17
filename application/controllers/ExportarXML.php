<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportarXML extends CI_Controller {

    public function index() {
        
    }

function exporta_cat() {
        
        $categorias = $this->modelo_tv->Categorias();
        print_r($categorias);
        $xml = new SimpleXMLElement('<Productos_Por_Categoria/>');
        
        foreach ($categorias as $categoria) {    
             $catxml = $xml->addChild('categoria');
            foreach ($categoria as $clave => $valor) {
                
                if ($clave!= 'idcat')
                $catxml->addChild($clave, utf8_encode($valor));
                
                
            } $this->IncluyeArticulos($catxml, $categoria['idcat']);
        } 
        
         
        
        Header('Content-type: octec-stream');
        
        $nomarch="Articulos_Por_Categoria";
        // Guardando el xml
        $xml->asXML("C:/xampp/htdocs/PracticaB2/asset/".$nomarch. ".xml");
        redirect('','location',301); 
    }



function IncluyeArticulos($catxml,$idcateg) {
        
        
    
    $ProXCat = $this->modelo_tv->ProductosCategoria($idcateg);
    
    //echo "<pre>".print_r($ProXCat)."</pre>";
        $xmlarticulos = $catxml->addChild('articulos'); 
        
        foreach ($ProXCat as $articulo) {
            $xmlarticulo = $xmlarticulos->addChild('articulo'); 
          
            foreach ($articulo as $clave => $valor) {
                $xmlarticulo->addChild($clave, utf8_encode($valor));
                
            }           
        }
    
    /*$articulos=$this->modelo_tv->SacaTodosProductos();
        $xml = new SimpleXMLElement('<xml/>');
        
         foreach ($articulos as $key => $articulo) {    
             $art = $xml->addChild('articulo');
            foreach ($articulo as $key => $value) {
                $art->addChild($key, $value);
            } 
        } 
        
        Header('Content-type: octec-stream');
        
        $nomarch="articulos";

        $xml->asXML("C:/xampp/htdocs/PracticaB2/asset/".$nomarch. ".xml");
        redirect('','location',301); */
    }
}