<?php

class recuperarModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function traer_infousuario($correo)
    {
        
        
        $sql="select * from usuario where email='".$correo."'";
       

        $datos = $this->_db->query($sql);
                $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetch();
    }


   public function cambiar_clave($actual, $nueva, $usuario)
    {
        
       echo $sql="update usuario set password='" . Hash::getHash('sha1', $nueva, HASH_KEY) ."' where id_usuario='".$usuario."'";
         $this->_db->query($sql);
    }  

    public function actualizar_clave($nueva, $login)
    {
        
        $sql="update usuario set password='" . Hash::getHash('sha1', $nueva, HASH_KEY) ."' where login='".$login."'";
        $this->_db->query($sql);
    } 


 public function buscar_usuario($clave, $login)
    {
        
        
     $sql="select * from usuario where login='".$login."' and password='" . Hash::getHash('sha1', $clave, HASH_KEY) ."'";
       

        $datos = $this->_db->query($sql);
                $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetch();
    }




}

?>
