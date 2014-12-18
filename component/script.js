// models
var Controllers = {
	init: function() {
	}
};

// controller
$( function() {
	Components.init();
	Controllers.init();
	$('#controllers').click( function( ev ) {
		var el = $(ev.target);
		if ( el[0].tagName == 'A' ) {
			ev.preventDefault();
			$('#id').val( el.html() );
		}
	});
});
