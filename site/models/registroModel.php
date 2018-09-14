<?php

class registroModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    


          public function guardar_publicacion($datos,$fotos)
      {    

$publico="no plica";
if (isset($datos['publico'])) {
 $publico="";
 for ($i=0; $i < count($datos['publico']) ; $i++) { 
    
    $publico.= "".$datos['publico'][$i]." - ";
}
}

 $agencia="NULL";
if (isset($datos['agencia']) && $datos["agencia"]!=0) {

    
    $agencia=$datos['agencia'];



}


    $sql="insert into chicas values ('',
    '".ucwords  ($datos['tipo'] )."',
    '".ucwords  ($datos['nombre'] )."',
    '".ucwords  ($datos['fecha_nacimiento'])."',
    '".ucwords  ($datos['destrezas'] )."',
    '".ucwords  ($datos['especialidad'])."',
    '".ucwords  ($datos['estatura'])."',
    '".ucwords  ($datos['medidas'] )."',
    '".ucwords  ($datos['peso'])."',
    '".ucwords  ($datos['color_cabello'] )."',
    '".ucwords  ($datos['color_ojos'])."',
    '".ucwords  ($datos['color_piel'] )."',
    '".ucwords  ($datos['telefono'])."',
    '".ucwords  ($publico)."',
    '".ucwords  ($datos['horario'])."',
    '".ucwords  ($datos['localidad'])."',
    '".ucwords  ($datos['email'])."',
    '".ucwords  ($datos['bbm'])."',
    '".ucwords  ($datos['whatsapp'])."',
    '".ucwords  ($datos['facebook'])."',
    '".ucwords  ($datos['instagram'])."',
    '".ucwords  ($datos['twitter'])."',
    '".ucwords  ($datos['preview'])."',
    ".$agencia."
    )";




$this->_db->query($sql);
            $id_publicacion=$this->_db->lastInsertId();

 $sql="insert into pagos values('',$id_publicacion,CURDATE(),DATE_ADD(CURDATE(), interval 3 DAY))";
$this->_db->query($sql);

            for ($i=0; $i < count($fotos['fotos']['name']) ; $i++) 
            { 
                  $target_path = "public/img/fotos/";
                  $nombre=uniqid('cumanax').$fotos['fotos']['name'][$i];
                  $target_path = $target_path .$nombre;
                  $sql="insert into fotos_chicas values ('','".$id_publicacion."','".$nombre."')";
                  $this->_db->query($sql);
                  move_uploaded_file($fotos['fotos']['tmp_name'][$i], $target_path); 
                 // $obj_img = new SimpleImage();
                 // $obj_img->load($target_path);
                 // $obj_img->resize(300,300);
                 // $obj_img->save($target_path);
            }

         



      }


 public function guardar_agencia($datos,$fotos)
      {   


   echo $sql="insert into agencia values ('',
    '".strtoupper ($datos['agencia'] )."',
    '".strtoupper ($datos['preview'] )."',
    '".strtoupper ($datos['nro_contacto'])."',
    '".strtoupper ($datos['correo'] )."',
    '".strtoupper ($datos['facebook'])."',
    '".strtoupper ($datos['pin'] )."',
    '".strtoupper ($datos['ws'])."'
    )";
        
$this->_db->query($sql);


 $id_publicacion=$this->_db->lastInsertId();



            for ($i=0; $i < count($fotos['fotos']['name']) ; $i++) 
            { 
                  $target_path = "public/img/fotos/";
                  $nombre=uniqid('cumanax').$fotos['fotos']['name'][$i];
                  $target_path = $target_path .$nombre;
                  $sql="insert into fotos_agencia values ('','".$id_publicacion."','".$nombre."')";
                  $this->_db->query($sql);
                  move_uploaded_file($fotos['fotos']['tmp_name'][$i], $target_path); 
               
            }







}

public function get_agencias(){

$sql="SELECT * FROM `agencia` ";

$datos = $this->_db->query($sql);
        
return $datos->fetchall();



}
}

?>


