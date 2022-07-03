<?php

namespace Controllers\Mnt;

use Controllers\PrivateController;
use Views\Renderer;

class Funciones extends PrivateController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["items"] = \Dao\Mnt\Funciones::obtenerFunciones();
        $viewData["new_enabled"] = true;
        $viewData["edit_enabled"] = true;
        $viewData["delete_enabled"] = true;
        Renderer::render("mnt/funciones", $viewData);
    }
}
