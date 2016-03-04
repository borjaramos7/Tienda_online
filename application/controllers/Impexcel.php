<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impexcel extends CI_Controller {

    protected function CargaPlantilla($cuerpo='',$encabezado="") {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo,
                'encabezado'=>$encabezado
                ));   
           }
    
    public function importaexcel() {
        $action = "/Impexcel/Procesaexcel";
        
        $this->CargaPlantilla(
                        $this->load->view('importarDatos',array(
                        'action' => $action
                            ),TRUE),"Selecciona un archivo para importar(Excel)");
    }
    
    public function Procesaexcel() {
        $archivo = $_FILES['uploadedfile'];
        $ExcelPHP = PHPExcel_IOFactory::load($archivo['tmp_name']);
        foreach ($ExcelPHP->getWorksheetIterator() as $worksheet) {
            //$worksheet=$ExcelPHP->getWorksheetIterator();
            $cat['codcat'] = $worksheet->getCellByColumnAndRow(4,3)->getValue();
            $cat['nombrecat'] = $worksheet->getCellByColumnAndRow(5,3)->getValue();
            $cat['descrip_cat'] = $worksheet->getCellByColumnAndRow(6,3)->getValue();
            
            
            
            $categoria_id = $this->Modelo_tv->AddCategoria($cat);
            
            $cont_pro = $worksheet->getHighestRow();
 
            $pro['categoria_idcat'] = $categoria_id;
            
            for ($fila = 7; $fila <= $cont_pro; ++$fila) {

                for ($col = 0; $col <= 12; ++$col) {
                
                switch ($col) {
                    case 0:$pro['codpro'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 1:$pro['nombrepro'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 2:$pro['precio'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 3:$pro['descuento'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 4:$pro['imagenpro'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 5:$pro['iva'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 6:$pro['descripcion'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 7:$pro['anuncio'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 8:$pro['stock'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 9:$pro['destacado'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 10:$pro['fechacom'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 11:$pro['fechafin'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 12:$pro['oculto'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    }
                }
                    $this->Modelo_tv->AddProducto($pro);
        
            }//echo "</pre>".print_r($pro)."</pre>";
        }
    }
      
}
