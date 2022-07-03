<?php

namespace Controllers\Mnt;

use Controllers\PublicController;

class Usuario extends PublicController
{
    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_usuarios",
            "Ocurrió algo inesperado. Intente Nuevamente."
        );
    }
    private function yeah()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_usuarios",
            "Operación ejecutada Satisfactoriamente!"
        );
    }
    public function run(): void
    {
        $viewData = array(
            "mode_dsc" => "",
            "mode" => "",
            "usercod" => "",
            "useremail" => "",
            "username" => "",
            "userpswd" => "",
            "userfching" => "",
            "userpswdest_ACT" => "",
            "userpswdest_INA" => "",
            "userpswdest_PLN" => "",
            "userpswdexp" => "",
            "userest_ACT" => "",
            "userest_INA" => "",
            "userest_PLN" => "",
            "useractcod" => "",
            "userpswdchg" => "",
            "usertipo_ACT" => "",
            "usertipo_INA" => "",
            "usertipo_PLN" => "",
            "funciones" => array(),
            "editarUsuario" => true,
            "quirarRol" => false,
            "hasErrors" => false,
            "Errors" => array(),
            "showaction" => true,
            "readonly" => false
        );
        $modeDscArr = array(
            "INS" => "Nuevo Usuario",
            "UPD" => "Editando Usuario (%s) %s",
            "DEL" => "Eliminando Usuario (%s) %s",
            "DSP" => "Detalle del Usuario (%s) %s"
        );

        if ($this->isPostBack()) {
            // se ejecuta al dar click sobre guardar
            $viewData["mode"] = $_POST["mode"];
            $viewData["usercod"] = $_POST["usercod"];
            $viewData["useremail"] = $_POST["useremail"];
            $viewData["username"] = $_POST["username"];
            $viewData["userpswd"] = $_POST["userpswd"];
            $viewData["userfching"] = $_POST["userfching"];
            $viewData["userpswdest"] = $_POST["userpswdest"];
            $viewData["userpswdexp"] = $_POST["userpswdexp"];
            $viewData["userest"] = $_POST["userest"];
            $viewData["useractcod"] = $_POST["useractcod"];
            $viewData["userpswdchg"] = $_POST["userpswdchg"];
            $viewData["usertipo"] = $_POST["usertipo"];
            $viewData["xsrftoken"] = $_POST["xsrftoken"];
            // Validate XSRF Token
            if (!isset($_SESSION["xsrftoken"]) || $viewData["xsrftoken"] != $_SESSION["xsrftoken"]) {
                $this->nope();
            }
            // Validaciones de Errores
            if (\Utilities\Validators::IsEmpty($viewData["useremail"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El useremail no Puede Ir Vacio!";
            }
            if (\Utilities\Validators::IsEmpty($viewData["username"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El username no Puede Ir Vacio!";
            }
            if ($viewData["mode"] != "DEL" || $viewData["mode"] != "UPD") {
            if (\Utilities\Validators::IsEmpty($viewData["userpswd"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El userpswd no Puede Ir Vacio!";
            }
        }
            if (\Utilities\Validators::IsEmpty($viewData["userfching"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El userfching no Puede Ir Vacio!";
            }

            if ($viewData["mode"] == "INS" ) {

                if (!\Utilities\Validators::IsValidPassword($viewData["userpswd"])) {
                    $viewData["hasErrors"] = true;
                    $viewData["Errors"][] = "La contraseña debe tener al menos 8 caracteres una mayúscula, un número y un caracter especial.";
                }
            }


            /*if (($viewData["userpswdest"] == "INA"
                || $viewData["userpswdest"] == "ACT"
                || $viewData["userpswdest"] == "PLN"
                ) == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "userpswdest Incorrecto!";
            }*/

            if (\Utilities\Validators::IsEmpty($viewData["userpswdexp"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El userpswdexp no Puede Ir Vacio!";
            }

            /*if (($viewData["userest"] == "INA"
                || $viewData["userest"] == "ACT"
                || $viewData["userest"] == "PLN"
                ) == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "userest Incorrecto!";
            }*/

            if (\Utilities\Validators::IsEmpty($viewData["useractcod"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El useractcod no Puede Ir Vacio!";
            }
            if (\Utilities\Validators::IsEmpty($viewData["userpswdchg"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El userpswdchg no Puede Ir Vacio!";
            }


            /*if (($viewData["usertipo"] == "INA"
                || $viewData["usertipo"] == "ACT"
                || $viewData["usertipo"] == "PLN"
                ) == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "usertipo Incorrecto!";
            }*/


            if (!$viewData["hasErrors"]) {
                switch ($viewData["mode"]) {
                    case "INS":
                        if (\Dao\Mnt\Usuarios::crearUsuario(
                            $viewData["useremail"],
                            $viewData["username"],
                            \Dao\Mnt\Usuarios::_hashPassword($viewData["userpswd"]),
                            $viewData["userfching"],
                            $viewData["userpswdest"],
                            $viewData["userpswdexp"],
                            $viewData["userest"],
                            $viewData["useractcod"],
                            $viewData["userpswdchg"],
                            $viewData["usertipo"]
                        )) {
                            $this->yeah();
                        }
                        break;
                    case "UPD":
                        if (\Dao\Mnt\Usuarios::editarUsuario(
                            $viewData["useremail"],
                            $viewData["username"],             
                            $viewData["userfching"],
                            $viewData["userpswdest"],
                            $viewData["userpswdexp"],
                            $viewData["userest"],
                            $viewData["useractcod"],
                            $viewData["userpswdchg"],
                            $viewData["usertipo"],
                            intval($viewData["usercod"])
                        )) {
                            $this->yeah();
                        }
                        break;
                    case "DEL":
                        if (\Dao\Mnt\usuarioRoles::Eliminarusuariorol(intval($viewData["usercod"])) && \Dao\Mnt\Usuarios::eliminarUsuario(
                            intval($viewData["usercod"])
                        )) {
                            $this->yeah();
                        }
                        break;
                }
            }
        } else {
            // se ejecuta si se refresca o viene la peticion
            // desde la lista
            if (isset($_GET["mode"])) {
                if (!isset($modeDscArr[$_GET["mode"]])) {
                    $this->nope();
                }
                $viewData["mode"] = $_GET["mode"];
            } else {
                $this->nope();
            }
            if (isset($_GET["usercod"])) {
                $viewData["usercod"] = $_GET["usercod"];
            } else {


                if ($viewData["mode"] !== "INS") {
                    $this->nope();
                }
            }
        }

        // Hacer elementos en comun

        if ($viewData["mode"] == "INS") {
            $viewData["mode_dsc"]  = $modeDscArr["INS"];
            $viewData["editarUsuario"] = false;
        } else {
            $tmpUsuario = \Dao\Mnt\Usuarios::obtenerUsuario($viewData["usercod"]);


            $viewData["useremail"] = $tmpUsuario["useremail"];
            $viewData["username"] = $tmpUsuario["username"];
            $viewData["userpswd"] = $tmpUsuario["userpswd"];
            $viewData["userfching"] = $tmpUsuario["userfching"];
            $viewData["userpswdest_ACT"] = $tmpUsuario["userpswdest"] == "ACT" ? "selected" : "";
            $viewData["userpswdest_INA"] = $tmpUsuario["userpswdest"] == "INA" ? "selected" : "";
            $viewData["userpswdest_PLN"] = $tmpUsuario["userpswdest"] == "PLN" ? "selected" : "";
            $viewData["userpswdexp"] = $tmpUsuario["userpswdexp"];
            $viewData["userest_ACT"] = $tmpUsuario["userest"] == "ACT" ? "selected" : "";
            $viewData["userest_INA"] = $tmpUsuario["userest"] == "INA" ? "selected" : "";
            $viewData["userest_PLN"] = $tmpUsuario["userest"] == "PLN" ? "selected" : "";
            $viewData["useractcod"] = $tmpUsuario["useractcod"];
            $viewData["userpswdchg"] = $tmpUsuario["userpswdchg"];
            $viewData["usertipo_ACT"] = $tmpUsuario["usertipo"] == "ACT" ? "selected" : "";
            $viewData["usertipo_INA"] = $tmpUsuario["usertipo"] == "INA" ? "selected" : "";
            $viewData["usertipo_PLN"] = $tmpUsuario["usertipo"] == "PLN" ? "selected" : "";

            // Obteniendo funciones del rol.
            $viewData["funciones"] = \Dao\Mnt\usuarioRoles::obtenerRolesPorUsuario($viewData["usercod"]);
            $viewData["mode_dsc"]  = sprintf(
                $modeDscArr[$viewData["mode"]],
                $viewData["usercod"],
                $viewData["useremail"],
                $viewData["username"],
                $viewData["userpswd"],
                $viewData["userfching"],
                $viewData["userpswdexp"],
                $viewData["useractcod"],
                $viewData["userpswdchg"],
            );
            if ($viewData["mode"] == "DSP") {
                $viewData["showaction"] = true;
                $viewData["readonly"] = "readonly";
                $viewData["editarUsuario"] = true;
                $viewData["quitarRol"] = false;
            }
            if ($viewData["mode"] == "DEL") {
                $viewData["readonly"] = "readonly";
                $viewData["editarUsuario"] = false;
            }
            if ($viewData["mode"] == "DEL") $viewData["readonly"] = "readonly";
            if ($viewData["mode"] == "UPD"){
                $viewData["readonly1"] = "readonly";
                $viewData["editarFunciones"] = true;
            }
             
        }
        // Generar un token XSRF para evitar esos ataques
        $viewData["xsrftoken"] = md5($this->name . random_int(10000, 99999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];
        \Views\Renderer::render("mnt/usuario", $viewData);
    }
}
