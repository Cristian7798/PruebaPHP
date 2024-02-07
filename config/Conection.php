<?php

include_once "Constants.php";

class Conection
{
    private static $conexion = null;

    private function __construct() {
    }
    
    public static function getConexion(){
        try {
            // Si no existe conexion, se crea
            if(!isset(self::$conexion)){
                self::$conexion = new PDO(
                    "mysql:host=" . SERVIDORBD . "; 
                    port= ".PUERTO."; 
                    dbname=" . NOMBREBD, 
                    USUARIO,
                    PASSWORD
                );  
               self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
               self::$conexion->exec("set character set utf8");
            }
        } catch (Exception $e) {
            echo "linea del error " .$e->getLine();
            echo "</br>";
            echo "archivo " . $e->getFile();
            echo "</br>";
            die("error " . $e->getMessage());
        }
        return self::$conexion;
    }
}