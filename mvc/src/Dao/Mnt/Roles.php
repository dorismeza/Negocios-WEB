<?php

namespace Dao\Mnt;

use Dao\Table;

class Roles extends Table
{
    public static function obtenerRoles()
    {
        $sqlStr = "SELECT * FROM roles";
        return self::obtenerRegistros($sqlStr, array());
    }

    public static function obtenerRol($rolcod)
    {
        $sqlStr = "SELECT * FROM roles WHERE rolescod = :rolescod";
        return self::obtenerUnRegistro($sqlStr, array("rolescod" => $rolcod));
    }

    public static function insertarRol(
        $rolescod,
        $rolesdsc,
        $rolesest
    ) {
        $sqlStr = "INSERT INTO roles(rolescod, rolesdsc, rolesest) VALUES(:rolescod, :rolesdsc, :rolesest);";
        $parametros = array(
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }

    public static function actualizarRol(
        $rolescod,
        $rolesdsc,
        $rolesest
    ) {
        $sqlStr = "UPDATE roles SET rolesdsc = :rolesdsc, rolesest = :rolesest WHERE rolescod = :rolescod;";
        $parametros = array(
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest,
            "rolescod" => $rolescod
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }

    public static function eliminarRol($rolescod)
    {
        $sqlStr = "DELETE FROM roles WHERE rolescod = :rolescod;";
        return self::executeNonQuery($sqlStr, array(
            "rolescod" => $rolescod
        ));
    }

    public static function GUID()
    {
        $guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        return substr($guid, 0, 15);
    }
}
