<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont_pedido extends CI_Controller {

	public function index()
	{
		
	}
        
        public function RealizaPedido() {
           $this->session->set_userdata('esta_comprando', true);

           if ($this->session->userdata('username')!=null)
           {
               $this->Finaliza_Compra();
           }
           else
           {
              $this->CargaPlantilla(
                        $this->load->view('Reg_o_login',"",TRUE));
           }
        }
        
        public function Finaliza_Compra() {
            $datos_usuario = $this->session->all_userdata();
            $datos_carrito = $this->carrito->get_content();
            //print_r($datos_carrito);
            $datos_pedido = array(
            "fecha_pedido" => date("Y-m-d"),
             "usuario_iduser" => $datos_usuario['id'],
             "estado_ped"=>"Pendiente de envio",
                "total_ped"=>$this->carrito->precio_total()
            );
            $this->modelo_tv->InsertaPedido($datos_pedido);
            $cod_pedido = $this->db->insert_id();

            foreach ($datos_carrito as $producto) {
                    $lineaped = array(
                    'pedido_idpedido' => $cod_pedido,
                     'producto_id' => $producto['id'],
                     'cantidad' => $producto['cantidad'],
                        'precio_ped'=>$producto['total']);
                $this->modelo_tv->InsLineaPedido($lineaped); 
                 $this->modelo_tv->AjustaStock($producto['id'],$producto['cantidad']); 
            }
            $this->carrito->destroy();   
            //$this->MuestraPedido($cod_pedido);
        }    


            public function MuestraPedido() {
            $datos_usuario = $this->session->all_userdata();
            
            $pedidos= $this->modelo_tv->SacaPedidosPorUser($datos_usuario['id']);
            foreach ($pedidos as $key=>$pedido) {
                $pedidos[$key]['lineas']=$this->modelo_tv->SacaLinPedido($pedido['idpedido']);
            }           
             
            $this->CargaPlantilla(
                        $this->load->view('Vistapedido',array(
                            'pedidos'=>$pedidos,
                        ),TRUE));
            }
            
            public function AnulaPedido($idpedido) {
                $this->modelo_tv->AnulaPedido($idpedido);
                redirect('/Cont_pedido/MuestraPedido','location',301);
            }
            
            protected function CargaPlantilla($cuerpo='') {
                $categ=$this->modelo_tv->Categorias();
                $this->load->view('vista_principal',array(
                    'categorias'=>$categ,
                    'cuerpo'=>$cuerpo
                    ));            
            }
          
}
