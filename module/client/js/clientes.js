

function login() {
   
   var parametros = {
            "login" : true,
            "user_login"  : $("#user_login").val(),
            "pass_login"  : $("#pass_login").val()
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                beforeSend: function () {
                        $("#homeContent").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                    var result = JSON.parse(response);
                    if ( result.respuesta ) {
                        self.location.reload();
                    } else {
                        alert("Acceso denegado.");
                    }
                }
        });
   
}


function cargarHtml(cargar){
    
    var parametros = {
            "html" : cargar
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                beforeSend: function () {
                        $("#homeContent").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $("#homeContent").html(response);
                }
        });
    
}

function logout(cargar){
    
    var parametros = {
            "logout" : true
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                beforeSend: function () {
                        $("#homeContent").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        self.location.reload();
                }
        });
    
}


function registro(){
    
    $("#modal-title").html("Registrar Nuevo Cliente");
    $("#modal-body").html("<label for='nombre'>Nombre: </label><input type='text' class='form-control' placeholder='Nombre' name='nombre' id='nombre' required>"+
                          "<label for='correo'>Correo: </label><input type='text' class='form-control' placeholder='Correo' name='mail' id='nombre' required>"+
                          "<label for='usuario'>Usuario: </label><input type='text' class='form-control' placeholder='Usuario' name='usuario' id='usuario' required>"+
                          "<label for='clave1'>Contrase&nacute;a: </label><input type='text' class='form-control' placeholder='Contrase&ntilde;a' name='clave1' id='clave1' required>"+
                          "<label for='clave2'>Confirmar Contrase&nacute;a: </label><input type='text' class='form-control' placeholder='Confirmar Contrase&ntilde;a' name='clave2' id='clave2' required>"+
                          "<label for='referido'>Referido: </label><input type='text' class='form-control' placeholder='Referido Por' name='referido' id='referido' required>"
                          
                         );
    $("#modal-footer").html('<input type="submit" class="btn btn-info" style="font-size: 10px;" value="Registrarme"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
    $("#modalBuy").modal();
    
    
}


function miperfil(){
    
    var parametros = {
            "miperfil" : true
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
                                
                                $("#modal-title").html("Editar Mi Perfil");
                                $('#form_modal').attr('onsubmit', 'editarPerfil(); return false;');
                                $("#modal-body").html("<label for='nombre'>Nombre: </label><input type='text' value='"+result.datos.nombre+"' class='form-control' placeholder='Nombre' name='nombre' id='nombre' required>"+
                                                      "<label for='correo'>Correo: </label><input type='text' value='"+result.datos.correo+"' class='form-control' placeholder='Correo' name='mail' id='nombre' required>"+
                                                      "<label for='usuario'>Usuario: </label><input type='text' readonly value='"+result.datos.login+"' class='form-control' placeholder='Usuario' name='usuario' id='usuario' required>"+
                                                      "<label for='referido'>Referido: </label><input type='text' readonly value='"+result.datos.referido+"' class='form-control' placeholder='Referido Por' name='referido' id='referido' required>"

                                                     );
                                $("#modal-footer").html('<input type="submit" class="btn btn-info" style="font-size: 10px;" value="Guardar"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
                                $("#modalClient").modal();
                                
                            } else {
                                alert(result.msg);
                            }
                    }
        });
    
    
}

function aceptarRegistro(){
    
    if ( $("#clave1").val() != $("#clave2").val() ) {
        alert("Las contraseñas ingresadas no coinciden");
    } else {
        
        var parametros = {
            "registro" : true,
            "datosForm" : $("#form_registro").serialize()
        };
        $.ajax({
                    data:  parametros,
                    url:   'controller.php',
                    type:  'post',
                    beforeSend: function () {
                            $("#homeContent").html("Procesando, espere por favor...");
                    },
                    success:  function (response) {
                            var result = JSON.parse(response);
                            if ( result.respuesta ) {
                                $("#modalBuy").modal('hide');
                                alert(result.msg);
                                
                            } else {
                                alert(result.msg);
                            }
                    }
        });
    }
    
    
    
}

function editarPerfil(){
    
    var parametros = {
        "editarPerfil" : true,
        "datosForm" : $("#form_modal").serialize()
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                
                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            $("#modalClient").modal('hide');
                            alert(result.msg);

                        } else {
                            alert(result.msg);
                        }
                }
    });
}


