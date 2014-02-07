/************************** jQuery extension **************************/
$.fn.extend({
	//### Prototype "up" method
	up: function(selector)
	{
		var found = "";
		selector = $.trim(selector || "");

		$(this).parents().each(function()
		{
			if (selector.length == 0 || $(this).is(selector))
			{
				found = this;
				return false;
			}
		});

		return $(found);
	},
	down: function() {
		var el = this[0] && this[0].firstChild;
		while (el && el.nodeType != 1)
			el = el.nextSibling;
		return $(el);
	}
});

function htmlEntities(str) {
	    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}


/************************** functions **************************/
var toMoney = function( value ){
	value = toInt(value); // there is posibility that value is string
	var rv = '';
	value = value + ''; // make value as string
	while ( value.length > 3 )  {
		rv = ',' + value.substr(value.length - 3) + rv;
		value = value.substr(0,value.length -3);
	}
	rv = value + rv;
	return rv;
}
var toInt = function( value ) {
	value = value + '';
	var rv = value.replace(/[^0-9]/gi,'');
	return parseInt(rv);
}
function setPng24(obj) {
	obj.width=obj.height=1; 
	obj.className=obj.className.replace(/\bpng24\b/i,''); 
	obj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');" 
		obj.src='';  
	return ''; 
}

var Flash = {
	write: function (url,w,h,id,bg,vars,win){
		   var flashStr="<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+w+"' height='"+h+"' id='"+id+"' align='middle'>"+
			   "<param name='allowScriptAccess' value='always' />"+
			   "<param name='movie' value='"+url+"' />"+
			   "<param name='FlashVars' value='"+vars+"' />"+
			   "<param name='wmode' value='"+win+"' />"+
			   "<param name='menu' value='false' />"+
			   "<param name='quality' value='high' />"+
			   "<param name='bgcolor' value='"+bg+"' />"+
			   "<embed src='"+url+"' FlashVars='"+vars+"' wmode='"+win+"' menu='false' quality='high' bgcolor='"+bg+"' width='"+w+"' height='"+h+"' name='"+id+"' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
			   "</object>";
		   return flashStr;
	   },
print: function (url,w,h) {
		   var rv = '';
		   rv = Flash.write(url,w,h,'flash','transparent','','transparent');
		   document.write( rv );
	   }
}

function copy_to_clipboard(text) {
	if(window.clipboardData) {
		window.clipboardData.setData('text',text);
	} else {
		var clipboarddiv=document.getElementById('divclipboardswf');
		if(clipboarddiv==null) {
			clipboarddiv=document.createElement('div');
			clipboarddiv.setAttribute("name", "divclipboardswf");
			clipboarddiv.setAttribute("id", "divclipboardswf");
			document.body.appendChild(clipboarddiv);
		}
		clipboarddiv.innerHTML='<embed src="/main/swf/clipboard.swf" FlashVars="clipboard='+ encodeURIComponent(text) + '" width="0" height="0" type="application/x-shockwave-flash"></embed>';
	}
	alert('클립보드에 복사되었습니다.');
	return false;
}

/************************* assign events ************************/ 
$( function() {
	/******************************* toggles *******************************/
	$('a.toggleId').click( function( ev ) {
		ev.preventDefault();
		$( $(ev.target).attr('href') ).toggle();
	});
	$('.toggleNext').click( function( ev ) {
		ev.preventDefault();
		$(ev.target).next().toggle();
	});
	$('a.toggleUpNext').click( function( ev ) {
		ev.preventDefault();
		$(ev.target).up().next().toggle();
	});

	/************************* common behavior ************************/ 
	$('a[data-confirm]').click( function( ev ) {
		if ( false === confirm( $(ev.target).attr('data-confirm') ) ) {
			ev.preventDefault();
			return false;
		}
	});
	$('section[data-href]').each( function( num, unit ) {
		var el = $(unit);
		el.load( el.attr('data-href') );
	});

	/************************* form **************************/
	$('form .ckAll').click( function( ev ) {
		ev.preventDefault();
		var targets = $(ev.target).up('form').find('input[type=checkbox]');
		var to = ! $(targets[0]).attr('checked');

		targets.each( function( unit ) {
			$(this).prop('checked', to )
		});
	});

	$('form.changeSubmit').change( function( ev ) {
		$(ev.target).up('form').submit();
	});

	$('button.back').click( function( ev ) {
		history.back();
	});

	/********************** right **********************/
	if ( ! $('#right').is(':empty') ) {
		$('#right').show();
		var width = parseInt( $('#right').css('width').match(/[0-9]+/) ) + 20;
		$('#main').css({ paddingRight: width });
	}

	$('#toggleRight').click( function( ev ) {
		ev.preventDefault();
		$('#right').toggle();
		if ( $('#right').css('display') == 'none' ) {
			$('#main').css({'padding-right': '20px' } );
			$('#toggleRight').css({right: '0px'}).html('&lt;<br />&lt;');
			return ;
		}
		$('#main').css({'padding-right': '270px' } );
		$('#toggleRight').css({right: '250px'}).html('&gt;<br />&gt;');
	});

	/*********************** popups ***********************/
	$('nav.personal a.popup').click( function( ev ) {
		ev.preventDefault();
		var popup = $('#personalPopup');
		if ( popup.is(':visible') ) {
			popup.hide();
		} else {
			popup.load( $(ev.target).attr('href') ).show();
		}
	});

	$('nav.component .popup').click( function( ev ) {
		ev.preventDefault();
		$('#popupWindow').load( $(ev.target).attr('href') ).show();
	});
});
