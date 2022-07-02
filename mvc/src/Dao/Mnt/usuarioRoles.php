<?php

namespace Dao\Mnt;

use Dao\Table;

class usuarioRoles extends Table{

    public static function obtenerRolesPorUsuario($usercod)
    {
        $sqlStr = "select r.rolescod, r.rolesdsc from usuario u inner join roles_usuarios ru on u.usercod= ru.usercod  inner join roles r on ru.rolescod = r.rolescod where u.usercod=:usercod";
        return self::obtenerRegistros($sqlStr, array("usercod"=>$usercod,));
    }

    public static function obtenerNonRoles($usercod)
    {
        $sqlStr = "SELECT rolescod, rolesdsc FROM roles
        WHERE rolescod NOT IN
        (select r.rolescod from usuario u inner join roles_usuarios ru on u.usercod= ru.usercod  inner join roles r on ru.rolescod = r.rolescod where u.usercod=:usercod);";
        return self::obtenerRegistros($sqlStr, array("usercod" => $usercod));
    }

    public static function InsertarRolesUsuario($usercod,$rolescod){
        $sqlStr= "INSERT INTO `roles_usuarios` (`usercod`, `rolescod`, `roleuserest`, `roleuserfch`, `roleuserexp`) VALUES (:usercod, :rolescod, 'ACT', now(), now());";
        return self::executeNonQuery($sqlStr, array("usercod"=>$usercod,"rolescod" => $rolescod));
    }
    
    public static function EliminarRolesUsuario($rolescod){
        $sqlStr= "delete from roles_usuarios where rolescod =:rolescod;";
        return self::executeNonQuery($sqlStr, array("rolescod" => $rolescod));
    }

    public static function Eliminarusuariorol($usercod){
        $sqlStr= "delete from roles_usuarios where usercod =:usercod;";
        return self::executeNonQuery($sqlStr, array("usercod" => $usercod));
    }

}

?>