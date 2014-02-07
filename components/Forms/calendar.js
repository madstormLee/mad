Event.observe(window, 'load', function(){
		MadDateSelector.init();
		});
var MadDateSelector = {
is_selector: 0,
reqId: null,
	   init: function(){
		   $$('.MadDateSelector').each(function(unit){
				   unit.observe('click', MadDateSelector.open);
				   });
	   },
open: function( event ){
		  if ( MadDateSelector.is_selector == 1 ) {
			  MadDateSelector.close();
		  }
		  MadDateSelector.is_selector = 1;
		  var offset = event.element().cumulativeOffset();
		  var _x = offset.left + 50;
		  var _y = offset.top - 30;
		  var calendar = new Element('div',{'id':'MadDateSeletor'});
		  $('container').insert(calendar);
		  calendar.absolutize();
		  calendar.style.left = _x + 'px';
		  calendar.style.top = _y + 'px';
		  MadDateSelector.request();
		  MadDateSelector.reqId = event.element().id;
	  },
request: function ( event ) {
			 var myDate = new Date();
			 var target_year = $('CurrentYear') ? $('CurrentYear').innerHTML : myDate.getFullYear();
			 var target_month = $('CurrentMonth') ? $('CurrentMonth').innerHTML : myDate.getMonth()+1 ;
			 if (event){
				 var doing = event.element().id;
				 if (doing == 'prevYear' ) target_year-- ;
				 if (doing == 'nextYear' ) target_year++ ;
				 if (doing == 'prevMonth' ) target_month--;
				 if (doing == 'nextMonth' ) target_month++;
				 if (target_month > 12 ) {
					 target_year++;
					 target_month = 1;
				 }
				 if (target_month < 1 ) {
					 target_year--;
					 target_month = 12;
				 }
			 }

			 new Ajax.Request('/AjaxFront.php?pg=MadCalendar', {
parameters: { year: target_year, month: target_month },
onSuccess: function( value ){
$('MadDateSeletor').innerHTML = value.responseText;
$('prevYear').observe('click', MadDateSelector.request);
$('nextYear').observe('click', MadDateSelector.request);
$('prevMonth').observe('click', MadDateSelector.request);
$('nextMonth').observe('click', MadDateSelector.request);
$$('.day').each(function(td){
	td.observe('click',MadDateSelector.enterDate);
	});
}
});
},
enterDate: function ( event ) {
			   var target = MadDateSelector.reqId;
			   $(target).value = $('CurrentYear').innerHTML +'-'+ $('CurrentMonth').innerHTML +'-'+ event.element().innerHTML;
			   MadDateSelector.close();
		   },
close: function () {
		   $('MadDateSeletor').remove();
		   MadDateSelector.is_selector = 0;
	   }
}
