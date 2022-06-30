<br><br><br>
<h1>Catalogo de Productos</h1>
<section>

</section>
<section>
<button name="btnCancelar" id="btnCancelar">Regresar</button>
{{foreach Catalogo}}
<div class="card" style="width: 18rem;">
  <img src="https://cdn-icons-png.flaticon.com/512/1312/1312307.png" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">{{invPrdPrc}}</h5>
    <p class="card-text">{{invPrdDsc}}</p>
    <p  class="card-text">ID del producto: {{invPrdId}}</p>
  </div>
</div>
{{endfor Catalogo}}

</section>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('btnCancelar').addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      window.location.href = 'index.php?page=mnt_productos';
    });
  });
</script>
