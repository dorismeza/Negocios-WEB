<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Validators;
use Dao\Mnt\Productos;

class BusquedaProducto extends PublicController
{
    private $viewData = array();


    public function run(): void
    {
        // code
        $this->init();
        
        
        // Cuando es método POST (click en el botón)
        if ($this->isPostBack()) {
            $this->procesarPost();
        }
        // Ejecutar Siempre
        //$this->processView();
        Renderer::render('mnt/busquedaProducto', $this->viewData);
    }

    private function init()
    {
        $this->viewData = array();

        $this->viewData["maximo"] = "";
        $this->viewData["minimo"] = "";
        $this->viewData["error_maximo"] = array();
        $this->viewData["error_minimo"] = array();
        $this->viewData["invPrdDsc"] = "";
        $this->viewData["error_invPrdDsc"] = array();
        $this->viewData["btnEnviarText"] = "Buscar";

    }

    private function procesarPost()
    {
        // Validar la entrada de Datos
        //  Todos valor puede y sera usando en contra del sistema
        $hasErrors = false;
        \Utilities\ArrUtils::mergeArrayTo($_POST, $this->viewData);
        if (
            isset($_SESSION[$this->name . "crsf_token"])
            && $_SESSION[$this->name . "crsf_token"] !== $this->viewData["crsf_token"]
        ) {
            \Utilities\Site::redirectToWithMsg(
                "index.php?page=mnt_productos",
                "ERROR: Algo inesperado sucedió con la petición Intente de nuevo."
            );
        }

        if (Validators::IsEmpty($this->viewData["invPrdDsc"] || $this->viewData["maximo"] && $this->viewData["minimo"])) {
            $this->viewData["error_invPrdDsc"][]
                = "Campo requerido";
             $hasErrors = true;
            $this->viewData["error_minimo"][]
                = "Campo requerido";
            $hasErrors = true;
            $this->viewData["error_maximo"][]
                = "Campo requerido";
             $hasErrors = true;
        }
        error_log(json_encode($this->viewData));
        // Ahora procedemos con las modificaciones al registro



        if (!$hasErrors) {
            $result = array();
            //descripcion
            if (Validators::IsEmpty($this->viewData["invPrdDsc"])) {
                $result["Catalogo"] = Productos::getByprice(
                    intval($this->viewData["maximo"]),
                    intval($this->viewData["minimo"])
                );
                Renderer::render('mnt/catalogoProducto', $result);

            } else if (Validators::IsEmpty($this->viewData["maximo"] && $this->viewData["minimo"])) {
                $result["Catalogo"] = Productos::getByDesc(
                    $this->viewData["invPrdDsc"]
                );
                Renderer::render('mnt/catalogoProducto', $result);
            
            } else {

                $result["Catalogo"] = Productos::getBypriceandDesc(
                    $this->viewData["invPrdDsc"],
                    intval($this->viewData["maximo"]),
                    intval($this->viewData["minimo"])
                );
                Renderer::render('mnt/catalogoProducto', $result);
            }
           
           if (!$result["Catalogo"]) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=Mnt_BusquedaProducto",
                        "Producto no Encontrado"
                    );
                }
    
        }
    }
}