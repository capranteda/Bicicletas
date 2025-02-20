<!DOCTYPE html>
<?php
if (isset ($_SESSION['user_id'])) {
  session_start();
  header('Location: inicio.php');
}

//PERSISTO LOS DATOS
    $tempEmail="";
    $tempPassword="";

if ($_POST){
     $tempEmail = $_POST["email"];
     $tempPassword = $_POST["password"];}


//SI VIENE FORM POR POST, VALIDO QUE NO ESTE VACIO Y TENGA FORMATO EMAIL

$errorLogin = "";
$mjsError = "";
if($_POST){
    require_once 'clases/Validador.php';
    $validador = new Validador;
    $errorLogin = $validador->login($_POST["email"],$_POST["password"]);

//SI NO HAY ERRORES DE VALIDACION, CONSULTO BASE DE DATOS
  if($errorLogin == ""){
    include 'clases/base_datos.php';
    $base = new Base;

    $usuario = $base -> traerUser($_POST["email"],$_POST["password"]);


//COMPARO EL PASS QUE ME LLEGA POR POST CON EL DE LA BASE Y SI ESTA OK INICIO SESION

    if (password_verify($_POST["password"], $usuario['password'])) {
      session_start();
      $_SESSION["id_usuario_logueado"] = $usuario['id'];
      header('Location:inicio.php');
    }
//SI EL PASS O EL MAIL ESTAN MAL, DOY MENSAJE DE ERROR
    else {
      $mjsError = "Error de login";
    }

  }
}

//SETEO LA COOKIE DE RECORDARME
if($_POST){
   if(isset($_POST["recordarme"])){
       setcookie("email",$_POST["email"]);
       setcookie("password", password_hash($_POST["password"],PASSWORD_DEFAULT));
     }
 }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ECO BICIS | Login</title>
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
               <a class="nav-link" href="Inicio.php">Home <span class="sr-only">(current)</span></a>
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
       <main class="row contacto borde" style="margin-bottom:50px;">
         <div class="portada" >
          <div><img class=" bajar rounded img-fluid" src="images/fondo.jpg" alt="">
          <div style="text-align:center; padding: 30px;"><h2>INGRESAR</h2> </div>
          </div>
        </div>


          <form class="col-8 offset-2" action="#" method="POST">
              <div class="row" style="display: flex;justify-content: center;">

                <span class="error"><?=$errorLogin?></span>
                <span class="error"><?=$mjsError?></span>

                  <label class="col-12 pl-0" for="email"><b>Email</b></label>
                  <input class="col-12 " type="email" placeholder="Ingresar Email" name="email"
                  value=<?=$tempEmail?>>

                  <label class="col-12 pl-0"for="pass"><b>Contraseña</b></label>
                  <input class="col-12" type="password" placeholder=" Ingresar contraseña" name="password"
                  value=<?=$tempPassword?>>


                  <div class="col-12">
                    <label class=""for="pass"><b>Recordarme</b></label>
                    <input class="" type="checkbox" name="recordarme"
                    value="recordarme">
                  </div>

                  <button style="background: #4fa4ffa6; width:45%;" type="submit" class="registerbtn mb-4">ENTRAR</button>
              </div>
          </form>
   </main>
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
