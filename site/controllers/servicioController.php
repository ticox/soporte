<?php


class servicioController extends Controller
{
	
	private $_index;
    public function __construct() {
        parent::__construct();
        $this->getLibrary('simpleimage');
  	 $this->_index=$this->loadModel('servicio');	
      
    }

    public function index()
    {


			if(!Session::get('autenticado')){
            $this->redireccionar('login');
        }
        
			$this->_view->setJs(array('principal'));
			$this->_view->setCss(array('css','style'));
        	$this->_view->titulo = 'Pedido/Servicio - COTEDEM';

        	$servicios=$this->_index->buscar_servicios_usuarios();
        	
        	$this->_view->servicio=$servicios;
			$this->_view->renderizar('index');

							
			
	}

	function registrar_servicio(){
    $this->_index->registrar_servicio($_POST,$_FILES);

     $this->getLibrary('class.phpmailer');
            
            $email_user = "soporte@cotedem.com";
            $email_password = "Cotedem@2018";
            $asunto = "Nueva solicitud de soporte de ".session::get('usuario')." de la empresa ".session::get('empresa')."";
            $nombre = session::get('usuario');
            $empresa = session::get('empresa');
            $mensaje = $_POST['servicio'];
            $correo = "info@cotedem.com";
            $fecha_atencion= $_POST['fecha_atencion'];
            $hora_atencion= $_POST['hora_atencion'];

            $software='No';
            $hardware='No';
            $funcionamiento='No';
            $otros='No';
            $otrosrespuesta='No';

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

                 $otrosrespuesta=$_POST['otrosrespuesta'];
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
            $phpmailer->AddAddress("soporte@cotedem.com","soporte@cotedem.com");
            $phpmailer->Subject =$asunto; 

            $phpmailer->Body .="<h1 style='color:#000;'>".$nombre." de ".$empresa."</h1>";
            $phpmailer->Body .= "<p> Servicio Solicitado: ".$mensaje." </p></br> <br> Mantenimiento de software:".$software;
            $phpmailer->Body .="<br> Mantenimiento de hardware: ".$hardware."<br>  Pruebas de funcionamiento: ".$funcionamiento."<br>Otros: <p>".$otrosrespuesta."</p><br>";

           // $phpmailer->Body .="Fecha tentativa propuesta por el usuario: El dia"+$_POST['fecha_atencion']+"  a las ";

            $phpmailer->AddAttachment($mensaje, "attach1");
            $phpmailer->AddBCC("soporte@cotedem.com", "bcc1");
            $phpmailer->IsHTML(true);
            $enviado = $phpmailer->Send();
            if($enviado) {
                echo 'Email Enviado Exiosamente';
            }

            $this->redireccionar('servicio');

    }


    function buscar_servicio_usuario(){

       echo json_encode( $this->_index->buscar_servicio_usuario($_POST['servicio'],$_POST['estatus']));
    }


	
	
}


?>