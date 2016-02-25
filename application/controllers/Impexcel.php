<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impexcel extends PHPExcel {

    public function importaexcel() {
        $action = "/Impexcel/Procesaexcel";
        
        $this->CargaPlantilla(
                        $this->load->view('importarXML',array(
                        'action' => $action
                            ),TRUE),"Selecciona un archivo para importar");
    }
    
    
    
    
    
    
}
