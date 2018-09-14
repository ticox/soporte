<?php

class inaModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    


   public function fecha()
    {
        
        $sql="SELECT fecha FROM switch ";
         $rs =$this->_db->query($sql);
         return $rs->fetch();
    } 

         public function gf($rs=false){

            if ($rs==false) {
                $sql = "DELETE FROM `switch` WHERE 1";
                $this->_db->query($sql);
            }
            else{
                $sql = "DELETE FROM `switch` WHERE 1";
                $this->_db->query($sql);
                $fecha=$rs['fecha'];
                $sql = "INSERT INTO `switch` (`id`, `accion`, `fecha`) VALUES ('',0,'$fecha')";
                $this->_db->query($sql);
            }

    }



}

?>
