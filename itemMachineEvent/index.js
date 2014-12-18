$( function() {
	$('a.btnTab').click( function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( el.hasClass( '.current' ) ) {
			return ;
		}
		var section = el.up('section');
		section.find('a.btnTab').removeClass('current');
		section.find('section.tab').hide();
		el.addClass('current');
		el.next('section').show();
	});
	$('#right').click( function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( el.hasClass( 'toggleUpNext' ) ) {
			el.up().next().toggle();
		}
	});
});
