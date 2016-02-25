<?php
class Modelo_tv extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();}
        
        public function Categorias() {
            
            $cat=$this->db->get('categoria');
            
            return $cat->result_array();
        }
        
        public function SacaNombreCat($id) {
            $query="select nombrecat from categoria where idcat=".$id."";
            $catnom=$this->db->query($query);
            return $catnom->row()->nombrecat;
        }
        
        public function SacaNombrePro($id) {
            $query="select nombrepro from producto where id= ".$id." and oculto=0";
            $pronom=$this->db->query($query);
            return $pronom->row()->nombrepro;
        }
        
        public function SacaPrecioPro($id) {
            $query="select precio from producto where id= ".$id." and oculto=0";
            $pronom=$this->db->query($query);
            return $pronom->row()->precio;
        }
        
        public function SacaStockPro($id) {
            $query="select stock from producto where id= ".$id." and oculto=0";
            $pronom=$this->db->query($query);
            return $pronom->row()->stock;
        }
        
         /*Antes paginar   public function ProductosCategoria($categoria, $page, $per_page)
    {
        $qr = $this->db->get_where('producto', array('categoria_idcat'=>$categoria, 'oculto'=>0), $per_page,$page);
        return $qr->result_array();
    }*/
        
           public function ProductosCategoria($categoria_id) {
            $query="select * from producto where categoria_idcat= ".$categoria_id." and oculto=0 ";
            $procat=$this->db->query($query);
            return $procat->result_array();
        }
        
        public function ProDestacados() {
            $query="select * from producto where destacado=1 and oculto=0"
                    . " and fechacom<=CURDATE() and fechafin>=CURDATE()";
            $prodes=$this->db->query($query);
            return $prodes->result_array();
        }
       
        public function SacaTodosProductos(){
            $query="select * from producto";
            $procat=$this->db->query($query);
            return $procat->result_array();
        }
        
        public function SacaProducto($id_pro){
            $query="select * from producto where id= ".$id_pro." and oculto=0";
            $procat=$this->db->query($query);
            return $procat->row();
        }
        
        public function AltaUsuario($newusuario){
            $this->db->insert('usuario', $newusuario); 
        }
        
        public function AddCategoria($cat){
            $this->db->insert('categoria', $cat);
            
            return $this->db->insert_id();
        }
        
        public function AddProducto($datospro){
            $this->db->insert('producto', $datospro); 
        }
        
        public function CompUser($usuario,$contr) {
            
            $query="select count(*) as 'total' from usuario where nombreus= '".$usuario."' and contrasena= '".$contr."'"
                    . " and estado='ok'";
            $usuarioexiste=$this->db->query($query);
            echo $query;
            $a=$usuarioexiste->row();
            $a=(array)$a;
            if ($a['total']==1)
                return true;
            else return false;
        }
        public function BajaUsuario() {
            $query="UPDATE usuario SET estado='baja' where nombreus= '".$this->session->userdata('username')."'";
            $this->db->query($query);
        }
        
        public function SacaIdUser($nomuser) {
             $query="select iduser from usuario where nombreus= '".$nomuser."'";
             $idusuario=$this->db->query($query);
             return $idusuario->row()->iduser;
        }
        
        public function CompNombreUser($usuario) {
            
            $query="select count(*) as 'total' from usuario where nombreus= '".$usuario."'";
            $usuarioexiste=$this->db->query($query);
            $a=$usuarioexiste->row();
            $a=(array)$a;
            if ($a['total']==1)
                return true;
            else return false;
        }
        
        public function InsertaPedido($datosped) {
            $this->db->insert('pedido', $datosped); 
        }
        
        public function InsLineaPedido($datoslinped) {
            $this->db->insert('linea_pedido', $datoslinped); 
        }
        
        public function SacaPedidoPorID($id_ped){
            $query="select * from pedido where idpedido= ".$id_ped."";
            $pedido=$this->db->query($query);
            return $pedido->row_array();
        }
        
        public function SacaPedidosPorUser($id_user){
            $query="select * from pedido where usuario_iduser= ".$id_user."";
            $pedido=$this->db->query($query);
            return $pedido->result_array();
        }
        
        public function SacaLinPedido($id_ped){
            $query="select * from linea_pedido where pedido_idpedido= ".$id_ped."";
            $lipedido=$this->db->query($query);
            return $lipedido->result_array();
        }
        
        public function AnulaPedido($idpedido) {
            $query="UPDATE pedido SET estado_ped='Anulado' where idpedido= ".$idpedido."";
            $this->db->query($query);
        }
        
        public function AjustaStock($idpro,$cantpro) {
            $newstock=$this->SacaStockPro($idpro)-$cantpro;
            
            $query="UPDATE producto SET stock= ".$newstock." where id= ".$idpro."";
            $this->db->query($query);
        }
        
        public function SacaUsuario($usuario){
            $query="select * from usuario where nombreus= '".$usuario."' and estado='ok'";
            $resuser=$this->db->query($query);
            return $resuser->result();
        }
        
        
        public function ModificaUsuario($nuevosdatos) {
            $this->db->where('nombreus',$this->session->userdata('username'));
            $this->db->update('usuario', $nuevosdatos); 
        }
        
        public function CuentaProductosXCat($idcat) {
            
            $query="select count(*) as 'total' from producto where categoria_idcat= ".$idcat."";
            $numprods=$this->db->query($query);
            return $numprods->row()->total;
        }
        
        public function CuentaProductosDes() {
            
            $query="select count(*) as 'total' from producto where destacado=1";
            $numprods=$this->db->query($query);
            return $numprods->row()->total;
        }
}


