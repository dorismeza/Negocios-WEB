<?php
namespace Dao\Mnt;

use Dao\Table;

class Usuarios extends Table{
    public static function obtenerUsuarios()
    {
        $sqlStr = "SELECT usercod,useremail,username,userpswd,date(userfching)userfching,userpswdest,date(userpswdexp)userpswdexp,userest,useractcod,userpswdchg,usertipo from usuario;";
        return self::obtenerRegistros($sqlStr, array());
    }

    public static function obtenerUsuario($usercod)
    {
        $sqlStr = "SELECT useremail, username, userpswd, date(userfching)userfching, userpswdest, date(userpswdexp)userpswdexp, userest, useractcod, userpswdchg, usertipo from usuario where usercod = :usercod;";
        return self::obtenerUnRegistro($sqlStr, array("usercod"=>intval($usercod)));
    }

    public static function crearUsuario($useremail, $username,$userpswd, $userfching,$userpswdest, $userpswdexp,$userest, $useractcod,$userpswdchg, $usertipo)
    {
        $sqlstr = "INSERT INTO usuario (useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo) values (:useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo);";
        $parametros = array(
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userfching" => $userfching,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }
    public static function editarUsuario($useremail, $username,$userpswd, $userfching,$userpswdest, $userpswdexp,$userest, $useractcod,$userpswdchg, $usertipo,$usercod)
    {
        $sqlstr = "UPDATE usuario set useremail=:useremail, username=:username, userpswd=:userpswd, userfching=:userfching, userpswdest=:userpswdest, userpswdexp=:userpswdexp, userest=:userest, useractcod=:useractcod, userpswdchg=:userpswdchg, usertipo=:usertipo where usercod = :usercod;";
        $parametros = array(
            "useremail" =>  $useremail,
            "username" =>  $username,
            "userpswd" =>  $userpswd,
            "userfching" =>  $userfching,
            "userpswdest" =>  $userpswdest,
            "userpswdexp" =>  $userpswdexp,
            "userest" =>  $userest,
            "useractcod" =>  $useractcod,
            "userpswdchg" =>  $userpswdchg,
            "usertipo" =>  $usertipo,
            "usercod" => intval($usercod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
        // sqlstr = "UPDATE X SET Y = '".$Y."' where Z='".$Z."';";
        // $Y = "'; DROP DATABASE mysql; SELECT * FROM (SELECT DATE)
    }

    public static function eliminarUsuario($usercod)
    {
        $sqlstr = "DELETE FROM usuario where usercod=:usercod;";
        $parametros = array(
            "usercod" => intval($usercod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }

    public static function _saltPassword($password)
    {
        return hash_hmac(
            "sha256",
            $password,
            \Utilities\Context::getContextByKey("PWD_HASH")
        );
    }

    public static function _hashPassword($password)
    {
        return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
    }

    public static function verifyPassword($raw_password, $hash_password)
    {
        return password_verify(
            self::_saltPassword($raw_password),
            $hash_password
        );
    }
}