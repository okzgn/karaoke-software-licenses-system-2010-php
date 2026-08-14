$(function() {
    if (newlic = $('.newlic')) {
        var generateBtn = newlic.find('.generate'),
        client = newlic.find('input[name="client"]'),
        code = newlic.find('input[name="code"]');
        generateBtn.click(function(e) {
            e.preventDefault();
            client_stat = (client.val() < 1 ? '<span class="red">[Campo vac&iacute;o]</span>': '<span class="lblue">' + client.val() + '</span>');
            code_stat = (code.val() < 1 ? '<span class="red">[Campo vac&iacute;o]</span>': '<span class="lblue">' + code.val() + '</span>');
            win('<span class="yellow">&iquest;Estas seguro de generar una nueva licencia?</span><br>Revisa los datos ingresados<br><br>-&gt; Nombre cliente: ' + client_stat + '<br>-&gt; C&oacute;digo: ' + code_stat, function() {
                if (client.val().length == 0 || code.val().length == 0) {
                    win('<div class="txt-center silver">&iexcl;Alg&uacute;n campo esta vacio!<br>No es posible generar la licencia</div>')
                    } else {
                    newlic.submit()
                    }
            })
            })
        }
    if (uniques = $('.unique')) {
        var out = $('#licComplete');
        uniques.hover(function() {
            $(this).addClass('unique-hover')
            }, function() {
            $(this).removeClass('unique-hover')
            });
        uniques.click(function() {
            var actual = $(this),
            client = actual.find('.client'),
            firstCode = actual.find('.firstCode'),
            xCode = actual.find('.xCode'),
            creationDate = actual.find('.creationDate');
            uniques.removeClass('unique-selected');
            actual.addClass('unique-selected');
            if (out.css('display') == 'none') {
                out.show()
                }
            out.html('<div class="pointer"><strong>Cliente: </strong><span>' + client.attr('title').slice(9) + '</span></div><div class="pointer"><strong>C&oacute;digo inicial: </strong><span>' + firstCode.html() + '</span></div><div class="pointer"><strong>C&oacute;digo generado: </strong><span class="lblue">' + xCode.html() + '</span></div><div class="pointer"><strong>Fecha creaci&oacute;n: </strong><span>' + creationDate.html() + '</span></div>')
            })
        }

var load = $('#load');
if (searchLicences = $('.searchLicences')) {
        searchLicences.click(function() {
            load.fadeIn();
            var seaUser = $('#mgu').attr('src').slice(16);
            var seaVal = $('.seaVal').val();
            $.get('req.php', {
                action: 'searchLicence',
                seaUser: seaUser,
                seaVal: seaVal,
                }, function(data) {
                load.hide();
                if (data == 'bad') {
                    win('<div class="txt-center silver">No hubo resultados en la b&uacute;squeda</div>');
                } else {
                    win('<span class="yellow">Resultados de la b&uacute;squeda</span> <span>"' + seaVal + '"</span><br><br><div class="searchResults">' + data + '</div>');
                }
            });
        });
    }
});