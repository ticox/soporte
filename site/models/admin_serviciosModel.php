<?php

class admin_serviciosModel extends Model
{
    public function __construct() {
        parent::__construct();
    }



    public function registrar_servicio($datos){

 	 $sql="INSERT INTO servicio values ('','".$datos['servicio']."','".$datos['software']."' ,'".$datos['hardware']."' ,'".$datos['funcionamiento']."' ,'".$datos['otros']."' , curdate() , curtime(),'".session::get('id_usuario')."','pendiente')";
        $this->_db->query($sql);
   }


   public function buscar_servicios_admin(){

 	 $sql="select servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario where servicio.id_usuario=usuario.id_usuario and servicio.estatus='pendiente'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }

   public function buscar_servicios_admin_solucionados(){

   $sql="select servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }

   public function buscar_servicio_usuario($servicio){

 	 $sql="select servicio.*, usuario.* from servicio, usuario where servicio.id_usuario=usuario.id_usuario and id_servicio='".$servicio."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }


   public function cambiar_estatus_servicio($datos){

    $sql="insert into solucion_servicio values('','".$datos['observacion']."',curdate(), curtime(),'".$datos['servicio']."')";
      $this->_db->query($sql);

     echo $sql2="update servicio SET estatus='".$datos['estatus']."' WHERE id_servicio='".$datos['servicio']."'";
      $this->_db->query($sql2);
      
      return 0;
   }

public function buscar_servicio_solucionado($id_servicio){

   $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario, solucion_servicio where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and servicio.id_servicio=$id_servicio";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }  
    


}?>
