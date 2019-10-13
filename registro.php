<?php
$nombre = "";
$psw = "";
$passre = "";
$apellido ="";
$mail = "";
//Compruebo foto
if ($_FILES){
  if ($_FILES["avatar"]["error"] !=0){
    $errorAvatar = "La imagen no fue correctamente cargada";
    $errores = true;

  }
  else{
    $avat = pathinfo($_FILES ["avatar"]["name"], PATHINFO_EXTENSION);
    if ($avat != "jpg" && $avat != "jpeg" && $avat != "png") {
      $errorAvatar = "La foto debe ser jpg, jpeg o png <br>";
      $errores = true;

    }
    else {
      //Si no hay errores subimos la foto
      move_uploaded_file($_FILES ["avatar"]["tmp_name"], "imgavatar/avatar.". $avat );
    }
  }
}

//Errores
$errorNombre = "";
$errorApellido = "";
$errorEmail = "";
$errorPassword = "";
$errorAvatar = "";

//averiguo si enviaron el formulario
if($_POST){
    //creo una variable para saber si hay errores o no
    $errores = false;

    if ($_FILES){
      if ($_FILES["avatar"]["error"] !=0){
        $errorAvatar = "La imagen no fue correctamente cargada <br>";
        $errores = true;

      }
      else{
        $avat = pathinfo($_FILES ["avatar"]["name"], PATHINFO_EXTENSION);
        if ($avat != "jpg" && $avat != "jpeg" && $avat != "png") {
          $errorAvatar = "La foto debe ser jpg, jpeg o png <br>";
          $errores = true;

        }
        else {
          //Si no hay errores subimos la foto
          move_uploaded_file($_FILES ["avatar"]["tmp_name"], "imgavatar/avatar.". $avat );
        }
      }
    }

    //valido los datos
    if($_POST["nombre"] == ""){
        $errorNombre = "Ingrese su nombre";
        $errores = true;
    }else if(strlen($_POST["nombre"]) < 4){
        $errorNombre = "Su nombre debe tener al menos 4 caracteres";
        $errores = true;
    }else{
      $nombre = $_POST["nombre"]; }

    if($_POST["apellido"] == ""){
        $errorApellido = "Ingrese su apellido";
        $errores = true;
    }
    else {
      $apellido = $_POST["apellido"];
    }

    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL == false)){
       $errorEmail = "Ingrese un mail valido";
       $errores = true;
    }
    else {
      $mail = $_POST["email"];
    }

    if($_POST["psw"] == "" || $_POST["pass-repeat"] == ""){
        $errorPassword = "Debe ingresar una contraseña";
        $errores = true;
    }else if($_POST["psw"] != $_POST["pass-repeat"]){
        $errorPassword = "Las contraseñas deben coincidir";
        $errores = true;
    }else{
        //Persisto password
        $psw = $_POST["psw"];
        $passre = $_POST["psw"];
        //hasheo psw
        $contrasenia = password_hash($_POST["psw"],PASSWORD_DEFAULT);

    }
    //Si no tenemos errores creo el usuario
    if(!$errores){
        //creo el usuario
        $usuario = [
            "id"=> md5($_POST["nombre"]),
            "nombre" => $_POST["nombre"],
            "apellido" => $_POST["apellido"],
            "email" => $_POST["email"],
            "password" => $contrasenia
        ];


        //traigo los usuarios del json
        $usuariosEnJSON = file_get_contents("usuarios.json");
        //convierto el json en array
        $usuarios = json_decode($usuariosEnJSON);
        //agrego el nuevo usuario al array de la base de datos
        $usuarios[] = $usuario;
        //convierto el nuevo array completo a json
        $nuevosUsuariosEnJSON = json_encode($usuarios);
        //escribo el nuevo json en el archivo .json
        file_put_contents("usuarios.json",$nuevosUsuariosEnJSON);
        header("Location:loginB.html");
        exit;

    }

}

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
                  <label class="col-12 col-md-2 p-0" for="nombre"><b>Nombre</b></label>
                  <input <?php echo $errorNombre!=""?"style='border:1px solid red;'":""; ?> class="col-12 col-md-4" type="text" placeholder="Ingresar nombre" name="nombre" value="<?=$nombre?><?=$errorNombre;?>" required>
                  <!--<span style="color:red;font-size:14px;"><?=$errorNombre;?></span>-->

                  <!--APELLIDO-->
                  <label class="col-12 col-md-2" for="apellido"><b>Apellido</b></label>
                  <input class="col-12 col-md-4" value="<?=$apellido?>"type="text" placeholder="Ingresar apellido" name="apellido" required>


                  <!--EMAIL-->
                  <label class="col-12 p-0" for="email"><b>Email</b></label>
                  <input class="col-12" value="<?=$mail?>"  type="email" placeholder="Ingresar Email" name="email" value="<?=$errorEmail;?>"required>


                  <!--AVATAR -->
                  <label class="col-12 p-0" for="avatar"><b>Avatar</b></label>
                  <div class="custom-file">
                    <input <?php echo $errorAvatar!=""?"style='border:1px solid red;'":""; ?> type="file" class="custom-file-input" name="avatar" value="<?=$errorAvatar?>"  lang="es">
                    <label class="custom-file-label" for="avatar">Seleccionar Archivo</label>
                    <span style="color:red;font-size:14px;"><?=$errorAvatar;?></span>
                  </div>



                  <!--PASSWORD -->
                  <div class="col-12 col-md-6 pl-0 pr-1">
                    <label class="col-12 p-0"for="pass"><b>Contraseña</b></label>
                    <input value="<?=$psw?>" class="col-12"type="password" placeholder=" Ingresar contraseña" name="psw" required>
                  </div>
                  <div class="col-12 col-md-6 p-0">
                    <label class="col-12 p-0"for="pass-repeat"><b>Confirme contraseña</b></label>
                    <input value="<?=$psw?>" class="col-12"type="password" placeholder="Repetir contraseña" name="pass-repeat" required>
                    <span style="color:red;font-size:12px;"><?=$errorPassword;?></span>
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
