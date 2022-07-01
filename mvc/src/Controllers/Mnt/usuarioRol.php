<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class usuarioRol extends PublicController
{
    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_usuarios",
            "Ocurrió algo inesperado. Intente nuevamente."
        );
    }

    private function yeah($usercod)
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_usuariorol&mode=DSP&usercod=$usercod",
            "¡Operación ejecutada satisfactoriamente!"
        );
    }

    public function run(): void
    {
        $viewData = array(
            "mode" => "",
            "usercod" => "",
            "rolescod" => "",
            "username"=>"",
            "rolesdsc"=>"",
            "roleuserest_ACT"=>"",
            "roleuserest_INA" => "",
            "roleuserest_PLN"=>"",
            "funciones" => array(),
            "showaction"=>true,
            "nonFunciones" => array()
        );
        if ($this->isPostBack()) {
            $viewData["mode"] = $_POST["mode"];
            $viewData["usercod"] = $_POST["usercod"];
            switch ($viewData["mode"]) {
                case "INS":
                    $this->yeah($viewData["usercod"]);
                    //dd($viewData);
                    break;
                default:
                    $this->yeah($viewData["usercod"]);
            }
        } else {
            if (isset($_GET["mode"])) {
                $viewData["mode"] = $_GET["mode"];
            } else $this->nope();
            if (isset($_GET["usercod"])) $viewData["usercod"] = $_GET["usercod"];
            else if ($viewData["mode"] !== "INS") $this->nope();
        }
        if (isset($viewData["mode"])) {
            // Obteniendo las funcioens en el rol.
            $tmpuser = \Dao\Mnt\usuarioRoles::obtenerRolesPorUsuario($viewData["usercod"],$viewData["rolescod"]);
            $counter = 0;
            //dd($tmpuser);
            //dd($tmpRol);
            foreach ($tmpuser as $user) {
                $viewData["rolesdsc"] = $user["rolesdsc"];
                //$viewData["funciones"][$counter]["usercod"] = $user["usercod"];
                $viewData["funciones"][$counter]["rolescod"] = $user["rolescod"];
                $viewData["funciones"][$counter]["rolesdsc"] = $user["rolesdsc"];
                //$viewData["funciones"][$counter]["roleuserest"] = $user["roleuserest"];
                $counter++;
            }
            // Obteniendo las funciones que no estan en el rol.
            $tmpNonRoles = \Dao\Mnt\usuarioRoles::obtenerNonRoles($viewData["usercod"]);
            //dd($viewData);
            foreach ($tmpNonRoles as $nonFunciones) {
                $viewData["nonFunciones"][$counter]["rolescod"] = $nonFunciones["rolescod"];
                $viewData["nonFunciones"][$counter]["rolesdsc"] = $nonFunciones["rolesdsc"];
                
                $counter++;
            }
            // dd($viewData["nonFunciones"]);

            // Insertamos la funcion al rol.
            switch ($viewData["mode"]) {
                case "INS":
                    $viewData["rolescod"] = $_GET["rolescod"];
                     //dd($viewData);
                    if (\Dao\Mnt\usuarioRoles::InsertarRolesUsuario(
                        $viewData["usercod"],
                        $viewData["rolescod"]
                    )){
                        //dd("hola mundo");
                        $this->yeah($viewData["usercod"]);
                    } 
                    break;
                case "DEL":
                    $viewData["rolescod"] = $_GET["rolescod"];
                    if (\Dao\Mnt\usuarioRoles::EliminarRolesUsuario($viewData["rolescod"]))
                        $this->yeah($viewData["usercod"]);
                    break;
            }
        }
        $viewData["xsrftoken"] = md5($this->name . random_int(10000, 99999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];
        \Views\Renderer::render("mnt/usuariorol", $viewData);
    }
}
