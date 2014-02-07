document.observe('dom:loaded', function() {
	new ManualWrite;
});
var ManualWrite = Class.create({
	initialize: function() {
		CKEDITOR.replace( 'content', {
			language: 'ko'
		});
	},
	onClick: function( ev ) {
		ev.stop();
		alert('tested');
	}
});
