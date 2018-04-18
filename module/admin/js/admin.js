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
                                
                                var mostrar = 'none';
                                if ( result.datos.estado == '1' ){
                                    alert("activo");
                                    mostrar = true;
                                }
    
                                $("#modal-title").html("Administrar Paquete");
                                $("#modal-body").html("<form onsubmit='return false;' id='formactpaq' ><table class='table'>"+
                                                      "<tr><td>Cliente:</td><td class='text-right'>"+result.datos.nombre+"<td></tr>"+
                                                      "<tr><td>Paquete:</td><td class='text-right'>"+result.datos.paquete+"<td></tr>"+
                                                      "<tr><td>Valor:</td><td class='text-right'>US$ <b>"+result.datos.valor+"<b><td></tr>"+
                                                      "<tr><td>Fecha de compra:</td><td class='text-right'>"+result.datos.fecha_registro+"<td></tr>"+
                                                      "<tr><td>Tipo de pago:</td><td class='text-right'>"+result.datos.tipo_pago+"<td></tr>"+
                                                      "<tr><td>Referencia Pago:</td><td class='text-right'>"+result.datos.referencia_pago+"<td></tr>"+
                                                      "<tr><td>Estado:</td><td class='text-right'>"+result.estados+"<td></tr>"+
                                                      "<tr id='fecinipaq' style='display:"+mostrar+";'><td>Fecha Inicio:</td><td class='text-right'><input type='date' value='"+result.datos.inicia+"' id='datefecinipaq' class='form-control'><td></tr>"+
                                                      "<tr id='fecfinpaq' style='display:"+mostrar+";'><td>Fecha Fin:</td><td class='text-right'><input type='date' value='"+result.datos.finaliza+"' id='datefecfinpaq' class='form-control'><td></tr>"+
                                                      "</table></form>"

                                                     );
                                $("#modal-footer").html('<input type="submit" class="btn btn-logg" style="font-size: 10px;" value="Guardar" onclick="modificarPaquete()"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
                                $("#modalPaq").modal();
    
                            } else {
                                swal(result.msg);
                            }
                    }
        });
}


function validarEstadoPaq() {
    var estadoSel = $("#selectEstado").val();
    
    if ( estadoSel == '1' ) {
        $("#fecinipaq").show();
        $("#fecfinpaq").show();
    } else {
        $("#fecinipaq").hide();
        $("#fecfinpaq").hide();
    }
}


function modificarPaquete(){
    
    alert($("#selectEstado").val());
    alert($("#datefecinipaq").val());
    alert($("#datefecfinpaq").val());
    
    var parametros = {
        "actualizarPaquete" : true,
        "datosForm" : $("#formactpaq").serialize()
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                
                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            //$("#listaPaquetes").html(result.tabla);
                            swal(result.msg);

                        } else {
                            swal(result.msg);
                        }
                }
    });
}