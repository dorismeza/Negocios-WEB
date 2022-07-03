<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Funcion extends PublicController
{
    private function nope($linea)
    {
        \Utilities\Site::redirectTowithMsg(
            "index.php?page=mnt_funciones",
            "Ocurrió algo inesperado en la línea $linea, Intente de nuevo."
        );
    }

    private function yeah()
    {
        \Utilities\Site::redirectTowithMsg(
            "index.php?page=mnt_funciones",
            "¡Operación realizada exitosamente!"
        );
    }

    public function run(): void
    {
        $viewData = array(
            "mode_dsc" => "",
            "mode" => "",
            "fncod" => "",
            "fndsc" => "",
            "fnest_ACT" => "",
            "fnest_INA" => "",
            "fnest_PLN" => "",
            "fntyp" => "",
            "fntyp_ACT" => "",
            "fntyp_INA" => "",
            "fntyp_PLN" => "",
            "funciones" => array(),
            "quitarFuncion" => true,
            "editarFunciones" => false,
            "hasErrors" => false,
            "Errors" => array(),
            "showaction" => true,
            "readonly" => false
        );
        $modeDscArray = array(
            "INS" => "Nueva funcion",
            "UPD" => "Editando funcion (%s) %s",
            "DEL" => "Eliminando funcion (%s) %s",
            "DSP" => "Detalle de la funcion",
        );

        if ($this->isPostBack()) {
            
            $viewData["mode"] = $_POST["mode"];
            $viewData["fncod"] = $_POST["fncod"];
            $viewData["fndsc"] = $_POST["fndsc"];
            $viewData["fnest"] = $_POST["fnest"];
            $viewData["fntyp"] = $_POST["fntyp"];
            $viewData["xsrftoken"] = $_POST["xsrftoken"];

            if (!isset($_SESSION["xsrftoken"]) || $viewData["xsrftoken"] != $_SESSION["xsrftoken"]) {
                dd($viewData);
                $this->nope("63");
            }
            if (\Utilities\Validators::IsEmpty($viewData["fndsc"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El nombre de la funcion no puede ir vacio!";
            }
            if (($viewData["fnest"] == "INA" ||
                    $viewData["fnest"] == "ACT" ||
                    $viewData["fnest"] == "PLN") == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "Estado de la funcion es incorrecto";
            }

            if (($viewData["fntyp"] == "INA" ||
                    $viewData["fntyp"] == "ACT" ||
                    $viewData["fntyp"] == "PLN") == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "Tipo de la funcion es incorrecto";
            }
           
            if (!$viewData["hasErrors"]) {
                switch ($viewData["mode"]) {
                    case "INS":
                        if (\Dao\Mnt\Funciones::insertarFuncion(
                            $viewData["fncod"],
                            $viewData["fndsc"],
                            $viewData["fnest"],
                            $viewData["fntyp"]
                        )) {
                            $this->yeah();
                        }
                        break;
                    case "UPD":
                        if (\Dao\Mnt\Funciones::actualizarFuncion(
                            $viewData["fncod"],
                            $viewData["fndsc"],
                            $viewData["fnest"],
                            $viewData["fntyp"]
                        )) {
                            $this->yeah();
                        }
                        break;
                    case "DEL":
                        if (\Dao\Mnt\Funciones::eliminarFuncione($viewData["fncod"])) {
                            $this->yeah();
                        }
                        break;
                    default:
                        $this->nope("114");
                }
            }
        } else {
            if (isset($_GET["mode"])) {
                if (!isset($modeDscArray[$_GET["mode"]])) $this->nope("119");
                $viewData["mode"] = $_GET["mode"];
            } else $this->nope("121");
            if (isset($_GET["fncod"])) $viewData["fncod"] = $_GET["fncod"];
            else {
                if ($viewData["mode"] !== "INS") $this->nope("124");
            }
        }

        if ($viewData["mode"] == "INS") {
            $viewData["mode_dsc"] = $modeDscArray["INS"];
            $viewData["fncod"] ="";
            
        } else {
            $tmpFuncion = \Dao\Mnt\Funciones::obtenerFuncion($viewData["fncod"]);
            $viewData["fndsc"] = $tmpFuncion["fndsc"];
            $viewData["fnest_ACT"] = $tmpFuncion["fnest"] == "ACT" ? "selected" : "";
            $viewData["fnest_INA"] = $tmpFuncion["fnest"] == "INA" ? "selected" : "";
            $viewData["fnest_PLN"] = $tmpFuncion["fnest"] == "PLN" ? "selected" : "";

            $viewData["fntyp_ACT"] = $tmpFuncion["fntyp"] == "ACT" ? "selected" : "";
            $viewData["fntyp_INA"] = $tmpFuncion["fntyp"] == "INA" ? "selected" : "";
            $viewData["fntyp_PLN"] = $tmpFuncion["fntyp"] == "PLN" ? "selected" : "";

            $viewData["mode_dsc"] = sprintf(
                $modeDscArray[$viewData["mode"]],
                $viewData["fncod"],
                $viewData["fndsc"]
            );
            if ($viewData["mode"] == "DSP") {
                $viewData["showaction"] = false;
                $viewData["readonly"] = "readonly";
                $viewData["quitarFuncion"] = false;
                $viewData["editarFuncion"] = true;
            }
            if ($viewData["mode"] == "DEL") $viewData["readonly"] = "readonly";
            if ($viewData["mode"] == "UPD") $viewData["readonly1"] = "readonly";
        }
        $viewData["xsrftoken"] = md5($this->name . random_int(10000, 99999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];
        Renderer::render("mnt/funcion", $viewData);
    }
}
