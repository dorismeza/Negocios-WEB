<br /><br />
<h4>Buscar Producto</h4>
<h4>{{mode_desc}}</h4>
<br>
<section>
  <form action="" method="post">
    <div class="form-group">
      <fieldset>
        <label for="invPrdDsc">Descripcion</label>
        <input {{if readonly}} readonly {{endif readonly}} type="text" id="invPrdDsc" name="invPrdDsc" placeholder="Descripcion del producto" value="{{invPrdDsc}}" />
        {{if error_invPrdDsc}}
          {{foreach error_invPrdDsc}}
            <div class="error">{{this}}</div>
         {{endfor error_invPrdDsc}}
        {{endif error_invPrdDsc}}
      </fieldset>
      <br>
       <fieldset>
        <label for="minimo">Precio Minimo</label>
        <input {{if readonly}} readonly {{endif readonly}} min="1" type="number" id="minimo" name="minimo" placeholder="Precio Minimo" value="{{minimo}}" />
        {{if error_minimo}}
          {{foreach error_minimo}}
            <div class="error">{{this}}</div>
          {{endfor error_minimo}}
        {{endif error_minimo}}
      </fieldset>
      <br>
      <fieldset>
        <label for="maximo">Precio Maximo</label>
        <input {{if readonly}} readonly {{endif readonly}} min="1" type="number" id="maximo" name="maximo" placeholder="Precio maximo" value="{{maximo}}" />
        {{if error_maximo}}
         {{foreach error_maximo}}
           <div class="error">{{this}}</div>
          {{endfor error_maximo}}
        {{endif error_maximo}}
      </fieldset>
      <br/>
      <fieldset>
        <button class="btn btn-primary" type="submit" name="btnEnviar">{{btnEnviarText}}</button>
        &nbsp;
        <button class="btn btn-secondary" name="btnCancelar" id="btnCancelar">Cancelar</button>
      </fieldset>
    </div>
  </form>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('btnCancelar').addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      window.location.href = 'index.php?page=Mnt_Productos';
    });
  });
</script>