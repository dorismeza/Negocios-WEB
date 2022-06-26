<h1>Este es mi primer form</h1>

<form action="index.php?page=NW202202_PrimerForm" method="post">
    <fieldset>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{txtNombre}}">
    </fieldset>
    <fieldset>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="{{txtApellido}}">
    </fieldset>
    <fieldset>
        <button type="submit" name="btnEnviar">Enviar</button>
    </fieldset>
</form>