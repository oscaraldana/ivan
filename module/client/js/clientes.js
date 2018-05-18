

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
                          "<label for='foto'>Foto: </label><input name='foto' id='foto' type='file' class='form-control form-file' accept='image/*' />"+
                          "<label for='referido'>Referido: </label><input type='text' class='form-control' placeholder='Referido Por' name='referido' id='referido'>"+
                          "<input type='hidden' name='registro' id='hidden' value = 'true'><iframe name='iframeUpload' style='display:none'></iframe>"
                          
                         );
    $("#modal-footer").html('<span class="text-left" style="float:left;" text-align="left"><label for="aceptoterminos">'+
                                '<ul class="buttons"><li><input type="checkbox" value="1" id="aceptoterminos" name = "aceptoterminos" class="radiobtn"><span></span> &nbsp;&nbsp;'+
                                ' Acepto </li></ul></label><a href="javascript:;" onclick="mostrarTerms()"> Terminos y Condiciones</a> </span>'+
                            '<input type="submit" class="btn btn-logg" style="font-size: 10px;" value="Registrarme"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
    $("#modalBuy").modal();
    
    
}


function mostrarTerms() {
    
    $("#modal-titlex").html("Terminos y Condiciones");
    $("#modal-bodyx").html('Los siguientes términos y condiciones (los "Términos y Condiciones") rigen el uso que usted le dé a este sitio web y a cualquiera de los contenidos disponibles por o a través de este sitio web, incluyendo cualquier contenido derivado del mismo (el "Sitio Web"). Time Inc. ("Time Inc." o "nosotros") ha puesto a su disposición el Sitio Web. Podemos cambiar los Términos y Condiciones de vez en cuando, en cualquier momento sin ninguna notificación, sólo publicando los cambios en el Sitio Web. AL USAR EL SITIO WEB, USTED ACEPTA Y ESTÉ DE ACUERDO CON ESTOS TÉRMINOS Y CONDICIONES EN LO QUE SE REFIERE A SU USO DEL SITIO WEB. Si usted no está de acuerdo con estos Términos y Condiciones, no puede tener acceso al mismo ni usar el Sitio Web de ninguna otra manera.'+
                            '1.         Derechos de Propiedad. Entre usted y Time Inc., Time Inc. es dueño único y exclusivo, de todos los derechos, título e intereses en y del Sitio Web, de todo el contenido (incluyendo, por ejemplo, audio, fotografías, ilustraciones, gráficos, otros medios visuales, videos, copias, textos, software, títulos, archivos de Onda de choque, etc.), códigos, datos y materiales del mismo, el aspecto y el ambiente, el diseño y la organización del Sitio Web y la compilación de los contenidos, códigos, datos y los materiales en el Sitio Web, incluyendo pero no limitado a, cualesquiera derechos de autor, derechos de marca, derechos de patente, derechos de base de datos, derechos morales, derechos sui generis y otras propiedades intelectuales y derechos patrimoniales del mismo. Su uso del Sitio Web no le otorga propiedad de ninguno de los contenidos, códigos, datos o materiales a los que pueda acceder en o a través del Sitio Web.'+
                            '2.         Licencia Limitada. Usted puede acceder y ver el contenido del Sitio Web desde su computadora o desde cualquier otro aparato y, a menos de que se indique de otra manera en estos Términos y Condiciones o en el Sitio Web, sacar copias o impresiones individuales del contenido del Sitio Web para su uso personal, interno únicamente. El uso del Sitio Web y de los servicios que se ofrecen en o a través del Sitio Web, son sólo para su uso personal, no comercial.'+
                            '3.         Uso Prohibido. Cualquier distribución, publicación o explotación comercial o promocional del Sitio Web, o de cualquiera de los contenidos, códigos, datos o materiales en el Sitio Web, está estrictamente prohibida, a menos de que usted haya recibido el previo permiso expreso por escrito del personal autorizado de Time Inc. o de algún otro poseedor de derechos aplicable. A no ser como está expresamente permitido en el presente contrato, usted no puede descargar, informar, exponer, publicar, copiar, reproducir, distribuir, transmitir, modificar, ejecutar, difundir, transferir, crear trabajos derivados de, vender o de cualquier otra manera explotar cualquiera de los contenidos, códigos, datos o materiales en o disponibles a través del Sitio Web. Usted se obliga además a no alterar, editar, borrar, quitar, o de otra manera cambiar el significado o la apariencia de, o cambiar el propósito de, cualquiera de los contenidos, códigos, datos o materiales en o disponibles a través del Sitio Web, incluyendo, sin limitación, la alteración o retiro de cualquier marca comercial, marca registrada, logo, marca de servicios o cualquier otro contenido de propiedad o notificación de derechos de propiedad. Usted reconoce que no adquiere ningún derecho de propiedad al descargar algún material con derechos de autor de o a través del Sitio Web. Si usted hace otro uso del Sitio Web, o de los contenidos, códigos, datos o materiales que ahí se encuentren o que estén disponibles a través del Sitio Web, a no ser como se ha estipulado anteriormente, usted puede violar las leyes de derechos de autor y otras leyes de los Estados Unidos y de otros países, así como las leyes estatales aplicables, y puede ser sujeto a responsabilidad legal por dicho uso no autorizado.'
                            );
    $("#modal-footerx").html('<button type="button" class="btn btn-logg" data-dismiss="modal" style="font-size: 10px;">Cerrar</button>');           
    $("#modalx").modal();
    
}

