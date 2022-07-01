<style>
    label{
        padding-right: 50px;
        padding-bottom: 500px;
    }
    section{
        padding-right: 15px;
        padding-bottom: 25px;
        
    }
    .grid{
        
        display: grid;
        grid-template-columns: repeat(3,auto);
    }
    .centro{
        width: 1100px;
        display: block;
        margin: auto;
    }
    input[type="text"],
    input[type="date"],input[type="password"],select{
        width: 300px;
        margin-top: 10px;
        
    }
    button{
        margin-right: 15px;
    }
</style>

<section class="centro">
    <h1>{{mode_dsc}}</h1>
  <form action="index.php?page=mnt_usuario&mode={{mode}}&usercod={{usercod}}"
    method="POST" >
    <div class="grid">
        <section>
    <label for="usercod">Código Usuario</label>
    <input type="hidden" id="usercod" name="usercod" value="{{usercod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}" />
    <input type="hidden" id="xsrftoken" name="xsrftoken" value="{{xsrftoken}}" />
    <input type="text" readonly name="usercoddummy" value="{{usercod}}"/>
    </section>
    <section>
      <label for="useremail">Usuario Email</label>
      <input type="text" {{readonly}} name="useremail" value="{{useremail}}" maxlength="450" placeholder="Direccion de Correo"/>
    </section>
    <section>
      <label for="username">Usuario nombre</label>
      <input type="text" {{readonly}} name="username" value="{{username}}" maxlength="450" placeholder="Nombre de Usuario"/>
    </section>
    <section>
      <label for="userpswd">Usuario password</label>
      <input type="password" {{readonly}} name="userpswd" value="{{userpswd}}" maxlength="450" placeholder="Contraseña"/>
    </section>
    <section>
      <label for="userfching">Usuario fecha</label>
      <input type="date" {{readonly}} name="userfching" value="{{userfching}}" maxlength="450" placeholder="Fecha"/>
    </section>
    <section>
      <label for="userpswdest">userpswdest</label>
      {{if readonly}}
       <input type="hidden" id="userpswdestdummy" name="userpswdest" value="" />
      {{endif readonly}}
      <select id="userpswdest" name="userpswdest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{userpswdest_ACT}}>Activo</option>
        <option value="INA" {{userpswdest_INA}}>Inactivo</option>
        <option value="PLN" {{userpswdest_PLN}}>Planificación</option>
      </select>
    </section>
    <section>
      <label for="userpswdexp">Usuario password expiracion</label>
      <input type="date" {{readonly}} name="userpswdexp" value="{{userpswdexp}}" maxlength="450" placeholder="Fecha"/>
    </section>
    <section>
      <label for="userest">userest</label>
      {{if readonly}}
       <input type="hidden" id="userestdummy" name="userest" value="userest" />
      {{endif readonly}}
      <select id="userest" name="userest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{userest_ACT}}>Activo</option>
        <option value="INA" {{userest_INA}}>Inactivo</option>
        <option value="PLN" {{userest_PLN}}>Planificación</option>
      </select>
    </section>
    <section>
      <label for="useractcod">useractcod</label>
      <input type="text" {{readonly}} name="useractcod" value="{{useractcod}}" maxlength="450" placeholder="useractcod"/>
    </section>
    <section>
      <label for="userpswdchg">userpswdchg</label>
      <input type="text" {{readonly}} name="userpswdchg" value="{{userpswdchg}}" maxlength="450" placeholder="userpswdchg"/>
    </section>
    <section>
      <label for="usertipo">usertipo</label>
      {{if readonly}}
       <input type="hidden" id="usertipodummy" name="usertipo" value="" />
      {{endif readonly}}
      <select id="usertipo" name="usertipo" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{usertipo_ACT}}>Activo</option>
        <option value="INA" {{usertipo_INA}}>Inactivo</option>
        <option value="PLN" {{usertipo_PLN}}>Planificación</option>
      </select>
    </section>
    </div>
    
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
      
      {{if editarUsuario}}
        <h2>Roles Usuario</h2>
        <a href="index.php?page=mnt_usuariorol&mode={{mode}}&usercod={{usercod}}">Editar Rol</a>
      {{endif editarUsuario}}
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
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnCancelar").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_usuarios");
      });
    });
</script>