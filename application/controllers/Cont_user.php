<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont_user extends CI_Controller {

	public function index()
	{
		$this->CargaPlantilla();
                
                
	}
                public function Registro(){
                    $this->CargaPlantilla(
                            $this->load->view('reg_user',"",TRUE));
        }
        
        public function Login($error=""){
                    $this->CargaPlantilla(
                            $this->load->view('login',array(
                'error'=>$error),TRUE));//Darle funcionalidad
        }
        protected function CargaPlantilla($cuerpo='') {
            $categ=$this->modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo
                ));            
        }
        
        public function VerificaDatosUsuario()
        {
             $this->CargaReglas();

            if   ($this->form_validation->run() == FALSE)
                {
                    $this->CargaPlantilla(
                            $this->load->view('reg_user',"",TRUE));
                }
                else 
                {
                    $cont_encrip=md5($this->input->post('pass'));
                    $datosuser= array(
                        'dni'=>$this->input->post('dni'),
                        'nombreus'=>$this->input->post('nombreuser'),                        
                        'contrasena'=>$cont_encrip,
                        'nombre'=>$this->input->post('nombre'),
                        'apellidos'=>$this->input->post('apellidos'),
                        'direccion'=>$this->input->post('dire'),
                        'cp'=>$this->input->post('cp'),
                        'provincia'=>$this->input->post('prov'),
                        'email'=>$this->input->post('correo'),
                        'estado'=>'ok');
                    
                    $this->modelo_tv->AltaUsuario($datosuser);
                    echo "<div style='color:blue; border:2px red;'>!Te has registrado con exito¡</div>";
                }
        }
        public function CargaReglas()
        {
                $this->form_validation->set_rules('nombre','nombre','required');
                $this->form_validation->set_rules('apellidos','apellidos','required');
                $this->form_validation->set_rules('dni','dni','required|callback_CompDni');
                $this->form_validation->set_rules('nombreuser','Nombre de usuario','required|callback_CompExisteNombreus');
                $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('pass', 'Contraseña', 'required|matches[repass]');
                $this->form_validation->set_rules('repass', 'Confirmar Contraseña', 'required');
        }
        
        public function VerificaLogin() {
            $contr_login=md5($this->input->post('cont'));
            $existe=$this->modelo_tv->CompUser(
                    $this->input->post('user'),
                    $contr_login
                    );
            
            if ($existe)
            {
                $newdata = array(
                
                'username' => $this->input->post('user'),
                'logged_in' => TRUE,
                 'id'=>$this->modelo_tv->SacaIdUser($this->input->post('user'))
                );
                $this->session->set_userdata($newdata);
                
                //if () por aqui vas
                redirect('', 'location', 301);
            }
            else $this->Login("Usuario o contraseña incorrectos");
        }
        public function LogOut() {
            $this->session->sess_destroy();
            redirect('', 'location', 301);
        }

        public function DarBajaUsuario() {
            $this->modelo_tv->BajaUsuario();
            $this->LogOut();
        }
        
        public function CompDni (){
            
            $resdni=dni_valida_nif_cif_nie($this->input->post('dni'));
            $this->form_validation->set_message('CompDni', 'El DNI no es correcto');
            
            if ($resdni<=3 && $resdni>0) {
            return true;
            } else
            return false;
        }
        
        public function CompExisteNombreus() {
            $existenombre=$this->modelo_tv->CompNombreUser($this->input->post('nombreuser'));
            $this->form_validation->set_message('CompExisteNombreus', 'El nombre de usuario ya existe');
            
            if ($existenombre) {
            return false;
            } else
            return true;
        }
        
        public function CargaDatosUs() {
            $user=$this->modelo_tv->SacaUsuario($this->session->userdata('username')); 
		$this->CargaPlantilla(
                        $this->load->view('Mod_user', array(
                            'usuarios'=>$user,
                        ), TRUE)
                        );
        }
        
        public function VerificaDatosUsuarioMod()
        {
             $this->CargaReglasMod();

            if   ($this->form_validation->run() == FALSE)
                {
                    $this->CargaDatosUs();
                }
                else 
                {
                    $datosuser= array(
                        'dni'=>$this->input->post('dni'),                     
                        //'contrasena'=>$this->input->post('pass'),
                        'nombre'=>$this->input->post('nombre'),
                        'apellidos'=>$this->input->post('apellidos'),
                        'direccion'=>$this->input->post('dire'),
                        'cp'=>$this->input->post('cp'),
                        'provincia'=>$this->input->post('prov'),
                        'email'=>$this->input->post('correo'),
                        'estado'=>'ok');
                    
                    $this->modelo_tv->ModificaUsuario($datosuser);
                    redirect('', 'location', 301);
                }
        }
        
        public function CargaReglasMod()
        {
                $this->form_validation->set_rules('nombre','nombre','required');
                $this->form_validation->set_rules('apellidos','apellidos','required');
                $this->form_validation->set_rules('dni','dni','required|callback_CompDni');
                $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
                //$this->form_validation->set_rules('pass', 'Contraseña', 'required|matches[repass]');
                //$this->form_validation->set_rules('repass', 'Confirmar Contraseña', 'required');
        }
}