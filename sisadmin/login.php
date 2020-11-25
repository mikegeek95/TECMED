<?php
require_once("clases/class.Funciones.php");
$f = new Funciones();
$navegador = $f->navegador();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/Login/login.css" rel="stylesheet" type="text/css" />
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">



</head>

<body class="fondo">

    <div class="container ">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0 ">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="imgArr col-lg-7">
				<div class="logoEnno col-lg-8 col-lg-pull-2 "
					style="position: absolute"></div>
				</div>
              <div class="col-lg-5">
                <div class="p-5">
                  <div class="text-center">
                    <h3>Bienvenido</h3>
                  </div>
					<br>
                  <form id="logeo"  action="javascript:void(0)">
                    <div class="form-group">
                      <input type="text" class="form-control " id="usuario" name="usuario"  placeholder="Ingresa usuario">
                    </div>
					  <br>
                    <div class="form-group">
                      <input type="password" class="form-control " id="pass" name="pass" placeholder="Ingresa Contraseña">
                    </div>
                    <div class="form-group">
                      
                    </div>
					  <br>
                    <div class="text-center">
                    <a class="small" href="forgot-password.html">¿Olvidaste tu contraseña?</a>
                  </div>
					  <br><br>
					  <input type="submit" value="INICIAR SESIÓN"
						id="btnIniSes" class="btn btn-primary btn-user btn-block">
                    
                    
                    
                  </form>
                  
                  
                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	

<script type="text/javascript"	src="librerias/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript"	src="librerias/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript"	src="librerias/bootstrapValidator/js/bootstrapValidator.min.js"></script>
	
  <script type="text/javascript"	src="js/Login/validaciones.js"></script>
  <script type="text/javascript"	src="js/Login/login.js"></script>
  <script type="text/javascript"	src="js/fn_Funciones.js"></script>
  <script type="text/javascript"	src="js/fn_Jquery.js"></script>

</body>

</html>
