document.observe('dom:loaded', function() {
(function(){
 /*Use Object Detection to detect IE6*/
 var m = document.uniqueID /*IE*/
 && document.compatMode /*>=IE6*/
 && !window.XMLHttpRequest /*<=IE6*/
 && document.execCommand ;

 try{
 if(!!m){
 m("BackgroundImageCache", false, true) /* = IE6 only */
 }
 }catch(oh){};
 })();
});


var MadNavi = {
back: function( ev ) {
		  history.back();
	  }
}
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
var DateSelector = {
init: function () {
		  var units = $$('.dateSelector');
		  units.each(function (unit) {
				  unit.observe('click', DateSelector.open);
				  });
	  },
open: function (event) {
	  }
}
function setPng24(obj) { 
	obj.width=obj.height=1; 
	obj.className=obj.className.replace(/\bpng24\b/i,''); 
	obj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');" 
		obj.src='';  
	return ''; 
}

var Calendar = {
init: function () {
		  // this.update();
	  },
update: function( direction ) {
			if( $('monYear') ){
				var monyear = $('monYear').firstChild.nodeValue;
			}
			new Ajax.Updater('calendar','/mad/calendar/calendar.ajax.php', {
parameters: { req_date: monyear, to : direction }
});
},
nextMonth: function () {
			   this.update('next');
		   },
prevMonth: function () {
			   this.update('prev');
		   }
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
var MadForm = {
init: function () {
		  $$('.madForm').each(function(unit){
				  if (unit.down('.sumit')) {
				  unit.down('.submit').observe('click',MadForm.check);
				  }
				  });
	  },
check: function ( event ) {
		   var el = event.element();
		   el.up('form').submit();
	   },
submit: function( ev ) {
			ev.element().up('form').submit();
		}
}
var MadImageUploader = {
init: function () {
		  $$('.MadImageUploader').each(function (unit) {
				  unit.observe('click',MadImageUploader.openUploader);
				  });
	  },
openUploader: function ( event ) {
				  var el = event.element();
				  $('MadImageUploader').show();
			  }
}
/******************* MadValidator ***********************/
var MadValidator = {
text: function( name, nickName, rules) {
		  var el = $(name);
		  var value = el.value.strip();
		  var len = value.length;
		  if ( rules[0] == 1 && len < 1 ) {
			  alert ( nickName + ' : 입력 해 주셔야 합니다.');
			  el.select();
			  return false;
		  }
		  if ( rules[0] > 1 && len < rules[0] ) {
			  alert ( nickName + ' : ' + rules[0] + '자 보다 커야 합니다.');
			  el.select();
			  return false;
		  }
		  if ( rules[1] > 1 && len > rules[1] ) {
			  alert ( nickName + ' : ' + rules[1] + '자 보다 작아야 합니다.');
			  el.select();
			  return false;
		  }
		  return true;
	  },
equals: function ( unitName1, unitName2 , nickName ) {
			if ( $F(unitName1) !== $F(unitName2) ) {
				alert ( nickName + '가 일치하지 않습니다.' );
				return false;
			}
			return true;
		},
validate: function ( jsonData ) {
			  var data = $H(jsonData);
			  var rv = true;
			  data.each( function( unit, iter ) {
					  var value = unit.value;
					  var nickName = value.nickName;
					  var rules = [ value.min , value.max ];
					  var result;
					  result = MadValidator.text(unit.key, nickName, rules );
					  if ( result == false ) {
					  rv = false;
					  throw $break; return;
					  }
					  });
			  return rv;
		  }
}
function copy_to_clipboard(text)
{
	if(window.clipboardData)
	{
		window.clipboardData.setData('text',text);
	}
	else
	{
		var clipboarddiv=document.getElementById('divclipboardswf');
		if(clipboarddiv==null)
		{
			clipboarddiv=document.createElement('div');
			clipboarddiv.setAttribute("name", "divclipboardswf");
			clipboarddiv.setAttribute("id", "divclipboardswf");
			document.body.appendChild(clipboarddiv);
		}
		clipboarddiv.innerHTML='<embed src="/main/swf/clipboard.swf" FlashVars="clipboard='+
			encodeURIComponent(text)+'" width="0" height="0" type="application/x-shockwave-flash"></embed>';
	}
	alert('클립보드에 복사되었습니다.');
	return false;
}
