<style>
  h2 {
    margin-bottom: 0 !important;
  }
  a {
      text-decoration: none !important;
  }
  .funciones {
    display: flex;
    flex-flow: row nowrap;
  }
  .fnitems {
    display: flex;
    position: relative;
    flex-flow: row nowrap;
    background: #f0f0f0;
    border: 1px solid #333;
    margin: .3125em;
    padding: .3125em;
    cursor: pointer;
    border-radius: .3125em;
    box-shadow: 3px 10px 1rem 1px rgba(0, 0, 0, 0.1);
  }

  .delete-funcion {
      background-color: #000;
      border-radius: 50%;
      height: 1em;
      width: 1em;
      padding: .625em;
      position: absolute;
      right: -4px;
      top: -4px;
      color: white;
      display: flex;
      align-items: center;
      transform: scale(0);
      transition: all .2s cubic-bezier(0.65, 0.05, 0.36, 1);
  }

  .fnitems:hover > .delete-funcion {
      transform: scale(1);
  }

  span {
      transform: translateX(-5px);
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
<h2>Agregar funciones al rol: {{rolesdsc}}</h2>
<section>
    <select name="" id="redirectSelect">
        <option value="#">Seleccionar...</option>
        {{foreach nonFunciones}}
            <option value="index.php?page=mnt_funcionrol&mode=INS&rolescod={{~rolescod}}&fncod={{fncod}}">{{fndsc}}</option>
        {{endfor nonFunciones}}
    </select>
</section>
<hr>
<h2>Funciones incluidas en el rol: {{rolesdsc}}</h2>
<section class="funciones">
{{foreach funciones}}
    <div class="fnitems">
        <a title="Eliminar función {{fndsc}} del rol {{~rolesdsc}}" class="delete-funcion" href="index.php?page=mnt_funcionrol&mode=DEL&rolescod={{~rolescod}}&fncod={{fncod}}"><span>X</span></a>
        <p>{{fndsc}}</p>
    </div>
{{endfor funciones}}
</section>
<button onclick="volverAtras('{{rolescod}}')">Volver atrás</button>

<script>
    function redirect(goto){
    if (goto.trim() != '') {
        window.location = goto;
    }
}

var selectEl = document.getElementById('redirectSelect');

selectEl.onchange = function(){
    var goto = this.value;
    redirect(goto);

};

let volverAtras = site => {
    window.location.assign(`index.php?page=mnt_rol&mode=DSP&rolescod=${site}`);
}
</script>