  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div id="addProductModal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <form id="new_product_file" autocomplete="off" method="post" enctype="multipart/form-data"
                  class="was-validated">
                  {{ csrf_field() }}
                  <div class="modal-header">
                      <h4 class="modal-title">Crear nuevo producto</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <label>Referencia</label>
                          <input type="text" id="referencia" name="referencia" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Nombre producto</label>
                          <input type="text" id="nombre_de_producto" name="nombre_de_producto" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Observaciones</label>
                          <input type="text" id="observaciones" name="observaciones" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Precio</label>
                          <input type="number" step="any" min="0" name="precio"  id="precio"
                              class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Impuesto</label>
                          <input type="number" step="any" min="0" max="20" id="impuesto" name="impuesto"
                              class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Cantidad</label>
                          <input type="number" step="any" min="0"  id="cantidad" name="cantidad"
                              class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Imagen</label>
                          <input id="imagen" accept="image/jpeg" type="file" class="form-control" name="imagen" required>
                      </div>
                      <div class="form-group">
                          <label>Estado</label>
                          <select id="estado" class="form-control" name="estado">
                              <option value="activo">activo</option>
                              <option value="inactivo">inactivo</option>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                      <input type="submit" class="btn btn-success" value="Crear">
                  </div>
              </form>
          </div>
      </div>
  </div>

  <script>
      $('input[type="file"]').on('change', function() {
          var ext = $(this).val().split('.').pop();
          if ($(this).val() != '') {
              if (ext == "jpeg") {
                  if ($(this)[0].files[0].size > 10048576) {
                      swal({
                          title: "¡Precaución!",
                          text: "Se solicita un archivo no mayor a 1MB. Por favor verifica.",
                          icon: "warning",
                          dangerMode: true,
                      })
                      $(this).val('');
                  } else {
                      $(".custom-file-input").on("change", function() {
                          var fileName = $(this).val().split("\\").pop();
                          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                      });

                  }
              } else {
                  $(this).val('');
                  swal({
                      title: "Lo sentimos",
                      text: "La extensión:" + ext + " no es permitida.",
                      icon: "warning",
                      dangerMode: true,
                  })
              }
          }
      });

      //crear
      $('#new_product_file').on('submit', function(e) {
          e.preventDefault();
          var formData = new FormData(this);
          formData.append('_token', $('input[name=_token]').val());
          $.ajax({
              type: 'POST',
              url: "{{ route('nuevo_producto') }}",
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                  swal({
                      title: "Bien echo",
                      text: "La informacion se guardo.",
                      type: "success"
                  }).then(function() {
                      location.reload();
                  });
              },
              error: function(jqXHR, text, error) {
                  swal({
                      title: "Lo sentimos",
                      text: "No pudimos subir la informacion",
                      icon: "warning",
                      dangerMode: true,
                  })
              }
          });
      });
  </script>
