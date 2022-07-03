<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class FuncionRol extends PublicController
{
    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_roles",
            "Ocurrió algo inesperado. Intente nuevamente."
        );
    }

    private function yeah($rolescod)
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_funcionrol&mode=DSP&rolescod=$rolescod",
            "¡Operación ejecutada satisfactoriamente!"
        );
    }

    public function run(): void
    {
        $viewData = array(
            "mode" => "",
            "rolescod" => "",
            "rolesdsc" => "",
            "fncod" => "",
            "funciones" => array(),
            "nonFunciones" => array()
        );
        if ($this->isPostBack()) {
            $viewData["mode"] = $_POST["mode"];
            $viewData["rolescod"] = $_POST["rolescod"];
            switch ($viewData["mode"]) {
                case "INS":
                    
                    dd($viewData);
                    break;
                default:
                    $this->yeah($viewData["rolescod"]);
            }
        } else {
            if (isset($_GET["mode"])) {
                $viewData["mode"] = $_GET["mode"];
            } else $this->nope();
            if (isset($_GET["rolescod"])) $viewData["rolescod"] = $_GET["rolescod"];
            else if ($viewData["mode"] !== "INS") $this->nope();
        }
        if (isset($viewData["mode"])) {
            
            $tmpRol = \Dao\Mnt\FuncionesRoles::obtenerFuncionesPorRol($viewData["rolescod"]);
            $counter = 0;
            
            foreach ($tmpRol as $rol) {
                $viewData["rolesdsc"] = $rol["rolesdsc"];
                $viewData["funciones"][$counter]["fncod"] = $rol["fncod"];
                $viewData["funciones"][$counter]["fndsc"] = $rol["fndsc"];
                $viewData["funciones"][$counter]["fnest"] = $rol["fnest"];
                $viewData["funciones"][$counter]["fnrolest"] = $rol["fnrolest"];
                $viewData["funciones"][$counter]["fnexp"] = $rol["fnexp"];
                $counter++;
            }
            
            $tmpNonFunciones = \Dao\Mnt\FuncionesRoles::obtenerNonFunciones($viewData["rolescod"]);
            foreach ($tmpNonFunciones as $nonFunciones) {
                $viewData["nonFunciones"][$counter]["fncod"] = $nonFunciones["fncod"];
                $viewData["nonFunciones"][$counter]["fndsc"] = $nonFunciones["fndsc"];
                $counter++;
            }
            

            
            switch ($viewData["mode"]) {
                case "INS":
                    $viewData["fncod"] = $_GET["fncod"];
                    
                    if (\Dao\Mnt\FuncionesRoles::insertarFuncionRol(
                        $viewData["rolescod"],
                        $viewData["fncod"]
                    )) $this->yeah($viewData["rolescod"]);
                    break;
                case "DEL":
                    $viewData["fncod"] = $_GET["fncod"];
                    if (\Dao\Mnt\FuncionesRoles::eliminarFuncionRol($viewData["fncod"]))
                        $this->yeah($viewData["rolescod"]);
                    break;
            }
        }
        $viewData["xsrftoken"] = md5($this->name . random_int(10000, 99999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];
        \Views\Renderer::render("mnt/funcionrol", $viewData);
    }
}
