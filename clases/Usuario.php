<?php

class Usuario {
  private $nombre;
  private $email;
  private $contrasenia;

  public function __construct($nombre1, $email1, $contrasenia1){
    $this-> nombre = $nombre1;
    $this-> email = $email1;
    $this-> contrasenia = $contrasenia1;
  }
  public function getNombre(){
  return $this->nombre;
  }

  public function getEmail(){
  return $this->email;
  }
    // code...
  }







 ?>
