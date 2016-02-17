<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function index()
	{
		$producto=$this->modelo_tv->ProDestacados(); 
		$this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE)
                        );  
	}
        
        public function VerCategoria($categoria_id) {
                $producto=$this->modelo_tv->ProductosCategoria($categoria_id);
		$this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE)
                        );
        }
        
        public function VerDestacado() {
                $producto=$this->modelo_tv->ProDestacados(); 
		$this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE)
                        );
        }
        
        /*public function VerProducto($id_pro) {
                $prod=$this->modelo_tv->SacaProducto($id_pro); 
		$this->CargaPlantilla(
                        $this->load->view('unprod', array(
                            'producto'=>$prod,
                        ), TRUE)
                        );
        }*/
        
        /* Codigo de carrito
         * <a href="<?=base_url()?>index.php/Cont_Carrito/MeteCarrito/<?=$prod->id?>/"
                                   class="btn btn-default add-to-cart">
                                    <i class="glyphicon glyphicon-shopping-cart"></i></a>*/

        protected function CargaPlantilla($cuerpo='') {
            $categ=$this->modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo
                ));            
        }

    
}
