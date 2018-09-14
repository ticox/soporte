<?php


class ninaController extends Controller
{
	
	private $_nina;
    public function __construct() {
        parent::__construct();
  	 $this->_index=$this->loadModel('principal');	
      
    }

    public function index(){

            $this->redireccionar('principal');

    }

    public function individual($id)
    {

        if($id==false){

            $this->redireccionar('principal');

        } 
  
			
			$this->_view->setJs(array('index'));
			$this->_view->setCss(array('css2'));

			$rs=$this->_index->get_all();

        	for ($i=0; $i < count($rs) ; $i++) { 
        		
        		if($rs[$i]["id_chicas"]==$id):

        			$index=$i;

        		$rs[$i]["fotos"]=$this->_index->get_photo_all($rs[$i]["id_chicas"]);
        		$this->_view->titulo = $rs[$i]['nombre_chicas']." - OrienteX";

        		endif;



        	}


        	$this->_view->datos=$rs[$index];
            $this->_view->valoracion=$this->_index->promedio_chica($id);
        	
			$this->_view->renderizar('index');
							
			
	}


    public function votacion(){

    $validacion=$this->_index->validar_voto($this->_ip,$_POST['id']);
    if($validacion==0){
        echo 0;
    }
    else{
    echo json_encode($this->_index->votacion($_POST['valor'],$_POST['id'],$this->_ip));
}

   }	
	
}

?>