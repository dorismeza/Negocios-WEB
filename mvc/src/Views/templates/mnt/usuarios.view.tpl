<style>
  td{
    text-align: center;
  }

  .crud{
    display: flex;
    width: 150px;
  }

  .editar{
    margin-right: 10px;
  }
  h1{
    text-align: center;
  }
  .crud{
    width: 100%;
  }

  button{
    width: 100%;
  }

  .edit{
    margin-bottom: 5px;
  }
</style>
<h1>Gestión de Usuarios</h1>
<section class="WWFilter">

</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Codigo Usuario</th>
        <th>Correo Electronico</th>
        <th>Nombre de Usuario</th>   
        <th>Fecha Creacion</th>
        <th>userpswdest</th>
        <th>Fecha de Expiracion</th>
        <th>Estado del Usuario</th>
        <th>userpswdchg</th>
        <th>Tipo de Usuario</th>
        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach items}}
      <tr>
        <td>{{usercod}}</td>
        <td><a href="index.php?page=mnt_usuario&mode=DSP&usercod={{usercod}}">{{useremail}}</a></td>
        <td>{{username}}</td>
        
        <td>{{userfching}}</td>
        <td>{{userpswdest}}</td>
        <td>{{userpswdexp}}</td>
        <td>{{userest}}</td>
        
        <td>{{userpswdchg}}</td>
        <td>{{usertipo}}</td>
        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
            <div class="crud">
              <input type="hidden" name="page" value="mnt_usuario"/>
              <input type="hidden" name="mode" value="UPD" />
              
              <input type="hidden" name="usercod" value={{usercod}} />
              <button type="submit" class="edit">Editar</button>
            </div>
          </form>
          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
            <div class="crud">
                <input type="hidden" name="page" value="mnt_usuario"/>
                <input type="hidden" name="mode" value="DEL" />
                <input type="hidden" name="usercod" value={{usercod}} />
                <button type="submit" class="delete">Eliminar</button>
            </div>
             
          </form>
          {{endif ~delete_enabled}}
        </td>
      </tr>
      {{endfor items}}
    </tbody>
  </table>
</section>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_usuario&mode=INS&usercod=0");
      });
    });
</script>
