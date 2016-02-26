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
            foreach ($datos_carrito as $producto)
            {
                if ($producto['cantidad']>$this->Modelo_tv->SacaStockPro($producto['id'])){
                    $this->CargaPlantilla
                    (" ","La cantidad solicitada de ".$this->Modelo_tv->SacaNombrePro($producto['id'])." es superior a su stock");}
                else{
                //print_r($datos_carrito);
                $datos_pedido = array(
                "fecha_pedido" => date("Y-m-d"),
                 "usuario_iduser" => $datos_usuario['id'],
                 "estado_ped"=>"Pendiente de envio",
                    "total_ped"=>$this->carrito->precio_total()
                );
                $this->Modelo_tv->InsertaPedido($datos_pedido);
                $cod_pedido = $this->db->insert_id();

                foreach ($datos_carrito as $producto) {
                        $lineaped = array(
                        'pedido_idpedido' => $cod_pedido,
                         'producto_id' => $producto['id'],
                         'cantidad' => $producto['cantidad'],
                            'precio_ped'=>$producto['total']);
                    $this->Modelo_tv->InsLineaPedido($lineaped); 
                     $this->Modelo_tv->AjustaStock($producto['id'],$producto['cantidad']); 
                }
                $this->PdfPedido($cod_pedido,true);
                $this->EnviarCor($cod_pedido);
                $this->carrito->destroy();
                }
                //$this->MuestraPedido($cod_pedido);
        }
        
            }    


            public function MuestraPedido() {
            $datos_usuario = $this->session->all_userdata();
            
            $pedidos= $this->Modelo_tv->SacaPedidosPorUser($datos_usuario['id']);
            foreach ($pedidos as $key=>$pedido) {
                $pedidos[$key]['lineas']=$this->Modelo_tv->SacaLinPedido($pedido['idpedido']);
            }           
             
            $this->CargaPlantilla(
                        $this->load->view('Vistapedido',array(
                            'pedidos'=>$pedidos,
                        ),TRUE));
            }
            
            public function PdfPedido($idpedido,$escorreo=false) {
                $pedido=$this->Modelo_tv->SacaPedidoPorID($idpedido);
                //$pedido['lineas']=$this->Modelo_tv->SacaLinPedido($pedido['idpedido']);
                $lineas=$this->Modelo_tv->SacaLinPedido($pedido['idpedido']);
                
                foreach ($lineas as $key=>$linea)
                {
                    $lineas[$key]['nombrepro']=$this->Modelo_tv->SacaNombrePro($linea['producto_id']);
                    $lineas[$key]['preciopro']=$this->Modelo_tv->SacaPrecioPro($linea['producto_id']);
                    //$linea[$key]['nombrepro']=$this->Modelo_tv->SacaNombrePro( $linea[$key]['producto_id']);
                }
                
                
                /*echo "<pre>";
                echo print_r($lineas);
                echo "</pre>";*/
                $this->pdf->PedidoPdf($pedido,$lineas,$escorreo);
                
                //$this->Modelo_tv->AnulaPedido($idpedido);
                //redirect('/Cont_pedido/MuestraPedido','location',301);
               
            }
            
            public function AnulaPedido($idpedido) {
                $this->Modelo_tv->AnulaPedido($idpedido);
                redirect('/Cont_pedido/MuestraPedido','location',301);
            }
            
            protected function CargaPlantilla($cuerpo='',$encabezado="") {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo,
                'encabezado'=>$encabezado
                ));   
           }
           
           public function EnviarCor($codigopedido)
	{
               $datos_usuario = $this->session->all_userdata();
               
		$this->email->from('aula4@iessansebastian.com', 'Pedido Buyphone');
		$this->email->to($datos_usuario['correo']); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject('Datos del pedido');
		$this->email->attach('asset/pedidocorreo/pedido.pdf');
		
		if ( $this->email->send() )
		{
			/*$cuerpo= $this->load->view('Compra_Realizada','', true);
                        $this->load->view('Index', Array('cuerpo' => $cuerpo));*/
                    echo "Correo enviado";
		}
		else 
		{
			echo "</pre>\n\n**** Compra realizada , fallo al enviar correo ****</pre>\n";
		}
		
		//echo $this->email->print_debugger();
                 //Mostramos compra realizada.
            
	}
          
          
}
