
<?php
/***
 * Este controlador sera el encargado de manejar todo lo relacionado con el carrito
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont_Carrito extends CI_Controller {

	public function index()
	{
		
	}
        /**
         * Recibe la id de un producto y llama a una vista pasandole un array con los datos de dicho producto 
         * previamente sacado con una llamada al modelo.
         * @param type $id_pro
         */
        public function VerProducto($id_pro) {
                $prod=$this->Modelo_tv->SacaProducto($id_pro); 
		$this->CargaPlantilla(
                        $this->load->view('unprod', array(
                            'producto'=>$prod,
                        ), TRUE),$prod->nombrepro
                        );
        }
        /**
         * Funcion invocada cuando metemos un producto en el carrito y que se encargada de ,utilizando la
         * libreria carrito , meter los datos del producto en el carrito.
         */
         public function MeteCarrito() {
             $datosprod=array(
                "id"=>$this->input->post('idpro'),
		"cantidad"=>$this->input->post('cantidad'),
		"precio"=>$this->input->post('prefi'),
             );
            $this->carrito->add($datosprod);

            $this->Muestracarrito();
            
            }
            /**
             * Saca los datos del carrito , añade el nombre del producto a esos datos y llama a la
             * vista que muestra el carrito.
             */
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
                            ),TRUE),"Tienes en tu carrito...");
            } 
            /**
             * Vacia el carrito
             */
            public function LimpiaCarrito() {
                $this->carrito->destroy();
                redirect('','location',301);
            }
            /**
             * Recibe la "idunique" de un producto del carrito y lo elimina del carrito
             * @param type $idunica
             */
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
           /**
            * Recibe un cuerpo y un encabezado y le pasa estos unido a las categorias a la vista principal.
            * @param type $cuerpo
            * @param type $encabezado
            */
           protected function CargaPlantilla($cuerpo='',$encabezado="") {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo,
                'encabezado'=>$encabezado
                ));   
           }
          
}     
             
             
             
           //$prod=$this->Modelo_tv->SacaProducto($id_pro); 
           