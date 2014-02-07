document.observe('dom:loaded', function() {
	new Manual;
});
var Manual = Class.create({
	initialize: function() {
		$('manualIndex').observe('click', this.onClick.bind(this));
		$('newForm').observe('submit', this.onNewSubmit.bind(this));
	},
	onClick: function( ev ) {
		var el = ev.element();
		if ( el.tagName == 'A' && el.hasClassName('btnNew') ) {
			ev.stop();
			#('manualNewForm').show();
		}
	}
});
