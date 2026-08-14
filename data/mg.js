$(function() {
    var load = $("#load");
    if (eraseBtn = $('.msgs .erase')) {
        eraseBtn.click(function(e) {
            e.preventDefault();
            win('<span class="yellow">&iquest;Realmente deseas borrar los mensajes?</span><br>Los mensajes se borraran definitivamente', function() {
                load.fadeIn();
                $.get('req.php', {
                    action: 'eraseMessages'
                }, function(data) {
                    load.hide();
                    if (data == "good") {
                        window.location = 'access.php?response=msgErased'
                    } else {
                        window.location = 'access.php?response=msgEraseFail'
                    }
                })
                })
            })
        }
    if (msg = $('.msg')) {
        var out = $('#msgComplete');
        msg.hover(function() {
            $(this).addClass('msg-hover')
            }, function() {
            $(this).removeClass('msg-hover')
            });
        msg.click(function() {
            var actual = $(this),
            names = actual.find('.real-names'),
            subject = actual.find('.real-subject'),
            message = actual.find('.real-message');
            msg.removeClass('msg-selected');
            actual.addClass('msg-selected');
            if (out.css('display') == 'none') {
                out.show()
                }
            out.html('<h3 class="lblue">MENSAJE</h3><h4>Remitente:</h4><strong>' + names.html() + '</strong><br><h4>Asunto:</h4><strong>' + subject.html() + '</strong><br><h4>Contenido:</h4><div class="prasi">' + message.html() + '</div>')
            })
        }
    if (add = $('.add')) {
        var addBtn = add.find('.addusr'),
        names = add.find('input[name="nw_names"]'),
        sign = add.find('input[name="nw_sign"]'),
        username = add.find('input[name="nw_username"]'),
        password = add.find('input[name="nw_password"]');
        addBtn.click(function(e) {
            e.preventDefault();
            names_stat = (names.val() < 1 ? '<span class="red">[Campo vac&iacute;o]</span>': '<span class="lblue">' + names.val() + '</span>');
            sign_stat = (sign.val() < 1 ? '<span class="red">[Campo vac&iacute;o]</span>': '<span class="lblue">' + sign.val() + '</span>');
            username_stat = (username.val() < 1 ? '<span class="red">[Campo vac&iacute;o]</span>': '<span class="lblue">' + username.val() + '</span>');
            password_stat = (password.val() < 1 ? '<span class="red">[Campo vac&iacute;o]</span>': '<span class="lblue">' + password.val() + '</span>');
            win('<span class="yellow">&iquest;Deseas agregar un nuevo usuario?</span><br>Revisa los datos ingresados<br><br>-&gt; Nombres y apellidos: ' + names_stat + '<br>-&gt; Etiqueta: ' + sign_stat + '<br>-&gt; Nombre de usuario: ' + username_stat + '<br>-&gt; Contrase&ntilde;a: ' + password_stat + '', function() {
                if (names.val().length == 0 || sign.val().length == 0 || username.val().length == 0 || password.val().length == 0) {
                    win('<div class="txt-center silver">&iexcl;Alg&uacute;n campo esta vacio!<br>No es posible agregar el usuario</div>')
                    } else {
                    add.submit()
                    }
            })
            })
        }
    if (alic = $('.alic')) {
        var attribBtn = alic.find('.attrib');
        attribBtn.click(function(e) {
            e.preventDefault();
            var stdLic = alic.find('#usrToAtt option:selected').val().split('^^');

            var usrNames = stdLic[1],
		licToAdd = Number(alic.find('input[name="al_licences"]').val())
		licPrice = Number(alic.find('input[name="al_price"]').val());

            licToAdd = isNaN(licToAdd) ? 0: licToAdd;
            licPrice = isNaN(licPrice) ? 0: licPrice;

	    if(licToAdd == 0 || licPrice == 0){
		win('<div class="txt-center silver">Las cantidades ingresadas no son correctas</div>');
	    }
	    else if(licPrice < 10){
		win('<div class="txt-center silver">No se puede agregar, el monto m&iacute;nimo por unidad es de <span class="white">$10</span></div>');
	    }
	    else {
	    	win('<span class="yellow">&iquest;Deseas agregar a <span class="white">' + usrNames + '</span>, la cantidad de <span class="white">' + licToAdd + '</span> licencias, por un monto total de <span class="white">$' + (licToAdd * licPrice) + '</span>?</span>', function(){alic.submit();});
	    }
            });
        }
    if (getlic = $('.getlic')) {
        getlic.click(function() {
            var stdUser = $('.stdUser').html();
            var stdLic = $('.clientList option:selected').val().split('^^'),
            licRef = stdLic[0],
            licOrd = stdLic[1],
            licClient = stdLic[2],
            licFirstCode = stdLic[3],
            licActivationCode = stdLic[4],
            licCreation = stdLic[5];
            win('<div class="licView"><h3>DATOS DE LICENCIA</h3><strong>Usuario vendedor: </strong><span class="yellow">' + stdUser + '</span><br><br><strong>Cliente(<span class="white">' + licOrd + '</span>): </strong><span>' + licClient + '</span><br><strong>C&oacute;digo inicial: </strong><span>' + licFirstCode + '</span><br><strong>C&oacute;digo activaci&oacute;n: </strong><span>' + licActivationCode + '</span><br><strong>Fecha de creaci&oacute;n: </strong><span>' + licCreation + '</span></div>')
            })
        }
    if (modlic = $('.modlic')) {
        modlic.click(function() {
            var stdUser = $('.stdUser').html();
            var stdLic = $('.clientList option:selected').val().split('^^'),
            licRef = stdLic[0],
            licOrd = stdLic[1],
            licClient = stdLic[2],
            licFirstCode = stdLic[3],
            licActivationCode = stdLic[4],
            licCreation = stdLic[5];
            win('<div class="licView"><h3>MODIFICAR LICENCIA</h3><strong>Usuario vendedor: </strong><span class="yellow">' + stdUser + '</span><br><br><strong>Cliente(<span class="white">' + licOrd + '</span>): </strong><input type="text" id="modClient" class="s-frm-text" value="' + licClient + '"><br><strong>Fecha de creaci&oacute;n: </strong><input type="text" id="modLicCreation" class="s-frm-text" value="' + licCreation + '"><br><strong>C&oacute;digo inicial: </strong><input type="text" id="modFirstCode" class="s-frm-text" value="' + licFirstCode + '"></div>', function() {
                var modClient = $.trim($('#modClient').val()),
                modCreation = $.trim($('#modLicCreation').val()),
                modFirstCode = $.trim($('#modFirstCode').val());
                if (modClient == licClient && modCreation == licCreation && modFirstCode == licFirstCode) {
                    win('<div class="txt-center silver">No hubo ning&uacute;n cambio en los datos</div>')
                    } else {
                    load.fadeIn();
                    $.post('req.php', {
                        action: 'modLic',
                        ref: licRef,
                        ord: licOrd,
                        client: modClient,
                        creation: modCreation,
                        firstCode: modFirstCode
                    }, function(data) {
                        load.hide();
                        if (data == 'good') {
                            win('<div class="txt-center">Se ha modificado la licencia correctamente</div><form id="refresh" action="access.php" method="post"><input type="hidden" name="lics_of" value="' + licRef + '^^' + stdUser + '"><input type="hidden" name="stdLic" value="' + licOrd + '"></form>', function() {
                                $('#refresh').submit()
                                }, {
                                hideNotBtn: true
                            })
                            } else {
                            win('<div class="txt-center"><span class="red">Ha ocurrido un error al guardar los cambios</span><br>Alg&uacute;n  campo est&aacute; mal escrito o es incorrecto</div>')
                            }
                    })
                    }
            }, {
                okBtnVal: 'Guardar',
                notBtnVal: 'Cancelar'
            })
            })
        }
    if (dellic = $('.dellic')) {
        dellic.click(function() {
            var stdUser = $('.stdUser').html();
            var stdLic = $('.clientList option:selected').val().split('^^'),
            licRef = stdLic[0],
            licOrd = stdLic[1],
            licClient = stdLic[2];
            win('<span class="yellow">&iquest;Realmente deseas borrar la licencia <span class="white">' + licOrd + '</span> de <span class="white">' + licClient + '</span>?</span>', function() {
                load.fadeIn();
                $.post('req.php', {
                    action: 'delLic',
                    ref: licRef,
                    ord: licOrd
                }, function(data) {
                    load.hide();
                    if (data == 'good') {
                        win('<div class="txt-center">Licencia borrada correctamente</div><form id="refresh" action="access.php" method="post"><input type="hidden" name="lics_of" value="' + licRef + '^^' + stdUser + '"></form>', function() {
                            $('#refresh').submit()
                            }, {
                            hideNotBtn: true
                        })
                        } else {
                        win('<div class="txt-center red">No se ha podido borrar la licencia</div>')
                        }
                })
                }, {
                okBtnVal: 'Borrar',
                notBtnVal: 'Cancelar'
            })
            })
        }
    if (editusr = $('.editusr')) {
        editusr.click(function() {
            var stnObj = $('#mgUsers'),
            stdUser = stnObj.find('option:selected').val().split('^^'),
            usrRef = stdUser[0],
            usrNames = stdUser[1],
            usrUsername = stdUser[2],
            usrSign = stdUser[3],
            usrLics = stdUser[4];
            win('<div class="chManage"><h3>MODIFICACI&Oacute;N DE DATOS</h3><span class="yellow">Cambiar informaci&oacute;n de </span><span>' + usrNames + '</span><br><br><strong class="white">Nombre de usuario: </strong><input type="text" id="newUsrName" class="s-frm-text" value="' + usrUsername + '"><br><strong class="white">Contrase&ntilde;a: </strong><input type="text" id="newUsrPwd" class="s-frm-text" value=""><br><br><strong>Nombres y apellidos: </strong><input type="text" id="newUsrNames" class="s-frm-text" value="' + usrNames + '"><br><strong>Etiqueta: </strong><input type="text" id="newUsrSign" class="s-frm-text" value="' + usrSign + '"><br><strong>Licencias h&aacute;biles: </strong><input type="text" id="newUsrLics" class="s-frm-text" value="' + usrLics + '"></div>', function() {
                load.fadeIn();
                $.post('req.php', {
                    action: 'editUsr',
                    ref: usrRef,
                    newUsrNames: $('#newUsrNames').val(),
                    newUsrSign: $('#newUsrSign').val(),
                    newUsrName: $('#newUsrName').val(),
                    newUsrPwd: $('#newUsrPwd').val(),
                    newUsrLics: $('#newUsrLics').val()
                    }, function(data) {
                    load.hide();
                    if (data == 'good') {
                        win('<div class="txt-center">Has cambiado los datos de usuario correctamente</div>', function() {
                            window.location = 'access.php';
                        }, {
                            hideNotBtn: true
                        })
                        } else {
                        win('<div class="txt-center red">No se ha podido cambiar la informaci&oacute;n del usuario</div>')
                        }
                })
                }, {
                okBtnVal: 'Cambiar',
                notBtnVal: 'Cancelar'
            })
            })
        }
    if (delusr = $('.delusr')) {
        delusr.click(function() {
            var stnObj = $('#mgUsers'),
            stdUser = stnObj.find('option:selected').val().split('^^'),
            usrRef = stdUser[0],
            usrNames = stdUser[1];
            win('<span class="yellow">&iquest;Deseas borrar al usuario <span class="white">' + usrNames + '</span> junto con sus datos?</span></span>', function() {
                load.fadeIn();
                $.post('req.php', {
                    action: 'delUsr',
                    ref: usrRef
                }, function(data) {
                    load.hide();
                    if (data == 'good') {
                        win('<div class="txt-center">Has borrado al usuario <span class="yellow">' + usrNames + '</span> del sistema</div>', function() {
                            window.location = 'access.php';
                        }, {
                            hideNotBtn: true
                        })
                        } else {
                        win('<div class="txt-center red">Debido a un error no se pudo eliminar</div>')
                        }
                })
                }, {
                okBtnVal: 'Eliminar',
                notBtnVal: 'Cancelar'
            })
            })
        }

    if(infusr = $('.infusr')){
	infusr.click(function(){
            var stdUser = $('#mgUsers option:selected').val().split('^^'),
            usrRef = stdUser[0],
            usrNames = stdUser[1],
            usrUsername = stdUser[2],
            usrSign = stdUser[3],
            usrLicActived = stdUser[4],
            usrLicUsed = stdUser[5],
            usrLast = stdUser[6];

	win('<div class="chManage"><h3>INFORMACI&Oacute;N DE USUARIO</h3><strong>Nombres y apellidos</strong><span class="yellow">' + usrNames + '</span><br><strong>Etiqueta: </strong><span>' + usrSign + '</span><br><br><strong>Nombre de usuario: </strong><span>' + usrUsername + '</span><br><strong>Licencias h&aacute;biles: </strong><span>' + usrLicActived + '</span><br><strong>Licencias usadas: </strong><span>' + usrLicUsed + '</span><br><strong>&Uacute;ltimo acceso: </strong><span>' + usrLast + '</span></div>')

	});
    }

    if(searchLics = $('.searchLicences')){
	searchLics.click(function(){
		var seaUser = $('#seaUsers option:selected').val(),
		seaField = $('#seaField option:selected').val(),
		seaVal = $('#seaVal').val();

                load.fadeIn();
		$.get('req.php', {
                    action: 'searchLicence',
                    seaUser: seaUser,
                    seaField: seaField,
                    seaVal: seaVal,
                }, function(data) {
                    load.hide();
                    if(data == 'bad'){
			win('<div class="txt-center silver">No hubo resultados en la b&uacute;squeda</div>');
		    }
		    else {
			win('<span class="yellow">Resultados de la b&uacute;squeda</span> <span>"' + seaVal + '"</span><br><br><div class="searchResults">' + data + '</div>');
		    }
                });
	});
    }

  $('h3.blue').click(function(){
	var target = $(this).parent().find('.box');
	target.slideToggle();
});


	if(gtTrademarks = $('.gt-trademarks')){
		gtTrademarks.click(function(){
 			win('<div class="genTrade"><h3>GENERAR P&Aacute;GINA</h3><br>'+
'<strong class="yellow">Direcci&oacute;n web:</strong>http://<input value="www.karaokelatinmusic.com" type="text" id="gt_dirweb" class="s-frm-text"><br>'+
'<strong class="yellow">Directorio:</strong><input type="text" id="gt_dir" class="s-frm-text"><br><br>'+

'<strong class="white">T&iacute;tulo de la p&aacute;gina:</strong><input value="Karaoke LatinMusic, Bienvenid@s" type="text" id="gt_title" class="s-frm-text"><br>'+
'<strong class="white">Keywords:</strong><input value="" type="text" id="gt_keywords" class="s-frm-text"><br>'+
'<strong class="white">Descripci&oacute;n:</strong><input value="Karaoke Latinmusic, el primer sistema de karaoke profesional en Ecuador. Venta y alquiler de karaoke profesional para todo tipo de eventos." type="text" id="gt_description" class="s-frm-text"><br><br>'+

'<strong>Nombre general:</strong><input value="Karaoke LatinMusic" type="text" id="gt_name" class="s-frm-text"><br>'+
'<strong>E-mail:</strong><input value="hello@okzgn.com" type="text" id="gt_mail" class="s-frm-text"><br><br>'+

'<strong>Texto superior:</strong><input value="Bienvenid@s a Karaoke LatinMusic" type="text" id="gt_superior" class="s-frm-text"><br>'+
'<strong>Direcci&oacute;n video:</strong><input value="http://www.youtube.com/embed/iQoJkHW26Oo" type="text" id="gt_dirvideo" class="s-frm-text"><br><br>'+

'<strong>Direcci&oacute;n empresa:</strong><input value="" type="text" id="gt_dirbis" class="s-frm-text"><br>'+
'<strong>Qui&eacute;nes somos:</strong><input value="" type="text" id="gt_whoweare" class="s-frm-text"><br>'+
'<strong>Misi&oacute;n:</strong><input value="" type="text" id="gt_mission" class="s-frm-text"><br>'+
'<strong>Tel&eacute;fonos:</strong><input value="" type="text" id="gt_phones" class="s-frm-text"><br>'+

'</div>', function(){

	var
	gtDir		= $('#gt_dir').val(),
	gtTitle		= $('#gt_title').val(),
	gtKeywords	= $('#gt_keywords').val(),
	gtDescription	= $('#gt_description').val(),
	gtName		= $('#gt_name').val(),
	gtDirWeb	= $('#gt_dirweb').val(),
	gtEmail		= $('#gt_mail').val(),
	gtSupText	= $('#gt_superior').val(),
	gtDirVideo	= $('#gt_dirvideo').val(),
	gtDirBis	= $('#gt_dirbis').val(),
	gtWhoWeAre	= $('#gt_whoweare').val(),
	gtMission	= $('#gt_mission').val(),
	gtPhones	= $('#gt_phones').val();

	if(gtDir){
		load.fadeIn();
                $.post('req.php', {
                    action: 'createTradeMark',
			gtDir		:gtDir,
			gtTitle		:gtTitle,
			gtKeywords	:gtKeywords,
			gtDescription	:gtDescription,
			gtName		:gtName,
			gtDirWeb	:gtDirWeb,
			gtEmail		:gtEmail,
			gtSupText	:gtSupText,
			gtDirVideo:gtDirVideo,
			gtDirBis	:gtDirBis,
			gtWhoWeAre:gtWhoWeAre,
			gtMission	:gtMission,
			gtPhones	:gtPhones
                }, function(data) {
                    load.hide();
                   if (/good$/.test(data)) {
                        win('<div class="txt-center">Se ha creado la p&aacute;gina para <span class="yellow">' + gtName +  '.</span></div>', function() {
                            window.location = 'access.php';
                        },{
                            hideNotBtn: true
                        })
                        } else {
                        win('<div class="txt-center red">Debido a un error no se pudo generar la p&aacute;gina</div>')
                        }
                })
	}

},{ okBtnVal: 'Generar' });
		});


		if(gtGomark = $('.gt-gomark')){
			gtGomark.click(function(){
				var dirmark = $('#marks option:selected').val();
				window.location = 'marks/' + dirmark + '/?action=insideView';
			});
		}

	}


});
