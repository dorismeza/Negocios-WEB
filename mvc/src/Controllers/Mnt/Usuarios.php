<?php

namespace Controllers\Mnt;

use Controllers\PrivateController;
use Views\Renderer;


class Usuarios extends PrivateController
{
    public function run() :void 
    {
        $viewData = array();
        $viewData["items"] = \Dao\Mnt\Usuarios::obtenerUsuarios();
        $viewData["new_enabled"] = self::isFeatureAutorized("Controllers\Mnt\Usuarios\New");
        $viewData["edit_enabled"] = self::isFeatureAutorized("Controllers\Mnt\Usuarios\Edit");
        $viewData["delete_enabled"] = self::isFeatureAutorized("Controllers\Mnt\Usuarios\Delete");
        Renderer::render("mnt/usuarios", $viewData);
    }
}



/*
{

    Usuarios: [],
    CanInsert: true,
    CanUpdate: true,
    CanDelete: true,
    CanView: true
}

withContext =
root =
{
    Usuarios: [],
    CanInsert: true,
    CanUpdate: true,
    CanDelete: true,
    CanView: true
}

foreach Usuarios
    withContext = Usuarios
    
    root =
        {
            Usuarios: [],
            CanInsert: true,
            CanUpdate: true,
            CanDelete: true,
            CanView: true
        }
endfor Usuarios
*/

?>