function modalInfo(id){
    
    
   $("#modal-footer").html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
   switch (id) {
        case 1:
                $("#modal-title").html("Paquete Principiante");
                $("#modal-body").html("<h3><img src='img/modulos/principiante.jpg' height='100px'>&nbsp;&nbsp;&nbsp;<b> Inversion de $US 100,oo </b><br><h4><b>Rentabilidad mensual de 17%</b></h4></h3>");
                break;
        case 2:
                $("#modal-title").html("Paquete Inversionista");
                $("#modal-body").html("<h3><img src='img/modulos/aprendiz.jpg' height='100px'>&nbsp;&nbsp;&nbsp;<b> Inversion de $US 1.000,oo </b><br><h4><b>Rentabilidad mensual de 18%</b></h4></h3>");
                break;
        case 3:
                $("#modal-title").html("Paquete Trader");
                $("#modal-body").html("<h3><img src='img/modulos/trader.jpg' height='100px'>&nbsp;&nbsp;&nbsp;<b> Inversion de $US 2.000,oo </b><br><h4><b>Rentabilidad mensual de 19%</b></h4></h3>");
                break;
        case 4:
                $("#modal-title").html("Paquete Master");
                $("#modal-body").html("<h3><img src='img/modulos/master-vip.jpg' height='100px'>&nbsp;&nbsp;&nbsp;<b> Inversion de $US 5.000,oo </b><br><h4><b>Rentabilidad mensual de 20%</b></h4></h3>");
                break;
        default:
            console.log("Sorry, we are out of " + id + ".");
}
   $("#modalBuy").modal();
}


function comprarPaquete(id){
    
    
   $("#modal-footer").html('<button type="button" class="btn btn-info" onclick="aceptarCompra('+id+')">Confirmar Pago</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>');
   switch (id) {
        case 1:
                $("#modal-title").html("<img src='img/modulos/principiante.jpg' height='80px'>Paquete Principiante");
                $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li><li><a data-toggle="tab" href="#menu1"><img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li>'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>100 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>18YRQ5po6Jbttjb7jGD6HjTA26krhjHXHG</b></div> <br>'+
                                      'Despues de efectuar el pago ingrese su direccion bitcoin de pago y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBitCoin" id="transaccionBitCoin"></div></p></div>'+
                                      
                                      '<div id="menu1" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>100 USD</b> '+
                                      'a la siguiente cuenta de ahorros de Bancolombia: <br><div style="text-align:center;"></p>'+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'+
                                      'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'+
                                      '</div>    </div></div>');
                break;
        case 2:
                $("#modal-title").html("<img src='img/modulos/aprendiz.jpg' height='80px'>Paquete Aprendiz");
                $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li><li><a data-toggle="tab" href="#menu1"><img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li>'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>1000 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>18YRQ5po6Jbttjb7jGD6HjTA26krhjHXHG</b></div> <br>'+
                                      'Despues de efectuar el pago ingrese su direccion bitcoin de pago y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBitCoin" id="transaccionBitCoin"></div></p></div>'+
                                      
                                      '<div id="menu1" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>1000 USD</b> '+
                                      'a la siguiente cuenta de ahorros de Bancolombia: <br><div style="text-align:center;"></p>'+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'+
                                      'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'+
                                      '</div>    </div></div>');
                break;
        case 3:
                $("#modal-title").html("<img src='img/modulos/trader.jpg' height='80px'>Paquete Trader");
                $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li><li><a data-toggle="tab" href="#menu1"><img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li>'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>2000 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>18YRQ5po6Jbttjb7jGD6HjTA26krhjHXHG</b></div> <br>'+
                                      'Despues de efectuar el pago ingrese su direccion bitcoin de pago y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBitCoin" id="transaccionBitCoin"></div></p></div>'+
                                      
                                      '<div id="menu1" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>2000 USD</b> '+
                                      'a la siguiente cuenta de ahorros de Bancolombia: <br><div style="text-align:center;"></p>'+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'+
                                      'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'+
                                      '</div>    </div></div>');
                break;
        case 4:
                $("#modal-title").html("<img src='img/modulos/master-vip.jpg' height='80px'>Paquete Master - VIP");
                $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li><li><a data-toggle="tab" href="#menu1"><img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li>'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>5000 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>18YRQ5po6Jbttjb7jGD6HjTA26krhjHXHG</b></div> <br>'+
                                      'Despues de efectuar el pago ingrese su direccion bitcoin de pago y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBitCoin" id="transaccionBitCoin"></div></p></div>'+
                                      
                                      '<div id="menu1" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>5000 USD</b> '+
                                      'a la siguiente cuenta de ahorros de Bancolombia: <br><div style="text-align:center;"></p>'+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'+
                                      'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'+
                                      '</div>    </div></div>');
                break;
        default:
            console.log("Sorry, we are out of " + id + ".");
}
   $("#modalBuy").modal();
}



function aceptarCompra(id){
    
    
    if ($('#transaccionBitCoin').val().trim() !== '' || $('#transaccionBanco').val().trim() !== '' ) {
        var parametros = {
                "aceptarCompra" : true,
                "paquete" : id,
                "transBit" : $("#transaccionBitCoin").val(),
                "transBan" : $("#transaccionBanco").val()
            };
            $.ajax({
                        data:  parametros,
                        url:   'controller.php',
                        type:  'post',
                        success:  function (response) {
                                var result = JSON.parse(response);
                                if ( result.respuesta ) {
                                    $("#modalBuy").modal('hide');
                                    alert(result.msg);

                                } else {
                                    alert(result.msg);
                                }
                        }
            });
        } else {
            alert("Por favor digite el comprobante de su transaccion.");
        }
    
}

