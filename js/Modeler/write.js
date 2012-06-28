document.observe('dom:loaded',function() {
		$$('.btnSubmit').invoke('observe','click',function( ev ) {
			ev.element().up('form').submit();
			});
		Modeler.init();
		});
var Modeler = {
init: function() {
		$$('.addRow').invoke('observe','click', Modeler.addRow );
		$$('.removeRow').invoke('observe','click', Modeler.removeRow );
	  },
addRow: function( ev ) {
			var el = ev.element();
			var target = el.up('tbody');
			var row = el.up('tr').innerHTML;
			target.innerHTML += '<tr>' + row + '</tr>';
			Modeler.init();
		},
removeRow: function( ev ) {
			   var el = ev.element();
			   if ( el.up('tbody').select('tr').length > 1 ) {
				   el.up('tr').remove();
			   }
		   }
}