function cambiarContra(){
    
    $("#modal-title").html("Cambiar Mi Contraseña");
    $("#modal-body").html("<label for='actual'>Mi contraseña actual: </label><input type='password' class='form-control' placeholder='Contraseña Actual' name='actual' id='actual' required>"+
                          "<label for='nueva1'>Mi nueva contraseña: </label><input type='password' class='form-control' placeholder='Nueva Contraseña' name='nueva1' id='nueva1' required>"+
                          "<label for='nueva2'>Confirmar mi nueva contraseña: </label><input type='password' class='form-control' placeholder='Confirmar Nueva Contraseña' name='nueva2' id='nueva2' required>"
                          
                         );
    $("#modal-footer").html('<input type="submit" class="btn btn-logg" style="font-size: 10px;" value="Guardar"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
    $("#modalClient").modal();
    $('#form_modal').attr('onsubmit', 'cambiarMiContra(); return false;');
}

function cambiarMiContra(){
    
     var parametros = {
        "cambiarContra" : true,
        "datosForm" : $("#form_modal").serialize()
    };
    $.ajax({
                data:  parametros,
                url:   '../client/controller.php',
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

function miperfil(){
    
    var parametros = {
            "miperfil" : true
        };
        $.ajax({
                    data:  parametros,
                    url:   '../client/controller.php',
                    type:  'post',
                    /*beforeSend: function () {
                            $("#homeContent").html("Procesando, espere por favor...");
                    },*/
                    success:  function (response) {
                            var result = JSON.parse(response);
                            
                        
                            if ( result.respuesta ) {
                                
                                $('#form_modal').attr('onsubmit', '');
                                $('#form_modal').attr('method', 'post');
                                $('#form_modal').attr('enctype', 'multipart/form-data');
                                $('#form_modal').attr('action', 'controller.php');
                                $('#form_modal').attr('target', 'iframeUpload');
                                $("#modal-title").html("Editar Mi Perfil");
                                //$('#form_modal').attr('onsubmit', 'editarPerfil(); return false;');
                                $("#modal-body").html("<label for='nombre'>Nombre: </label><input type='text' value='"+result.datos.nombre+"' class='form-control' placeholder='Nombre' name='nombre' id='nombre' required>"+
                                                      "<label for='correo'>Correo: </label><input type='text' value='"+result.datos.correo+"' class='form-control' placeholder='Correo' name='mail' id='nombre' required>"+
                                                      "<label for='foto'>Foto: </label><input name='foto' id='foto' type='file' class='form-control form-file' accept='image/*' />"+
                                                      "<label for='usuario'>Usuario: </label><input type='text' readonly value='"+result.datos.login+"' class='form-control' placeholder='Usuario' name='usuario' id='usuario' required>"+
                                                      "<label for='referido'>Referido: </label><input type='text' readonly value='"+result.datos.referido+"' class='form-control' placeholder='Referido Por' name='referido' id='referido' required>"+
                                                      "<input type='hidden' name='editarPerfil' id='editarPerfil' value ='true'>"
                                                     );
                                $("#modal-footer").html('<input type="submit" class="btn btn-logg" style="font-size: 10px;" value="Guardar"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button><iframe name="iframeUpload" style="display:none"></iframe>');           
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


function actInfo (nombre, foto){
    $('#nomPerfil').html(nombre);
    if( foto.length > 0 ){
        d = new Date();
        $('#imgPerfil').attr('src', foto+'?'+d.getTime());
    }
}

function closeModalx (x){
    $("#"+x).modal('hide');
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
    
     var parametros = {
        "dataComprarPaquete" : true,
        "idPaquete" : id
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                
                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            //$("#modalClient").modal('hide');
                            //swal(result.msg);
                            $("#modal-title").html(result.title);
                            $("#modal-body").html(result.body);
                            $("#modal-footer").html(result.footer);
                            $("#modalBuy").modal();

                        } else {
                            swal(result.msg);
                        }
                }
    });
    
    /*
    $("#modal-footer").html('<button type="button" class="btn btn-info" onclick="aceptarCompra('+id+')">Confirmar Pago</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>');
    switch (id) {
        case 1:
                $("#modal-title").html("<img src='img/modulos/principiante.jpg' height='80px'>Paquete Principiante");
                $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li> '+
                                      '<!-- <li><a data-toggle="tab" href="#menu1"> <img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li> -->'+
                                      '<li><a data-toggle="tab" href="#reinvertirTab"><i class="fa fa-exchange"></i> Reinvertir</a></li> '+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>100 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>1HZ2wMzf7BPKyoKnw3Y9RAnxJCM9BJMoEK</b></div> <br>'+
                                      'Despues de efectuar el pago ingrese su direccion bitcoin de pago y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBitCoin" id="transaccionBitCoin"></div></p></div>'+
                                      
                                      '<div id="menu1" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>100 USD</b> '+
                                      'a la siguiente cuenta de ahorros de Bancolombia: </p><br><div style="text-align:center;">'+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'+
                                      'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'+
                                      
                                      '<div id="reinvertirTab" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>100 USD</b> '+
                                      'a la siguiente cuenta de ahorros de Bancolombia: <br><div style="text-align:center;"></p>'+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'+
                                      'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'+
                                      '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'+
                                      
                                      '</div>  </div>'+
                                      
                                      '</div>');
                break;
        case 2:
                $("#modal-title").html("<img src='img/modulos/aprendiz.jpg' height='80px'>Paquete Aprendiz");
                $("#modal-body").html('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' +
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li> <!-- <li><a data-toggle="tab" href="#menu1"> <img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li> -->'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>1000 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>1HZ2wMzf7BPKyoKnw3Y9RAnxJCM9BJMoEK</b></div> <br>'+
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
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li> <!-- <li><a data-toggle="tab" href="#menu1"> <img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li> -->'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>2000 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>1HZ2wMzf7BPKyoKnw3Y9RAnxJCM9BJMoEK</b></div> <br>'+
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
                                      '<i class="fa fa-bitcoin"></i> Bitcoin</a></li> <!-- <li><a data-toggle="tab" href="#menu1"> <img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li> -->'+
                                      '</ul>'+
                                      '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>Principiante</b> envia la cantidad de <b>5000 USD</b> '+
                                      'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '+
                                      '<img src="img/modulos/qr.png" width="150px;"><br><b>1HZ2wMzf7BPKyoKnw3Y9RAnxJCM9BJMoEK</b></div> <br>'+
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
    */
}



function aceptarCompra(id){
    
    
    if ($('#transaccionBitCoin').val().trim() !== '' || $('#transaccionBanco').val().trim() !== '' || $("#selectforpag").val() > 0 ) {
    
        
        
        
        if ( ($('#transaccionBitCoin').val().trim() !== '' && $('#transaccionBanco').val().trim() !== '' ) ||
             ($('#transaccionBitCoin').val().trim() !== '' && $("#selectforpag").val() > 0 ) ||   
             ($('#transaccionBanco').val().trim() !== '' && $("#selectforpag").val() > 0 )    
        ){
            swal("Seleccione solamente una forma de pago.");
        } else {
        
        
            if ( $("#selectforpag").val() > 0 ){
                swal({
                    title: "Confirmar Solicitud!",
                    text: "Confirma que desea reinvertir sus ganancias, comprando este paquete?",
                    buttons: true,
                    dangerMode: false,
                })
                .then((accept) => {
                    if (accept) {
                        
                        var parametros = {
                            "aceptarCompra" : true,
                            "paquete" : id,
                            "transBit" : $("#transaccionBitCoin").val(),
                            "transBan" : $("#transaccionBanco").val(),
                            "opcionReinvertir" : $("#selectforpag").val()
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
                    }
                });

            } else {
                
                
                var parametros = {
                            "aceptarCompra" : true,
                            "paquete" : id,
                            "transBit" : $("#transaccionBitCoin").val(),
                            "transBan" : $("#transaccionBanco").val(),
                            "opcionReinvertir" : $("#selectforpag").val()
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
                
            }
        
        
        }
    } else {
        swal("Por favor indique su forma de pago.");
    }
    
}

function solicitarRetiro(tipo){
    
    var formaPago = "";
    if ( tipo == 1 ){
        formaPago = $("#metodoPagoRetiro").val();
    } else if ( tipo == 2 ) {
        formaPago = $("#metodoPagoRetiroRef").val();
    }
    
    
    if ( formaPago !== "" && formaPago !== undefined ) {
    swal({
        title: "Confirmar Solicitud!",
        text: "Confirma que desea solicitar el retiro de tus ganancias?",
        buttons: true,
        dangerMode: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          confirmarRetiro(formaPago, tipo);
        }
      });
    } else {
        swal("Por favor seleccione el metodo de pago.");
    }
    
}

function confirmarRetiro(formaPago, tipo){
    
    var parametros = {
        "solicitarRetiro" : true,
        "formaPago" : formaPago,
        "tipoPago" : tipo
    };
    $.ajax({
                data:  parametros,
                url:   'controller.php',
                type:  'post',
                
                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            $("#modalClient").modal('hide');
                            cargarHtml('retirar');
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
                                        '<option value="">--</option><option value="BANCO AV VILLAS">BANCO AV VILLAS</option><option value="BANCO BBVA COLOMBIA S.A.">BANCO BBVA COLOMBIA S.A.</option><option value="BANCO CAJA SOCIAL">BANCO CAJA SOCIAL</option><option value="BANCO COLPATRIA">BANCO COLPATRIA</option><option value="BANCO DAVIVIENDA">BANCO DAVIVIENDA</option><option value="BANCO DE BOGOTA">BANCO DE BOGOTA</option><option value="BANCO DE OCCIDENTE">BANCO DE OCCIDENTE</option><option value="BANCO GNB SUDAMERIS">BANCO GNB SUDAMERIS</option><option value="BANCO POPULAR">BANCO POPULAR</option><option value="BANCOLOMBIA">BANCOLOMBIA</option><option value="CITIBANK ">CITIBANK </option><option value="BANCO CORPBANCA - HELM BANK S.A.">BANCO CORPBANCA - HELM BANK S.A.</option> </select>  ' +
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

function formOlvidoClave () {
    
    $("#modal-titlex").html("Olvide mi contrase&ntilde;a");
    $("#modal-bodyx").html("<br><br>"+
                           "<br><label for='userl'><i class='icon_profile'></i> Usuario de acceso</label><input type='text' class='form-control' placeholder='Digite su usuario' name='userl' id='userl' required><br>&nbsp;");
    $("#modal-footerx").html('<input type="button" class="btn btn-logg" style="font-size: 10px;" value="Recordar Contrase&ntilde;a" onclick="olvideContra()"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 10px;">Cancelar</button>');           
    $("#modalx").modal();
    
    
}

function olvideContra(){

    if( $("#userl").val().trim() == '' ){
        swal("Digite su nombre de usuario.");
        return;
    }
    
    var parametros = {
        "olvideContrasena" : true,
        "usuario" : $("#userl").val()
    };
    $.ajax({
                data:  parametros,
                url:   '../client/controller.php',
                type:  'post',

                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            $("#modalx").modal('hide');
                            swal(result.msg);

                        } else {
                            swal(result.msg);
                        }
                }
    });

}


function cambiarUsuario(id){
     swal({
        title: "Confirmar Solicitud!",
        text: "Confirma que desea loguearse como este cliente?",
        buttons: true,
        dangerMode: false,
      })
      .then((willDelete) => {
        if (willDelete) {
            var parametros = {
                "cambiarUsuario" : true,
                "idUsuario" : id
            };
            
            $.ajax({
                    data:  parametros,
                    url:   '../client/controller.php',
                    type:  'post',

                    success:  function (response) {
                            var result = JSON.parse(response);
                            if ( result.respuesta ) {
                                
                                window.location.href = "../client";
                            } else {
                                swal(result.msg);
                            }
                    }
           });
        }
      });
}







/*
 * Para relog regresivo
 * 
 */

function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var segundos = Math.floor((t / 1000) % 60);
  var minutos = Math.floor((t / 1000 / 60) % 60);
  var horas = Math.floor((t / (1000 * 60 * 60)) % 24);
  var dias = Math.floor(t / (1000 * 60 * 60 * 24));
 
  return {
    'total': t,
    'dias': dias,
    'horas': horas,
    'minutos': minutos,
    'segundos': segundos
  };
}

function getTimeIni(initime) {
  var tini = Date.parse(new Date()) - Date.parse(initime);
  return {
    'inicio': tini
  };
}

  
 
function initializeReloj(id, endtime, cod, iniline) {
  var reloj = document.getElementById(id);
  
  var diaSpan = reloj.querySelector('#dias_'+cod);
  var horaSpan = reloj.querySelector('#horas_'+cod);
  var minutoSpan = reloj.querySelector('#minutos_'+cod);
  var segundoSpan = reloj.querySelector('#segundos_'+cod);
 
  function updateReloj() {
    var t = getTimeRemaining(endtime);
    var ini = getTimeIni(iniline);
    
    if (t.total <= 0 || ini.inicio < 0) {
        diaSpan.innerHTML = "0";
        horaSpan.innerHTML = 0;
        minutoSpan.innerHTML = 0;
        segundoSpan.innerHTML = 0;  
        diaSpan.style.backgroundColor = "#ff4d4d"; 
        horaSpan.style.backgroundColor = "#ff4d4d"; 
        minutoSpan.style.backgroundColor = "#ff4d4d"; 
        segundoSpan.style.backgroundColor = "#ff4d4d"; 
      clearInterval(timeinterval);
    } else {
        diaSpan.innerHTML = t.dias;
        horaSpan.innerHTML = ('0' + t.horas).slice(-2);
        minutoSpan.innerHTML = ('0' + t.minutos).slice(-2);
        segundoSpan.innerHTML = ('0' + t.segundos).slice(-2);
    }
  }
  updateReloj();
  var timeinterval = setInterval(updateReloj, 1000);
}
 
 
 function detallarGanancias(id) {
     
     var parametros = {
        "detallarGanancias" : true,
        "paquete" : id
    };
    $.ajax({
                data:  parametros,
                url:   '../client/controller.php',
                type:  'post',

                success:  function (response) {
                        var result = JSON.parse(response);
                        if ( result.respuesta ) {
                            $("#modal-title").html(result.title);
                            $("#modal-body").html(result.imprimir);
                            $("#modal-footer").html('<button type="button" class="btn btn-logg" data-dismiss="modal" style="font-size: 10px;">Cerrar</button>');           
                            $("#modalClient").modal();

                        } else {
                            swal(result.msg);
                        }
                }
    });
     
 }
