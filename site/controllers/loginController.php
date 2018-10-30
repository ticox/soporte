<?php

class loginController extends Controller
{
    private $_login;
    
    public function __construct(){
        parent::__construct();
        $this->_login = $this->loadModel('login');
    }
    
    public function index(){


        
        if(Session::get('autenticado')){
            $this->redireccionar('principal');
        }
        
        $this->_view->titulo = 'Iniciar Sesion - COTEDEM';
        $this->_view->setCss(array('css','bootstrap-material-design.min'));
        $this->_view->setJs(array('js'));

        if(isset($_POST['enviar'])){
            $this->_view->datos = $_POST;
  
            $row = $this->_login->getUsuario(
                    $_POST['usuario'],
                    $_POST['clave']
                    );
            
            if(!$row){
                $this->_view->_error = 'Usuario y/o password incorrectos';
                $this->_view->renderizar('index');
                exit;
            }
            
            /*if($row['estado'] != 1){
                $this->_view->_error = 'Este usuario no esta habilitado';
                $this->_view->renderizar('index','login');
                exit;
            }*/
            
                        
            Session::set('autenticado', true);
            Session::set('role', $row['id_role']);
            Session::set('empresa', $row['empresa']);
            Session::set('departamento', $row['departamento']);
            Session::set('usuario', $row['nombre'].' '.$row['apellido']);
            Session::set('login', $row['login']);
            Session::set('id_usuario', $row['id_usuario']);
            Session::set('tiempo', time());
            if ($row['id_role']==99) {
               // $this->enviaremail($row['login']);
                $this->redireccionar("app");
                //break;
            }
           $this->redireccionar();
        }
        
        $this->_view->renderizar('index');
        
    }
    
    public function cerrar()
    {
        Session::destroy();
        $this->redireccionar();
    }


       public function verificar_user(){


    echo json_encode($this->_login->verificar_user($_POST));


   }


public function enviaremail($login){



     $this->getLibrary('class.phpmailer');
            
            $mail = new PHPMailer();
            $mail->IsSMTP(); 
           // $mail->SMTPDebug  = 1;                   
            $mail->SMTPAuth   = true; 
            $mail->SMTPSecure = "tls"; 
            $mail->Host       = "smtp.gmail.com";
            $mail->Port = 587;  
            $mail->Username   = "prccnoreply@gmail.com";       
            $mail->Password   = "20574205";        
            $mail->SetFrom('prccnoreply@gmail.com');
            
            $mail->AddReplyTo("prccnoreply@gmail.com","tecnoservi");    
            $mail->Subject = 'acceso';

            if($login=="charlot"){
            $mail->Body = 'Hola jefes ,' .
                            'el puto dios, rey de reyes, hermano de goku y mi amo ' .$login.' acaba de iniciar seccion. deben rendir pleitesía';    

            }else{

            $mail->Body = 'Hola jefes ,' .
                            'la marmota de: ' .$login.' acaba de iniciar seccion';
            }
            $mail->AddAddress("tecnoservi@tecnoservi.net.ve");
            
            //Enviamos el correo
            if(!$mail->Send()) {
              echo "Hubo un error: " . $mail->ErrorInfo;
            } else {
              echo "Mensaje enviado con exito.";
            }
       


   }
}

?>
