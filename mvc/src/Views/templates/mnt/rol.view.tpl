<style>
  h2 {
    margin-bottom: 0 !important;
  }
  .funciones {
    display: flex;
    flex-flow: row nowrap;
  }
  .fnitems {
    display: flex;
    flex-flow: row nowrap;
    background: #f0f0f0;
    border: 1px solid #333;
    margin: .3125em;
    padding: .3125em;
    cursor: pointer;
    border-radius: .3125em;
    overflow: hidden;
    box-shadow: 3px 10px 1rem 1px rgba(0, 0, 0, 0.1);
  }

  button {
    border: none !important;
  }

  .btn-remove-funcion {
    height: 100% !important;
    border-radius: .3125em !important;
    margin-left: .3125em;
    background-color: hsla(0, 60%, 40%, 1);
  }
</style>
<h1>{{mode_dsc}}</h1>
<section>
  <form action="index.php?page=mnt_rol&mode={{mode}}&rolescod={{rolescod}}"
    method="POST" >
    <section>
    <label for="rolescod">Código</label>
    <input type="hidden" id="rolescod" name="rolescod" value="{{rolescod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}" />
    <input type="hidden" id="xsrftoken" name="xsrftoken" value="{{xsrftoken}}" />
    <input type="text"  {{readonly}} {{readonly1}} name="rolescod"placeholder="escriba el codigo" value="{{rolescod}}"/>
    </section>
    <section>
      <label for="rolesdsc">Roles</label>
      <input type="text"  {{readonly1}} name="rolesdsc" value="{{rolesdsc}}" maxlength="45" placeholder="Nombre de Categoría"/>
    </section>
    <section>
      <label for="rolesest">Estado</label>
      {{if readonly}}
       <input type="hidden" id="rolesestdummy" name="rolesest" value="" />
      {{endif readonly}}
      <select id="rolesest" name="rolesest" {{readonly1}}>
        <option value="ACT" {{rolesest_ACT}}>Activo</option>
        <option value="INA" {{rolesest_INA}}>Inactivo</option>
        <option value="PLN" {{rolesest_PLN}}>Planificación</option>
      </select>
    </section>
    {{if hasErrors}}
        <section>
          <ul>
            {{foreach Errors}}
                <li>{{this}}</li>
            {{endfor Errors}}
          </ul>
        </section>
    {{endif hasErrors}}
    
    <div class="funciones-title">
      <h2>Funciones del rol</h2>
      {{if editarFunciones}}
        <a href="index.php?page=mnt_funcionrol&mode={{mode}}&rolescod={{rolescod}}">Editar</a>
      {{endif editarFunciones}}
    

    </div>

    <section class="funciones">
    {{foreach funciones}}
        <div class="fnitems">
          <p>{{fndsc}}</p>
        </div>
    {{endfor funciones}}
    </section>


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
        window.location.assign("index.php?page=mnt_roles");
      });
  });
</script>
