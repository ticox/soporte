<?php


class servicioController extends Controller
{
	
	private $_index;
    public function __construct() {
        parent::__construct();
  	 $this->_index=$this->loadModel('servicio');	
      
    }

    public function index()
    {


			
			$this->_view->setJs(array('principal'));
			$this->_view->setCss(array('css','style'));
        	$this->_view->titulo = 'Pedido/Servicio - COTEDEM';

        	$servicios=$this->_index->buscar_servicios_usuarios();
        	
        	$this->_view->servicio=$servicios;
			$this->_view->renderizar('index');

							
			
	}

	function registrar_servicio(){
       $this->_index->registrar_servicio($_POST);

     $this->getLibrary('class.phpmailer');
            
            $email_user = "soporte@cotedem.com";
            $email_password = "Cotedem@2018";
            $asunto = "Nueva solicitud de soporte de ".session::get('usuario')." de la empresa ".session::get('empresa')."";
            $nombre = session::get('usuario');
            $empresa = session::get('empresa');
            $mensaje = $_POST['servicio'];
            $correo = "soporte@cotedem.com";

            $software='No';
            $hardware='No';
            $funcionamiento='No';
            $otros='No';

            if($_POST['software']==1){

                 $software='Si';
            }
            if($_POST['hardware']==1){

                 $hardware='Si';
            }

            if($_POST['funcionamiento']==1){

                 $funcionamiento='Si';
            }

             if($_POST['otros']==1){

                 $otros='Si';
            }

            $phpmailer = new PHPMailer();

            // ---------- Datos de la cuenta de correo -----------------------------
            $phpmailer->Username = $email_user;
            $phpmailer->Password = $email_password; 
            //---------------------------------------------------------------------
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "box308.bluehost.com";
            $phpmailer->Port = 465;
            //$phpmailer->SMTPDebug = 2;
            $phpmailer->IsSMTP();
            $phpmailer->SMTPAuth = true;

            $phpmailer->setFrom($phpmailer->Username,$nombre);
            $phpmailer->AddAddress("info@cotedem.com");
            $phpmailer->Subject =$asunto; 

            $phpmailer->Body .="<h1 style='color:#000;'>".$nombre." de ".$empresa."</h1>";
            $phpmailer->Body .= "<h3> Servicio Solicitado: ".$mensaje." </h3></br> <br> <b>Mantenimiento de software:</b> ".$software;
            $phpmailer->Body .="<br> <b>Mantenimiento de hardware:</b> ".$hardware."<br> <b> Pruebas de funcionamiento:</b> ".$funcionamiento."<br> <b>otros:</b> ".$otros."<br>";

            $phpmailer->AddAttachment($mensaje, "attach1");
            $phpmailer->AddBCC("soporte@cotedem.com", "bcc1");
            $phpmailer->IsHTML(true);
            $enviado = $phpmailer->Send();
            if($enviado) {
                echo 'Email Enviado Exiosamente';
            }

    }


    function buscar_servicio_usuario(){

       echo json_encode( $this->_index->buscar_servicio_usuario($_POST['servicio'],$_POST['estatus']));
    }


	
	
}


?>