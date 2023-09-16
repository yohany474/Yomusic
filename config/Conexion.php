<?php

class Conexion
{

    private $conexion = null;
    private $server = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'music';

    // private $user = 'c1601882_music';
    // private $password = 'zeKAziwe09';
    // private $database = 'c1601882_music';


    public function __construct()
    {
        $this->conexion = mysqli_connect("$this->server", "$this->user", "$this->password", "$this->database");
    }
    public function getConexion()
    {
        return $this->conexion;
    }

}
$bd = new Conexion();
$conexion = $bd->getConexion();
?>