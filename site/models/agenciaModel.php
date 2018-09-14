<?php

class agenciaModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
public function get_all(){



$sql="SELECT * FROM `agencia` where 1=1  limit 0,10 ";

$datos = $this->_db->query($sql);
        
return $datos->fetchall();

}

public function get_all_for_point(){



$sql = "SELECT agencia.*,\n"
    . "COUNT(votacion.id_votacion) as votos,\n"
    . "AVG(votacion.votacion) as puntos\n"
    . "FROM\n"
    . "agencia \n"
    . "LEFT JOIN chicas on agencia.id_agencia=chicas.id_agencia\n"
    . "LEFT JOIN votacion on votacion.id_chica= chicas.id_chicas\n"
    . "GROUP BY agencia.id_agencia\n"
    . "ORDER BY votos DESC LIMIT 0,30";

$datos = $this->_db->query($sql);
        
return $datos->fetchall();

}

public function get_all_for_id($id){



$sql="SELECT * FROM `agencia` where id_agencia=$id ";

$datos = $this->_db->query($sql);
        
return $datos->fetch();

}

public function get_photo_all($id){


$sql="select * from fotos_agencia where id_agencia='$id'";

$datos = $this->_db->query($sql);
        
        return $datos->fetchall();

}

public function chicas_agencias($id){
$sql="SELECT fotos_chicas.*,chicas.* from 
fotos_chicas,chicas where 
fotos_chicas.id_chicas=chicas.id_chicas 
and chicas.id_agencia=$id
group by (fotos_chicas.id_chicas)";
$datos=$this->_db->query($sql);
    return $datos->fetchall();
}

public function get_only_name($name){



$sql = "SELECT agencia.*,\n"
    . "COUNT(votacion.id_votacion) as votos,\n"
    . "AVG(votacion.votacion) as puntos\n"
    . "FROM\n"
    . "agencia \n"
    . "LEFT JOIN chicas on agencia.id_agencia=agencia.id_agencia\n"
    . "LEFT JOIN votacion on votacion.id_chica= chicas.id_chicas\n"
    . "WHERE agencia.nombre_agencia LIKE '%$name%'\n"
    . "GROUP BY agencia.id_agencia\n"
    . "ORDER BY votos DESC LIMIT 0,30";

$datos = $this->_db->query($sql);
        
return $datos->fetchall();

}


public function get_count_camp($id,$tipo){



 $sql="SELECT count(id_chicas) as cantidad FROM agencia,chicas where  agencia.id_agencia = chicas.id_agencia and chicas.tipo like '%$tipo%' and agencia.id_agencia = '$id'  ";

$datos = $this->_db->query($sql);
        
return $datos->fetch();

}

public function point_for_agencia($id){



$sql = "SELECT SUM(votacion.votacion)/ COUNT(votacion.id_votacion) as puntuacion FROM agencia,chicas,votacion WHERE \n"
    . "agencia.id_agencia = chicas.id_agencia and\n"
    . "chicas.id_chicas= votacion.id_chica AND\n"
    . "agencia.id_agencia='$id' GROUP by agencia.id_agencia";

$datos = $this->_db->query($sql);
        
return $datos->fetch();

}





}

?>
