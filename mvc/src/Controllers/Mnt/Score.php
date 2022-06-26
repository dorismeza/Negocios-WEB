<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Validators;
use Dao\Mnt\Scores;


class Score extends PublicController
{
    private $viewData = array();
    private $arrEstados = array();
    private $arrModeDesc = array();

    public function run():void
    {
        // code
        $this->init();
        // Cuando es método GET (se llama desde la lista)
        if (!$this->isPostBack()) {
            $this->procesarGet();
        }
        // Cuando es método POST (click en el botón)
        if ($this->isPostBack()) {
            $this->procesarPost();
        }
        // Ejecutar Siempre
        $this->processView();
        Renderer::render('mnt/score', $this->viewData);
    }

    private function init()
    {
        $this->viewData = array();
        $this->viewData["mode"] = "";
        $this->viewData["mode_desc"] = "";
        $this->viewData["crsf_token"] = "";
        $this->viewData["scoreid"] = "";
        $this->viewData["scoredsc"] = "";
        $this->viewData["error_scoredsc"] = array();
        $this->viewData["scoreauthor"] = "";
        $this->viewData["error_scoreauthor"] = array();
        $this->viewData["scoregenre"] = "";
        $this->viewData["error_scoregenre"] = array();
        $this->viewData["scoreyear"] = "";
        $this->viewData["error_scoreyear"] = array();
        $this->viewData["scoresales"] = "";
        $this->viewData["error_scoresales"] = array();
        $this->viewData["scoreprice"] = "";
        $this->viewData["error_scoreprice"] = array();
        $this->viewData["scoredocurl"] = "";
        $this->viewData["error_scoredocurl"] = array();
        $this->viewData["scoreest"] = "";
        $this->viewData["scoreestArr"] = array();

        $this->viewData["btnEnviarText"] = "Guardar";
        $this->viewData["readonly"] = false;
        $this->viewData["showBtn"] = true;

        $this->arrModeDesc = array(
            "INS"=>"Nuevo Producto",
            "UPD"=>"Editando %s %s",
            "DSP"=>"Detalle de %s %s",
            "DEL"=>"Eliminado %s %s"
        );

        $this->arrEstados = array(
            array("value" => "ACT", "text" => "Activo"),
            array("value" => "INA", "text" => "Inactivo"),
        );

        $this->viewData["scoreestArr"] = $this->arrEstados;
    }

    private function procesarGet()
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if (!isset($this->arrModeDesc[$this->viewData["mode"]])) {
                error_log('Error: (Particion) Mode solicitado no existe.');
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=mnt_scores",
                    "No se puede procesar su solicitud!"
                );
            }
        }
        if ($this->viewData["mode"] !== "INS" && isset($_GET["id"])) {
            $this->viewData["scoreid"] = intval($_GET["id"]);
            $tmpParticion = Scores::getById($this->viewData["scoreid"]);
            error_log(json_encode($tmpParticion));
            \Utilities\ArrUtils::mergeFullArrayTo($tmpParticion, $this->viewData);
        }
    }
    private function procesarPost()
    {
        // Validar la entrada de Datos
        //  Todos valor puede y sera usando en contra del sistema
        $hasErrors = false;
        \Utilities\ArrUtils::mergeArrayTo($_POST, $this->viewData);
        if (isset($_SESSION[$this->name . "crsf_token"])
            && $_SESSION[$this->name . "crsf_token"] !== $this->viewData["crsf_token"]
        ) {
            \Utilities\Site::redirectToWithMsg(
                "index.php?page=mnt_scores",
                "ERROR: Algo inesperado sucedió con la petición Intente de nuevo."
            );
        }

        if (Validators::IsEmpty($this->viewData["scoredsc"])) {
            $this->viewData["error_scoredsc"][]
                = "La descripcion es requerida";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["scoreauthor"])) {
            $this->viewData["error_scoreauthor"][]
                = "El autor es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["scoregenre"])) {
            $this->viewData["error_scoregenre"][]
                = "El genero es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["scoreyear"])) {
            $this->viewData["error_scoreyear"][]
                = "El año es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["scoresales"])) {
            $this->viewData["error_scoresales"][]
                = "El numero de venta es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["scoreprice"])) {
            $this->viewData["error_scoreprice"][]
                = "El precio es requerido";
            $hasErrors = true;
        }
       
        error_log(json_encode($this->viewData));
        // Ahora procedemos con las modificaciones al registro
        if (!$hasErrors) {
            $result = null;
            switch($this->viewData["mode"]) {
            case 'INS':
                $result = Scores::insert(
                    $this->viewData["scoredsc"],
                    $this->viewData["scoreauthor"],
                    $this->viewData["scoregenre"],
                    $this->viewData["scoreyear"],
                    $this->viewData["scoresales"],
                    $this->viewData["scoreprice"],
                    null,
                    $this->viewData["scoreest"]
                );
                if ($result) {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt_scores",
                            "Particion Guardada Satisfactoriamente!"
                        );
                }
                break;
            case 'UPD':
                $result = Scores::update(
                    $this->viewData["scoredsc"],
                    $this->viewData["scoreauthor"],
                    $this->viewData["scoregenre"],
                    intval($this->viewData["scoreyear"]),
                    intval($this->viewData["scoresales"]),
                    intval($this->viewData["scoreprice"]),
                    null,
                    $this->viewData["scoreest"],
                    intval($this->viewData["scoreid"])
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=mnt_scores",
                        "Particion Actualizada Satisfactoriamente"
                    );
                }
                break;
            case 'DEL':
                $result = Scores::delete(
                    intval($this->viewData["scoreid"])
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=mnt_scores",
                        "Particion Eliminada Satisfactoriamente"
                    );
                }
                break;
            }
        }
    }

    private function processView()
    {
        if ($this->viewData["mode"] === "INS") {
            $this->viewData["mode_desc"]  = $this->arrModeDesc["INS"];
            $this->viewData["btnEnviarText"] = "Guardar Nuevo";
        } else {
            $this->viewData["mode_desc"]  = sprintf(
                $this->arrModeDesc[$this->viewData["mode"]],
                $this->viewData["scoredsc"],
                    $this->viewData["scoreauthor"],
                    $this->viewData["scoregenre"],
                    $this->viewData["scoreyear"],
                    $this->viewData["scoresales"],
                    $this->viewData["scoreprice"]
            );
            $this->viewData["scoreestArr"]
                = \Utilities\ArrUtils::objectArrToOptionsArray(
                    $this->arrEstados,
                    'value',
                    'text',
                    'value',
                    $this->viewData["scoreest"]
                );
            if ($this->viewData["mode"] === "DSP") {
                $this->viewData["readonly"] = true;
                $this->viewData["showBtn"] = false;
            }
            if ($this->viewData["mode"] === "DEL") {
                $this->viewData["readonly"] = true;
                $this->viewData["btnEnviarText"] = "Eliminar";
            }
            if ($this->viewData["mode"] === "UPD") {
                $this->viewData["btnEnviarText"] = "Actualizar";
            }
        }
        $this->viewData["crsf_token"] = md5(getdate()[0] . $this->name);
        $_SESSION[$this->name . "crsf_token"] = $this->viewData["crsf_token"];
    }
}
