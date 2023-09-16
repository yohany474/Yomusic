<?php 

require_once 'config/Conexion.php';
$consulta = $conexion->query("SELECT * FROM musica INNER JOIN genero ON musica.idgenero = genero.idgenero  ORDER BY musica.idmusica desc");{
    $data =array();
    if($consulta->num_rows >0){
        while($musica  =$consulta->fetch_assoc()){
            $data [] = $musica; 
        }
    }
    return $data;
}

?>