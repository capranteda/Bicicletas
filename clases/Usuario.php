<?php

class Usuario {
  private $nombre;
  private $email;
  private $contrasenia;

  public function __construct($nombre1,  $email1, $apellido1, $contrasenia1){
    $this-> nombre = $nombre1;
    $this-> apellido = $apellido1;
    $this-> email = $email1;
    $this-> contrasenia = $contrasenia1;
  }
  public function getNombre(){
  return $this->nombre;
  }

  public function getEmail(){
  return $this->email;
  }

    public function getApellido(){
  return $this->email;
  }
    // code...
  }







 ?>
