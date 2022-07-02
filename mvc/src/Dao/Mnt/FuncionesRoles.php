<?php

namespace Dao\Mnt;

use Dao\Table;

class FuncionesRoles extends Table
{
    public static function obtenerFuncionesPorRol($rolescod)
    {
        $sqlStr = "SELECT r.rolescod,
                            r.rolesdsc,
                            f.fncod,
                            f.fndsc,
                            f.fnest,
                            fr.fnrolest,
                            fr.fnexp
                    FROM roles r
                    INNER JOIN funciones_roles fr
                    ON r.rolescod = fr.rolescod
                    INNER JOIN funciones f
                    ON fr.fncod = f.fncod
                    WHERE r.rolescod = :rolescod;";
        return self::obtenerRegistros($sqlStr, array("rolescod" => $rolescod));
    }

    public static function obtenerNonFunciones($rolescod)
    {
        $sqlStr = "SELECT fncod, fndsc FROM funciones
                    WHERE fncod NOT IN
                    (SELECT f.fncod
                    FROM roles r
                    INNER JOIN funciones_roles fr
                    ON r.rolescod = fr.rolescod
                    INNER JOIN funciones f
                    ON fr.fncod = f.fncod
                    WHERE r.rolescod = :rolescod);";
        return self::obtenerRegistros($sqlStr, array("rolescod" => $rolescod));
    }

    public static function insertarFuncionRol(
        $rolescod,
        $fncod
    ) {
        $sqlStr = "INSERT INTO funciones_roles(
                        rolescod,
                        fncod,
                        fnrolest,
                        fnexp
                    ) values (
                        :rolescod,
                        :fncod,
                        'ACT',
                        DATE_ADD(NOW(), INTERVAL 1 YEAR)
                    );";
        return self::executeNonQuery($sqlStr, array(
            "rolescod" => $rolescod,
            "fncod" => $fncod
        ));
    }

    public static function eliminarFuncionRol($fncod)
    {
        $sqlStr = "DELETE FROM funciones_roles WHERE fncod = :fncod";
        return self::executeNonQuery($sqlStr, array("fncod" => $fncod));
    }
}
