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
                            
                        alert(result);
                            if ( result.respuesta ) {
    
                                $("#modal-title").html("Administrar Paquete");
                                $("#modal-body").html("<table class='table'>"+
                                                      "<tr><td>Cliente:</td><td>"+result.datos.nombre+"<td></tr>"+
                                                      "<tr><td>Paquete:</td><td class='text-right'>"+result.datos.paquete+"<td></tr>"+
                                                      "<tr><td>Valor:</td><td>"+result.datos.valor+"<td></tr>"+
                                                      "</table>"

                                                     );
                                $("#modal-footer").html('<input type="submit" class="btn btn-logg" style="font-size: 10px;" value="Registrarme"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
                                $("#modalPaq").modal();
    
                            } else {
                                swal(result.msg);
                            }
                    }
        });
}