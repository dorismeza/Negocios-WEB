<?php

namespace Controllers\Mnt;

use Controllers\PrivateController;
use Controllers\PublicController;
use Views\Renderer;

class Rol extends PrivateController
{
    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_roles",
            "Ocurrió algo inesperado. Intente nuevamente."
        );
    }

    private function yeah()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_roles",
            "¡Operación ejecutada satisfactoriamente!"
        );
    }

    public function run(): void
    {
        $viewData = array(
            "mode_dsc" => "",
            "mode" => "",
            "rolescod" => "",
            "rolesdsc" => "",
            "rolesest_ACT" => "",
            "rolesest_INA" => "",
            "rolesest_PLN" => "",
            "funciones" => array(),
            "quitarFuncion" => true,
            "editarFunciones" => false,
            "hasErrors" => false,
            "Errors" => array(),
            "showaction" => true,
            "readonly" => false
        );
        $modeDscArray = array(
            "INS" => "Nuevo rol",
            "UPD" => "Editando el rol (%s) %s",
            "DEL" => "Eliminando rol (%s) %s",
            "DSP" => "Detalle del rol",
        );
        if ($this->isPostBack()) {
            $viewData["mode"] = $_POST["mode"];
            $viewData["rolescod"] = $_POST["rolescod"];
            $viewData["rolesdsc"] = $_POST["rolesdsc"];
            $viewData["rolesest"] = $_POST["rolesest"];
            $viewData["xsrftoken"] = $_POST["xsrftoken"];
            // Validar el XSRFTOKEN.
            if (!isset($_SESSION["xsrftoken"]) || $viewData["xsrftoken"] != $_SESSION["xsrftoken"]) {
                $this->nope();
            }
            // Validaciones de errores.
            if (\Utilities\Validators::IsEmpty($viewData["rolesdsc"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "¡El nombre del rol no puede ir vacio!";
            }
            if (($viewData["rolesest"] == "INA" ||
                    $viewData["rolesest"] == "ACT" ||
                    $viewData["rolesest"] == "PLN") == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "Estado de la categoría es incorrecto";
            }
            // Si no existe ningun error proceder a hacer lo siguiente.
            if (!$viewData["hasErrors"]) {
                switch ($viewData["mode"]) {
                    case "INS":
                        if (\Dao\Mnt\Roles::insertarRol(
                            \Dao\Mnt\Roles::GUID(),
                            $viewData["rolesdsc"],
                            $viewData["rolesest"]
                        )) {
                            $this->yeah();
                        }
                        break;
                    case "UPD":
                        // dd($viewData);
                        if (\Dao\Mnt\Roles::actualizarRol(
                            $viewData["rolescod"],
                            $viewData["rolesdsc"],
                            $viewData["rolesest"]
                        )) {
                            $this->yeah();
                        }
                        break;
                    case "DEL":
                        // dd($viewData["rolescod"]);
                        if (\Dao\Mnt\Roles::eliminarRol($viewData["rolescod"])) {
                            $this->yeah();
                        }
                        break;
                    default:
                        $this->nope();
                }
            }
        } else {
            // Se ejecuta si se refresca o viene la peticion desde la lista.
            if (isset($_GET["mode"])) {
                if (!isset($modeDscArray[$_GET["mode"]])) $this->nope();
                $viewData["mode"] = $_GET["mode"];
            } else $this->nope();
            if (isset($_GET["rolescod"])) $viewData["rolescod"] = $_GET["rolescod"];
            else {
                if ($viewData["mode"] !== "INS") $this->nope();
            }
        }

        // Hacer elementos en común.
        if ($viewData["mode"] == "INS") {
            $viewData["mode_dsc"] = $modeDscArray["INS"];
        } else {
            // Obteniendo todos los roles.
            $tmpRol = \Dao\Mnt\Roles::obtenerRol($viewData["rolescod"]);
            $viewData["rolesdsc"] = $tmpRol["rolesdsc"];
            $viewData["rolesest_ACT"] = $tmpRol["rolesest"] == "ACT" ? "selected" : "";
            $viewData["rolesest_INA"] = $tmpRol["rolesest"] == "INA" ? "selected" : "";
            $viewData["rolesest_PLN"] = $tmpRol["rolesest"] == "PLN" ? "selected" : "";
            // Obteniendo funciones del rol.
            $viewData["funciones"] = \Dao\Mnt\FuncionesRoles::obtenerFuncionesPorRol($viewData["rolescod"]);
            // dd($viewData["funciones"]);
            // dd($tmpFunciones);
            $viewData["mode_dsc"] = sprintf(
                // Descripción del título de la acción a realizarse.
                $modeDscArray[$viewData["mode"]],
                $viewData["rolescod"],
                $viewData["rolesdsc"]
            );
            if ($viewData["mode"] == "DSP") {
                $viewData["showaction"] = false;
                $viewData["readonly"] = "readonly";
                $viewData["quitarFuncion"] = false;
                $viewData["editarFunciones"] = true;
            }
            if ($viewData["mode"] == "DEL") $viewData["readonly"] = "readonly";
            if ($viewData["mode"] == "UPD") $viewData["editarFunciones"] = true;
        }
        // Generando un token para evitar ataques XSRF.
        $viewData["xsrftoken"] = md5($this->name . random_int(10000, 99999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];
        Renderer::render("mnt/rol", $viewData);
    }
}
