Event.observe(window, 'load', function(){
		if ( $$('form').length > 0 ){
		ByteCk.init();
		}
		});
/********************** ByteCheck ********************/
var Limits = {
	  name: { min: 4, max: 20 },
	  openSesame: { min: 8, max: 20 },
	  shoutBox: { min: 1, max: 30 },
	  hobby: { min: 1, max: 10 },
	  introduction: { min: 1, max: 200 },
	  title: { min: 1, max: 40 },
	  tag: { min: 1, max: 100 },
	  location: { min: 1, max: 20 },
	  description: { min: 1, max: 100 },
	  category: { min: 2, max: 20 },
	  secretPass: { min: 4, max: 4 },
	  contents: { min: 1, max: 2000 },
	  topicContents: { min: 1, max: 1000 },
	  comment: { min: 1, max: 200 }
}

var ByteCk = {
init: function () {
		  var limit = $$('form');
		  limit.each(function(item){
				  var inputs = item.select('input');
				  if (inputs.length > 0) {
				  inputs.each(function(item){
					  if ( item.maxLength > 1 ) {
					  item.observe('keyup', ByteCk.max);
					  }
					  });
				  }
				  var textareas = item.select('textarea');
				  if (textareas.length > 0) {
				  textareas.each(function(item){
					  item.observe('keyup', ByteCk.max);
					  });
				  }
				  });
	  },
min: function ( event ) {
		 var el = event.element();
	 },
max: function ( event ) {
		 var el = event.element();
		 var code = event.keyCode;
		 var ml = el.maxLength; // in textarea case, this works only ie
		 try { ml = Limits[el.id].max; } catch (e) {}
		 var value = el.value;
		 if ( value.length >= ml &&
				 code != Event.KEY_TAB &&
				 code != Event.KEY_BACKSPACE &&
				 code != Event.KEY_RETURN &&
				 code != Event.KEY_SHIFT &&
				 code != Event.KEY_DELETE &&
				 code != Event.KEY_ALT) {
			 alert( "sorry, you can input just "+ml+" bytes." );
			 el.value = value.substring( 0 , ml );
		 }
		 event.stop();
	 },
maxTa: function ( event ) {
		   var el = event.element();
		   if ( el.hasClassName('description')) {
		   }
	   }
}
var MadForms = {
initCkAll: function () {
				  $('ckAll').observe('click', PulauForms.ckAll);
			  },
ckAll: function () {
		  if( $('ck1').checked==false ){
			  for(var i=1; i <= 30; i++){
				  if ( $('ck'+i) ) {
				  	$('ck'+i).checked=true;
				  } else break;
			  }
		  } else {
		  	for(var i=1; i <= 30; i++){
				  if ( $('ck'+i) ) {
				  $('ck'+i).checked=false;
				  } else break;
		  	}
		  }
	  },
elementCheck: function (el) {
			   if( $F(el)=='' ) {
				   Popup.popup("Please input'" + $(el).id +"' field!!",300,500);
				   $(el).style.backgroundColor='#fdd';
				   $(el).focus();
				   return false;
			   } else {
				   $(el).style.backgroundColor='#fff';
				   return true;
			   }
				  },
passConfirm: function (pw,confirmpw) {
				 if( $F(pw) != $F(confirmpw) ) {
				   	Popup.popup("password not confirmed.",300,500);
				   $(pw).style.backgroundColor='#fdd';
				   $(confirmpw).style.backgroundColor='#fdd';
				   $(pw).focus();
					 return false;
				 } else {
				   $(pw).style.backgroundColor='#fff';
				   $(confirmpw).style.backgroundColor='#fff';
					 return true;
				 }
			 }
}
