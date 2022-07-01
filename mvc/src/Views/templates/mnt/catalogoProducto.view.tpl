<br /><br />
<button class="btn btn-primary" name="btnCancelar" id="btnCancelar">Regresar</button>
<br />
<h4 style="text-align: center;">Catalogo de Productos</h4>
<div class="m-4">
  <div class="card-group">
    
    {{foreach Catalogo}}
    <div class="card text-white bg-secondary mb-3" style="max-width: 10rem">
      <img src="https://cdn-icons-png.flaticon.com/512/1312/1312307.png" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">Precio:&nbsp; {{invPrdPrc}}</h5>
        <p class="card-text">{{invPrdDsc}}</p>
        <p class="card-text">Codigo: {{invPrdId}}</p>
      </div>
    </div>
     &nbsp; &nbsp;&nbsp;
    {{endfor Catalogo}}
  </div>
  
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btnCancelar').addEventListener('click', function (e) {
      e.preventDefault(); e.stopPropagation(); window.location.href =
        'index.php?page=mnt_productos';
    });
  });
</script>