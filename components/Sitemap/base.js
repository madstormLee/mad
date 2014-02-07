Event.observe(window,'load', function () {
		MadSitemap.init();
		});
var MadSitemap = {
init: function(){
		  $$('.addMethod').each(function(unit){
				  unit.observe('click',MadSitemap.addMethod);
				  });
		  $('addClass').observe('click',MadSitemap.addClass);
		  $('newMethod').observe('focus',function(event){
				  event.element().value='';
				  });
		  $('formAddMethod').observe('submit',function(event){
				  return false;
				  });
	  },
addClass: function( event ) {
			  $('formAddMethod').hide();
			  var el = $('formAddClass').show();
			  el.style.left = Event.pointerX(event) -220 + 'px';
			  el.style.top = Event.pointerY(event) -10 + 'px';
		  },
addMethod: function( event ) {
			   $('formAddClass').hide();
			   $('className').value = event.element().previous('.controller').innerHTML;
			   var el = $('formAddMethod').show();
			   el.style.left = Event.pointerX(event) -220 + 'px';
			   el.style.top = Event.pointerY(event) -10 + 'px';
		   }
}
