<?php 

require_once 'config/Conexion.php';
$consultagenero = $conexion->query("SELECT * FROM genero");{
    $genero =array();
    if($consultagenero->num_rows >0){
        while($musica  =$consultagenero->fetch_assoc()){
            $genero [] = $musica; 
        }
    }
    return $genero;
}

?>