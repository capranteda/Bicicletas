<?php

class Base{

    private $conexion;

    public function __construct(){
        $dsn = "mysql:host=localhost;dbname=base_datos";
        $user = "root";
        $pass = "root";
        $opciones = [];

        $this->conexion = new PDO($dns,$user,$pass,$opciones);
    }

    public function registrarUsuario($nombre,$email,$pass){
        $consulta = $this->conexion->prepare("INSERT INTO usuarios (id,nombre,email,contrasenia) VALUES
        DEFAULT, :nombre1 ,:email1 , :pass1 ");
        $consulta->bindValue(":nombre1",$nombre);
        $consulta->bindValue(":email1",$email);
        $consulta->bindValue(":pass1",password_hash($pass,PASSWORD_DEFAULT));
        $consulta->execute();

        return $consulta->lastInsertId();
    }

    public function verPerfilDelUsuario($id){
        $consulta = $this->conexion->query("SELECT * FROM usuarios WHERE id = $id");
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
 ?>
