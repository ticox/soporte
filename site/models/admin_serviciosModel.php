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

   public function editar_servicio_s($id_servicio){

    $sql="select servicio.*, solucion_servicio.* from servicio, solucion_servicio where servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and servicio.id_servicio=$id_servicio";


     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }



   public function cambiar_estatus_servicio($datos,$fotos){
    if($fotos['foto']['name'][0]==''){

       $sql="insert into solucion_servicio values('','".$datos['observacion']."',curdate(), '".$datos['hora_fin']."','".$datos['id_servicio']."','','','".$datos['hora_inicio']."','".session::get('id_usuario')."')";
                  $this->_db->query($sql);
    }else{
      $target_path = "public/img/soluciones/";
                  $nombre='solucion-'.$fotos['foto']['name'][0];
                  $target_path = $target_path .$nombre;
                  $sql="insert into solucion_servicio values('','".$datos['observacion']."',curdate(), '".$datos['hora_fin']."','".$datos['id_servicio']."','".$nombre."','','".$datos['hora_inicio']."')";
                  $this->_db->query($sql);
                  move_uploaded_file($fotos['foto']['tmp_name'][0], $target_path); 
                  $obj_img = new SimpleImage();
                  $obj_img->load($target_path);
                  //$obj_img->resize(234,135);
                  $obj_img->save($target_path);
}
      $sql2="update servicio SET estatus='".$datos['estatus']."' WHERE id_servicio='".$datos['id_servicio']."'";
      $this->_db->query($sql2);
      return 0;
   }

public function buscar_servicio_solucionado($id_servicio){

  /* $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario, solucion_servicio where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and servicio.id_servicio=$id_servicio";*/

  $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido from servicio, usuario, solucion_servicio where servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and usuario.id_usuario=solucion_servicio.id_usuario_sol and servicio.id_servicio=$id_servicio";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }  

   public function buscar_servicios_solucionados($nombre){
   
$sql="select servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario where servicio.id_usuario=usuario.id_usuario and usuario.nombre like '$nombre%' and servicio.estatus='solucionado'";
$datos = $this->_db->query($sql);
return $datos->fetchall();
}

public function modificar_solucion_servicio($datos){
   
 echo $sql="UPDATE solucion_servicio SET observacion='".$datos['observacion']."',fecha_solucion='".$datos['fecha_solucion']."',hora_solucion='".$datos['hora_solucion']."',hora_inicio='".$datos['hora_inicio']."' WHERE id_solucion='".$datos['id_solucion']."'";

      $this->_db->query($sql);
      return 0;
   }
    

   


}?>
