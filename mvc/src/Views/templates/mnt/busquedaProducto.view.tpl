<h1>{{mode_desc}}</h1>
<br><br><br><br><br>
<section>
  <form action="" method="post">
    <fieldset>
      <label for="invPrdDsc">Descripcion</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="invPrdDsc" name="invPrdDsc" placeholder="Código de Barra" value="{{invPrdDsc}}"/>
      {{if error_invPrdDsc}}
        {{foreach error_invPrdDsc}}
          <div class="error">{{this}}</div>
        {{endfor error_invPrdDsc}}
      {{endif error_invPrdDsc}}
    </fieldset> 
    <fieldset>
      <label for="maximo">Precio Maximo</label>
      <input {{if readonly}}readonly{{endif readonly}} type="number" id="maximo" name="maximo" placeholder="Precio" value="{{maximo}}"/>
      {{if error_maximo}}
        {{foreach error_maximo}}
          <div class="error">{{this}}</div>
        {{endfor error_maximo}}
      {{endif error_maximo}}
    </fieldset>  
       <fieldset>
      <label for="minimo">Precio Minimo</label>
      <input {{if readonly}}readonly{{endif readonly}} type="number" id="minimo" name="minimo" placeholder="Precio" value="{{minimo}}"/>
      {{if error_minimo}}
        {{foreach error_minimo}}
          <div class="error">{{this}}</div>
        {{endfor error_minimo}}
      {{endif error_minimo}}
    </fieldset>  
    <br><br>
        <fieldset>
        <button type="submit" name="btnEnviar">{{btnEnviarText}}</button>
        &nbsp;
      <button name="btnCancelar" id="btnCancelar">Cancelar</button>
    </fieldset>
  </form>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('btnCancelar').addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      window.location.href = 'index.php?page=Mnt_BusquedaProducto';
    });
  });
</script>