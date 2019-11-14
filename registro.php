<?php

$nombre = "";
$psw = "";
$passre = "";
$apellido ="";
$mail = "";


//Errores
$errorNombre = "";
$errorEmail = "";
$errorApellido = "";
$errorContrasenia = "";
$errorAvatar = "";
$errores = false;


//////////////////////////////////////////////////////////////
if($_POST){
    require_once 'clases/ValidadorReg.php';
    $validador = new Validador;
    //VALIDO
    $errorNombre = $validador->full_name($_POST["nombre"]);
    $errorApellido = $validador->apellido($_POST["apellido"]);
    $errorEmail = $validador->email($_POST["email"]);
    $errorContrasenia = $validador->contrasenias($_POST["psw"],$_POST["pass-repeat"]);

    //si no hay errores de validacion persistimos
    $nombre = $validador->persisteNombre($_POST["nombre"]);
    $apellido = $validador->persisteApellido($_POST["apellido"]);
    $psw = $validador->persistePsw($_POST["psw"],$_POST["pass-repeat"]);
    $mail = $validador->persisteEmail( $_POST["email"]);

////////////////////////////////////////////////////////////////
  //VALIDO LA FOTO
    if ($_FILES){
      if ($_FILES["avatar"]["error"] !=0){
        $errorAvatar = "*La imagen no fue correctamente cargada <br>";
        $errores = true;

      }
      else{
        $avat = pathinfo($_FILES ["avatar"]["name"], PATHINFO_EXTENSION);
        if ($avat != "jpg" && $avat != "jpeg" && $avat != "png") {
          $errorAvatar = "*La foto debe ser jpg, jpeg o png <br>";
          $errores = true;

        }
        else {
          $errorAvatar = "#";
        }
      }
    }

///////////////////////////////////////////////////////////////////

    if($errorNombre == "#" && $errorEmail == "#" && $errorContrasenia == "#" && $errorAvatar == "#" && $errorApellido== "#"){
        //guardo la foto
        move_uploaded_file($_FILES ["avatar"]["tmp_name"], "imgavatar/". $mail . "." . $avat );
        //aca registro.
        require_once 'clases/base_datos.php';
        $bd = new BD;
        $id_user = $bd->registrarUsuario($_POST["nombre"],$_POST["email"],$_POST["psw"],$_POST["apellido"]);
        //si se registro bien...
        if($id_user){
            session_start();
            //LOGUEO AL USUARIO Y REDIRIJO AL HOME
            $_SESSION["id_usuario_logueado"] = $id_user;
            header("Location:inicio.php");
        }

    }
}

/////////////////////////////////////////////////////////////


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ECO BICIS | Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilosregistro.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">


</head>
<body>
   <div class="container.fluid">
     <!--PRINCIPIO HEADER-->
       <header>
         <nav class="navbar navbar-expand-lg navbar-light bg-light" style="z-index: 1;">
         <a class="navbar-brand" style="color:white; font-size:40px;" href="inicio.php">EcoBici</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
           <ul class="navbar-nav">
             <li class="nav-item active">
               <a class="nav-link" href="inicio.php">Home <span class="sr-only">(current)</span></a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="registro.php">Registrarse</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="loginB.php">Login</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="FAQ.php">FAQs</a>
             </li>
           </ul>
         </div>
       </nav>
       </header>
   <!--FIN DE HEADER-->
       <div class="row contacto borde" style="margin-bottom:50px;">
         <div class="portada" >
          <div><img class=" bajar rounded img-fluid" src="images/fondo.jpg" alt="">
          <div style="text-align:center; padding: 30px;"><h2>REGISTRATE</h2> </div>
          </div>
        </div>
          <form class="col-8 offset-2" action="registro.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                  <!--NOMBRE-->
                  <span class="col-12 pl-0" style="color:red;font-size:14px;"><?=$errorNombre != "#" ? $errorNombre : '';?></span>
                  <label class="col-12 col-md-2 p-0" for="nombre"><b>Nombre</b></label>
                  <input  class="col-12 col-md-4" type="text" placeholder="Ingresar nombre" name="nombre" value="<?=$nombre?>" required>

                  <!--APELLIDO-->
                  <label class="col-12 col-md-2 pl-0" for="apellido"><b>Apellido</b></label>
                  <input class="col-12 col-md-4" value="<?=$apellido?>"type="text" placeholder="Ingresar apellido" name="apellido" required>


                  <!--EMAIL-->
                  <span style="color:red;font-size:14px;"><?=$errorEmail != "#" ? $errorEmail : '';?></span>
                  <label class="col-12 p-0" for="email"><b>Email</b></label>
                  <input class="col-12" value="<?=$mail?>"  type="email" placeholder="Ingresar Email" name="email" required>


                  <!--AVATAR -->
                  <span style="color:red;font-size:14px;"><?=$errorAvatar;?></span>
                  <label class="col-12 p-0" for="avatar"><b>Avatar</b></label>
                  <div class="custom-file">
                    <input  type="file" class="custom-file-input" name="avatar" value="<?=$errorAvatar?>"  lang="es">
                    <label class="custom-file-label" for="avatar">Seleccionar Archivo</label>
                  </div>



                  <!--PASSWORD -->
                  <div class="col-12 col-md-6 pl-0 pr-1">
                    <span style="color:red;font-size:14px;"><?=$errorContrasenia != "#" ? $errorContrasenia : '';?></span>
                    <label class="col-12 p-0"for="pass"><b>Contraseña</b></label>
                    <input value="<?=$psw?>" class="col-12"type="password" placeholder=" Ingresar contraseña" name="psw" required>
                  </div>
                  <div class="col-12 col-md-6 p-0">
                    <span style="color:red;font-size:14px;"><?=$errorContrasenia != "#" ? $errorContrasenia : '';?></span>
                    <label class="col-12 p-0"for="pass-repeat"><b>Confirme contraseña</b></label>
                    <input value="<?=$psw?>" class="col-12"type="password" placeholder="Repetir contraseña" name="pass-repeat" required>
                  </div>


                  <p class="text-left">Al registrarse ud acepta nuestros <a href="#">terminos y condiciones</a>.</p>
                  <div class="contenedorBoton col-12">
                    <button  style="background: #4fa4ffa6; width:45%;" type="submit" class="registerbtn mb-4">ENVIAR</button>

                  </div>
              </div>
          </form>
   </div>
   <!-- Comienzo footer-->
   <footer class="row">
       <div class="colFooter col-lg-4 col-md-12">
         <p>Dirección: Avenida Córdoba 2222
         <b>CABA</b> <br>
         <p>Tel: 15151-515515</p>
         <a href="mailto:consultas@ecobici.com.ar">consultas@ecobici.com.ar</a>
       </p>
       </div>
       <div class="colFooter col-lg-4 col-md-12">
         <p>Seguinos en nuestras redes</p>
         <a href="#"><img class="redes" src="images/icono-face.png" alt="facebook" width="35px;" height="35px;"></a>
         <a href="#"><img class="redes" src="images/icono-insta.png" alt="instagram" width="35px;" height="35px;"></a>
         <a href="#"><img class="redes" src="images/icono-wa.png" alt="whatsapp" width="35px;" height="35px;"></a>
       </div>
       <div class="colFooter col-lg-4 col-md-12 d-none d-md-block">
         <p class="textoDestacado">
           <i>Somos representantes exclusivos de las mejores marcas internacionales y ofrecemos garantía oficial.</i>
         </p>
       </div>
   </footer>
   <!--Fin del footer-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
