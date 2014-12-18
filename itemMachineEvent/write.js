$( function() {
	$('#eventSelector').draggable({handle: 'b'});
	$('#eventSelector').click( function( ev ) {
		var el = $(ev.target);
		if ( el[0].tagName == 'INPUT' ) {
			var checked = ! ! el.attr( 'checked' );
			el.up('dl').find('input[type=checkbox]').each( function( unit ) {
				$(this).prop( 'checked', checked );
				$(this).next().toggleClass('checked');
			});
		}
	});
});
