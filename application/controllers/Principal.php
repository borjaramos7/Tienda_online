<?php
/**
 * Controlador de productos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function index()
	{
		$producto=$this->Modelo_tv->ProDestacados(); 
		$this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE)
                        );  
	}
        /**
         * Recibe una id y saca los productos que sean de esa categoria para mandarselos a la vista que los muestra
         * @param type $categoria_id
         */
        public function VerCategoria($categoria_id) {
                $producto=$this->Modelo_tv->ProductosCategoria($categoria_id);
		$this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE),"Moviles ".$this->Modelo_tv->SacaNombreCat($categoria_id)
                        );
        }
        /**
         * Llama a la vista que carga los productos pasandole un array con los prodcutos destacados
         */
        public function VerDestacado() {
                $producto=$this->Modelo_tv->ProDestacados(); 
		$this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE),"Productos Destacados"
                        );
        }
        
        /*public function mostrar($categoria, $page=0) {
            $config['base_url'] = base_url() . 'index.php/Principal/mostrar/' . $categoria;
            $config['uri_segment']=4;
            $config['total_rows'] = $this->Modelo_tv->CuentaProductosXCat($categoria);
            $config['per_page'] = 3;
            $config['num_links'] = 1;
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><span>';
            $config['cur_tag_close'] = '</span></li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['first_link'] = 'Primero';
            $config['prev_link'] = 'Anterior';
            $config['last_link'] = 'Último';
            $config['next_link'] = 'Siguiente';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            //$producto=$this->Modelo_tv->ProductosCategoria($categoria);
            $producto = array('pro' => $this->Modelo_tv->ProductosCategoria($categoria, $page, $config['per_page']),
            'paginacion' => $this->pagination->create_links());
            echo "<pre>".print_r($producto)."</pre>";
            $this->CargaPlantilla(
                        $this->load->view('productos', array(
                            'productos'=>$producto,
                        ), TRUE)
                        );
            }*/

        protected function CargaPlantilla($cuerpo='',$encabezado="") {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo,
                'encabezado'=>$encabezado
                ));            
        }

    
}
