/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function consultarPaquetes (){
    buscarListaPaquetes();
}

function buscarListaPaquetes(){
   
   var parametros = {
        "formSearch" : true,
        "datosForm" : $("#formSearch").serialize()
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                
                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            $("#listaPaquetes").html(result.tabla);
                            //swal(result.msg);

                        } else {
                            swal(result.msg);
                        }
                }
    });
    
}

function editarPaquete (id) {
    
    var parametros = {
            "consultapaquete" : true,
            "paquete_id" : id
        };
        $.ajax({
                    data:  parametros,
                    url:   'controller.php',
                    type:  'post',
                    /*beforeSend: function () {
                            $("#homeContent").html("Procesando, espere por favor...");
                    },*/
                    success:  function (response) {
                            var result = JSON.parse(response);
                            
                        
                            if ( result.respuesta ) {
    
                                $("#modal-title").html("Administrar Paquete");
                                $("#modal-body").html("<label for='nombre'>Nombre: </label><input type='text' class='form-control' placeholder='Nombre' name='nombre' id='nombre' required>"+
                                                      "<label for='correo'>Correo: </label><input type='text' class='form-control' placeholder='Correo' name='mail' id='nombre' required>"+
                                                      "<label for='usuario'>Usuario: </label><input type='text' class='form-control' placeholder='Usuario' name='usuario' id='usuario' required>"+
                                                      "<label for='clave1'>Contrase&nacute;a: </label><input type='password' class='form-control' placeholder='Contrase&ntilde;a' name='clave1' id='clave1' required>"+
                                                      "<label for='clave2'>Confirmar Contrase&nacute;a: </label><input type='password' class='form-control' placeholder='Confirmar Contrase&ntilde;a' name='clave2' id='clave2' required>"+
                                                      "<label for='foto'>Foto: </label><input name='foto' id='foto' type='file' class='form-control form-file' accept='image/x-png,image/gif,image/jpeg' />"+
                                                      "<label for='referido'>Referido: </label><input type='text' class='form-control' placeholder='Referido Por' name='referido' id='referido' required>"+
                                                      "<input type='hidden' name='registro' id='hidden' value = 'true'><iframe name='iframeUpload' style='display:none'></iframe>"

                                                     );
                                $("#modal-footer").html('<input type="submit" class="btn btn-logg" style="font-size: 10px;" value="Registrarme"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
                                $("#modalPaq").modal();
    
                            } else {
                                swal(result.msg);
                            }
                    }
        });
}