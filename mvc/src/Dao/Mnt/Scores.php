<?php

namespace Dao\Mnt;

use Dao\Table;

class Scores extends Table
{
    /*
            CREATE TABLE `scores` (
            `scoreid` BIGINT(18) NOT NULL AUTO_INCREMENT,
            `scoredsc` VARCHAR(128) NULL, 
            `scoreauthor` VARCHAR(256) NULL,
            `scoregenre` VARCHAR(256) NULL, genero de partitura
            `scoreyear` INT NULL,año
            `scoresales` INT NULL, ventas
            `scoreprice` DECIMAL(13,2) NULL, precio
            `scoredocurl` VARCHAR(256) NULL, url a pdf
            `scoreest` CHAR(3) NULL, estado -> ACT, INA
            PRIMARY KEY (`scoreid`));
                select estado
                select genero
            */

    public static function getAll()
    {
        $sqlstr = "SELECT * FROM scores;";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function getById(int $scoreid)
    {
        $sqlstr = "SELECT * from `scores` where scoreid=:scoreid;";
        $sqlParams = array("scoreid" => $scoreid);
        return self::obtenerUnRegistro($sqlstr, $sqlParams);
    }

    public static function insert(
        $scoredsc,
        $scoreauthor,
        $scoregenre,
        $scoreyear,
        $scoresales,
        $scoreprice,
        $scoredocurl,
        $scoreest
    ) {
        $sqlstr = "INSERT INTO `scores`
        (`scoredsc`,
        `scoreauthor`,
        `scoregenre`,
        `scoreyear`,
        `scoresales`,
        `scoreprice`,
        `scoredocurl`,
        `scoreest`)
    VALUES
    (:scoredsc, :scoreauthor,
    :scoregenre, :scoreyear, :scoresales,
    :scoreprice, :scoredocurl, :scoreest);
    ";
        $sqlParams = [
            "scoredsc" => $scoredsc ,
            "scoreauthor" => $scoreauthor ,
            "scoregenre" => $scoregenre ,
            "scoreyear" => $scoreyear ,
            "scoresales" => $scoresales ,
            "scoreprice" => $scoreprice ,
            "scoredocurl" =>  $scoredocurl ,
            "scoreest" => $scoreest
        ];
        return self::executeNonQuery($sqlstr, $sqlParams);
    }
 
    public static function update(
        $scoredsc,
        $scoreauthor,
        $scoregenre,
        $scoreyear,
        $scoresales,
        $scoreprice,
        $scoredocurl,
        $scoreest,
        $scoreid
    ) {
        $sqlstr = "UPDATE `scores` set
`scoredsc`=:scoredsc, `scoreauthor`=:scoreauthor,
`scoregenre`=:scoregenre, `scoreyear`=:scoreyear, `scoresales`=:scoresales,
`scoreprice`=:scoreprice, `scoredocurl`=:scoredocurl, `scoreest`=:scoreest
 where `scoreid` = :scoreid;";

        $sqlParams = array(
            "scoredsc" => $scoredsc ,
            "scoreauthor" => $scoreauthor ,
            "scoregenre" => $scoregenre ,
            "scoreyear" => $scoreyear ,
            "scoresales" => $scoresales ,
            "scoreprice" => $scoreprice ,
            "scoredocurl" =>  $scoredocurl ,
            "scoreest" => $scoreest,
            "scoreid" => $scoreid
        );
        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    public static function delete($scoreid)
    {
        $sqlstr = "DELETE from `scores` where scoreid = :scoreid;";
        $sqlParams = array(
            "scoreid" => $scoreid
        );
        return self::executeNonQuery($sqlstr, $sqlParams);
    }

}
