document.observe('dom:loaded', function() {
	new MadPopup();
});
var MadPopup = Class.create({
	initialize: function() {
		this.console = $('console');
		this.popupData = $('MadPopup').innerHTML;
	},
	test: function( ev ) {
	}
});
