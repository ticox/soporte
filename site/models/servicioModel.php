<?php

class servicioModel extends Model
{
    public function __construct() {
        parent::__construct();
    }



    public function registrar_servicio($datos){

 	 $sql="INSERT INTO servicio values ('','".$datos['servicio']."','".$datos['software']."' ,'".$datos['hardware']."' ,'".$datos['funcionamiento']."' ,'".$datos['otros']."' , curdate() , curtime(),'".session::get('id_usuario')."','pendiente')";
        $this->_db->query($sql);
   }


   public function buscar_servicios_usuarios(){

 	 $sql="select * from servicio where id_usuario='".Session::get('id_usuario')."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }

   public function buscar_servicio_usuario($servicio){

 	 $sql="select * from servicio where id_servicio='".$servicio."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }

   public function buscar_servicio_solucionado(){

  $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario, solucion_servicio where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and servicio.id_servicio=$id_servicio";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }

     


   
    


}?>
