<?php
namespace Controllers\NW202202;

use Controllers\PublicController;
use Views\Renderer;

class PrimerForm extends PublicController {
    public function run(): void
    {
        $viewData = array();
        $viewData["txtNombre"] = "Fulano";
        $viewData["txtApellido"] = "D'tal";
        if(isset($_POST["btnEnviar"])){
             $_POST["txtNombre"] = $_POST["nombre"];
        }
        if ($this->isPostBack()){// lo mismo que isset
            $viewData["txtApellido"] = $_POST["apellido"];
        }

        Renderer::render('nw202202/primerform',$viewData);
      //die("Hola"); 
    }
}

?>