$.fn.fixed = function(){
	var obj = $(this),
	pos = obj.offset();
	if($.browser.msie && $.browser.version < 9){
		obj.css({
			position: 'absolute',
			top: pos.top,
			left: pos.left
		});
		$(window).scroll(function(){
			obj.css({
				top: pos.top + $(this).scrollTop(),
				left: pos.left + $(this).scrollLeft()
			});
		});
	}
	else {
		obj.css('position', 'fixed');
	}
}

	setInterval(function(){
		if(haveNotices = $('.response')){
			haveNotices.fadeOut('fast', function(){ $(this).remove(); });
		}
	}, 7000);

function win(msg,func,opts){var win_box=$('#win');if(win_box.css('display')!='block'){var win_msg=win_box.find('#win_message'),win_ok=win_box.find('#btn_ok'),win_not=win_box.find('#btn_not'),win_stat=$.isFunction(func),win_opts=(typeof opts=='object');win_msg.html(msg);win_ok.val('Aceptar');win_not.val('Cancelar');win_not.show();if(win_opts&&opts.okBtnVal){win_ok.val(opts.okBtnVal)}if(win_opts&&opts.notBtnVal){win_not.val(opts.notBtnVal)}if(!win_stat||(win_opts&&opts.hideNotBtn)){win_not.hide()}win_ok.off('click');win_ok.click(function(){win_box.fadeOut('fast',function(){if(win_stat){func.apply()}})});win_not.click(function(){win_box.fadeOut('fast')});win_box.css({top:(($(window).height()-win_box.outerHeight())/2)+$(window).scrollTop()+'px',left:(($(window).width()-win_box.outerWidth())/2)+$(window).scrollLeft()+'px'}).fadeIn()}}$(function(){$(document.createElement('div')).attr('id','win').html('<p id="win_message">&nbsp;</p><div class="win-options"><input type="button" id="btn_ok" class="s-frm-button" value="Ok"><input type="button" id="btn_not" class="s-frm-button" value="Not"></div>').appendTo('#LIM');$(document.createElement('div')).attr('id','load').html('Procesando ... porfavor espere').appendTo('#LIM');$('#load').fixed();$('#LIM').show();});