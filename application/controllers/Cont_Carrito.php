<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont_Carrito extends CI_Controller {

	public function index()
	{
		
	}
        
        public function VerProducto($id_pro) {
                $prod=$this->Modelo_tv->SacaProducto($id_pro); 
		$this->CargaPlantilla(
                        $this->load->view('unprod', array(
                            'producto'=>$prod,
                        ), TRUE)
                        );
        }
        
         public function MeteCarrito() {
             //$prod=$this->Modelo_tv->SacaProducto($this->input->post('idpro')); 
             $datosprod=array(
                "id"=>$this->input->post('idpro'),
		"cantidad"=>$this->input->post('cantidad'),
		"precio"=>$this->input->post('prefi'),
             );
            $this->carrito->add($datosprod);

            $this->Muestracarrito();
            
            }
           public function MuestraCarrito() {
           
            $datos_carrito=$this->carrito->get_content();
            $pretotal=$this->carrito->precio_total();
            foreach ($datos_carrito as $key => $value) {
               $datos_carrito[$key]['nombrepro']=$this->Modelo_tv->SacaNombrePro(($value['id'])); 
            }
           $this->CargaPlantilla(
                        $this->load->view('Vistacarrito',array(
                        'datos_car'=>$datos_carrito,
                            'precio_total'=>$pretotal,
                            ),TRUE));
            } 
            public function LimpiaCarrito() {
                $this->carrito->destroy();
                redirect('','location',301);
            }
            
            public function EliminaProd($idunica) {
                $this->carrito->remove_producto($idunica);

                 if ($this->carrito->get_content()==null)
                 {
                 $this->carrito->destroy();
                 redirect('','location',301);                
                 }
                else{ 
                    redirect('/Cont_Carrito/MuestraCarrito','location',301);
                }
                 
            }
           protected function CargaPlantilla($cuerpo='') {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo
                ));            
        }
          
}     
             
             
             
           //$prod=$this->Modelo_tv->SacaProducto($id_pro); 
           