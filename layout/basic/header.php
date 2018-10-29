<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta content="text/html">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
    <!--Core CSS
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>public/img/favicon1.png">
    <link href="<?php echo BASE_URL; ?>public/css/alertify.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL; ?>public/css/alertify.core.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo BASE_URL; ?>public/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo BASE_URL; ?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL; ?>public/css/jquery-ui.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo BASE_URL; ?>public/css/jquery-ui.structure.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo BASE_URL; ?>public/css/jquery-ui.theme.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL; ?>public/css/default_modal.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo BASE_URL; ?>public/css/component_modal.css" rel="stylesheet" type="text/css" />
    
    <!-- Plugin CSS 
    <!-- Custom CSS 
    <link href="<?php echo $_layoutParams['ruta_css']; ?>layout.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $_layoutParams['ruta_css']; ?>estilos_varios.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $_layoutParams['ruta_css']; ?>botones.css" rel="stylesheet" type="text/css" />
     <link href="<?php echo $_layoutParams['ruta_css']; ?>formulario.css" rel="stylesheet" type="text/css" />
    <!-- CSS view.. 
    <?php if(isset($_layoutParams['css']) && count($_layoutParams['css'])): ?>
        <?php for($i=0; $i < count($_layoutParams['css']); $i++): ?>
            <link href="<?php echo $_layoutParams['css'][$i] ?>" rel="stylesheet" type="text/css" />
        <?php endfor; ?>
    <?php endif; ?> 
</head>

<body id="page-top">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display 
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo BASE_URL; ?>principal" class="navbar-brand"><img src="<?php echo BASE_URL; ?>public/img/cara.png" class="logox"><h4 class="texto">OrienteX.com.ve</h4></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling 
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul id="menu" class="nav navbar-nav">
                        <?php if(isset($_layoutParams['menu'])): ?>
                            <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                           

                            <li ><a class="enlace-menu" href="<?php echo BASE_URL.$_layoutParams['menu'][$i]['enlace']; ?>"><b><?php  echo $_layoutParams['menu'][$i]['titulo']; ?></b></a></li>

                            <?php endfor; ?>
                            <?php endif; ?>

                    </ul>
                    <?php if (session::get('autenticado')): ?>
                    <ul  class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo session::get('usuario'); ?><span class="glyphicon glyphicon-user" aria-hidden="true"></span><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo BASE_URL; ?>recuperar/cambiar">CAMBIAR CONTRASEÑA</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo BASE_URL; ?>login/cerrar">CERRAR SESIÓN</a></li>
                                </ul>
                         </li>
                    </ul>
                <?php endif; ?>

                  

                </div>
            </div>
    </nav>

    <div class="container-fluid fondo">

    <input type="hidden" value="<?php echo Session::get('role');?>" id="_ROL_">

    <div class="row">
    
        <div class="page-header xxx">
            <img src="<?php echo BASE_URL; ?>public/img/logox.png" class="logo_centro">
            <!-- <h1 class="title1">Www.CumanaX.Com <small class="text-color">Servicios Especiales</small></h1> 
        </div>
-->
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="<?php echo BASE_URL; ?>public/img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Main Stylesheet File -->
  <link href="<?php echo BASE_URL; ?>public/css/default_modal.css" rel="stylesheet" type="text/css" /> 
  <link href="<?php echo BASE_URL; ?>public/css/component_modal.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo BASE_URL; ?>public/css/alertify.bootstrap3.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo BASE_URL; ?>public/css/alertify.core.css" rel="stylesheet" type="text/css" /> 
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/main.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/bootstrap.min.css">
  <!--<link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/bootstrap-material-design.min.css">-->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/bootstrap-material-design.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/ripples.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/sweetalert2.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/jquery.mCustomScrollbar.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/material-design-iconic-font.css">

<?php if(isset($_layoutParams['css']) && count($_layoutParams['css'])): ?>
        <?php for($i=0; $i < count($_layoutParams['css']); $i++): ?>
            <link href="<?php echo $_layoutParams['css'][$i] ?>" rel="stylesheet" type="text/css" />
        <?php endfor; ?>
    <?php endif; ?> 
</head>

<body class="cover" id="cover">
  <!-- <div class="loader2"></div> -->

  <!--==========================
    Header
  ============================-->

<?php if (session::get('autenticado')): ?>
<section class="full-box cover dashboard-sideBar">
    <div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
    <div class="full-box dashboard-sideBar-ct">
      <!--SideBar Title -->
      <div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
        <?php echo session::get('empresa'); ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
      </div>
      <!-- SideBar User info -->
      <div class="full-box dashboard-sideBar-UserInfo">
        <figure class="full-box">
          <img src="<?php echo BASE_URL ?>public/img/avatar.jpg" alt="UserIcon">
          <figcaption class="text-center text-titles">Usuario: <?php echo session::get('usuario'); ?> <br> Empresa: <?php echo session::get('empresa'); ?> <br> Departamento: <?php echo session::get('departamento'); ?> </figcaption>
          <!-- <figcaption class="text-center text-titles">Name: Gilberto Vargas</figcaption> -->
        </figure>
        <ul class="full-box list-unstyled text-center">
          <li>
            <a href="<?php echo BASE_URL ?>recuperar/cambiar">
              <i data-toggle='tooltip' data-placement='bottom' title='Cambiar Contraseña' class="glyphicon glyphicon-cog"></i>
            </a>
          </li>
          <li>
            <a href="<?php echo BASE_URL ?>login/cerrar" class="btn-exit-system">
              <i data-toggle='tooltip' data-placement='bottom' title='Salir del Sistema' class="glyphicon glyphicon-off"></i>
            </a>
          </li>
        </ul>
      </div>
      <!-- SideBar Menu -->



      <ul class="list-unstyled full-box dashboard-sideBar-Menu">
        

        <?php if(isset($_layoutParams['menu'])): ?>
                            <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                           
                            <li> <a href="<?php echo BASE_URL.$_layoutParams['menu'][$i]['enlace']; ?>"> <b> <?php  echo $_layoutParams['menu'][$i]['titulo']; ?> </b></a></li>

                            <?php endfor; ?>
                            <?php endif; ?>
      </ul>
    </div>
  </section>

  <!-- Content page-->
  <section class="full-box dashboard-contentPage">
    <!-- NavBar -->
    <nav class="full-box dashboard-Navbar">
      <ul class="full-box list-unstyled text-right">
        <li class="pull-left">
          <a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
        </li>
        <li>
          <a href="<?php echo BASE_URL ?>public/manual.pdf" target="_blank" class="btn-modal-help">
            <i class="zmdi zmdi-help-outline">Ayuda</i>
          </a>
        </li> 
      
        <li>
          <a href="<?php echo BASE_URL ?>public/manual.pdf" target="_blank" class="btn-modal-help">
            <i class="zmdi zmdi-help-outlinee"></i>
          </a>
        </li> 
      </ul>
    </nav>
    <!-- Content page -->
<?php endif; ?>




</div class="container">
