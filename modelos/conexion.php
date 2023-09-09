<?php

class Conexion
{
    static public function conectar()
    {
        $link = new PDO("mysql:host=localhost;dbname=dbavi0xfxxxjkw", "uzdcgsoudgeif", "g@j*}e1hbd@,");

        $link->exec("set names utf8");

        return $link;
    }
}
