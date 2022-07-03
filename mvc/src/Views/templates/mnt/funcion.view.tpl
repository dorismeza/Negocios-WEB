<h1>{{mode_dsc}}</h1>
<section>
  <form action="index.php?page=mnt_funcion&mode={{mode}}&fncod={{fncod}}"
    method="POST" >
    <section>
    <label for="fncod">Código</label>
    <input type="hidden" id="fncod" name="fncod" value="{{fncod}}"/>
    <input type="text" {{readonly}}{{readonly1}} name="fncod" placeholder="Escriba el codigo" value="{{fncod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}" />
    <input type="hidden" id="xsrftoken" name="xsrftoken" value="{{xsrftoken}}" />
    </section>

    <section>
      <label for="fndsc">Funcion</label>
      <input type="text" {{readonly}} name="fndsc" value="{{fndsc}}" maxlength="45" placeholder="Nombre de Funcion"/>
    </section>

    <section>
      <label for="fnest">Estado</label>
      {{if readonly}}
       <input type="hidden" id="fnestdummy" name="fnest" value="" {{readonly}}/>
      {{endif readonly}}
      <select id="fnest" name="fnest" >
        <option value="ACT" {{fnest_ACT}}>Activo</option>
        <option value="INA" {{fnest_INA}}>Inactivo</option>
        <option value="PLN" {{fnest_PLN}}>Planificación</option>
      </select>
    </section>

    <section>
      <label for="fntyp">Tipo</label>
      {{if readonly}}
       <input type="hidden" id="fntypdummy" name="fntyp" value="" />
      {{endif readonly}}
      <select id="fntyp" name="fntyp" {{readonly}}>
        <option value="ACT" {{fntyp_ACT}}>Activo</option>
        <option value="INA" {{fntyp_INA}}>Inactivo</option>
        <option value="PLN" {{fntyp_PLN}}>Planificación</option>
      </select>
    </section>

    {{if hasErrors}}
        <section>
          <ul>
            {{foreach aErrors}}
                <li>{{this}}</li>
            {{endfor aErrors}}
          </ul>
        </section>
    {{endif hasErrors}}
    
    <section>
      {{if showaction}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif showaction}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_funciones");
      });
  });
</script>