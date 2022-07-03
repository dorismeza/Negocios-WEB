<?php

namespace Dao\Mnt;

use Dao\Table;

class Funciones extends Table
{
    public static function obtenerFunciones()
    {
        $sqlStr = "SELECT * from funciones";
        return self::obtenerRegistros($sqlStr, array());
    }

    public static function obtenerFuncion($fncod)
    {
        $sqlStr = "SELECT * from funciones WHERE fncod = :fncod;";
        return self::obtenerUnRegistro($sqlStr, array("fncod" => $fncod));
    }

    public static function insertarFuncion(
        $fncod,
        $fndsc,
        $fnest,
        $fntyp
    ) {
        $sqlStr = "INSERT INTO funciones(fncod, fndsc, fnest, fntyp) VALUE(:fncod, :fndsc, :fnest, :fntyp);";
        $parametros = array(
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }

    public static function actualizarFuncion(
        $fncod,
        $fndsc,
        $fnest,
        $fntyp
    ) {
        $sqlStr = "UPDATE funciones SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp WHERE fncod = :fncod";
        $parametros = array(
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp,
            "fncod" => $fncod
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }
    public static function eliminarFuncione($fncod)
    {
        $sqlStr = "DELETE FROM funciones WHERE  fncod=:fncod;";
        return self::executeNonQuery($sqlStr, array(
            "fncod" => $fncod
        ));
    }
  
}
